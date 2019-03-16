<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Admin extends CI_Controller{

	private $categories;

	public function __construct(){
        parent::__construct();
        $this->load->model('queries');
        $result = $this->queries->categories();
        $this->processCategories($result);
    }

    public function processCategories($array){
        $this->categories = array();
        foreach ($array as $key => $value) {
            $this->categories[$value['cat_Ref']] = $value['cat_Design'];
        }
    }

	public function index(){
		if(isset($this->session->isAdmin)){
			$this->load->view('admin_dashboard');
		}
		else{

		$this->load->view('adminLogin');
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
		$this->adminLogin();	
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
	        		$this->load->view('admin_dashboard');
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

		// var_dump($clientdata['data']['key']);

		$arg = array(
			'field' => $clientdata['data']['key'],
			'motif' => $clientdata['data']['motif'],
		);
		$result = $this->queries->searchuser($arg);
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
                $this->queries->emptyArticles();

                $data = array('upload_data' => $this->upload->data());
                $file = $data['upload_data']['full_path'];
                $myfile = fopen($file, "r") or die("Unable to open file!");
                $content = fread($myfile, filesize($file));

                $rows = explode(';', $content);
                // var_dump($rows);
                for ($i=0; $i <sizeof($rows);$i += 1){ 
                    $fields = explode('*', $rows[$i]);
                    if (strlen($rows[$i]) > 0 && $this->queries->getClient($fields[0]) == FALSE) {
                    				$date = date("Y-m-d G:i:s");
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
                fclose($myfile);
                $data['success'] = "articles updated successfully";
                $this->load->view('manageArticles', $data);
        }
	}
}


?>