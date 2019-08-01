<?php

Class Espaceclient extends CI_Controller{

	private $categories;

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
        // $this->load->helper('security');
        $result = $this->queries->categories();
        $this->processCategories($result);
    }

	public function registration(){
        $data['options'] = $this->categories;
        $data['title'] = "Enregistrement";
		// echo date("Y-m-d G:i:s");
		$this->load->view('registration',$data);
	}

    public function processCategories($array){
        $this->categories = array();
        foreach ($array as $key => $value) {
            $this->categories[$value['cat_Ref']] = $value['cat_Design'];
        }
    }

    public function getCatRef($design){
        $key = 'CLI';
        foreach ($this->categories as $key => $value) {
            if (strcmp($key, $design) == 0) {
                $key = $value;
                return false;
            }
        }

        return $key;
    }

	public function userlogin(){
        $data['title'] = "Connexion";
		$this->load->view('login',$data);	
	}

	public function validatelogin(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->userlogin();
        }
        else{
        	$login_data = array(
        		'username' => $this->input->post('username',TRUE),
        		'password' => $this->input->post('password', TRUE),
        	);

        	$this->load->model('queries');
        	$result = $this->queries->authenticateuser($login_data);
        	if($result == FALSE){
        		// echo "Incorrect Username or Password";
        		$donnees['err'] = "Incorrect Username or Password";
                $donnees['title'] = "connexion";
        		$this->load->view('login',$donnees);
        	}
        	else{
        		
        		$sessionData = array(
        			'id' => $result->id,
        			'username' => $result->username,
        			'name' => $result->name,
        			'phoneNum' => $result->phoneNum,
        			'email' => $result->email,
                    'cat_Ref' => $result->cat_Ref,
        		);

        		$this->session->set_userdata($sessionData);
                $data['title'] = "Tableau de bord";
        		// $this->load->view('home');
                redirect('dashboard');
        		// echo var_dump($result);
        	}
        	// echo "submited data are correct";
        }
	}

	public function Validategistration(){
		// echo "validating";
		$this->form_validation->set_message('is_unique', 'this %s is already taken');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('email', 'E-Mail Address', 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('phoneNum', 'Phone Number', 'trim|required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->registration();
        }
        else
        {
        	$data = array(
        		'name' => $this->input->post('name',TRUE),
        		'email' => $this->input->post('email',TRUE),
        		'username' => $this->input->post('username',TRUE),
        		'phoneNum' => $this->input->post('phoneNum',TRUE),
        		'password' => sha1($this->input->post('password',TRUE)),
                'cat_Ref'  => $this->input->post('categorie',TRUE),
        		'created_at' => date("Y-m-d G:i:s"),
        		'updated_at' => date("Y-m-d G:i:s"),
        		);
        	// var_dump($data);
         //    var_dump($this->input->post('categorie'));

        	$this->load->model('queries');
        	if($this->queries->insertdata($data)){
                $this->session->set_flashdata('success', 'registration completed successfully');
        		// echo "registration completed successfully";	
        	}
        	else{
                $this->session->set_flashdata('error', 'registration failed');
        		// echo "registration failed";
        	}
            $data['options'] = $this->categories;
            $data['title'] = "Enregistrement";
            $this->load->view('registration',$data);
        }
	}

	public function userlogout(){
		$array = array('name','email','username','phoneNum','id','cat_Ref');
		$this->session->unset_userdata($array);
		header('location: http://www.siappharma.com');
		// $this->load->view('home');
	}

	public function dashboard(){
		if(isset($this->session->id)){
            $data['title'] = "Tableau de bord";
			$this->load->view('dashboard',$data);
		}
		else{
            $data['title'] = "Connexion";
			$this->load->view('login',$data);
		}
	}
}

?>