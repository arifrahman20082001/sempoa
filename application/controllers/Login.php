<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_Login');
		date_default_timezone_set('Asia/Jakarta');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if ($this->session->userdata('id_user')) {
			redirect(base_url('dashboard'));
		} else {
			$this->session->set_userdata("judul", "Home");
			$this->load->view('login');
		}
	}

	public function proses()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean',  array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean', array('required' => '%s tidak boleh kosong.'));
		$res['status'] = 0;
		$res['desc'] = "";
		if ($this->form_validation->run() == FALSE) {
			$res['desc'] = "Username dan Password harus diisi!";
		} else {
			$usr = $this->input->post('username');
			$psw = $this->input->post('password');
			$u = $usr;
			$p = $psw;
			$cek = $this->Model_Login->cek($u, $p);
			if ($cek->num_rows() > 0) {
				$data = $cek->row();
				foreach ($cek->result() as $qad) {
					$sess_data['id_user'] = $qad->usr_id;
					$sess_data['username'] = $qad->usr_username;
					$sess_data['password'] = $qad->usr_password;
					$sess_data['nama'] = $qad->usr_nama;
					$sess_data['level'] = $qad->usr_level;
					$this->session->set_userdata($sess_data);
				}
				$res['status'] = 1;
				$res['desc'] = "Selamat bekerja {$u}!";
			} else {
				$res['desc'] = "Username atau Password salah.";
			}
		}
		echo json_encode($res);
	}

	public function ubah_pass()
	{
		$this->form_validation->set_rules('usr_pass', 'Password Lama', 'required|trim|xss_clean',  array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('usr_passBaru', 'Password Baru', 'required|trim|xss_clean', array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('usr_passBaru2', 'Konfirmasi Password Baru', 'required|trim|xss_clean', array('required' => '%s tidak boleh kosong.'));
		if ($this->form_validation->run() == FALSE) {
			$up_data['status'] = FALSE;
			$up_data['pesan'] = validation_errors();
		} else {
			$u = $this->session->userdata("username");
			$p = $this->input->post('usr_pass');
			$cek = $this->Model_Login->cek($u, $p, $this->session->userdata("id_user"));
			if ($cek->num_rows() > 0) {
				$data = array(
					'usr_password' => md5($this->input->post('usr_passBaru'))
				);
				$up_pass = $this->Model_Login->update('ast_login', array('usr_username' => $u, 'usr_password' => md5($p)), $data);
				if ($up_pass >= 0) {
					$this->session->sess_destroy();
					$up_data['status'] = TRUE;
					$up_data['pesan'] = "Password berhasil diubah";
				}
			} else {
				$up_data['status'] = FALSE;
				$up_data['pesan'] = "Password lama salah";
			}
		}
		echo json_encode($up_data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url("login"));
	}
}
