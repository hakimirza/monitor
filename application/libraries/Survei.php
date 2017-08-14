<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends CI_Controller {

	// SET SUPER GLOBAL
	var $ci = NULL;	
	private $id_proj; //for testing only
	private $project;
	private $kues;
	private $uuids;
	private $dataSurvei;

	public function __construct() {

		$this->ci =& get_instance();
		$this->ci->load->model('project_model');
		$this->ci->load->model('uuid_model');
		$this->ci->load->model('location_name');
		$this->ci->load->library('parsexml');
		$this->ci->load->library('getuuid');

		$this->id_proj = $this->ci->session->userdata('id_proj');
		$this->setVars();
	}

	private function setVars(){

		$this->project = $this->ci->project_model->getProject($this->id_proj);
		$this->kues = $this->ci->project_model->getKuesioner($this->id_proj);
		$this->uuids = $this->ci->getuuid->getUuid(
			$this->project['aggregate_url'], 
			$this->ci->parsexml->getFormId(
				$this->kues['file'], 
				$this->kues['tag']
				)
			);
		$this->dataSurvei = $this->setData();
	}

	public function getIdProj(){

		return $this->id_proj;
	}

	public function getProject(){

		return $this->project;
	}

	public function getKues(){

		return $this->kues;
	}

	public function getUuid(){

		return $this->uuids;
	}

	// menggabungkan BS dengan kode desa
	private function modifBS($arr){

		foreach ($arr as $key => $row) {

			$arr[$key]['P106'] = $arr[$key]['P104'].$arr[$key]['P106'];
		}
		return $arr;
	}
	
	// set data survei dalam bentuk array assoc by uuid
	private function setData(){

		$project = $this->project;
		$kues = $this->kues;
		$uuids = $this->uuids;
		$server = $project['aggregate_url'];
		$file = $kues['file'];
		$tag = $kues['tag'];

		$dataSurvei = $this->ci->parsexml->getInstance($server, $file, $tag, $uuids);
		$dataSurvei = $this->modifBS($dataSurvei);
		$dataSurvei = $this->sortDate($dataSurvei);

		return $dataSurvei;
	}

	public function getNama(){

		return $this->project['name'];
	}

	public function getStartDate(){

		return $this->project['start_date'];
	}

	public function getEndDate(){

		return $this->project['end_date'];
	}

	public function getData(){

		return $this->dataSurvei;
	}

	public function countData(){

		return count($this->getData());
	}	

	public function getDataIzin(){

		$data = $this->getData();

		$izin1 = 0;
		$izin2 = 0;
		$izin3 = 0;

		foreach ($data as $row) {
			
			$izin = $row['izin'];

			if ($izin == 1) {
				$izin1++;
			}elseif ($izin == 2) {
				$izin2++;
			}else $izin3++;
		}

		$dataIzin = array($izin1, $izin2, $izin3);

		return $dataIzin;
	}

	public function avgDurByDay(){

		$data = $this->getData();

		$durByDay = array();

		foreach ($data as $row) {

			$today = $row['today'];
			$start = $row['start'];
			$end = $row['end'];
			$dur = $this->minuteDiff($start, $end);

			if (isset($durByDay[$today])) {

				array_push($durByDay[$today], $dur);
			}
			else{

				$durByDay[$today][0] = $dur;
			}
		}

		foreach ($durByDay as $day => $arr) {
			$durByDay[$day] = round(array_sum($arr)/count($arr), 1);
		}

		$dateAlong = $this->getDateAlong($this->getStartDate(), $today);

		$durByDay = $this->insertZeroDate($durByDay, $dateAlong);

		ksort($durByDay);

		// expected output array pf date=>avgDuration
		return $durByDay;
	}

	public function countByDay(){

		$data = $this->getData();

		$submitTime = array();

		foreach ($data as $row) {

			$today = $row['today'];
			if(!isset($submitTime[$today])) $submitTime[$today] = 1;
			else $submitTime[$today]++;
		}

		$dateAlong = $this->getDateAlong($this->getStartDate(), $today);

		$submitTime = $this->insertZeroDate($submitTime, $dateAlong);

		ksort($submitTime);

		// expected output array pf date=>inputCount
		return $submitTime;
	}

		// difference 2 datetimes in minutes
	private function minuteDiff($time, $time2){

		// strtotime converts a date string to the number of seconds since January 1 1970 00:00:00 UTC
		$time = strtotime($time);
		$time2 = strtotime($time2);
		$inter = $time2 - $time;

		return ($inter/60);
	}

	// expected input date string like '2017-07-14'
	private function getDateAlong($start, $end){
		$period = new DatePeriod(
			new DateTime($start),
			new DateInterval('P1D'),
			(new DateTime($end))->modify('+1 day')
			);
		$array = array();
		foreach( $period as $date) { $array[] = $date->format('Y-m-d'); }
		return $array;
	}

	// date => value insertion with date => 0
	private function insertZeroDate($dateVal, $dates){

		foreach ($dates as $date) {
			
			if (!array_key_exists($date, $dateVal)) {
				
				$dateVal[$date] = 0;
			}
		}

		return $dateVal;
	}

	private function sortDate($arr){

		if (!function_exists('cmp')){

			function cmp($a, $b){
				$a = strtotime($a['today']);
				$b = strtotime($b['today']);
				return ($a == $b) ? 0 : 
				($a < $b) ? -1 : 1;
			}
		}
		usort($arr, 'cmp');

		return $arr;
	}
}