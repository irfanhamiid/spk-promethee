<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {

	public function get_where($where, $table)
	{
		return $this->db->get_where($table, $where);
	}

	public function getpenggunabyid($id)
	{
		$pengguna = $this->db->query('SELECT * FROM pengguna WHERE id_pengguna = "' . $id . '"');
		return $pengguna;
	}

	public function get($table)
	{
		return $this->db->get($table)->result_array();
	}

	public function delete($where, $table)
	{
		$this->db->delete($table, $where);
		$delete = $this->db->affected_rows();
		return $delete;
	}
	public function insert($data, $table)
	{
		$this->db->insert($table, $data);
		$add = $this->db->affected_rows();
		return $add;
	}

	public function update($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
		$update = $this->db->affected_rows();
		return $update;
	}

	public function getkriteria()
	{
		$kriteria = $this->db->query("SELECT * FROM kriteria_penilaian");
		return $kriteria;
	}

	public function subkriteria($id)
	{
		$subkriteria = $this->db->query("SELECT * FROM subkriteria a,kriteria_penilaian b where a.id_kriteria=b.id_kriteria and a.id_kriteria='$id' order by a.nilai desc")->result_array();
		return $subkriteria;
	}

	public function penilaian()
	{
		$penilaian = $this->db->query("SELECT * FROM penilaian_alternatif a,alternatif b,kriteria_penilaian c where a.id_alternatif = b.id_alternatif and a.id_kriteria = c.id_kriteria AND a.id_penilaian IN (SELECT MIN(id_penilaian) FROM penilaian_alternatif GROUP BY id_alternatif)")->result_array();
		return $penilaian;
	}
}