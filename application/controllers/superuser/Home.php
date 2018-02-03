<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('sentril_model','',true);
      	$this->load->helper("akses");  
      	$this->load->library('dompdf_gen');    	
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


		//$data['row'] = $this->sentril_model->get_kegiatan_su()->result_array();
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		$data['total'] = $this->sentril_model->get_total_kegiatan()->row_array();
		$data['subtotal'] = $this->sentril_model->get_total_subkegiatan()->row_array();
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

	public function tambah_anggaran()
	{	
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		$this->load->view('spuser/templates/header_insert');
		$this->load->view('spuser/add_anggaran',$data);
		$this->load->view('spuser/templates/footer_insert');
	}

	public function tambah_anggaran_proccess(){
		$id = $this->input->post('id');
		$target = $this->input->post('target');
		$anggaran = $this->input->post('anggaran');
		$trget = str_replace(".", "",$target);
		$anggrn = str_replace(".", "",$anggaran);
		$this->sentril_model->db->query("UPDATE tbl_kegiatan SET target=target+$trget,anggaran=anggaran+$anggrn,sisa_anggaran=sisa_anggaran+$anggrn,sisa_target=sisa_target+$trget WHERE id_kegiatan='$id'");
		redirect('superuser/home/kegiatan');
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
			$gbr = $this->sentril_model->get_file_keg($id[$i])->result_array();
			foreach($gbr as $data){
				$file = './assets/file/'.$data['file'];
				unlink($file);
			}
			$this->sentril_model->delete_data("tbl_kegiatan","id_kegiatan",$id[$i]);
			$this->sentril_model->delete_data("tbl_subkegiatan","id_kegiatan",$id[$i]);
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
		//$data['tanggal'] = $tgl[2].'-'.$bulan[$tgl[1]-1].'-'.$tgl[0];
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
		//$agr = $this->sentril_model->get_data("tbl_subkegiatan","id_kegiatan",$id_keg)->row_array();
		$this->sentril_model->db->query("UPDATE tbl_subkegiatan SET status='terverifikasi' WHERE id_subkegiatan='$id'");
		$agr = $this->sentril_model->db->query("SELECT anggaran FROM tbl_subkegiatan WHERE id_kegiatan='$id_keg' AND status='terverifikasi' ORDER BY id_subkegiatan DESC LIMIT 1")->row_array();
		$angg = $agr['anggaran'];
		//echo $angg;
		$a = $this->sentril_model->db->query("SELECT sum(anggaran) AS anggaran_total,count(id_kegiatan) AS jlh FROM tbl_subkegiatan WHERE status='terverifikasi' AND  id_kegiatan='$id_keg'")->result_array();
		foreach ($a as $t) {
			$data[] = $t['jlh'];
		}
		//var_dump($data);die;
		$realisasi_keg=implode("",$data);
		//var_dump($realisasi_keg);die;
		$this->sentril_model->db->query("UPDATE tbl_kegiatan SET realisasi=realisasi+1,sisa_target=sisa_target-1,realisasi_anggaran=realisasi_anggaran+$angg,sisa_anggaran=sisa_anggaran-$angg WHERE id_kegiatan='$id_keg'");
		redirect('superuser/home/log_subkegiatan');
	}	

	public function cari_kegiatan(){
		//$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		//var_dump($data);die;
		$this->load->view('spuser/templates/header_table');
		$this->load->view('spuser/cari_kegiatan');
		$this->load->view('spuser/templates/footer_insert');
		$this->load->view('spuser/cari_kegiatan_script');
	}


	function cari_kegiatan_ajax($id){
		$data['nama'] = $this->sentril_model->get_data("tbl_kegiatan","id_kegiatan",$id)->row_array();
		$data['total'] = $this->sentril_model->get_total_kegiatan2($id)->row_array();
		$data['subtotal'] = $this->sentril_model->get_total_subkegiatan2($id)->row_array();
		$data['row'] = $this->sentril_model->get_subkegiatan($id)->result_array();
		$this->load->view('spuser/cari_kegiatan_ajax',$data);
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


	function print_laporan(){
		$this->load->library('PHPExcel');

		 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'Tanggal : '.date('d-m-Y'))
        ->setCellValue('A2', 'Kode')
        ->setCellValue('B2', 'Nama Kegiatan')
        ->setCellValue('C2', 'Target')
        ->setCellValue('D2', 'Realisasi Target')
        ->setCellValue('E2', 'Sisa Target')
        ->setCellValue('F2', 'Anggaran')
        ->setCellValue('G2', 'Realisasi Anggaran')
        ->setCellValue('H2', 'Sisa Anggaran')
        ->setCellValue('I2', 'Tanggal Mulai')
        ->setCellValue('J2', 'Lokasi')
        ->setCellValue('K2', 'Penanggung Jawab')
        ->setCellValue('L2', 'Keterangan');
        

          $styleTop = array(
            'borders' => array(
              'top' => array(
                  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
               ),
               'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
               )
            ),

         );
         $styleBottom = array(
             'borders' => array(
               'bottom' => array(
                   'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                   )
               )
             );
       $styleRight = array(
          'borders' => array(
             'right' => array(
                 'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                 )
             )
          );

          $styleLeft = array(
          'borders' => array(
             'left' => array(
                 'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                 )
             )
          );

           $styleDefault = array(
          'borders' => array(
             'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
               )
             )
          );
      
        // set align center
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 		$this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);

        $detail = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		$total = $this->sentril_model->get_total_kegiatan()->row_array();
		$subtotal = $this->sentril_model->get_total_subkegiatan()->row_array();

		$row=3;
		foreach($detail as $data){
			  $this->phpexcel->setActiveSheetIndex(0)
			  		->setCellValue('A' . $row, $data['id_kegiatan'])
			  		->setCellValue('B' . $row, $data['nama_kegiatan'])
			  		->setCellValue('C' . $row, $data['target'])
			  		->setCellValue('D' . $row, $data['realisasi'])
			  		->setCellValue('E' . $row, ($data['sisa_target']))
			  		->setCellValue('F' . $row, ("Rp. ".number_format($data['anggaran'],0,'','.')))
			  		->setCellValue('G' . $row, ("Rp. ".number_format($data['realisasi_anggaran'],0,'','.')))
			  		->setCellValue('H' . $row, ("Rp.".number_format($data['sisa_anggaran'],0,'','.')))
			  		->setCellValue('I' . $row, $data['tanggal'])
			  		->setCellValue('J' . $row, $data['lokasi'])
			  		->setCellValue('K' . $row, $data['nama_pj'])
			  		->setCellValue('L' . $row, $data['keterangan']);

			  $this->phpexcel->setActiveSheetIndex(0)->getStyle('A'.$row.':L'.$row)->applyFromArray($styleDefault);
			 $row++;
		}

		  // set style
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('A2:L2')->applyFromArray($styleTop);
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('L2:L'.($row-1))->applyFromArray($styleRight);
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('A2:A'.($row-1))->applyFromArray($styleLeft);
		 $this->phpexcel->setActiveSheetIndex(0)->getStyle('A' . ($row-1).':L'.($row-1))->applyFromArray($styleBottom);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.date('d-m-Y').'-laporan-kegiatan.xlsx"');
        header('Cache-Control: max-age=0');
        // output
        $obj_writer = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
        $obj_writer->save('php://output');
	}

	function print_laporan_sub(){
		$id = $this->input->get('id');
		
		$this->load->library('PHPExcel');

		 $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'Tanggal : '.date('d-m-Y'))
        ->setCellValue('A2', 'Tanggal Kegiatan')
        ->setCellValue('B2', 'Jam')
        ->setCellValue('C2', 'Anggaran')
        ->setCellValue('D2', 'Lokasi')
        ->setCellValue('E2', 'PJ Kegiatan')
        ->setCellValue('F2', 'Keterangan')
        ->setCellValue('G2', 'File');
        
          $styleTop = array(
            'borders' => array(
              'top' => array(
                  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
               ),
               'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
               )
            ),

         );
         $styleBottom = array(
             'borders' => array(
               'bottom' => array(
                   'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                   )
               )
             );
       $styleRight = array(
          'borders' => array(
             'right' => array(
                 'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                 )
             )
          );

          $styleLeft = array(
          'borders' => array(
             'left' => array(
                 'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                 )
             )
          );

           $styleDefault = array(
          'borders' => array(
             'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
               )
             )
          );
      
        // set align center
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 		$this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
        $this->phpexcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
        
        $detail = $this->sentril_model->get_subkegiatan($id)->result_array();
		$total = $this->sentril_model->get_total_kegiatan()->row_array();
		$subtotal = $this->sentril_model->get_total_subkegiatan()->row_array();

		$row=3;
		foreach($detail as $data){
			  $this->phpexcel->setActiveSheetIndex(0)
			  		->setCellValue('A' . $row, $data['tanggal_kegiatan'])
			  		->setCellValue('B' . $row, $data['jam'])
			  		->setCellValue('C' . $row, ("Rp. ".number_format($data['anggaran'],0,'','.')))
			  		->setCellValue('D' . $row, $data['lokasi'])
			  		->setCellValue('E' . $row, $data['pj_kegiatan'])
			  		->setCellValue('F' . $row, $data['keterangan'])
			  		->setCellValue('G' . $row, $data['file']);
			  		
			  $this->phpexcel->setActiveSheetIndex(0)->getStyle('A'.$row.':G'.$row)->applyFromArray($styleDefault);
			 $row++;
		}

		  // set style
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('A2:G2')->applyFromArray($styleTop);
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('G2:G'.($row-1))->applyFromArray($styleRight);
        $this->phpexcel->setActiveSheetIndex(0)->getStyle('A2:A'.($row-1))->applyFromArray($styleLeft);
		 $this->phpexcel->setActiveSheetIndex(0)->getStyle('A' . ($row-1).':G'.($row-1))->applyFromArray($styleBottom);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.date('d-m-Y').'-laporan-subkegiatan.xlsx"');
        header('Cache-Control: max-age=0');
        // output
        $obj_writer = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
        $obj_writer->save('php://output');
	}

	function cetak_pdf(){
		$data['row'] = $this->sentril_model->get_all_data("tbl_kegiatan")->result_array();
		$data['total'] = $this->sentril_model->get_total_kegiatan()->row_array();
		$data['subtotal'] = $this->sentril_model->get_total_subkegiatan()->row_array();
		$this->load->view("spuser/cetak",$data);
		
      	$paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
	}

	function cetak_pdf_sub(){
		$id = $this->input->get("id");
		$data['nama'] = $this->sentril_model->get_data("tbl_kegiatan","id_kegiatan",$id)->row_array();
		$data['total'] = $this->sentril_model->get_total_kegiatan2($id)->row_array();
		$data['subtotal'] = $this->sentril_model->get_total_subkegiatan2($id)->row_array();
		$data['row'] = $this->sentril_model->get_subkegiatan($id)->result_array();
		$this->load->view("spuser/cetak_sub",$data);
		
      	$paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
	}
}
