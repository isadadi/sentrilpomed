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
		if(isset($_POST['ubah'])){
			$id = $this->input->post('id');
		$nama = $this->input->post('nama');
		$target = $this->input->post('target');
		$anggaran = $this->input->post('anggaran');
		$tgl = $this->input->post('tanggal');
		$lokasi = $this->input->post('lokasi');
		$pj = $this->input->post('pj');
		$ket = $this->input->post('keterangan');

		// $tgl = explode("-", $tgl);
		$trget = str_replace(".", "",$target);
		$anggrn = str_replace(".", "",$anggaran);

		// $bln["January"] = "01";
		// $bln["February"] = "02";
		// $bln["March"] = "03";
		// $bln["April"] = "04";
		// $bln["May"] = "05";
		// $bln["June"] = "06";
		// $bln["July"] = "07";
		// $bln["August"] = "08";
		// $bln["September"] = "09";
		// $bln["October"] = "10";
		// $bln["November"] = "11";
		// $bln["December"] = "12";

		// $tanggal = $tgl[2]."-".$bln[$tgl[1]]."-".$tgl[0];
		//var_dump($tanggal);die;
		$data = array(
			'id_kegiatan'=>$id,
			'nama_kegiatan'=>$nama,
			'target'=>$trget,
			'anggaran'=>$anggrn,
			'realisasi'=>0,
			'tanggal'=>$tgl,
			'lokasi'=>$lokasi,
			'nama_pj'=>$pj,
			'realisasi_anggaran'=>0,
			'sisa_anggaran'=>$anggrn,
			'sisa_target'=>$target,
			'keterangan'=>$ket
		);

		if($this->sentril_model->update_kegiatan($data,$id)){
			$data['pesan'] = 1;
		}else{
			$data['pesan'] = 0;
		}

		}
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		$data['total'] = $this->sentril_model->db->query("SELECT count(id_kegiatan) AS total_kegiatan, SUM(anggaran) AS total_anggaran, SUM(sisa_anggaran)AS sisa_anggaran FROM tbl_kegiatan")->result();
		//var_dump($data);die;
		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/kegiatan',$data);
		$this->load->view('spuser/templates/footer_table');
		$this->load->view('spuser/kegiatan_script');
	}

	public function user()
	{
		if(isset($_POST['ubah'])){
			$id = $this->input->post('id');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$level = $this->input->post('level');
			
			if($password != ''){
				$data = array(
				'username'=>$username,
				'password'=>set_pass($password),
				'level'=>$level,
				);	
			}else{
				$data = array(
				'username'=>$username,			
				'level'=>$level,
				);
			}
			if($this->sentril_model->update_user($data,$id)){
				$data['pesan'] = 1;
			}else{
				$data['pesan'] = 0;
			}

		}
		$data['row'] = $this->sentril_model->get_all_data("tbl_user")->result_array();
		//var_dump($data);die;
		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/user',$data);
		$this->load->view('spuser/templates/footer_table');
		$this->load->view('spuser/user_script');
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
			'password'=>set_pass($password),
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

		// $tgl = explode("-", $tgl);
		$trget = str_replace(".", "",$target);
		$anggrn = str_replace(".", "",$anggaran);

		// $bln["January"] = "01";
		// $bln["February"] = "02";
		// $bln["March"] = "03";
		// $bln["April"] = "04";
		// $bln["May"] = "05";
		// $bln["June"] = "06";
		// $bln["July"] = "07";
		// $bln["August"] = "08";
		// $bln["September"] = "09";
		// $bln["October"] = "10";
		// $bln["November"] = "11";
		// $bln["December"] = "12";

		// $tanggal = $tgl[2]."-".$bln[$tgl[1]]."-".$tgl[0];
		//var_dump($tanggal);die;
		$data = array(
			'id_kegiatan'=>$id,
			'nama_kegiatan'=>$nama,
			'target'=>$trget,
			'anggaran'=>$anggrn,
			'realisasi'=>0,
			'tanggal'=>$tgl,
			'lokasi'=>$lokasi,
			'nama_pj'=>$pj,
			'realisasi_anggaran'=>0,
			'sisa_anggaran'=>$anggrn,
			'sisa_target'=>$trget,
			'keterangan'=>$ket
		);

		$this->sentril_model->insert_data("tbl_kegiatan",$data);
		redirect('superuser/home/kegiatan');
	}
	public function delete(){
		$id = $this->input->post('checkbox');# Using Form POST method you can use whatever you want like GET
		//var_dump($id);die;
		for ($i=0; $i < count($id) ; $i++) { 
			$gbr = $this->sentril_model->get_file_sub($id[$i])->result_array();
			foreach($gbr as $file){
				$files = 'assets/file/'.$file['file'];
				unlink($files);
			}
			$this->sentril_model->delete_data("tbl_kegiatan","id_kegiatan",$id[$i]);
		}
		redirect('superuser/home/kegiatan');
	}
	public function delete_subkegiatan(){
		$id = $this->input->post('checkbox');# Using Form POST method you can use whatever you want like GET
		//var_dump($id);die;
		for ($i=0; $i < count($id) ; $i++) { 
			$gbr = $this->sentril_model->get_file_sub($id[$i])->result_array();
			//var_dump($gbr);die;
			foreach($gbr as $data){
				$file = './assets/file/'.$data['file'];
				unlink($file);
			}
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


	function kegiatan_ajax($id){
		$data = $this->sentril_model->get_kegiatan($id)->row_array();

		$bulan  = array('January','February','March','April','May','June','July','August','September','October','November','December');
		$tgl = explode('-', $data['tanggal']);
		$data['tanggal'] = $tgl[2].'-'.$bulan[$tgl[1]-1].'-'.$tgl[0];
		header("Content-Type:application/json");
		echo json_encode($data);
	}


	function user_ajax($id){
		$data = $this->sentril_model->get_user($id)->row_array();		
		header("Content-Type:application/json");
		echo json_encode($data);
	}


	function laporan(){
		$this->load->library('pagination');
		$total_rows = $this->sentril_model->get_file_total()->num_rows();

		if($total_rows>0){
			$limit = 10;
			$page_num = $this->uri->segment(4);
			($page_num>1) ? $start = ($page_num-1)*$limit : $start = 0;	
			$data['file'] = $this->sentril_model->get_file_date($limit, $start)->result_array();
			$config['base_url'] = base_url('superuser/home/laporan');
			$config['total_rows'] = $total_rows;
			$config['per_page'] = $limit;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = true;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';

			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();

		}
		

		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/laporan',$data);
		$this->load->view('spuser/templates/footer_table');
		$this->load->view('spuser/laporan_script');
			
	}


	function file_laporan($date){
		$data['file'] = $this->sentril_model->get_file($date)->result_array();
		$data['tanggal'] = $date;
		$this->load->view('spuser/file_laporan',$data);
	}

	public function verifikasi(){
		$id = $this->input->get('id');
		$id_keg = $this->input->get('id_keg');
		//var_dump($id_keg);die;
		$this->sentril_model->db->query("UPDATE tbl_subkegiatan SET status='terverifikasi' WHERE id_subkegiatan='$id'");
		$a = $this->sentril_model->db->query("SELECT count(id_kegiatan) AS total_kegiatan, sum(anggaran) total_anggaran FROM tbl_subkegiatan WHERE id_kegiatan='$id_keg' AND status='terverifikasi' ORDER BY id_kegiatan;")->row_array();
		$b = $this->sentril_model->db->query("SELECT anggaran FROM tbl_subkegiatan WHERE id_subkegiatan=$id")->row_array();$anggrn=$b['anggaran'];
		$total =$a['total_kegiatan'];$anggaran=$a['total_anggaran'];
		$this->sentril_model->db->query("UPDATE tbl_kegiatan SET realisasi=$total,realisasi_anggaran=$anggaran,sisa_anggaran=sisa_anggaran-$anggrn,sisa_target=target-$total WHERE id_kegiatan='$id_keg';");
		redirect('superuser/home/log_subkegiatan');
	}	
}
