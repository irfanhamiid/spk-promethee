<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Crud','crud');
	}

	public function index()
	{
		if ($this->session->userdata('level') == 'Admin') {
			redirect('admin');
		} else {
			$this->load->view('auth/login');
		}
	}

	function do_login()
	{
		$username = $this->input->post('username');
		$pass = $this->input->post('password');
		$password = md5($pass);
		$data = $this->db->query('SELECT * FROM admin where username= "' . $username . '" AND password = "' . $password . '"');
		$p = $data->row();
		$cek = $data->num_rows();
		if ($cek > 0) {
			$this->session->set_userdata(array(
				'level' => "Admin",
				'id_admin' => $p->id_admin,
				'username' => $p->username,
				'nama_admin' => $p->nama_admin,
				
			));
			redirect('admin');
		}else {
			$this->session->set_flashdata('gagal', 'Username/Password salah !');
			redirect('welcome');
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect('welcome', 'refresh');
	}
}
