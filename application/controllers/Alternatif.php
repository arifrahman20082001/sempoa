<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alternatif extends CI_Controller
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
		$this->load->model('Model_Alternatif', 'alternatif');
		$this->load->model('Model_ObjekWisata', 'objekwisata');
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

	//alternatif	
	public function tampil()
	{

		$this->session->set_userdata("judul", "Data Alternatif");
		$ba = [
			'judul' => "Data Alternatif",
			'subjudul' => "Kelas",
		];
		$data = [
			'objek_wisata' => $this->objekwisata->get_objekwisata()
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('alternatif', $data);
		$this->load->view('background_bawah');
	}

	public function ajax_list_alternatif()
	{
		$list = $this->alternatif->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$label_kondisi = "";
		$label_fasilitas = "";
		foreach ($list as $alternatif) {
			if ($alternatif->alt_kondisi == 1) {
				$label_kondisi = "<span class=\"badge badge-success\">Bagus</span>";
			} elseif ($alternatif->alt_kondisi == 2) {
				$label_kondisi = "<span class=\"badge badge-warning\">Sedang</span>";
			} else {
				$label_kondisi = "<span class=\"badge badge-danger\">Parah</span>";
			}
			if ($alternatif->alt_fasilitas == 1) {
				$label_fasilitas = "<span class=\"badge badge-success\">Bagus</span>";
			} elseif ($alternatif->alt_fasilitas == 2) {
				$label_fasilitas = "<span class=\"badge badge-warning\">Sedang</span>";
			} else {
				$label_fasilitas = "<span class=\"badge badge-danger\">Parah</span>";
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $alternatif->alt_nama;
			$row[] = round((float)($alternatif->alt_jarak / 1000), 2);
			$row[] = $label_kondisi;
			$row[] = $label_fasilitas;
			$row[] = "<a href='#' onClick='ubah_alternatif(" . $alternatif->alt_id . ")' class='btn btn-info btn-sm' title='Ubah data alternatif'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_alternatif(" . $alternatif->alt_id . ")' class='btn btn-danger btn-sm' title='Hapus data alternatif'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->alternatif->count_all(),
			"recordsFiltered" => $this->alternatif->count_filtered(),
			"data" => $data,
			"query" => $this->alternatif->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('alt_id');
		$data = $this->alternatif->cari_alternatif($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('alt_id');
		$data = $this->input->post();
		$data['alt_kelurahan'] = ucwords($this->input->post('alt_kelurahan'));
		if ($id == 0) {
			$insert = $this->alternatif->simpan("smp_alternatif", $data);
		} else {
			$insert = $this->alternatif->update("smp_alternatif", array('alt_id' => $id), $data);
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
			if ($id == 0) {

				$resp['status'] = 0;
				$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
				$resp['error'] = $err;
			} else {
				$resp['status'] = 1;
				$resp['desc'] = "Berhasil menyimpan data";
			}
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->alternatif->delete('smp_alternatif', 'alt_id', $id);
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
