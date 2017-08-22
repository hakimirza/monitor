<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends MY_Controller {

	public function index($id_proj = '')
	{

		$this->cekParam($id_proj);

		$page = 'Dasbor';
		
		$this->load->library('survei');
		$this->load->model('target_model');
		$this->load->model('location_name');

		$survei = new Survei();
		$target = new Target_model();
		$locName = new Location_name();
		
		// initiate project id
		$survei->setProj($id_proj);
		$target->setProj($survei->getProject());

		// check user monitoring scope
		$wil_filter = $this->wilFilter();
		$area = $wil_filter != '' ? $locName->getNamaWil($wil_filter) : 'Nasional';

		// name
		$namaSurvei = $survei->getNama();

		// progres
		$target_input = $target->getTarget($wil_filter);

		// 2017-06-21 02:36:54
		// time sample : "Aug 11, 2017 10:00:00"
		$start_time = $survei->getStartDate();
		$end_time = $survei->getEndDate();

		$data = array(
			'title' => $page,
			'area' => $area,
			'id_proj' => $id_proj,
			'nama_survei' => $namaSurvei,
			'start' => $start_time,
			'deadline' => $end_time,
			'target_input' => $target_input,
			);

		$this->load->view('templates/header', $data);
		$this->load->view('add_head/css_leaflet');
		$this->load->view('templates/nav_top');
		$this->load->view('templates/nav_left');
		$this->load->view('dasbor');
		$this->load->view('templates/sidebar_ctrl');
		$this->load->view('templates/footer');
		$this->load->view('add_foot/js_dasbor');
		$this->load->view('templates/closer');
	}

	public function data($id_proj){

		$this->load->library('survei');
		$this->load->model('target_model');
		$this->load->model('map_model');

		$survei = new Survei();
		$target = new Target_model();
		$map = new Map_model();

		$survei->setProj($id_proj);
		$target->setProj($survei->getProject());

		$wil_filter = $this->wilFilter();
		$survei->setData($wil_filter);
		$map->setSurvei($survei);

		// progres
		$input = $survei->countData();
		$target_input = $target->getTarget($wil_filter);
		$percent = ($input/$target_input) * 100;
		$percent_input = round($percent , 1);

		// map
		$forTable = $survei->objectify($wil_filter);

		$pins = $map->getAllPins();

		$data = array(
			'input' => $input,
			'percent_input' => $percent_input, 
			'forTable' => $forTable,
			'pins' => $pins,
			'donatIzin' => $survei->getIzin(),
			'lineInput' => $survei->splitCount(),
			'lineDur'	=> $survei->splitAvgDur()
			);

		echo json_encode($data);
	}

}
