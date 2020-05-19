<?php

	class Dashboard extends CI_Controller{
		public function cek_auth()
		{
			if($this->session->userdata('id_role')==2){
			}
			else{
				redirect('auth/login');
			}
		}
		public function index()
		{
			$this->cek_auth();
			if($this->session->userdata('no_user')){
				$this->load->view('templates_admin/header');
				$this->load->view('admin/dashboard');
				$this->load->view('templates_admin/footer');
			}
			else{
				redirect('auth/login');
			}
		}

	} 

?>