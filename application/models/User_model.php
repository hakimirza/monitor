<?php

class User_model extends CI_Model {

	//roles allowed to monitor 
	//1 => superadmin, 5 => admin prov, 6 => admin kab, 4 => monitor pusat, 41 => monitor prov, 42 => monitor kab
	private $role_monitor = array(1, 5, 6, 4, 41, 42);

	public function __construct()
	{

		$this->load->database();
		parent::__construct();
	}

	public function loginData($data){

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

	public function getProjectList($id_user){

		$role = $this->role_monitor;

		$this->db->select('id_project');
		$this->db->from('user_role_project');
		$this->db->where('id_user', $id_user);
		$this->db->where_in('id_role', $role);
		$this->db->distinct();
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$projects[] = $row->id_project;
		}

		return $projects;
	}

	public function isExist($id_user, $id_project){

		$this->db->select('*');
		$this->db->from('user_project');
		$this->db->where('id_user', $id_user);
		$this->db->where('id_project', $id_project);
		$count = $this->db->count_all_results();
		$isExist = $count > 0 ? true : false;

		return $isExist;
	}

	public function isPusat($id_user){

		$this->db->select('is_pusat');
		$this->db->from('user');
		$this->db->where('id_user', $id_user);
		$query = $this->db->get();
		$val = $query->row();

		return $val->is_pusat == 0 ? false : true;
	}

	public function isProv($id_user){

		$this->db->select('id_provinsi');
		$this->db->from('user');
		$this->db->where('id_user', $id_user);
		$query = $this->db->get();
		$val = $query->row();

		return $val->id_provinsi == 0 ? false : true;
	}

	public function isKab($id_user){

		$this->db->select('id_kabupaten');
		$this->db->from('user');
		$this->db->where('id_user', $id_user);
		$query = $this->db->get();
		$val = $query->row();

		return $val->id_kabupaten == 0 ? false : true;
	}

	// expected input $key => ['prov', 'kab']
	public function idWil($id_user, $key){

		$col = $key == 'prov' ? 'id_provinsi' : ($key == 'kab' ? 'id_kabupaten' : true);

		if($col) return false;

		$this->db->select($col);
		$this->db->from('user');
		$this->db->where('id_user', $id_user);
		$query = $this->db->get();
		$val = $query->row_array();

		return $val[$col];
	}	

}