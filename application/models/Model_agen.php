<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_agen extends CI_Model{

    public function create(){
        $data = array('namaagen' => $this->input->post('namaagen'),
        'keterangan'=>$this->input->post('keterangan'));
        $query = $this->db->insert('tbl_agen', $data);
        return $query;
    }
    public function getAll(){
        $query = $this->db->get('tbl_agen');
        return $query;
    }
    public function read($id){
        $this->db->where('id_agen', $id);
        $query = $this->db->get('tbl_agen');
        return $query;
    }
    public function delete($id){
        $this->db->where('id_agen', $id);
        $query = $this->db->delete('tbl_agen');
        return $query;
    }
    public function update($id){
        $data = array('namaagen' => $this->input->post('namaagen'),
        'keterangan'=>$this->input->post('keterangan'));
        $this->db->where('id_agen', $id);
        $query = $this->db->update('tbl_agen', $data);
        return $query;
    }

}