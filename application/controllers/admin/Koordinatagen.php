<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koordinatagen extends CI_Controller{

     public function __construct()
    {
        parent::__construct();
        //kita load model yang dibutuhkan, yaitu model jalan
        $this->load->model(array('model_agen','model_koordinatagen'));
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    function index()
    {
        $data = array('content' => 'admin/formkoordinatagen',//kita buat file formagen di dalam folder views/admin
        'itemagen'=>$this->model_agen->getAll(),
        'itemkoordinat'=>$this->model_koordinatagen->getAll());
        $this->load->view('templates/template-admin', $data);
    }

    function create(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            //kita validasi inputnya dulu
            $this->form_validation->set_rules('id_agen', 'Nama agen', 'trim|required');
            $this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
            $this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                $agen = $this->input->post('id_agen');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                if ($this->model_koordinatagen->validasi($agen)->num_rows()==null) {
                    if ($this->model_koordinatagen->create($agen,$latitude,$longitude)){
                    $status = 'success';
                    $msg = "Data koordinat agen berhasil disimpan";
                    }else{
                    $status = 'error';
                    $msg = "terjadi kesalahan saat menyimpan data agen";
                }
                }else{
                    $status = 'error';
                    $msg = "koordinat marker untuk agen tersebut sudah ada";
                }
                
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }

    function delete(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            //kita validasi inputnya dulu
            $this->form_validation->set_rules('id_koordinatagen', 'Id Koordinat agen', 'trim|required');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                $id = $this->input->post('id_koordinatagen');
                if ($this->model_koordinatagen->delete($id)){
                    $status = 'success';
                    $msg = "Data koordinat agen berhasil dihapus";
                }else{
                    $status = 'error';
                    $msg = "terjadi kesalahan saat menghapus data agen";
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }

    function read(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            //kita validasi inputnya dulu
            $this->form_validation->set_rules('id_koordinatagen', 'Id Koordinat agen', 'trim|required');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                $id = $this->input->post('id_koordinatagen');
                if ($this->model_koordinatagen->read($id)->num_rows()!=null){
                    $status = 'success';
                    $msg = $this->model_koordinatagen->read($id)->result();
                }else{
                    $status = 'error';
                    $msg = "Data tidak ditemukan";
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }

}