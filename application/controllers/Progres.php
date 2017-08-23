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
			'wil' => $wil_filter,
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

		// data
		$forTable = $survei->objectify($wil_filter);
		$input = $survei->countData();
		$pins = $map->getAllPins();

		$data = array(
			'forTable' => $forTable,
			'pins' => $pins,
			'input' => $input
			);

		echo json_encode($data);
	}

// mendapatkan wilayah di atasnya | breadcrumb di view
	public function getParents($id = ''){

		$parents = array();

		$this->load->library('survei');
		$this->load->model('location_name');
		$survei = new Survei();

		$id = (string)$id;
		$n = strlen($id);

		if ($this->wilFilter() == '') {

			$def = array(
				'id' => '',
				'jenis' => '',
				'name' => 'INDONESIA',
				'col' => $survei->cekId('')['col']
				);
			array_push($parents, $def);

			if ($n == 0) {
				echo json_encode($parents);
				return;
			}
		}

		if ($n >= 2) {

			$sub = substr($id, 0, 2);
			$prov = array(
				'id' => $sub,
				'jenis' => 'PROVINSI',
				'name' => $this->location_name->getNamaWil($sub),
				'col' => $survei->cekId($sub)['col']
				);
			array_push($parents, $prov);
		}

		if($n >= 4){

			$sub = substr($id, 0, 4);
			$kab = array(
				'id' => $sub,
				'jenis' => 'KOTA/KABUPATEN',
				'name' => $this->location_name->getNamaWil($sub),
				'col' => $survei->cekId($sub)['col']
				);
			array_push($parents, $kab);
		}

		if($n >= 7){

			$sub = substr($id, 0, 7);
			$kec = array(
				'id' => $sub,
				'jenis' => 'KECAMATAN',
				'name' => $this->location_name->getNamaWil($sub),
				'col' => $survei->cekId($sub)['col']
				);
			array_push($parents, $kec);
		}

		if($n == 10){

			$sub = substr($id, 0, 10);
			$des = array(
				'id' => $sub,
				'jenis' => 'DESA/KELURAHAN',
				'name' => $this->location_name->getNamaWil($sub),
				'col' => $survei->cekId($sub)['col']
				);
			array_push($parents, $des);
		}

		echo json_encode($parents);
	}
}