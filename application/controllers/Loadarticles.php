<?php

Class Loadarticles extends CI_Controller{

	public function articles(){
		$this->load->model('queries');
		$result = $this->queries->fetcharticles();
		$result = json_encode($result);
		// var_dump($result);
		echo $result;
	}
}

 ?>