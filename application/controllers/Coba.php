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
		$this->load->model('petugas_model');

		$query = $this->petugas_model->getListPcl($id_proj);

		print_r($query);
	}
}
