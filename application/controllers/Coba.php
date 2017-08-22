<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba extends MY_Controller {

	public function index()
	{
		// // JSON POST Publisher receiver
		// $input_data = "kosong";
		// if ($_SERVER['REQUEST_METHOD'] == 'POST')
		// {
		// 	$input_data = json_decode(file_get_contents("php://input"));
		// }
		// $data = array(
		// 	'json' => $input_data
		// 	);
		// $this->load->view('blank', $data);
		$id_proj = 9;
		$id = 3171080001;
		$id = 3172060001;
		
		$this->load->library('survei');
		$this->load->model('map_model');

		$survei = new Survei();
		$survei->setProj($id_proj);
		$survei->setData($id);
		$data = $survei->getData();

		$res = $survei->getCountDistinct($id_proj, $id, $data);

		// $map = new Map_model();
		// $map->setSurvei($survei);

		// $pins = $map->getAllPins();

		// $data = $pins;
		print_r($res);
	}
}
