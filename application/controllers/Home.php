<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index($page = 'Home'){

		$data = array(
			'title' => $page,
			'datatableId' => 'tabel-survei-list'
			);

		$this->load->view('templates/header', $data);
		$this->load->view('add_head/css_datatables');
		$this->load->view('templates/nav_top-nav');
		$this->load->view('home');
		$this->load->view('templates/sidebar_ctrl');
		$this->load->view('templates/footer');
		$this->load->view('add_foot/js_datatables');
		$this->load->view('add_foot/js_home');
		$this->load->view('templates/closer');
	}

	public function daftar_survei(){

		$this->load->model('user_model');
		$this->load->model('target_model');
		$this->load->library('survei');

		$survei = new Survei();
		$target = new Target_model();
		$user = new User_model();

		$id_user = $this->session->userdata('id_user');
		$ids = $user->getProjectList($id_user);

		foreach ($ids as $id) {

			$survei->setProj($id);
			$project = $survei->getProject();
			$target->setProj($project);

			$input = $survei->countData();
			$target_input = $target->getTotalTarget();
			$percent = ($input/$target_input) * 100;

			$arr['id'] = $project['id'];
			$arr['name'] = $project['name'];
			$arr['status'] = strtotime($project['end_date'])>(time()+18000) ? 'Aktif' : 'Selesai';
			$arr['color'] = $arr['status'] == 'Aktif' ? 'success' : 'danger';
			$arr['progres'] = round($percent, 1);
			$data[] = $arr;
		}

		echo json_encode($data);
	}

	public function error(){
		echo '<b>404</b> Halaman tidak ditemukan. Kembali ke <a href="'.base_url().'">Home</a>';
	}

}
