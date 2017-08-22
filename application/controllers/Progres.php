<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progres extends MY_Controller {

	public function index($id_proj = '')
	{

		$this->cekParam($id_proj);

		$page = 'Monitoring Progres';

		$this->load->library('survei');
		$this->load->model('location_name');

		$survei = new Survei();
		$locName = new Location_name();

		// initiate project id
		$survei->setProj($id_proj);

		// check user monitoring scope
		$wil_filter = $this->wilFilter();
		$area = $wil_filter != '' ? $locName->getNamaWil($wil_filter) : 'Nasional';

		// name
		$namaSurvei = $survei->getNama();

		$data = array(
			'title' => $page,
			'id_proj' => $id_proj,
			'namaSurvei' => $namaSurvei,
			'area' => $this->location_name->getNamaWil($wil_filter),
			'jenisWil' => $survei->cekId($wil_filter)['jenis'],
			'colJenis' => $survei->cekId($wil_filter)['col'],
			'datatableId' => 'tabel-progres'
			);

		$this->load->view('templates/header', $data);
		$this->load->view('add_head/css_leaflet');
		$this->load->view('add_head/css_datatables');
		$this->load->view('templates/nav_top');
		$this->load->view('templates/nav_left');
		$this->load->view('progres');
		$this->load->view('templates/sidebar_ctrl');
		$this->load->view('templates/footer');
		$this->load->view('add_foot/js_datatables');
		$this->load->view('add_foot/js_progres');
		$this->load->view('templates/closer');		
	}

public function data($id_proj, $id_wil = ''){

		$this->load->library('survei');
		$this->load->model('map_model');

		$survei = new Survei();
		$map = new Map_model();

		$survei->setProj($id_proj);

		$wil_filter = $id_wil == '' ? $this->wilFilter() : $id_wil;
		$survei->setData($wil_filter);
		$map->setSurvei($survei);

		// map
		$forTable = $survei->objectify($wil_filter);

		$pins = $map->getAllPins();

		$data = array(
			'forTable' => $forTable,
			'pins' => $pins,
			// 'donatIzin' => $survei->getIzin(),
			// 'lineInput' => $survei->splitCount(),
			// 'lineDur'	=> $survei->splitAvgDur()
			);

		echo json_encode($data);
	}

// mendapatkan wilayah di atasnya | breadcrumb di view
	public function getParents($id){

		$this->load->model('location_name');

		$id = (string)$id;
		$n = strlen($id);

		$parents = array();

		if ($n >= 2) {

			$prov = array(
				'id' => substr($id, 0, 2),
				'jenis' => 'Provinsi',
				'name' => $this->location_name->getNamaWil(substr($id, 0, 2))
				);
			array_push($parents, $prov);
		}

		if($n >= 4){

			$kab = array(
				'id' => substr($id, 0, 4),
				'jenis' => 'Kota/Kabupaten',
				'name' => $this->location_name->getNamaWil(substr($id, 0, 4))
				);
			array_push($parents, $kab);
		}

		if($n >= 7){

			$kec = array(
				'id' => substr($id, 0, 7),
				'jenis' => 'Kecamatan',
				'name' => $this->location_name->getNamaWil(substr($id, 0, 7))
				);
			array_push($parents, $kec);
		}

		if($n == 10){

			$des = array(
				'id' => substr($id, 0, 10),
				'jenis' => 'Desa/Kelurahan',
				'name' => $this->location_name->getNamaWil(substr($id, 0, 10))
				);
			array_push($parents, $des);
		}

		echo json_encode($parents);
	}
}