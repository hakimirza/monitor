<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends CI_Controller {

	public function index($page = 'Dasbor')
	{

		// dummyyyyyyyyyy ===========================
		$id_project = 9;
		$id_user = 51;
		$this->session->set_userdata('id_proj', $id_project);
		$this->session->set_userdata('id_user', $id_user);
		// dummyyyyyyyyyy ===========================

		$id_proj = $this->session->userdata('id_proj');
		
		$this->load->library('survei');
		$this->load->model('map_model');

		$survei = new Survei();
		$map = new Map_model();

		$namaSurvei = $survei->getNama();
		$dataSurvei = $survei->getData();

		$map->setSurvei($survei);
		$location = $map->getAllPins();

		$end_time = "Jun 11, 2017 10:00:00";
		$percent_input = 86;
		$count_input = 3450;
		$percent_time = 80;

		$data = array(
			'title' => $page,
			'nama_survei' => $namaSurvei,
			'deadline' => $end_time,
			'percent_input' => $percent_input,
			'location' => $location,
			'count_input' => $count_input,
			'percent_time' => $percent_time
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

	private function getEndTime(){
		
		return $end_time;
	}

	private function getTimeElapsed($end_time){
		// get start time from db
		$start_time = "Jun 7, 2017 10:00:00";

		// get end time from db
		$end_time = "Jun 9, 2017 10:00:00";

		// percent time elapsed
		$time_now = 6;
		return $end_time - $time_now; 
	}

	private function getInput(){

	}

}
