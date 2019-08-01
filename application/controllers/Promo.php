<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	Class Promo extends CI_Controller{

		public function __construct(){
			parent::__construct();
			// security
      $allowed = array(
        'userlogin',
        'validatelogin',
      );
      if (!isset($this->session->id) && ! in_array($this->router->fetch_method(), $allowed)) {
         redirect('login');
      }
			$this->load->model('queries');
		}

		public function index(){
			if (isset($this->session->id)) {
				if ($this->session->isAdmin) {
					$this->load->view('promotion');
				}
				else{
					echo "Access forbidden for none admin user";
				}
				
			}
			else{
				redirect('admindashboard');
			}
		}

		public function toutePromo(){
			$result = $this->queries->promoFullList();
			echo json_encode($result);
			// $this->load->view('toutesPromo');
		}

		public function detailPromo($artRef){

			$result['data'] = $this->queries->detailPromotion($artRef);
			if ($result['data'] != FALSE) {
				$result['artDesign'] = $this->queries->getArticleName($artRef)[0]['designArt'];
				// var_dump($result['artDesign']);
			}
			$result['autrepromo'] = $this->queries->autrePromotion($artRef);
			// var_dump(strtotime(date('Y-m-d')) <= strtotime($result['data'][0]['date_fin']));
			// var_dump(date('Y-m-d').' '.$result['data'][0]['date_fin']);
			$this->load->view('detailPromotion',$result);

		}

		public function newPromo(){
			$stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
		  $clientdata = json_decode($stream_clean,TRUE);
		  $promo = $clientdata['promo'];
		  
		  // now we build the array for the model
		  $savepromo = array(
		  	'date_debut' 			=> $promo['dated'],
		  	'date_fin' 	 			=> $promo['datef'],
		  	'id_article' 			=> $promo['article'],
		  	'quantite'	 			=> $promo['quantite'],
		  	'pourcentage'			=> $promo['pourcent'],
		  	'unite_gratuite'	=> $promo['unitegratuite'],
		  );

		  $this->load->model('queries');
		  $result = $this->queries->newPromotion($savepromo);
		  echo $result;
		  // if ($this->queries->newPromotion($savepromo)) {
		  // 	echo 1;
		  // }
		  // else{
		  // 	echo -1;
		  // }
		  // echo -1;
		}

		public function editPromo(){
			$this->load->view('editPromotion');
		}

		public function fetchPromo($artRef){
			$result = $this->queries->fetchPromo($artRef);
			echo json_encode($result);
		}

		public function saveEditedPromo(){
			$stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
		  $clientdata = json_decode($stream_clean,TRUE);
			$data = $clientdata['data'];

			$savepromo = array(
		  	'date_debut' 			=> $data['dated'],
		  	'date_fin' 	 			=> $data['datef'],
		  	'sommeil' 				=> $data['sommeil'],
		  	'quantite'	 			=> $data['quantite'],
		  	'pourcentage'			=> $data['pourcentage'],
		  	'unite_gratuite'	=> $data['unitegratuite'],
		  );

		  $this->queries->editedPromo($data['pk'],$savepromo);
		}

	}	

?>