<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
    public function __construct(){

        parent::__construct();
        //Initialization code that affects all controllers
        // dummyyyyyyyyyy ===========================
		$id_project = 9;
		$id_user = 51;
		$this->session->set_userdata('id_proj', $id_project);
		$this->session->set_userdata('id_user', $id_user);
		// dummyyyyyyyyyy ===========================

		// if($this->ci->session->userdata('nip') == '') {

		// 	$this->ci->session->set_flashdata('Peringatan','Anda belum login');
		// 	redirect(base_url('login'));
		// }
		$this->cek_login();
    }

     // Cek login halaman
	private function cek_login() {

		if($this->session->userdata('email') == '') {

			$this->session->set_flashdata('Peringatan','Anda belum login');
			header('Location: '.base_url().'login');
		}
	}

}