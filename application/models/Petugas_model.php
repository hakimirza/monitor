<?php

class Petugas_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function getListPcl($id_proj)
	{
		$this->db->
		select('u.id, u.firstname, u.lastname, p.id AS idprov, p.name AS prov, r.id AS idkab, r.name AS kab, tu.id_team, t.team_name, COUNT(d.id_user) AS input, tt.target_pcl');
		$this->db->from('user u');
		$this->db->join('provinces p', 'u.id_provinsi = p.id');
		$this->db->join('regencies r', 'u.id_kabupaten = r.id');
		$this->db->join('team_user tu', 'u.id = tu.id_user');
		$this->db->join('team t', 'tu.id_team = t.id');
		$this->db->join('data_publish d', 'u.id = d.id_user AND d.id_project = '.$id_proj, 'left');
		$this->db->join('team_target tt', 'tu.id_team = tt.id_team');
		$this->db->where('t.id_project', $id_proj);
		$this->db->where('tu.is_kortim', 0);
		$this->db->group_by('u.id');
		$query = $this->db->get();

		return $query;
	}

	public function getUuidPcl($pcl, $id_proj){

		$this->db->select('uuid_aggregate AS uuid');
		$this->db->from('data_publish');
		$this->db->where('id_user', $pcl);
		$this->db->where('id_project', $id_proj);
		$query = $this->db->get();

		return $query;
	}

	// insert survei object
	public function getPclLoc($id, $survei){

		$project = $survei->getProject();
		$table = $project['sampling_table'];

		$this->db->select('tb.id_pcl, z.idprovinsi AS idprov, z.idkabupaten AS idkab, z.idkecamatan AS idkec, z.iddesa AS iddes, z.nobloksensus AS bs');
		$this->db->from('team_bloksensus tb, '.$table.' z');
		$this->db->where('tb.id_pcl', $id);
		$this->db->where('tb.id_bloksensus = z.skit_id');
		$query = $this->db->get();

		return $query;
	}

	public function getAName($id){

		$this->db->select('firstname, lastname');
		$this->db->from('user u');
		$this->db->where('u.id',$id);
		$query = $this->db->get();
		$result = $query->row_array();
		$name = $result['firstname'].' '.$result['lastname'];

		return $name;
	}

}

?>