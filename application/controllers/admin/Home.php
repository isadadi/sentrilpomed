<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //$this->load->library('session');
		$this->load->model('sentril_model','',true);
		$this->load->helper(array('url','form','file'),'',true);
		// if ($this->session->userdata('nama')=="") {
		// 	redirect('login');
		// }
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
}
