<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Admin extends CI_Controller{

	private $categories;
	private $perpage;

	public function __construct(){
    parent::__construct();
    $this->load->model('queries');
    // $this->load->helper('security');
    $result = $this->queries->categories();
    $this->processCategories($result);

    // pagination
    $this->config->load('bootstrap_pagination');
		$config = $this->config->item('pagination_config');
    $result = $this->queries->countCommandes();
    $config['base_url'] = site_url('history');
		$config['total_rows'] = $result;
		$config['per_page'] = 8;
		$this->perpage = $config['per_page'];
		$this->pagination->initialize($config);
  }

  public function processCategories($array){
    $this->categories = array();
    foreach ($array as $key => $value) {
      $this->categories[$value['cat_Ref']] = $value['cat_Design'];
    }
  }

	public function index($num_commandes=0){
		if(isset($this->session->isAdmin)){
			$result = $this->lastCommande();

			$commandes = $this->queries->retrieveCommande($this->perpage,$num_commandes);
			// var_dump($commandes);
			$data['recentOrder'] = $result;
			$data['commandes'] = $commandes;
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('admin_dashboard',$data);
		}
		else{
			$this->load->view('adminLogin');
		}
	}

	public function lastCommande(){
		$this->load->model('queries');
		$result = $this->queries->retrieveLastCommande();
		if($result == FALSE){
			return FALSE;
		}
		else{
			$dat = explode(' ', $result[0]['updated_at']);
			$enlettre = date('D',strtotime($dat[0])).' '.date('j',strtotime($dat[0])).' '.date('M',strtotime($dat[0])).' '.date('Y',strtotime($dat[0])).' '.$dat[1];
			$recentOrder =array(
				'nom' => $result[0]['name'],
				'statut' => $result[0]['cat_Design'],
				'montantht' => $result[0]['montantHT'],
				'date'			=> $enlettre
			);
			// var_dump();
			return $recentOrder;
		}
	}

	public function adminLogin(){
		if(isset($this->session->isAdmin)){
			$this->load->view('admin_dashboard');
			return;
		}
		$this->load->view('adminLogin');	
	}

	public function adminLogout(){
		$array = array('name','email','username','phoneNum','id','isAdmin','cat_Ref');
		$this->session->unset_userdata($array);
		// $this->adminLogin();
		redirect('admindashboard');	
	}

	public function checkLogin(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE)
    {
        $this->adminLogin();
    }
    else{
    	$login_data = array(
    		'username' => $this->input->post('username'),
    		'password' => $this->input->post('password'),
    	);

    	$this->load->model('queries');
    	$result = $this->queries->authenticateuser($login_data);
    	if($result == FALSE){
    		// echo "Incorrect Username or Password";
    		$donnees['err'] = "Incorrect Username or Password";
    		$this->load->view('adminLogin',$donnees);
    	}
    	else{

    		if($result->isAdmin == 0){
    			// only admin is allowed to log in
    			$donnees['err'] = "you cannot log in, wrong admin credentials";
    			$this->load->view('adminLogin',$donnees);
    		}
    		else{
    			$sessionData = array(
    			'id' => $result->id,
    			'username' => $result->username,
    			'name' => $result->name,
    			'phoneNum' => $result->phoneNum,
    			'email' => $result->email,
    			'isAdmin' => $result->isAdmin,
    			'cat_Ref' => $result->cat_Ref,
      		);
    			$this->session->unset_userdata($sessionData);
      		$this->session->set_userdata($sessionData);
      		// $this->index();

        redirect('admindashboard');

    		}
    	}
    }	
	}

	public function alter(){
		// var_dump($this->categories);
		$data['options'] = $this->categories;
		$this->load->view('editProfile',$data);
	}

	public function search(){
		$this->load->model('queries');
		$stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
		$clientdata = json_decode($stream_clean,TRUE);

		// var_dump($clientdata);

		$arg = array(
			'field' => $clientdata['data']['key'],
			'motif' => $clientdata['data']['motif'],
		);
		$result = $this->queries->searchuser($arg);
		// $result['csrf_bad_token'] = $this->security->get_csrf_hash();
		echo json_encode($result);
		// if($result == FALSE){
		// 	$this->session->set_flashdata('noresult',"No matching record found");
		// 	$this->load->view('editProfile');
		// }
		// else{
		// 	// var_dump($result);
		// 	$this->load->view('editProfile',['result' => $result]);
		// }
	}

	public function modifiedRecord(){
		$this->load->model('queries');
		$stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
		$clientdata = json_decode($stream_clean,TRUE);

		$arg = array(
			'name' => $clientdata['update']['name'],
			'email' => $clientdata['update']['email'],
			'username' => $clientdata['update']['username'],
			'phoneNum' => $clientdata['update']['phoneNum'],
			'cat_Ref' => $clientdata['update']['cat_Ref'],
			'updated_at' => date("Y-m-d G:i:s"),
		);

		if ($clientdata['update']['password'] != 'false') {
			$arg['password'] = sha1($clientdata['update']['password']);
		}
		// var_dump($arg);
		$result = $this->queries->updateClient($arg);
		echo json_encode($result);
	}

	public function initClientSelectTag(){
		$this->load->model('queries');
		$result = json_encode($this->queries->fetchClients());
		echo $result;
	}

	public function showUpdatePage(){
		$this->load->view('manageArticles');
	}

	public function updateArticles(){
		$this->load->helper('file');
    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'txt';
    $config['max_size']             = 100;
    $config['overwrite']            =TRUE;
    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('userfile'))
    {
      $error = array('error' => $this->upload->display_errors());

      $this->load->view('manageArticles', $error);
    }
    else
    {
      $this->load->model('queries');

      // first, delete all record from articles' table
      // $this->queries->emptyArticles();

      $data = array('upload_data' => $this->upload->data());
      $file = $data['upload_data']['full_path'];
      $myfile = fopen($file, "r") or die("Unable to open file!");
      $content = fread($myfile, filesize($file));

      $rows = explode(';', $content);
      // var_dump($rows);
      $date = date("Y-m-d G:i:s");
      // $temp = $this->queries->getArticle('3042536');
      // var_dump(floatval($temp[0]['pu']));
      for ($i=0; $i <sizeof($rows);$i += 1){ 
          $fields = explode('*', $rows[$i]);
          if (strlen($rows[$i]) > 0) {
          	$temp = $this->queries->getArticle($fields[0]);
          	// if the product exist
          	if ($temp != FALSE) {
          			if (floatval($temp[0]['pu']) != floatval($fields[2])) { // if the price is different then we update the price
          				$clientArray = array(
          					'refArt' => $fields[0],
          					'pu'		 => $fields[2]
          				);
          				$this->queries->updateArticlePrice($clientArray);
          			}
          	}
          	else{//we insert a new line
          		$clientArray = array(
		            'refArt'        => $fields[0],
		            'designArt'   	=> $fields[1],
		            'pu'						=> $fields[2],
		            'created_at'		=> $date,
		            'updated_at'		=> $date
		          );

		          $this->queries->insertArticles($clientArray);
          	}
    				            
          }

      }
      fclose($myfile);
      $data['success'] = "articles updated successfully";
      $this->load->view('manageArticles', $data);
    }
	}

	public function setArticleImage(){
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$this->load->view('articleImages');
		}
		else{
			if (strlen($_FILES['files']['name'][0]) > 0) {

				$data = array();
				$numFiles = count($_FILES['files']['name']);
				$this->load->helper('file');
				$this->load->model('queries');
				$uploadData = array();

				for ($i=0; $i < $numFiles; $i++) { 
					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];

				
			    $config['upload_path']          = './assets/img/articles/';
			    $config['allowed_types']        = 'gif|jpg|jpeg|png';
			    // $config['max_size']             = 100;
			    $config['overwrite']            =TRUE;
			    $this->load->library('upload', $config);
			    $this->upload->initialize($config);

			    if ($this->upload->do_upload('file'))
			    {
		        $fileData = $this->upload->data();
		        $uploadData[$i]['file_name'] = $fileData['file_name'];
			    }
				}
				if (!empty($uploadData)) {
					// sauvegarde des infos dans la base de donnees
					$this->queries->articleImagesProcessing($uploadData);
					// $data['success'] = "traitement termine";
					$this->session->set_flashdata('success',"traitement termine");
					$this->load->view('articleImages');
				}

			}
			else{
				$error['error'] = "vous devez selectionner au moins une image";
				$this->load->view('articleImages',$error);
			}
		}
	}
}


?>