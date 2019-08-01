<?php

	Class Listing_articles extends CI_Controller{

		private $perpage;
		private $conf;

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

			// desactivation des promotions expirees
			$this->queries->batchDeactivation();

			// pagination
	    $this->config->load('bootstrap_pagination');
			$config = $this->config->item('pagination_config');
	    // $result = $this->queries->countListing();
	    $config['uri_segment'] = 3;
			// $config['total_rows'] = $result;
			$config['per_page'] = 4;
			$this->perpage = $config['per_page'];
			$this->conf = $config;
			// $this->pagination->initialize($config);
		}

		public function listing($car=""){
			$result['data'] = $this->queries->promoShortList();

			if ($car == "") {
				$result['listing'] = $this->queries->shortListing();
			}
			else{
	      $this->setPaginationParam($car);
	      $result['listing'] = $this->queries->filterListing($car,$this->perpage,0);
				// $result['listing'] = $this->queries->filterListing($car,);	
			}
			// var_dump($result['listing']);
			$result['pagination'] = $this->pagination->create_links();
			$result['title'] = "Accueil";
			$this->load->view('home',$result);
		}

		public function listingPaginated($prefix,$offset=0){
			$result['listing'] = $this->queries->filterListing($prefix,$this->perpage,$offset);
			$result['data'] = $this->queries->promoShortList();
			$this->setPaginationParam($prefix);			
			$result['pagination'] = $this->pagination->create_links();
			$result['title'] = "Accueil";
			$this->load->view('home',$result);
			// var_dump($result);

		}

		public function setPaginationParam($car){
			$this->conf['base_url'] = site_url('pagination/').$car;
      $res = $this->queries->countListing($car);
      $this->conf['total_rows'] = $res;
			$this->pagination->initialize($this->conf);
		}

	}

 ?>