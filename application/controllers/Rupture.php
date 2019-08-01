<?php
	Class Rupture extends CI_controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('queries');
		}

		public function index(){
			$this->load->view('rupture');
		}

		public function miseajour(){
			$this->load->helper('file');
	    $config['upload_path']  = './uploads/';
	    $config['allowed_types'] = 'txt';
	    $config['max_size'] = 100;
	    $config['overwrite'] =TRUE;
	    $this->load->library('upload', $config);

	    if ( ! $this->upload->do_upload('userfile'))
	    {
        $error = array('error' => $this->upload->display_errors());

        $this->load->view('manageArticles', $error);
	    }
	    else
	    {
	      $this->load->model('queries');

	      $data = array('upload_data' => $this->upload->data());
	      $file = $data['upload_data']['full_path'];
	      $myfile = fopen($file, "r") or die("Unable to open file!");
	      $content = fread($myfile, filesize($file));

	      $rows = explode(';', $content);
	      // var_dump($rows);
	      for ($i=0; $i <sizeof($rows);$i += 1){ 
          $fields = explode('*', $rows[$i]);
          if (strlen($rows[$i]) > 0) {
            $clientArray = array(
            'refArt' => $fields[0],
        		);

        		if ($fields[2] > 0) {
        			$clientArray['rupture'] = 0;
        		}
        		else{
        			$clientArray['rupture'] = 1;
        		}

            $this->queries->setRupture($clientArray);
          }
	      }
	      fclose($myfile);
	      $data['success'] = "operation completed successfully";
	      $this->load->view('rupture', $data);
	    }
		}
	}
?>