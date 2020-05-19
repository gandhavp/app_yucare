<?php 

class Auth extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function cek_auth()
	{
		$check = $this->session->userdata('id_role');
		switch ($check) {
			case 1 : redirect('super_admin/dashboard');
				break;
			case 2 : redirect('admin/dashboard');
				break;
			case 3 : redirect('pasien/dashboard');
				break;					
			default:
				break;
		}
	}
	
	public function login()
	{
		$this->cek_auth();
		$this->_rules();
		if($this->form_validation->run() == FALSE){
			$this->load->view('form_login');			
		}
		else{
			$no_user = $this->input->post('no_user');
			$password = $this->input->post('password');

			$user = $this->db->get_where('user', ['no_user' => $no_user])->row_array();
			if ($user == FALSE) {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-small mb-0" role="alert">No Pasien / ID Salah
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
				redirect('auth/login');
			}
			else{
				if (password_verify($password, $user['password'])) {
					$data = [
						'no_user' => $user['no_user'],
						'email' => $user['email'],
						'id_role' => $user['id_role']
					];
					$this->session->set_userdata($data);

					switch ($user['id_role']) {
						case 1 : redirect('super_admin/dashboard');
							break;
						case 2 : redirect('admin/dashboard');
							break;
						case 3 : redirect('pasien/dashboard');
							break;					
						default:
							break;
					}
				}
				else{
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-small mb-0" role="alert">Password Salah
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
					redirect('auth/login');
				}
			}
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('no_user', 'No User', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login');
	}

	public function forgotPassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Lupa Password';
			$this->load->view('forgot_password');
		}
		else{
			$email = $this->input->post('email');
			$user = $this->db->get_where('user', ['email' => $email])->row_array();

			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token
				];

				$this->db->insert('user_token', $user_token);
				$this->_sendemail($token, 'forgot');

				$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show text-small mb-0" role="alert">Cek Email untuk reset password
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
				redirect('auth/forgotPassword');
			}
			else{
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-small mb-0" role="alert">Email belum terdaftar
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
				redirect('auth/forgotPassword');
			}
		}
	}

	private function _sendEmail($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'Startupicare@gmail.com',
			'smtp_pass' => 'iCare2019',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		];

		$this->load->library('email', $config);
		$this->email->initialize($config);

		$this->email->from('Startupicare@gmail.com', 'YuCare');
		$this->email->to($this->input->post('email'));
		
		if ($type == 'forgot') {
			$this->email->subject('Reset Password');
			$this->email->message('Silahkan klik link berikut ini untuk melakukan reset password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset</a>');
		}
		else if ($type == 'registration') {
			$this->email->subject('Pendaftaran Berhasil');
			$this->email->message('Terimakasih telah melakukan pendaftaran akun baru pada website YuCare. Berikut ini informasi detail akun Anda:<br>
				No. Pasien : '. $this->input->post('no_user') .' <br>
				Email : '. $this->input->post('email') .' ');
		}
		
		if ($this->email->send()) {
			return true;
		}
		else{
			echo $this->email->print_debugger();
			die;
		}
	}

	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if($user){
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			}
			else{
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-small mb-0" role="alert">Reset password gagal, token salah
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
				redirect('auth/forgotPassword');
			}
		}
		else{
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-small mb-0" role="alert">Reset password gagal, email salah
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
			redirect('auth/forgotPassword');
		}
	}

	public function changePassword()
	{
		if(!$this->session->userdata('reset_email')){
			redirect('auth/login');
		}

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|matches[password2]');
		$this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password1]');
		
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Ubah Password';
			$this->load->view('change_password');
		}
		else{
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');

			$this->session->unset_userdata('reset_email');
			$this->db->delete('user_token', ['email' => $email]);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show text-small mb-0" role="alert">Reset Password Berhasil
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
			redirect('auth/login');
		}
	}

	public function registration()
	{
		$this->form_validation->set_rules('no_user', 'No Pasien', 'required|trim|is_unique[user.no_user]', [
			'is_unique' => 'No Pasien telah terdaftar'
		]);
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
			'is_unique' => 'Email telah terdaftar'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => 'Password tidak cocok',
			'min_length' => 'Password terlalu singkat, min. 3 karakter'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Daftar Akun Baru';
			$this->load->view('registration');
		}
		else{
			$token = base64_encode(random_bytes(32));
			$data = [
				'no_user' => htmlspecialchars($this->input->post('no_user', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'id_role' => 3
			];

			$this->db->insert('user', $data);
			
			$this->_sendEmail($token, 'registration');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show text-small mb-0" role="alert">Pendaftaran Akun Berhasil
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
			redirect('auth/login');
		}
	}
}

?>