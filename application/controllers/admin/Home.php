<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //$this->load->library('session');
		$this->load->model('sentril_model','',true);
		$this->load->helper(array('form','file','akses'),'',true);
		
		cek_admin();
	}
	
	public function index()
	{
		$this->load->view('private/home');
	}

	public function kegiatan()
	{
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		//var_dump($data);die;
		$this->load->view('private/kegiatan',$data);
	}

	public function add_kegiatan(){
		$this->load->view('private/add_kegiatan');
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

		$data = array(
			'id_kegiatan'=>$id,
			'nama_kegiatan'=>$nama,
			'target'=>$target,
			'anggaran'=>$anggaran,
			'realisasi'=>0,
			'tanggal'=>$tgl,
			'lokasi'=>$lokasi,
			'realisasi_anggaran'=>0,
			'sisa_anggaran'=>0,
			'keterangan'=>$ket
		);

		var_dump($data);	
	}
}
