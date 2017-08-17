<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends MY_Controller {

	public function index($id_proj = '')
	{

		$this->cekParam($id_proj);

		$page = 'Dasbor';
		// $id_proj = $this->session->userdata('id_proj');
		
		$this->load->library('survei');
		$this->load->model('map_model');
		$this->load->model('target_model');
		$this->load->model('location_name');

		$survei = new Survei();
		$target = new Target_model();
		$map = new Map_model();
		$locName = new Location_name();
		
		// initiate project id
		$survei->setProj($id_proj);
		$target->setProj($survei->getProject());
		$map->setSurvei($survei);

		// check user monitoring scope
		$wil_filter = $this->wilFilter();
		$area = $wil_filter != '' ? $locName->getNamaWil($wil_filter) : '';

		// set and load response data
		$survei->setData($wil_filter);

		// name
		$namaSurvei = $survei->getNama();

		// map pins
		$location = $map->getAllPins();

		// progres
		$input = $survei->countData();
		$target_input = $target->getTarget($wil_filter);
		$percent = ($input/$target_input) * 100;
		$percent_input = round($percent , 1);

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
			'location' => $location,
			'count_input' => $input,
			'target_input' => $target_input,
			'percent_input' => $percent_input
			);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav_top');
		$this->load->view('templates/nav_left');
		$this->load->view('dasbor');
		$this->load->view('templates/sidebar_ctrl');
		$this->load->view('templates/footer');
		$this->load->view('add_foot/js_dasbor');
		$this->load->view('templates/closer');
	}

	private function cekParam($id_proj){
		
		$this->load->model('user_model');
		$id_user = $this->session->userdata('id_user');
		$is_exist = $this->user_model->isExist($id_user, $id_proj);

		if (!$is_exist) {
			redirect(base_url().'home/error');
		}
	}

	private function getTimeProgres($start, $end){
		
		// unix standardized time format
		$start_u = strtotime($start);
		$end_u = strtotime($end);
		$now = time()+18000;

		// percent time elapsed
		$percent = ($now - $start_u) / ($end_u - $start_u) * 100;
		return $percent; 
	}

	private function getIzin($survei){
		
		// $this->load->library('survei');
		// $survei = new Survei();

		$data = $survei->getDataIzin();

		return $data;
	}

	private function countByDay($survei){
		
		// $this->load->library('survei');
		// $survei = new Survei();

		$data = $survei->countByDay();

		foreach ($data as $key => $value) {
			$newKey = $this->dateMonth($key);
			$data[$newKey] = $value;
			unset($data[$key]);
		}

		$dataDate = array();
		$dataCount = array();

		foreach ($data as $key => $value) {
			array_push($dataDate, $key);
			array_push($dataCount, $value);
		}

		return array('date' => $dataDate, 'count' => $dataCount);
	}

	private function getAvgDur($survei){

		// $this->load->library('survei');
		// $survei = new Survei();

		$data = $survei->avgDurByDay();
		// return $dataDur;

		foreach ($data as $key => $value) {
			$newKey = $this->dateMonth($key);
			$data[$newKey] = $value;
			unset($data[$key]);
		}

		$dataDate = array();
		$dataDur = array();

		foreach ($data as $key => $value) {
			array_push($dataDate, $key);
			array_push($dataDur, $value);
		}

		return array('date' => $dataDate, 'dur' => $dataDur);
	}

	public function ajaxChart($id_proj){

		$this->load->library('survei');
		$survei = new Survei();
		$survei->setProj($id_proj);
		$wil_filter = $this->wilFilter();
		$survei->setData($wil_filter);

		$data = array(
			'donatIzin' => $this->getIzin($survei),
			'lineInput' => $this->countByDay($survei),
			'lineDur'	=> $this->getAvgDur($survei)
			);

		echo json_encode($data);
	}

	// input format suggestion : '2017-07-14'
	private function dateMonth($date){ 

		$date = date_create($date);

		// output format : 14th July
		return date_format($date, 'jS F');
	}

	private function wilFilter(){

		$wil_filter = '';
		$wil = $this->session->userdata('id_wil');
		if (!$wil['pusat']) {

			if (!$wil['kab']) {

				$wil_filter = $wil['prov'];
			}
			else{

				$wil_filter = $wil['kab'];
			}
		}

		return $wil_filter;
	}

}
