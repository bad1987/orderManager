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
		$this->db->select('refArt,designArt,pu');
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
}

?>