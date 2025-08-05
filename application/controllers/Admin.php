<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Crud','crud');
		if ($this->session->userdata('level') != 'Admin') {
			redirect('welcome');
		}
	}

	public function index()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}

	public function alternatif()
	{
		$data['alternatif'] = $this->crud->get('alternatif');
		$this->load->view('admin/header');
		$this->load->view('admin/alternatif',$data);
		$this->load->view('admin/footer');
	}

	public function tambahalternatif()
	{
		$nama_alternatif = $this->input->post('nama_alternatif');
		$data = array('nama_alternatif' => $nama_alternatif);
		$this->crud->insert($data, 'alternatif');
		$id = $this->db->insert_id();
		$where = array('id_alternatif' => $id );
		$kode = "A" . $id;
		$data = array('kode' => $kode);
		$this->crud->update($where,$data, 'alternatif');

		$this->session->set_flashdata('pesan', 'ditambahkan');
		redirect('admin/alternatif');
	}

	public function updatealternatif()
	{
		$id = $this->input->post('id_alternatif');
		$nama_alternatif = $this->input->post('nama_alternatif');
		$where = array('id_alternatif' => $id );
		$data = array('nama_alternatif' => $nama_alternatif);
		$this->crud->update($where, $data, 'alternatif');
		$this->session->set_flashdata('pesan', 'diupdate');
		redirect('admin/alternatif');
	}

	public function deletealternatif($id)
	{
		$where = array('id_alternatif' => $id );
		$this->crud->delete($where, 'alternatif');
		$this->crud->delete($where, 'penilaian_alternatif');
		$this->session->set_flashdata('pesan', 'dihapus');
		redirect('admin/alternatif');
	}

	public function kriteria()
	{
		$data['kriteria'] = $this->crud->getkriteria()->result_array();
		$this->load->view('admin/header');
		$this->load->view('admin/kriteria',$data);
		$this->load->view('admin/footer');
	}

	public function tambahkriteria()
	{
		$kriteria = $this->input->post('kriteria');
		$data = array('nama_kriteria' => $kriteria);
		$this->crud->insert($data, 'kriteria_penilaian');
		$id = $this->db->insert_id();
		$where = array('id_kriteria' => $id );
		$kode = "K" . $id;
		$data = array('kode_kriteria' => $kode);
		$this->crud->update($where,$data, 'kriteria_penilaian');
		$this->session->set_flashdata('pesan', 'Kriteria '.$kriteria.' ditambahkan');
		redirect('admin/kriteria');
	}

	public function updatekriteria()
	{
		$id = $this->input->post('id_kriteria');
		$kriteria = $this->input->post('kriteria');
		$where = array('id_kriteria' => $id );
		$data = array('nama_kriteria' => $kriteria);
		$this->crud->update($where, $data, 'kriteria_penilaian');
		$this->session->set_flashdata('pesan', 'Kriteria diupdate');
		redirect('admin/kriteria');
	}

	public function deletekriteria($id)
	{
		$where = array('id_kriteria' => $id );
		$this->crud->delete($where, 'kriteria_penilaian');
		$this->crud->delete($where, 'subkriteria');
		$this->session->set_flashdata('pesan', 'Kriteria '.$kriteria.' dihapus');
		redirect('admin/kriteria');
	}

	public function subkriteria()
	{
		$id = $this->input->get('id');
		$data['kriteria'] = $this->crud->subkriteria($id);
		$this->load->view('admin/header');
		$this->load->view('admin/subkriteria',$data);
		$this->load->view('admin/footer');
	}

	public function tambahsubkriteria()
	{
		$id = $this->input->post('id_kriteria');
		$subkriteria = $this->input->post('subkriteria');
		$nilai = $this->input->post('nilai');
		$data = array('nama_subkriteria'=>$subkriteria,'nilai'=>$nilai,'id_kriteria'=>$id);
		$this->crud->insert($data, 'subkriteria');
		$this->session->set_flashdata('pesan', 'subkriteria ditambahkan');
		redirect('admin/kriteria');
	}

	public function updatesubkriteria()
	{
		$id = $this->input->post('id_subkriteria');
		$id_kriteria = $this->input->post('id_kriteria');
		$subkriteria = $this->input->post('subkriteria');
		$nilai = $this->input->post('nilai');
		$where = array('id_subkriteria' => $id );
		$data = array('nama_subkriteria'=>$subkriteria,'nilai'=>$nilai,'id_kriteria'=>$id_kriteria);
		$this->crud->update($where, $data, 'subkriteria');
		$this->session->set_flashdata('pesan', 'diupdate');
		redirect('admin/subkriteria?id='.$id_kriteria);
	}

	public function deletesubkriteria($id)
	{
		$where = array('id_subkriteria' => $id );
		$this->crud->delete($where, 'subkriteria');
		$this->session->set_flashdata('pesan', 'dihapus');
		redirect('admin/kriteria');
	}

	public function penilaian()
	{
		$data['penilaian'] = $this->crud->penilaian();
		$data['kriteria'] = $this->crud->get('kriteria_penilaian');
		$data['alternatif'] = $this->db->query("SELECT * FROM alternatif a WHERE NOT EXISTS (SELECT 1 FROM penilaian_alternatif b WHERE a.id_alternatif = b.id_alternatif)")->result_array();
		$this->load->view('admin/header');
		$this->load->view('admin/penilaian',$data);
		$this->load->view('admin/footer');
	}

	public function nilaicalon()
	{
		$alternatif = $this->db->query("SELECT * FROM alternatif");
		$query = $this->db->query("SELECT * FROM penilaian_alternatif");
		$penilaian_data = $query->result_array();
		$nilai_per_kriteria_alternatif = array();
		foreach ($penilaian_data as $penilaian) {
			$id_kriteria = $penilaian['id_kriteria'];
			$id_alternatif = $penilaian['id_alternatif'];
			$nilai = $penilaian['nilai'];
			if (!isset($nilai_per_kriteria_alternatif[$id_kriteria])) {
				$nilai_per_kriteria_alternatif[$id_kriteria] = array();
			}
			$nilai_per_kriteria_alternatif[$id_kriteria][$id_alternatif] = $nilai;
		}
		$data['nilai_per_kriteria_alternatif'] = $nilai_per_kriteria_alternatif;
		$data['kriteria'] = $this->crud->get('kriteria_penilaian');
		$data['alternatif'] = $this->db->query("SELECT * FROM alternatif");
		$this->load->view('admin/header');
		$this->load->view('admin/nilaicalon',$data);
		$this->load->view('admin/footer');
	}

	public function tambahpenilaian()
	{
		$id_alternatif = $this->input->post('id_alternatif');
		$id_kriteria = count($this->input->post('id_kriteria'));
		$nilai = $this->input->post('nilai');
		for ($i=0; $i < $id_kriteria ; $i++) 
		{ 
			$datas[$i] = array(
				'id_kriteria'   => $this->input->post('id_kriteria['.$i.']'),
				'id_alternatif'       => $id_alternatif,
				'nilai'         => $this->input->post('nilai['.$i.']')
			);
			$this->crud->insert($datas[$i],'penilaian_alternatif');
		}
		$this->session->set_flashdata('pesan', 'ditambahkan');
		redirect('admin/penilaian');
	}

	public function updatenilai() {
		$id_penilaian = $this->input->post('id_penilaian');
		$id_alternatif = $this->input->post('id_alternatif');
		$id_kriteria = $this->input->post('id_kriteria');
		$nilai = $this->input->post('nilai');
		for ($i = 0; $i < count($id_kriteria); $i++) {
			$data = array(
				'id_kriteria'   => $id_kriteria[$i],
				'id_alternatif'       => $id_alternatif,
				'nilai'      => $nilai[$i]
			);
			$where = array('id_penilaian' => $id_penilaian[$i]);
			$this->crud->update($where, $data, 'penilaian_alternatif');
		}
        // Set success message and redirect back to the penilaian page
		$this->session->set_flashdata('pesan', 'Data berhasil diupdate');
		redirect('admin/penilaian');
	}

	public function deletepenilaian($id)
	{
		$where = array('id_alternatif' => $id );
		$this->crud->delete($where, 'penilaian_alternatif');
		$this->session->set_flashdata('pesan', 'dihapus');
		redirect('admin/penilaian');
	}
}
