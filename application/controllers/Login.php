<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{

		if($this->session->userdata('email') != '') {

			header('Location: '.base_url().'dasbor');
		}
		
		// $this->load->library('form_validation');
		// Fungsi Login
		// $valid = $this->form_validation;
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		// $valid->set_rules('email', 'NIP', 'required');
		// $valid->set_rules('password', 'Password', 'required');
		$data = array(
			'email' => $email,
			'password' => $password
			);

		// $this->log_in($data);
		if ($email != '') {

			$this->log_in($data);
		}

		$var['title'] = 'Login';

		$this->load->view('templates/header', $var);
		$this->load->view('login');
		$this->load->view('templates/closer');
	}

	// Fungsi login
	private function log_in($data) {

		$this->load->model('user_model');

		$query = $this->user_model->auth($data);
		if($query->num_rows() > 0) {

			$row = $query->row();
			$nama = $row->firstname.' '.$row->lastname;
			$email = $row->email;

			$this->session->set_userdata('email', $email);
			$this->session->set_userdata('nama', $nama);
			redirect(base_url().'dasbor');
		}else{

			$this->session->set_flashdata('galat','NIP atau password salah');
			redirect(base_url().'login');
		}
		return false;
	}

 // Fungsi logout
	public function logout() {

		$this->session->unset_userdata('email');
		$this->session->unset_userdata('nama');
		$this->session->set_flashdata('sukses','Anda berhasil logout');
		redirect(base_url().'login');
	}
}
