<?php

class Project_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	// get general info survei by id
	public function getProject($id){

		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('project');
		$row = $query->row();

		$project = array(
			'id' => $row->id,
			'name' => $row->name,
			'aggregate_url' => $row->aggregate_url,
			'description' => $row->description,
			'sample_target' => $row->sample_target,
			'sample_target_bs' => $row->sampel_target_bs,
			'sampling_table' => $row->sampling_frame_table,
			'loc_columns' => $row->alloc_unit_columns,
			'start_date' => $row->start_date,
			'end_date' => $row->finish_date,
			'delete_status' => $row->delete_status,
			'date_created' => $row->date_created
		 );
		 return $project;						
	}

	public function getKuesioner($id_project){

		$this->db->select('*');
		$this->db->where('id_project', $id_project);
		$query = $this->db->get('kuesioner');
		$row = $query->row();

		$kues = array('tag' => $row->name, 'file' => $row->file);
		return $kues;
	}
}

?>