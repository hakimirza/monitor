<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends MY_Controller {

	public function index($id_proj = '')
	{

		$this->cekParam($id_proj);

		$page = 'Monitoring Petugas Cacah';

		$this->load->library('survei');
		$this->load->model('location_name');

		$survei = new Survei();
		$locName = new Location_name();

		// initiate project id
		$survei->setProj($id_proj);

		// check user monitoring scope
		$wil_filter = $this->wilFilter();
		$area = $wil_filter != '' ? $locName->getNamaWil($wil_filter) : 'Nasional';

		// name
		$namaSurvei = $survei->getNama();

		$data = array(
			'title' => $page,
			'id_proj' => $id_proj,
			'namaSurvei' => $namaSurvei,
			'wil' => $wil_filter,
			'area' => $this->location_name->getNamaWil($wil_filter),
			'datatableId' => 'tabel-petugas'
			);

		$this->load->view('templates/header', $data);
		// $this->load->view('add_head/css_leaflet');
		$this->load->view('add_head/css_datatables');
		$this->load->view('templates/nav_top');
		$this->load->view('templates/nav_left');
		$this->load->view('petugas');
		$this->load->view('templates/sidebar_ctrl');
		$this->load->view('templates/footer');
		$this->load->view('add_foot/js_datatables');
		$this->load->view('add_foot/js_petugas');
		$this->load->view('templates/closer');		
	}

	public function data($id_proj, $wil = ''){

		$this->load->library('PCL');

		$pcl = new PCL();
		$pcl->setProj($id_proj, $wil);

		$data = $pcl->getPcl();

		echo json_encode($data);
	}

	public function dataXtra($id_proj, $id_pcl, $wil = ''){

		$this->load->library('PCL');

		$pcl = new PCL();
		$pcl->setProj($id_proj, $wil);

		$data = $pcl->pclChart($id_pcl, $wil);

		echo json_encode($data);
	}
}
