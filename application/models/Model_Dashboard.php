<?php
class Model_Dashboard extends CI_Model
{
	public function get_pegawai()
	{
		$log_level = $this->session->userdata('level');
		$log_peg = $this->session->userdata('peg_id');
		$log_unt = $this->session->userdata('unt_id');
		$this->db->from("ast_pegawai");
		if ($log_level == 2) {
			$this->db->where('pgw_unt_id', $log_unt);
		}
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_kriteria()
	{
		
		$this->db->from("smp_kriteria");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_alternatif()
	{
		
		$this->db->from("smp_alternatif");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_objekwisata()
	{
		
		$this->db->from("smp_objekwisata");
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}
}
