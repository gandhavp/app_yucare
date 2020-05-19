<?php

	class Dashboard extends CI_Controller{
		public function cek_auth()
		{
			if($this->session->userdata('id_role')==1){
			}
			else{
				redirect('auth/login');
			}
		}
		public function index()
		{
			$this->cek_auth();
			if($this->session->userdata('no_user')){
				$this->load->view('templates_super_admin/header');
				$this->load->view('super_admin/dashboard');
				$this->load->view('templates_super_admin/footer');
			}
			else{
				redirect('auth/login');
			}
		}

	} 

?>