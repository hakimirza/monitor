<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends CI_Controller {

	// SET SUPER GLOBAL
	var $ci = NULL;	
	private $id_proj; //for testing only
	private $project;
	private $kues;
	private $uuids;

	private $namaVar = array();

	public function __construct() {

		$this->ci =& get_instance();
		$this->ci->load->model('project_model');
		$this->ci->load->model('uuid_model');
		$this->ci->load->model('location_name');
		$this->ci->load->library('parsexml');
		$this->setIdProj();
	}

	public function setIdProj(){

		$this->id_proj = $this->ci->session->userdata('id_proj');
	}

	private function getProject(){

		return $this->ci->project_model->getProject($this->id_proj);
	}

	private function getKues(){

		return $this->ci->project_model->getKuesioner($this->id_proj);
	}

	private function getUuid(){

		return $this->ci->uuid_model->getUuid($this->id_proj);
	}

	// menggabungkan BS dengan kode desa
	private function modifBS($arr){

		foreach ($arr as $key => $row) {

			$arr[$key]['P106'] = $arr[$key]['P104'].$arr[$key]['P106'];
		}
		return $arr;
	}

	public function getNama(){

		return $this->getProject()['name'];
	}
	// get data survei dalam bentuk array assoc by uuid
	public function getData(){

		$project = $this->getProject();
		$kues = $this->getKues();
		$uuids = $this->getUuid();
		$server = $project['aggregate_url'];
		$file = $kues['file'];
		$tag = $kues['tag'];

		$dataSurvei = $this->ci->parsexml->getInstance($server, $file, $tag, $uuids);
		$dataSurvei = $this->modifBS($dataSurvei);
		return $dataSurvei;
	}	
}