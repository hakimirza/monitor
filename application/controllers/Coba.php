<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba extends CI_Controller {

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

		$this->load->model('location_name');
		echo $this->location_name->getNamaWil('11').'<br>';
		echo $this->location_name->getNamaWil('1102').'<br>';
		echo $this->location_name->getNamaWil('1102011').'<br>';
		echo $this->location_name->getNamaWil('1102011001').'<br>';

	}
}
