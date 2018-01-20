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
		$this->load->view('private/templates/header_home');
		$this->load->view('private/home');
		$this->load->view('private/templates/footer_home');
	}

	public function kegiatan()
	{
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		//var_dump($data);die;
		$this->load->view('private/templates/header_table');
		$this->load->view('private/kegiatan',$data);
		$this->load->view('private/templates/footer_table');
	}

	public function add_kegiatan(){
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		//var_dump($data);die;
		$this->load->view('private/templates/header_insert');
		$this->load->view('private/add_kegiatan',$data);
		$this->load->view('private/templates/footer_insert');
	}

	public function cari_kegiatan(){
		//$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		//var_dump($data);die;
		$this->load->view('private/templates/header_insert');
		$this->load->view('private/cari_kegiatan');
		$this->load->view('private/templates/footer_insert');
		$this->load->view('private/cari_kegiatan_script');
	}
	public function insert_proccess(){
		$id = $this->input->post('id');
		$anggaran = $this->input->post('anggaran');
		$tgl = $this->input->post('tanggal');
		$lokasi = $this->input->post('lokasi');
		$pj = $this->input->post('pj');
		$ket = $this->input->post('keterangan');

		$tgl = explode("-", $tgl);
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

		$mimeExt = array();
		$mimeExt['image/jpeg'] ='.jpg';
		$mimeExt['image/pjpeg'] ='.jpg';
		$mimeExt['image/bmp'] ='.bmp';
		$mimeExt['image/gif'] ='.gif';
		$mimeExt['image/x-icon'] ='.ico';
		$mimeExt['image/png'] ='.png';
		//var_dump($tanggal);die;
		$data = array(
			'id_kegiatan'=>$id,
			'tanggal_kegiatan'=>$tanggal,
			'anggaran'=>$anggrn,
			'lokasi'=>$lokasi,
			'pj_kegiatan'=>$pj,
			'keterangan'=>$ket
		);

		if ($_FILES['fupload']['name'] != "") {
			$image = $mimeExt[$_FILES['fupload']['type']]; //Get image extension
			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$nama_file   = $_FILES['fupload']['name'];
			// Tentukan folder untuk menyimpan file
			$folder = "./assets/file/";
			$namafilenya ="$id-$tanggal-$nama_file";
			$alamat=$folder.$namafilenya;
			if (move_uploaded_file($lokasi_file,$alamat))
			{
		 		// echo "Nama File : <b>$nama_file</b> sukses di upload";
	 			$data['file'] = $namafilenya;
			}
		}

		//var_dump($data);die;
		$this->sentril_model->insert_data("tbl_subkegiatan",$data);
		$a = $this->sentril_model->db->query("SELECT count(id_kegiatan) AS total_kegiatan, sum(anggaran) total_anggaran FROM tbl_subkegiatan WHERE id_kegiatan=$id ORDER BY id_kegiatan;")->row_array();

		$total =$a['total_kegiatan'];$anggaran=$a['total_anggaran']; 
		$this->sentril_model->db->query("UPDATE tbl_kegiatan SET realisasi=$total,realisasi_anggaran=$anggaran,sisa_anggaran=sisa_anggaran-$anggrn WHERE id_kegiatan=$id;");
		redirect('admin/home/kegiatan');
	}


	function proses_cari($id){
		
		$kegiatan =  $this->sentril_model->cari_kegiatan($id);

		if($kegiatan->num_rows()>0){
			$data['error'] = 0;
			$data['id'] = $id;
		}
		else{
			$data['error'] = 1;
		}

		header("Content-Type:application/json");
		echo json_encode($data);

	}


	function cari_kegiatan_ajax($id){
		$data['row'] = $this->sentril_model->get_subkegiatan($id)->result_array();
		$this->load->view('private/cari_kegiatan_ajax',$data);
	}
	
}
