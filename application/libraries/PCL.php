<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PCL extends CI_Controller {

	// SET SUPER GLOBAL
	var $ci = NULL;
	private $id_proj;
	private $pcl;
	private $pclIdOnly;
	private $survei;

	public function __construct() {

		$this->ci =& get_instance();
		$this->ci->load->model('petugas_model');
		$this->ci->load->library('Survei');
	}

	public function getPcl(){
		
		return $this->pcl;
	}

	public function setProj($id_proj, $wil = ''){

		$this->id_proj = $id_proj;

		$this->survei = new Survei();
		$this->survei->setProj($id_proj);

		$this->setPcl($wil);
	}

	public function getUuidPclArray(){

		$ids = $this->pclIdOnly;
		$idUuid = array();

		foreach ($ids as $id) {

			$arr = $this->getUuidAPcl($id);
			$idUuid[$id] = $arr;
		}

		return $idUuid;
	}

	private function getUuidAPcl($id){

		$proj = $this->id_proj;

		$arr = array();			
		$query = $this->ci->petugas_model->getUuidPcl($id, $proj);
		$result = $query->result_array();

		foreach ($result as $row) {

			array_push($arr, $row['uuid']);
		}

		return $arr;
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

		$pcls = $data;

		if ($wil != '') {

			$pcls = $this->filterPcl($pcls, $wil);
		}

		$this->pcl = $pcls;
		$this->setPclIdOnly($pcls);
	}

	private function setPclIdOnly($pcls){

		$ids = array();

		foreach ($pcls as $pcl) {

			array_push($ids, $pcl['id']);
		}

		$this->pclIdOnly = $ids;
	}

	// filter pcl by id wilayah
	private function filterPcl($pcls, $wil){

		$pclNew = array();

		foreach ($pcls as $pcl) {

			if ($pcl['idprov'] == $wil || $pcl['idkab'] == $wil) {

				array_push($pclNew, $pcl);
			}
		}

		return $pclNew;
	}

	public function pclChart($id, $wil){
		
		$uu = $this->getUuidAPcl($id);

		$survei = $this->survei;

		if (count($uu) > 0) {

				$survei->setUuid($uu);
				$survei->setData($wil);

				$arr['donatIzin'] = $survei->getIzin();
				$arr['lineInput'] = $survei->splitCount();
				$arr['lineDur'] = $survei->splitAvgDur();
				
				return $arr;
		}
		else {

			return false;
		}
	}
}