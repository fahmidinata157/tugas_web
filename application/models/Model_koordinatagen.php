<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_koordinatagen extends CI_Model{

    public function create($agen,$latitude,$longitude){
        $data = array('agen_id' => $agen,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $query = $this->db->insert('tbl_koordinatagen', $data);
        return $query;
    }
    public function getAll(){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinatagen');
        $this->db->join('tbl_agen', 'tbl_agen.id_agen = tbl_koordinatagen.agen_id');//kita join tbl agen dengan foreign key agen_id
        $query = $this->db->get();
        return $query;
    }
    public function read($id){
        $this->db->select('*');//kita akan mengambil semua data
        $this->db->from('tbl_koordinatagen');
        $this->db->join('tbl_agen', 'tbl_agen.id_agen = tbl_koordinatagen.agen_id');//kita join tbl agen dengan foreign key agen_id
        $this->db->where('id_koordinatagen', $id);
        $query = $this->db->get();
        return $query;
    }
    public function update($agen,$latitude,$longitude,$id){
        $data = array('agen_id' => $agen,
        'latitude'=>$latitude,
        'longitude'=>$longitude);
        $this->db->where('id_koordinatagen', $id);
        $query = $this->db->update('tbl_koordinatagen',$data);
        return $query;
    }
    public function delete($id){
        $this->db->where('id_koordinatagen', $id);
        $query = $this->db->delete('tbl_koordinatagen');
        return $query;
    }
    public function validasi($id){
        $this->db->where('agen_id', $id);
        $query = $this->db->get('tbl_koordinatagen');
        return $query;
    }

}