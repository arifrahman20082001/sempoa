<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ObjekWisata extends CI_Controller
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

	//objekwisata	
	public function tampil()
	{

		$this->session->set_userdata("judul", "Data ObjekWisata");
		$ba = [
			'judul' => "Data ObjekWisata",
			'subjudul' => "Kelas",
		];
		
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('objekwisata');
		$this->load->view('background_bawah');
	}

	public function ajax_list_objekwisata()
	{
		$list = $this->objekwisata->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $objekwisata) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $objekwisata->objWis_nama;
			$row[] = $objekwisata->objWis_alamat;
			$row[] = $objekwisata->objWis_fasilitas;
			$row[] = $objekwisata->objWis_longitude;
			$row[] = $objekwisata->objWis_latitude;
			$row[] = $objekwisata->objWis_kelurahan;
			$row[] = "<a href='#' onClick='ubah_objekwisata(" . $objekwisata->objWis_id . ")' class='btn btn-info btn-sm' title='Ubah data objekwisata'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_objekwisata(" . $objekwisata->objWis_id . ")' class='btn btn-danger btn-sm' title='Hapus data objekwisata'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->objekwisata->count_all(),
			"recordsFiltered" => $this->objekwisata->count_filtered(),
			"data" => $data,
			"query" => $this->objekwisata->getlastquery(),
		);
		//output to json format
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('objWis_id');
		$data = $this->objekwisata->cari_objekwisata($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('objWis_id');
		$data = $this->input->post();
		$data['objWis_kelurahan'] = ucwords($this->input->post('objWis_kelurahan'));
		if ($id == 0) {
			$insert = $this->objekwisata->simpan("smp_objekwisata", $data);
		} else {
			$insert = $this->objekwisata->update("smp_objekwisata", array('objWis_id' => $id), $data);
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
			if($id==0){
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
		$delete = $this->objekwisata->delete('smp_objekwisata', 'objWis_id', $id);
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
