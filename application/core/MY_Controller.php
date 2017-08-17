<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
    public function __construct(){

        parent::__construct();

        //Initialization code that affects all controllers extended from this controller
        // dummyyyyyyyyyy ===========================
		$id_project = 9;
		$this->session->set_userdata('id_proj', $id_project);
		// dummyyyyyyyyyy ===========================
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