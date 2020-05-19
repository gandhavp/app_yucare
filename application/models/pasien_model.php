<?php
class Pasien_model extends CI_model{
	public function get_data($table){
		return $this->db->get($table);
	}
	public function insert_data($data, $table){
		$this->db->insert($table, $data);
	}
	public function cek_login()
	{
		$no_user = set_value('no_user');
		$password = set_value('password');

		$result = $this->db
						->where('no_user', $no_user)
						->where('password', $password)
						->limit(1)
						->get('user');

		if ($result->num_rows()>0) {
			return $result->row();
		}
		else{
			return FALSE;
		}

	}
}
?>