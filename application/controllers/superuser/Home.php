<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
      	$this->load->helper("akses");
      	// $this->load->session()
      	cek_superuser();
	}
	
	function index(){
		echo $this->session->userdata('level');
		echo "superuser";
	}
	
}
