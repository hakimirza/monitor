<?php

class Uuid_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	//get array uuid dari tabel data_publish, database custom
	public function getUuid($id_project){
		$this->db->select('uuid_aggregate');
		$this->db->where('id_project', $id_project);
		$query = $this->db->get('data_publish');
		$uuidObs = $query->result();
		$uuids = array();

		foreach ($uuidObs as $uuidOb) {
			
			array_push($uuids, $uuidOb->uuid_aggregate);
		}

		return $uuids;
	}
}

?>