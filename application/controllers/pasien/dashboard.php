<?php

	class Dashboard extends CI_Controller{
		public function cek_auth()
		{
			if($this->session->userdata('id_role')==3){
			}
			else{
				redirect('auth/login');
			}
		}
		public function index()
		{
			$this->cek_auth();
			if($this->session->userdata('no_user')){
				$this->load->view('templates_pasien/header');
				$this->load->view('pasien/dashboard');
				$this->load->view('templates_pasien/footer');
			}
			else{
				redirect('auth/login');
			}
		}

	} 

?>