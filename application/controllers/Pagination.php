<?php

Class Pagination extends CI_Controller{
	private $perpage;

	public function __construct(){
		parent::__construct();
		$this->load->model('queries');
		$this->config->load('bootstrap_pagination');
		$config = $this->config->item('pagination_config');
		$result = $this->queries->countUserOrders($this->session->id);
		$config['base_url'] = '/articles';
		$config['total_rows'] = $result;
		$config['per_page'] = 2;
		$this->perpage = $config['per_page'];
		$this->pagination->initialize($config);
	}

	public function commandeClient($num_articles=0){
		$stat = $this->queries->paginateOrders($this->perpage,$num_articles);
		$data['pagination'] = $this->pagination->create_links();
		$data['stat'] = $stat;
		$this->load->view('paginationtest',$data);
	}
}
?>