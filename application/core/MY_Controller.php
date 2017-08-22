<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
    public function __construct(){

        parent::__construct();

        //Initialization code that affects all controllers extended from this controller
        
		$this->cek_login();
    }

     // Cek login halaman
	private function cek_login() {

		if($this->session->userdata('email') == '') {

			$this->session->set_flashdata('Peringatan','Anda belum login');
			header('Location: '.base_url().'login');
		}
	}

	public function cekParam($id_proj){
		
		$this->load->model('user_model');
		$id_user = $this->session->userdata('id_user');
		$is_exist = $this->user_model->isExist($id_user, $id_proj);

		if (!$is_exist) {
			redirect(base_url().'home/error');
		}
	}

	public function wilFilter(){

		$wil_filter = '';
		$wil = $this->session->userdata('id_wil');
		if (!$wil['pusat']) {

			if (!$wil['kab']) {

				$wil_filter = $wil['prov'];
			}
			else{

				$wil_filter = $wil['kab'];
			}
		}

		return $wil_filter;
	}

}