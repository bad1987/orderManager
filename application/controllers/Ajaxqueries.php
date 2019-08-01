<?php 
use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// require 'vendor/autoload.php';

Class Ajaxqueries extends CI_Controller{

	private $numCmde;
    private $sendState;
    private $filename;
    private $perpage;

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

        // pagination
        $this->config->load('bootstrap_pagination');
        $config = $this->config->item('pagination_config');
        $result = $this->queries->countCommandesUser();
        $config['base_url'] = site_url('statCommandes');
        $config['total_rows'] = $result;
        $config['per_page'] = 6;
        $this->perpage = $config['per_page'];
        $this->pagination->initialize($config);
    }

	public function envoiCommande(){
        //definir le nom du fichier
        $this->filename = "temp/commandeClient ".date("Y-m-d G:i:s").".txt";

		// echo $this->input->post('prixTotal');
		$stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
		$clientdata = json_decode($stream_clean,TRUE);
		// var_dump($clientdata['order']);
		// foreach ($clientdata['order'] as $key => $value) {
		// 	echo $key;
		// 	var_dump($value);	
		// }
        $content = "";

        if(isset($this->session->id)){
        	$userID = -1;
			$cmde = $clientdata['order'];
			$this->generateCode();
			
            $userID = $this->session->id;

            $dateCmde = date("Y-m-d G:i:s");
            $montantHT = $cmde['prixTotal'];
            $created_at = $dateCmde;
            $updated_at = $dateCmde;

            try{
                // creation de l'entete de la commande

                $datacommande = array(
                	'userId' => $userID,
                    'numCmde' => $this->numCmde,
                    'dateCmde' => $dateCmde,
                    'montantHT' => $montantHT,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                );

                if($this->queries->insertCommande($datacommande) == FALSE){
                	echo "impossible de sauvegarder l'entete de la commande";
                	return 1;
                }

                // creation des lignes de commandes
                $lastNum = $this->queries->getCommandeId();
                if($lastNum == FALSE){
                	echo "unable to retrieve commandes id";
                	return 1;
                }
                
                $body = '<html>
                <head>
                    <meta charset="UTF-8">
                </head>';
                $body .= '<body style="background-color:#7a6b66">';
                // $body = '<h3 style="">Client: '.$this->session->name.'</h3>';
                if ($cmde['clientRef'] == 'NULL') {
                    $body = '<h3 style="">CLIENT: '.strtoupper($this->session->name).'</h3>';
                    $content .= $this->session->username.chr(10);
                }
                else{
                    $body = '<h3 style="">COMMERCIAL: '.strtoupper($this->session->name).'</h3>';
                    $body .= '<h3 style="">CLIENT CONCERNE: '.strtoupper($cmde['clientDesign']).'</h3>';
                    $content .= $cmde['clientRef'].chr(10);
                }

                $body .= '<h3>EMAIL: '.$this->session->email.'</h3>';
                $body .='<h3>NUMERO TELEPHONE: '.$this->session->phoneNum.'</h3><br><br><br>';
                $body .= '<table style="width:100%;border: 1px solid black;border-collapse: collapse;">';
                $body .= '<tr><th style="border: 1px solid black;border-collapse: collapse;">QUANTITE</th>
                         <th style="border: 1px solid black;border-collapse: collapse;">DESIGNATION</th></tr>';

                

                foreach($cmde as $key=>$value){
                    if($key === 'prixTotal' || $key === 'clientRef' || $key === 'clientDesign'){
                        break;
                    }
                    //preparation du mail
                    $body .='<tr><td style="text-align: center;border: 1px solid black;border-collapse: collapse;">'.$value[1].'</td>';
                    $body .='<td style="text-align: center;border: 1px solid black;border-collapse: collapse;">'.$value[0].'</td></tr>';

                    $content .= $value[1].'*'.$value[0].'*'.$key.chr(10);

                    $dataligne = array(
                    	'refferenceArt' => $key,
                        'libelleProduit' => $value[0],
                        'idCmde' => $lastNum->id,
                        'pu' => $value[2],
                        'Qte' => $value[1],
                        'montantHT' => $value[1] * $value[2],
                        'created_at' => $created_at,
                        'updated_at' => $updated_at
                    );

                    if($this->queries->insertLigneCommande($dataligne) == FALSE){
	                	echo "impossible de sauvegarder les lignes de la commande";
	                	return 1;
	                }    
                }
                $body .= "</table></body></html>";
                // envoi de la commande par mail

                $this->createFile($content);
                $this->sendMail($body,$lastNum->id);
                try{
                    if (is_readable($this->filename)) {
                        unlink($this->filename);
                    }
                }
                catch(Exception $e){

                }

                echo $this->sendState;
                // sleep(5);
                // return response()->json("envoye");
            } catch(Exception $e){
                echo $e;
            }
        }
        else{
        	echo "Vous devez etre connecter avant de passer une commande";
        }
	}

    public function createFile($string){
        $file = fopen($this->filename, 'w') or die("unable to open the file");
        fwrite($file, $string);
        fclose($file);
    }

	protected function sendMail($body,$lastNum){

        $mail             = new PHPMailer\PHPMailer(); // create a n
        // $mail->SMTPDebug  = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465; // or 587
        $mail->isSMTP();

        $mail->Username = "didier.bayanga@gmail.com";
        $mail->Password = "siappharma2019";

        $mail->SetFrom($this->session->email, $this->session->name);
        $mail->Subject = "Commande de ".$this->session->name;
        $mail->Body    = $body;
        // new update
        $mail->addAttachment($this->filename);
        $mail->AddAddress("antoine.bayanga@gmail.com", "administrateur");
        $mail->ContentType = 'text/html';
        if ($mail->Send()) {
            $this->sendState = "commande envoyee";
        } else {
            //suppression des donnees concernant cette commande
            $this->queries->resetLastCommande($this->numCmde);
            $this->queries->resetLastLigneCommande($lastNum);

            $this->sendState = 'l\'envoi de la commande a echoue';
        }
    }

    protected function generateCode(){
        $string = $this->queries->getCommandeId();
            // if($string == FALSE){
            // 	echo "unable to retrieve commandes id in function 'generateCode()'";
            // 	return 1;
            // }

        $pref = date('y').'CD';
        if($string == FALSE){
            $this->numCmde = $pref.'00000';
        }
        else{
            $string = $string->numCmde;

            // $arrayCar = str_split($string->numCmde);
            // array_shift($arrayCar);
            // array_shift($arrayCar);
            // array_shift($arrayCar);
            // array_shift($arrayCar);

            // $arrayCar = array_reverse($arrayCar);

            // $nextId='';
            // $j = 0;
            // foreach($arrayCar as $car){
            //     if($car <9 && $j === 0){
            //         $nextId = ($car + 1).$nextId;
            //         $j = $j + 1;
            //     }
            //     else{
            //         $nextId = $car.$nextId;
            //     }
            // }
            // $nextId = $pref.$nextId;

            $prefix="";$suffix="";$nouveau='';
            $i = strlen($string) - 1;
            while ($i >= 4) {
                $suffix = $string[$i].$suffix;
                $i = $i - 1;
            }
            while ($i >= 0) {
                $prefix = $string[$i].$prefix;
                $i = $i - 1;
            }

            if ($prefix != $pref) {
                $nouveau = $pref.'00000';
            }
            else{
                $nouveau = (int)$suffix + 1;
                if (strlen($nouveau) > strlen($suffix)) {
                    # code...
                }
                else{
                    if (strlen($nouveau) < strlen($suffix)) {
                        $i = (strlen($suffix) - strlen($nouveau)) - 1;
                        while ($i >=0) {
                            $nouveau = $suffix[$i].$nouveau;
                            $i = $i - 1;
                        }
                    }
                }
                $nouveau = $prefix.$nouveau;
            }

            $this->numCmde = $nouveau;
        }
    }

    public function chargerCommande($offset=0){
        
        $result = $this->queries->retrieveCommandeUser($this->perpage,$offset);
        // if($result == FALSE){
        //     echo json_encode(array());
        //     return 1;
        // }

        // $result = json_encode($result);
        // echo $result;

        $data['stat'] = $result;
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = "Statistiques";
        // var_dump($data['stat']);
       $this->load->view('statClients',$data); 
    }

    public function chargerLigneCommande($id){

        $result = $this->queries->loadOrderLignes($id);
        if($result == FALSE){
            echo json_encode(array());
            return 1;
        }

        $result = json_encode($result);
        echo $result;
    }

    public function filtrer($debut,$fin){
        $result = $this->queries->filter($debut,$fin);
        if ($result == FALSE) {
            $result = array(); 
        }
        echo json_encode($result);
    }

    public function indexClient(){
        $this->load->view('manageClients');
    }
    public function createClients(){
        $this->load->helper('file');
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'txt';
        $config['max_size']             = 100;
        $config['overwrite']            =TRUE;
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
                $error = array('error' => $this->upload->display_errors());
                $data['error'] = $error;
                $data['title'] = "Gestion clients";

                $this->load->view('manageClients', $data);
        }
        else
        {

                $data = array('upload_data' => $this->upload->data());
                $file = $data['upload_data']['full_path'];
                $myfile = fopen($file, "r") or die("Unable to open file!");
                $content = fread($myfile, filesize($file));

                $rows = explode(';', $content);
                // var_dump($rows);
                for ($i=0; $i <sizeof($rows);$i += 1){ 
                    $fields = explode(',', $rows[$i]);
                    if (strlen($rows[$i]) > 0 && $this->queries->getClient($fields[0]) == FALSE) {
                            $clientArray = array(
                            'CL_Ref'        => $fields[0],
                            'CL_Intitule'   => $fields[1]
                        );

                        $this->queries->insertClient($clientArray);
                    }

                }
                fclose($myfile);
                $data['success'] = "client table created successfully";
                $data['title'] = "Gestion clients";
                $this->load->view('manageClients', $data);
        }
    }

    public function commandesClient(){
        $data['title'] = "Commande";
        $this->load->view('commandeClient',$data);
    }
}

?>