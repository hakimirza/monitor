<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabulasi extends CI_Controller {

	public function index(){

		$page = 'Tabulasi Data';
		$this->load->library('survei');
		$id_proj = $this->session->userdata('id_proj');

		$survei = new Survei();

		$namaSurvei = $survei->getNama();

		$data = array(
			'title' => $page,
			'namaSurvei' => $namaSurvei
			);

		$this->load->view('templates/header', $data);
		$this->load->view('add_head/css_tabulasi');
		$this->load->view('templates/nav_top');
		$this->load->view('templates/nav_left');
		$this->load->view('tabulasi');
		$this->load->view('templates/sidebar_ctrl');
		$this->load->view('templates/footer');
		$this->load->view('add_foot/js_tabulasi');
		$this->load->view('templates/closer');		
	}

	public function dataJson(){

		$id_proj = $this->session->userdata('id_proj');
		$this->load->library('survei');

		$survei = new Survei();
		// $survei->setIdProj($id_proj);
		$data = $survei->getData();

		$data = $this->splitRuta($data);

		echo json_encode($data);
	}

	private function splitRuta($data){

		$group = array();
		$indiv = array();
		$arrKey = array();

		foreach ($data as $uuid => $row) {

			$arrTemp = array();
			
			// insert array to $group
			foreach ($row as $tag => $value) {

				if (!is_array($value)) {

					// $group[$uuid][$tag] = $value;
					$arrTemp[$tag] = $value;
				}
				else{

					$arrKey[$tag] = $tag;
				}
			}

			array_push($group, $arrTemp);
			
			// get roster length
			$n = 0;
			foreach ($row as $value) {

				if (is_array($value)) {

					$n = count($value);
					break;
				}
			}

			// insert array to $indiv
			if ($n > 0) {

				for ($i=0; $i < $n ; $i++) { 

					$arrTemp = array();

					foreach ($row as $tag => $value) {

						if (!is_array($value)) {

							// $indiv[$uuid][$tag] = $value;
							$arrTemp[$tag] = $value;
						}
						else{

							// $indiv[$uuid][$tag] = $value[$i];
							$arrTemp[$tag] = $value[$i];
						}
					}

					array_push($indiv, $arrTemp);
				}
			}
			else{

				$arrTemp = array();

				foreach ($row as $tag => $value) {

					$arrTemp[$tag] = $value;
				}

				array_push($indiv, $arrTemp);
			}
		}

		// $group fitting
		foreach ($group as $i => $row) {
			
			$group[$i] = array_diff_key($group[$i], $arrKey);
		}

		$result['group'] = $group;
		$result['indiv'] = $indiv;

		// will contain 2 arrays each for individuals data and households data
		return $result;
	} 
	// splitRuta

}