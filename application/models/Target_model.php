<?php

class Target_model extends CI_Model {

	// private $id_proj;
	private $project;
	private $targetBS;
	private $table;
	private $columns;

	public function __construct()
	{
		$this->load->database();
		// $this->load->model('project_model');

		parent::__construct();
	}

	public function setProj($project){

		$this->project = $project;
		$this->setVars();
	}

	private function setVars(){

		// $this->project = $this->project_model->getProject($this->id_proj);
		$this->targetBS = $this->project['sample_target_bs'];
		$this->table = $this->project['sampling_table'];
		$this->columns = json_decode($this->project['loc_columns']);
	}

	// get general target by id wilayah
	public function getTarget($id){

		$table = $this->table;
		$columns = $this->columns;
		$targetBS = $this->targetBS;

		$this->db->select('*');
		$this->db->from($table);

		$n = strlen((string)$id);

		if ($n >= 2) {
			
			$this->db->where($columns[0], substr($id, 0, 2));
		}
		if ($n >= 4) {

			$this->db->where($columns[1], substr($id, 2, 2));
		}
		if ($n >= 7) {

			$this->db->where($columns[2], substr($id, 4, 3));
		}
		if ($n >= 10) {
			
			$this->db->where($columns[3], substr($id, 7, 3));
		}
		if ($n > 10) {

			$this->db->where($columns[4], substr($id, 10));
		}

		$count = $this->db->count_all_results();

		return $count * $targetBS;					
	}

	// get all area by certain locus column
	// expected input array is array of locus without zero count
	public function getRestRow($array){

		$table = $this->table;
		$columns = $this->columns;

		$n = strlen(
			(string)
			current($array));

		$cols = '';

		if ($n >= 2) {
			
			$cols .= ', '.$this->columns[0];			
		}
		if ($n >= 4) {

			$cols .= ', '.$this->columns[1];			
		}
		if ($n >= 7) {

			$cols .= ', '.$this->columns[2];			
		}
		if ($n >= 10) {
			
			$cols .= ', '.$this->columns[3];			
		}
		if ($n > 10) {

			$cols .= ', '.$this->columns[4];			
		}

		$this->db->select($cols);
		$query = $this->db->get($this->table);

		return $query->result_array();
	}

	public function getTotalTarget(){

		$table = $this->table;
		$targetBS = $this->targetBS;

		$this->db->select('*');
		$this->db->from($table);
		$result = $this->db->count_all_results() * $targetBS;

		return $result;
	}

}

?>