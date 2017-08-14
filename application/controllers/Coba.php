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
		
		$this->load->library('survei');
		$survei = new Survei();
		$data = $survei->countByDay();
		$data2 = $survei->avgDurByDay();

		print_r($data);
		print_r($data2);

	}
}
