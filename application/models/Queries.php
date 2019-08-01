<?php

Class Queries extends CI_Model{


	public function insertdata($data){
		return $this->db->insert('users',$data);
	}

	public function authenticateuser($data){

		$query = $this->db->where(['username' => $data['username'], 'password' => sha1($data['password'])])
			->get('users');

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return FALSE;
		}
	}

	public function countUserOrders($userId){
		$this->db
				 ->where('userId', $userId)
				 ->select('userId')
				 ->from('commandes');
		$query = $this->db->count_all_results();
		return $query;
	}


	public function fetcharticles(){
		$this->db->select('refArt,designArt,pu,rupture');
		$query = $this->db->get('articles');

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function insertCommande($data){
		return $this->db->insert('commandes',$data);
	}

	public function insertLigneCommande($data){
		return $this->db->insert('ligneCommandes',$data);
	}

	public function getCommandeId(){
		$query = $this->db->order_by('updated_at', 'DESC')->get('commandes');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return FALSE;
		}
	}

	public function loadOrders(){

		$this->db->select('id,numCmde,dateCmde,montantHT');
		$this->db->where(['userId' => $this->session->id]);
		$this->db->order_by('dateCmde', 'DESC');
		$query =$this->db->get('commandes');

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}

	}

	public function paginateOrders($limite,$offset){
		$this->db
				 ->limit($limite,$offset)
				 ->where(['userId' => $this->session->id])
				 ->order_by('dateCmde', 'DESC')
				 ->select('id,numCmde,dateCmde,montantHT');
		$query =$this->db->get('commandes');

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function loadOrderLignes($id){

		$this->db->select('libelleProduit, Qte');
		$this->db->where(['idCmde' => $id]);
		$query =$this->db->get('ligneCommandes');

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}

	}

	public function searchuser($arg){
		if ($arg['field'] == 'name') {
			$this->db->like('name', $arg['motif']);
		} else {
			$this->db->where([$arg['field'] => $arg['motif']]);
		}
		$query =$this->db->get('users');	

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function updateClient($data){
		$this->db->where('username',$data['username']);
		$query = $this->db->update('users',$data);
		return $this->db->affected_rows();
	}

	public function filter($d,$f){
		$this->db->where('userId', $this->session->id);	
		$this->db->where('dateCmde >=',$d);
		$this->db->where('dateCmde <=',$f);
		$this->db->select('id, numCmde, dateCmde, montantHT');
		$query = $this->db->get('commandes');


		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function categories(){
		$this->db
			 ->select('cat_Ref, cat_Design');
		$query = $this->db->get('categorie');

		return $query->result_array();
	}

	public function insertClient($data){
		$this->db->insert('clients',$data);
	}

	public function getClient($CL_Ref){
		$this->db->where('CL_Ref', $CL_Ref);
		$query = $this->db->get('clients');


		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}	
	}

	public function fetchClients(){
		$this->db->select('CL_Ref,CL_Intitule');
		$query = $this->db->get('clients');

		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function emptyArticles(){
		$this->db->empty_table('articles');
	}

	public function insertArticles($data){
		$this->db->insert('articles',$data);
	}

	public function resetLastCommande($idCmde){
		$this->db->delete('commandes', array('numCmde' => $idCmde));
	}

	public function resetLastLigneCommande($lastNum){
		$this->db->delete('ligneCommandes', array('idCmde' => $lastNum));
	}

	public function retrieveLastCommande(){
		$this->db
					->select('commandes.updated_at,montantHT, name, cat_Design')
					->from('users')
					->join('commandes','commandes.userId = users.id')
					->join('categorie','categorie.cat_Ref = users.cat_Ref')
					->limit(1)
					->order_by('commandes.id','DESC');

		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function retrieveCommande($perpage,$numbCmde){
		$this->db
					->limit($perpage,$numbCmde)
					->select('commandes.updated_at,montantHT, name')
					->from('users')
					->join('commandes','commandes.userId = users.id');

		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}	
	}

	public function countCommandes(){
		$this->db
				 ->select('id')
				 ->from('commandes');
		$query = $this->db->count_all_results();
		return $query;
  }

  public function retrieveCommandeUser($perpage,$numbCmde){
		$this->db
				->limit($perpage,$numbCmde)
				->select('id,numCmde,created_at,montantHT')
				->order_by('dateCmde', 'DESC')
				->where('userId',$this->session->id);

		$query = $this->db->get('commandes');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else{
			return false;
		}	
	}

	public function countCommandesUser(){
		$this->db
				 ->select('id')
				 ->where('userId',$this->session->id)
				 ->from('commandes');
		$query = $this->db->count_all_results();
		return $query;
  }

  public function articleImagesProcessing($uploadData){
  	$numImages = count($uploadData);
  	for ($i=0; $i < $numImages; $i++) {
  		$articleRef = explode('.', $uploadData[$i]['file_name'])[0];
  		$this->db
  				 ->where('refArt',$articleRef)
  				 ->update('articles',array('imageLink' => $uploadData[$i]['file_name']));
  	}
  }

  /************************************PROMOTION**************************************************************/

  public function newPromotion($rows){
  	$this->db->insert('promotions',$rows);
  	if ($this->db->affected_rows() > 0) {
  		return TRUE;
  	}
  	else{
  		return FALSE;
  	}
  }

  public function promoShortList(){
  	$this->db
  			 ->distinct()
  			 ->select('promotions.id_article, articles.designArt')
  			 ->from('promotions')
  			 ->where('sommeil',0)
  			 ->join('articles','articles.refArt = promotions.id_article')
  			 ->limit(5);
  	$query = $this->db->get();
  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	}
  	else{
  		return FALSE;
  	}
  }

  public function promoFullList(){
  	$this->db
  			 ->distinct()
  			 ->select('promotions.id_article, articles.designArt')
  			 ->from('promotions')
  			 ->where('sommeil',0)
  			 ->join('articles','articles.refArt = promotions.id_article');
  	$query = $this->db->get();
  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	}
  	else{
  		return FALSE;
  	}
  }

  public function autrePromotion($artRef){
  	$this->db
  			 ->distinct()
  			 ->select('promotions.id_article, articles.designArt')
  			 ->from('promotions')
  			 ->where('sommeil',0)
  			 ->where('promotions.id_article <>',$artRef)
  			 ->join('articles','articles.refArt = promotions.id_article');
  	$query = $this->db->get();
  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	}
  	else{
  		return FALSE;
  	}
  }

  public function detailPromotion($artRef){
  	$this->db
  			 ->select('quantite, pourcentage, unite_gratuite, date_debut, date_fin')
  			 ->from('promotions')
  			 ->where('sommeil',0)
  			 ->where('id_article',$artRef);
  	$query = $this->db->get();
  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	} else {
  		return FALSE;
  	}
  	
  }

  public function getArticleName($artRef){
  	$this->db
  			 ->select('designArt')
  			 ->from('articles')
  			 ->where('refArt',$artRef);
  	$query = $this->db->get();
  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	} else {
  		return FALSE;
  	}
  }

  public function getArticle($refArt){
  	$this->db
  			 ->where('refArt',$refArt);
  	$query = $this->db->get('articles');
  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	} else {
  		return FALSE;
  	}
  }

  public function updateArticlePrice($data){
  	$this->db
  			 ->set('pu',$data['pu'])
  			 ->where('refArt',$data['refArt'])
  			 ->update('articles');
  }

  public function batchDeactivation(){
  	$today = date('Y-m-d');
  	// echo "disabling some promotions";
  	$this->db
  			 ->set('sommeil',1)
  			 ->where('date_fin <',$today)
  			 ->where('sommeil',0)
  			 ->update('promotions');
  }

  public function fetchPromo($artRef){
  	$this->db
  			 ->where('id_article',$artRef);
  	$query = $this->db->get('promotions');
  	
  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	} else {
  		return FALSE;
  	}
  }

  public function editedPromo($pk,$data){
  	$this->db
  			 ->where('id_promotion',$pk)
  			 ->update('promotions',$data);
  }


  /***********************************************************************************************************/

  /**********************************Listing des articles*****************************************************/
	public function filterListing($caracter,$limit,$offset){
  	$this->db
  			 ->select("designArt, imageLink")
  			 ->from('articles')
  			 ->where('imageLink IS NOT NULL')
  			 ->limit($limit,$offset)
  			 ->like('designArt',$caracter,'after');
  	$query = $this->db->get();

  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	} else {
  		return FALSE;
  	}
  }

  public function shortListing(){
  	$this->db
  			 ->select("designArt, imageLink")
  			 ->from('articles')
  			 ->limit(4)
  			 ->where('imageLink IS NOT NULL');
  	$query = $this->db->get();

  	if ($query->num_rows() > 0) {
  		return $query->result_array();
  	} else {
  		return FALSE;
  	}
  }

  public function countListing($car){
		$this->db
				 ->select('imageLink')
				 ->from('articles')
				 ->like('designArt',$car,'after')
				 ->where('imageLink IS NOT NULL');
		$query = $this->db->count_all_results();
		return $query;
  }

  /***********************************************************************************************************/

  /*******************************************Rupture*********************************************************/

  public function setRupture($tab){
  	$this->db
  			 ->set('rupture',$tab['rupture'])
  			 ->where('refArt',$tab['refArt'])
  			 ->update('articles');
  }

  /***********************************************************************************************************/
}

?>





