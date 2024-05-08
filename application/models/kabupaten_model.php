<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class kabupaten_model extends CI_Model
{
    // get data dropdown
    function dd_kabupaten()
    {
        // ambil data dari db
        $this->db->query('SELECT * FROM m_kab');
        $this->db->order_by('nama_kab', 'asc');
        $result = $this->db->get('nama_kab');
        
        // bikin array
        // please select berikut ini merupakan tambahan saja agar saat pertama
        // diload akan ditampilkan text please select.
        $dd[''] = 'Please Select';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $dd[$row->id_provinsi] = $row->provinsi;
            }
        }
        return $dd;
    }
}