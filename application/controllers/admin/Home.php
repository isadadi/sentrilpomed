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
			'realisasi_anggaran'=>0,
			'sisa_anggaran'=>0,
			'keterangan'=>$ket
		);

		$this->sentril_model->insert_data("tbl_kegiatan",$data);
		redirect('admin/home/kegiatan');
	}
}
