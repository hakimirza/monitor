<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PCL extends CI_Controller {

	// SET SUPER GLOBAL
	var $ci = NULL;
	private $id_proj;
	private $pcl;

	public function __construct() {

		$this->ci =& get_instance();
		$this->ci->load->model('petugas_model');
	}

	public function getPcl(){
		
		return $this->pcl;
	}

	public function setProj($id_proj, $wil = ''){

		$this->id_proj = $id_proj;
		$this->setPcl($wil);
	}

	private function setPcl($wil = ''){

		$id_proj = $this->id_proj;

		$query = $this->ci->petugas_model->getListPcl($id_proj);

		$data = array();

		foreach ($query->result_array() as $row) {
			$r = array(
				'id' => $row['id'],
				'name' => ucwords($row['firstname'].' '.$row['lastname']),
				'idprov' => $row['idprov'],
				'prov' => $row['prov'],
				'idkab' => $row['idkab'],
				'kab' => $row['kab'],
				'idtim' => $row['id_team'],
				'tim' => $row['team_name'],
				'input' => intval($row['input']),
				'target' => intval($row['target_pcl'])
 				);
			array_push($data, $r);
		}

		$this->pcl = $data;

		if ($wil != '') {

			$this->pcl = $this->filterPcl($wil);
		}
	}

	// filter pcl by id wilayah
	private function filterPcl($wil){

		$pclNew = array();
		$pcls = $this->pcl;

		foreach ($pcls as $pcl) {

			if ($pcl['idprov'] == $wil || $pcl['idkab'] == $wil) {

				array_push($pclNew, $pcl);
			}
		}

		return $pclNew;
	}

	private function pclPerform(){

		$pcl = $this->pcl;

	}
}