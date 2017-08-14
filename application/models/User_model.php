<?php

class User_model extends CI_Model {

	public function __construct()
	{

		$this->load->database();
		parent::__construct();
	}

	public function auth($data){

		$email = $data['email'];
		$password = md5($data['password']);

		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$query = $this->db->get();
		$count = $this->db->count_all_results();

		if ($count != 0) {
			return $query;
		}

		return false;
	}

}