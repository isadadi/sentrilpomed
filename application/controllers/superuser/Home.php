<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('sentril_model','',true);
      	$this->load->helper("akses");
      	// $this->load->session()
      	cek_superuser();
	}
	
	public function index()
	{
		$this->load->view('spuser/templates/header_home');
		$this->load->view('spuser/home');
		$this->load->view('spuser/templates/footer_home');
	}

	public function kegiatan()
	{
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		$data['total'] = $this->sentril_model->db->query("SELECT count(id_kegiatan) AS total_kegiatan, SUM(anggaran) AS total_anggaran, SUM(sisa_anggaran) AS sisa_anggaran FROM tbl_kegiatan")->result();
		//var_dump($data);die;
		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/kegiatan',$data);
		$this->load->view('spuser/templates/footer_table');
	}

	public function user()
	{
		$data['row'] = $this->sentril_model->get_all_data("tbl_user")->result_array();
		//var_dump($data);die;
		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/user',$data);
		$this->load->view('spuser/templates/footer_table');
	}

	public function add_user()
	{
		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/add_user');
		$this->load->view('spuser/templates/footer_table');
	}

	public function insert_proccess_user(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$level = $this->input->post('level');
		
		$data = array(
			'username'=>$username,
			'password'=>$password,
			'level'=>$level,
		);

		$this->sentril_model->insert_data("tbl_user",$data);
		redirect('superuser/home/user');
	}
	public function log_subkegiatan()
	{
		$data['row'] = $this->sentril_model->get_all_data("tbl_subkegiatan")->result_array();
		//var_dump($data);die;
		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/subkegiatan',$data);
		$this->load->view('spuser/templates/footer_table');
	}

	public function add_kegiatan(){
		$this->load->view('spuser/templates/header_insert');
		$this->load->view('spuser/add_kegiatan');
		$this->load->view('spuser/templates/footer_insert');
	}

	public function insert_proccess(){
		$id = $this->input->post('id');
		$nama = $this->input->post('nama');
		$target = $this->input->post('target');
		$anggaran = $this->input->post('anggaran');
		$tgl = $this->input->post('tanggal');
		$lokasi = $this->input->post('lokasi');
		$pj = $this->input->post('pj');
		$ket = $this->input->post('keterangan');

		$tgl = explode("-", $tgl);
		$trget = str_replace(".", "",$target);
		$anggrn = str_replace(".", "",$anggaran);

		$bln["January"] = "01";
		$bln["February"] = "02";
		$bln["March"] = "03";
		$bln["April"] = "04";
		$bln["May"] = "05";
		$bln["June"] = "06";
		$bln["July"] = "07";
		$bln["August"] = "08";
		$bln["September"] = "09";
		$bln["October"] = "10";
		$bln["November"] = "11";
		$bln["December"] = "12";

		$tanggal = $tgl[2]."-".$bln[$tgl[1]]."-".$tgl[0];
		//var_dump($tanggal);die;
		$data = array(
			'id_kegiatan'=>$id,
			'nama_kegiatan'=>$nama,
			'target'=>$trget,
			'anggaran'=>$anggrn,
			'realisasi'=>0,
			'tanggal'=>$tanggal,
			'lokasi'=>$lokasi,
			'nama_pj'=>$pj,
			'realisasi_anggaran'=>0,
			'sisa_anggaran'=>$anggrn,
			'keterangan'=>$ket
		);

		$this->sentril_model->insert_data("tbl_kegiatan",$data);
		redirect('superuser/home/kegiatan');
	}
	public function delete(){
		$id = $this->input->post('checkbox');# Using Form POST method you can use whatever you want like GET
		//var_dump($id);die;
		for ($i=0; $i < count($id) ; $i++) { 
			$this->sentril_model->delete_data("tbl_kegiatan","id_kegiatan",$id[$i]);
		}
		redirect('superuser/home/kegiatan');
	}
	public function delete_subkegiatan(){
		$id = $this->input->post('checkbox');# Using Form POST method you can use whatever you want like GET
		//var_dump($id);die;
		for ($i=0; $i < count($id) ; $i++) { 
			$this->sentril_model->delete_data("tbl_subkegiatan","id_subkegiatan",$id[$i]);
		}
		redirect('superuser/home/kegiatan');
	}
	public function delete_user(){
		$id = $this->input->post('checkbox');# Using Form POST method you can use whatever you want like GET
		//var_dump($id);die;
		for ($i=0; $i < count($id) ; $i++) { 
			$this->sentril_model->delete_data("tbl_user","id_user",$id[$i]);
		}
		redirect('superuser/home/user');
	}
	
}
