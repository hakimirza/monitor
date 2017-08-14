<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progres extends MY_Controller {

	public function index($id = '')
	{

		$id_proj = $this->session->userdata('id_proj');

		$page = 'Monitoring Progres';

		$this->load->library('survei');
		$this->load->model('map_model');
		$this->load->model('target_model');
		$this->load->model('location_name');

		$survei = new Survei();
		$map = new Map_model();

		$namaSurvei = $survei->getNama();
		$dataSurvei = $survei->getData();
		$keyCol = $this->cekId($id)['tag'];
		$count = $this->getCountDistinct($id_proj, $id, $dataSurvei);

		$map->setSurvei($survei);
		$location = $map->getAllPins();

		// $keyCol = array(
		// 	'P101',//Prov
		// 	'P102',//KabKot
		// 	'P103',//Kec
		// 	'P104' //Des
		// 	);

		$parents = '';
		$forTable = $this->objectify($count, $id_proj);
		
		if ($id != '') {
			
			$parents = $this->getParents($id);
		}

		$data = array(
			'title' => $page,
			'namaSurvei' => $namaSurvei,
			'location' => $location,
			'forTable' => $forTable,
			'jenisWil' => $this->cekId($id)['jenis'],
			'colJenis' => $this->cekId($id)['col'],
			'namaWil' => $this->location_name->getNamaWil($id),
			'parents' => $parents
			);

		$this->load->view('templates/header', $data);
		$this->load->view('add_head/css_progres');
		$this->load->view('templates/nav_top');
		$this->load->view('templates/nav_left');
		$this->load->view('progres');
		$this->load->view('templates/sidebar_ctrl');
		$this->load->view('templates/footer');
		$this->load->view('add_foot/js_datatables');
		$this->load->view('add_foot/js_progres');
		$this->load->view('templates/closer');		
	}

	private function cekId($id){

		$n = strlen($id);

		switch ($n) {

			case '2':
			return array(
				'tag'=>'P102',
				'jenis'=>'Provinsi',
				'col' => 'Kabupaten/Kota'
				);

			case '4':
			return array(
				'tag'=>'P103',
				'jenis'=>'Kota/Kabupaten',
				'col' => 'Kecamatan'
				);

			case '7':
			return array(
				'tag'=>'P104',
				'jenis'=>'Kecamatan',
				'col' => 'Kelurahan/Desa'
				);

			case '10':
			return array(
				'tag'=>'P106',
				'jenis'=>'Kelurahan/Desa',
				'col' => 'Blok Sensus'
				);

			default:
			return array(
				'tag'=>'P101',
				'jenis'=>'<b>INDONESIA</b>',
				'col'=>'Provinsi'
				);
		}
	}

// hitung jumlah row distinct by tag -> need function cekId() based on xml instances ODK
	private function getCountDistinct($id_proj, $id, $data){

		$target = new Target_model();

		$id = (string)$id;
		$n = strlen((string)$id);
		$tag = $this->cekId($id)['tag'];

		$var = array();
		foreach ($data as $row) {

			array_push($var, $row[$tag]);
		}

		$count = array_count_values($var);

		// get zero input area
		$exist = array();
		foreach ($count as $key => $val) {

			array_push($exist, $key);
		}
		$restRow = $target->getRestRow($exist);

		$arrAllWil = array();
		foreach ($restRow as $arr) {

			$key = '';
			$i = 1;
			foreach ($arr as $cod) {

				if ($i == 2) {

					$cod = str_pad($cod, 2, "0", STR_PAD_LEFT); //fixing kode kota 2 digit
				}else if ($i == 3) {
					
					$cod = str_pad($cod, 3, "0", STR_PAD_LEFT); //kode kecamatan 3 digit
				}else if ($i == 4) {
					
					$cod = str_pad($cod, 3, "0", STR_PAD_LEFT); //kode desa 3 digit
				}

				$key .= $cod;
				$i++;
			}

			$arrAllWil[$key] = 0;
		}

		//extract key outersection of 2 arrays and join with previous given array
		$count = $count + array_diff_key($arrAllWil, $count);

		if ($id != '') {

			$arrNew = array();
			foreach ($count as $key => $val) {

				$key = (string)$key;
				$keyCut = substr($key, 0, $n);
				if ($keyCut == $id) {

					$arrNew[$key] = $val;
				}
			}

			return $arrNew;
		}
		else return $count;
	}

// insert variabel count per kode wilayah
	private function objectify($count, $id_proj){

		$target = new Target_model();

		$arrChild = array();

		foreach ($count as $kode => $val) {

			$countObj = array(
				'id' => $kode,
				'nama' => $this->location_name->getNamaWil($kode),
				'count' => $val,
				'target' => $target->getTarget($kode)
				);

			// $arrChild[$kode] = $countObj;
			array_push($arrChild, $countObj);
		}

		return $arrChild;
	}

// mendapatkan wilayah di atasnya | breadcrumb di view
	private function getParents($id){

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

		return $parents;
	}
}