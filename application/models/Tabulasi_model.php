<?php

class Tabulasi_model extends CI_Model {

	private $table = 'user_tabulation_config';

	public function __construct()
	{
		$this->load->database();

		parent::__construct();
	}

	public function saveConfig($data){

		// $id_user = $data['id_user'];
		// $id_project = $data['id_project'];
		// $config = $data['config'];
		// $is_on = $data['is_on'];
		do{
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('id_user', $data['id_user']);
			$this->db->where('id_project', $data['id_project']);
			$this->db->where('name', $data['name']);
			$count = $this->db->count_all_results();

			if ($count != 0) {
				$data['name'] .= '('.($count+1).')';
			}
		}while($count != 0);

		$this->db->insert('user_tabulation_config', $data);
	}

	public function loadConfig($data){

		$this->db->select('*');
		$this->db->where('id_user', $data['id_user']);
		$this->db->where('id_project', $data['id_project']);
		$this->db->where('is_on', 1);
		$query = $this->db->get($this->table);

		return $query->result_array();
	}
}

?>