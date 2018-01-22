<?php

class sentril_model extends CI_Model{

	public function delete_data($table,$id,$val){
		return $this->db->where($id,$val)->delete($table);
	}

	public function get_foto($nim){
		$this->db->select('foto')->from('pengurus')->where('nim',$nim);
		return $this->db->get();
	}

	public function update_data($table,$id,$val,$data){
		return $this->db->where($id,$val)->update($table,$data);
	}

	public function insert_data($table,$data){
		return $this->db->insert($table,$data);
	}
	
	public function get_data($table,$id,$val){
		return $this->db->where($id,$val)->get($table);
	}

	public function get_all_data($table){
		return $this->db->get($table);
	}
	
	public function get_data_id($id)
	{
		$this->db->select('*')->from('tbl_berita')->where('id_berita',$id);
		return $this->db->get();
	}


	function cari_kegiatan($id){
		return $this->db->select('*')->from('tbl_kegiatan')
			->join('tbl_subkegiatan','tbl_kegiatan.id_kegiatan=tbl_subkegiatan.id_kegiatan')
			->where('tbl_kegiatan.id_kegiatan',$id)->get();
	}

	function get_subkegiatan($id){
		return $this->db->where('id_kegiatan',$id)->get('tbl_subkegiatan');
	}


	function get_kegiatan($id){
		return $this->db->where('id_kegiatan',$id)->get('tbl_kegiatan');
	}


	function update_kegiatan($data,$id){
		return $this->db->where('id_kegiatan',$id)->update('tbl_kegiatan',$data);
	}

	function get_file_sub($id){
		return $this->db->select('file')->where('id_kegiatan',$id)->get('tbl_subkegiatan');
	}


	function get_user($id){
		return $this->db->where('username',$id)->get('tbl_user');
	}

	function update_user($data,$id){
		return $this->db->where('id_user',$id)->update('tbl_user', $data);
	}

	function get_file_date($limit, $offset){
		return $this->db->select('tanggal_kegiatan')->from('tbl_subkegiatan')->group_by('tanggal_kegiatan')->order_by('tanggal_kegiatan','desc')->limit($limit,$offset)->get();
	}

	function get_file_total(){
		return $this->db->select('tanggal_kegiatan')->from('tbl_subkegiatan')->group_by('tanggal_kegiatan')->order_by('tanggal_kegiatan','desc')->get();
	}
	function get_file($date){
		return $this->db->where('tanggal_kegiatan',$date)->get('tbl_subkegiatan');
	}
}