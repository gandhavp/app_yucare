<?php

class Daftar_pasien extends CI_Controller{
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
		$data['pasien'] = $this->pasien_model->get_data('user')->result();
		$data['role'] = $this->pasien_model->get_data('role')->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/daftar_pasien', $data);
		$this->load->view('templates_admin/footer');
	}
	public function tambah_pasien()
	{
		$this->cek_auth();
		$data['role'] = $this->pasien_model->get_data('role')->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/form_tambah_pasien', $data);
		$this->load->view('templates_admin/footer');
	}
	public function tambah_pasien_aksi()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->tambah_pasien();
		}
		else{
			$no_user 	= $this->input->post('no_user');
			$email 		= $this->input->post('email');
			$password	= $this->input->post('password');
			$id_role	= $this->input->post('id_role');

			$data = array(
				'no_user' 	=> $no_user,
				'email' 	=> $email,
				'password' 	=> $password,
				'id_role' 	=> $id_role
			);

			$this->pasien_model->insert_data($data, 'user');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			  Data Pasien Berhasil Ditambahkan.
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>');
			redirect('admin/daftar_pasien');
		}
	}
	public function _rules()
	{
		$this->form_validation->set_rules('no_user','No User', 'required');
		$this->form_validation->set_rules('email','Email', 'required');
		$this->form_validation->set_rules('password','Password', 'required');
		$this->form_validation->set_rules('id_role','Id Role', 'required');
	}
}

?>