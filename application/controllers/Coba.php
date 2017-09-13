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
		$wil = 31;
		$this->load->library('PCL');
		$this->load->library('survei');

		$pcl = new PCL();
		$pcl->setProj($id_proj,$wil);
		$uuid = $pcl->getUuidPclArray();

		$survei = new Survei();
		$survei->setProj($id_proj);

		$charts = array();
		
		foreach ($uuid as $key => $uu) {

			if (count($uu) > 0) {

				$survei->setUuid($uu);
				$survei->setData($wil);

				$arr['izin'] = $survei->getIzin();
				$arr['lineInput'] = $survei->splitCount();
				$arr['lineDur'] = $survei->splitAvgDur();

				$charts[$key] = $arr;
			}
			else $charts[$key] = 'N/A'; 
		}

		print_r($charts);
	}
}
