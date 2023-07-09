<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		if ($this->session->userdata("level") > 2) {
			redirect(base_url("Dashboard"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Kriteria', 'kriteria');
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

	//kriteria	
	public function tampil()
	{

		$this->session->set_userdata("judul", "Data Kriteria");
		$ba = [
			'judul' => "Data Kriteria",
			'subjudul' => "Kelas",
		];
		
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('kriteria');
		$this->load->view('background_bawah');
	}

	public function ajax_list_kriteria()
	{
		$list = $this->kriteria->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kriteria) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $kriteria->krtr_nama;
			$row[] = "<a href='#' onClick='ubah_kriteria(" . $kriteria->krtr_id . ")' class='btn btn-info btn-sm' title='Ubah data kriteria'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_kriteria(" . $kriteria->krtr_id . ")' class='btn btn-danger btn-sm' title='Hapus data kriteria'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->kriteria->count_all(),
			"recordsFiltered" => $this->kriteria->count_filtered(),
			"data" => $data,
			"query" => $this->kriteria->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('krtr_id');
		$data = $this->kriteria->cari_kriteria($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('krtr_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->kriteria->simpan("smp_kriteria", $data);
		} else {
			$insert = $this->kriteria->update("smp_kriteria", array('krtr_id' => $id), $data);
		}
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->kriteria->delete('smp_kriteria', 'krtr_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}
}
