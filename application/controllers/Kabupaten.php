<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class kabupaten extends CI_Controller
{
    // create akan menampilkan form 
    public function create() 
    {
        // load model dan form helper 
        $this->load->model('kabupaten_model');
        $this->load->helper('form_helper');

        $data = array(
            'button' => 'Create',
            'action' => site_url('provinsi/create_action'),
            'dd_kabupaten' => $this->kabupaten_model->dd_kabupaten(),
            'kabupaten_selected' => $this->input->post('nama_kabupaten') ? $this->input->post('nama_kabupaten') : '', // untuk edit ganti '' menjadi data dari database misalnya $row->provinsi
	);
        
        $this->load->view('kabupaten_form', $data);
    }
}