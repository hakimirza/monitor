<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabulasi extends MY_Controller {

	public function index($id_proj = ''){

		$this->cekParam($id_proj);

		$page = 'Tabulasi Data';

		$this->load->library('survei');
		$this->load->model('location_name');

		$survei = new Survei();
		$locName = new Location_name();
		
		// initiate project id
		$survei->setProj($id_proj);

		// check user monitoring scope
		$wil_filter = $this->wilFilter();
		$area = $wil_filter != '' ? $locName->getNamaWil($wil_filter) : 'Nasional';

		$namaSurvei = $survei->getNama();

		$data = array(
			'title' => $page,
			'id_proj' => $id_proj,
			'namaSurvei' => $namaSurvei,
			'area' => $this->location_name->getNamaWil($wil_filter)
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

	public function dataJson($id_proj){

		$this->load->library('survei');

		$survei = new Survei();
		$survei->setProj($id_proj);

		$wil_filter = $this->wilFilter();
		$survei->setData($wil_filter);

		$data = $survei->getData();

		$data = $this->splitRuta($data);

		echo json_encode($data);
	}

	public function saveConfig($id_project){

		if ($this->session->userdata('id_user')) {

			$this->load->model('tabulasi_model');

			$id_user = $this->session->userdata('id_user');

			$config = $this->input->post('config');
			$name = $this->input->post('name');
 
			$data = array(
				'id_user' => $id_user,
				'id_project' => $id_project,
				'tabulation_config' => $config,
				'name' => $name,
				'is_on' => 1,
				);

			$this->tabulasi_model->saveConfig($data);

			echo 'Berhasil';
		}
		else{
			echo "404 not found";
		}
	}

	public function loadConfig($id_project){

			$this->load->model('tabulasi_model');
			$id_user = $this->session->userdata('id_user');

			$data = array(
				'id_user' => $id_user,
				'id_project' => $id_project
				);

			$result = $this->tabulasi_model->loadConfig($data);
			$result = json_encode($result);
			// $result = str_replace('"',"'",$result);
			echo $result;
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