<?php
class M_getfunction extends CI_Model{
    //private $table="pemirsa_m_target";
    
    function getsatuan($id_subkegiatan){
		$hasil=$this->db->query("SELECT s.id_satuan, s.satuan FROM m_satuan s LEFT JOIN m_listkegiatan k ON s.id_satuan = k.satuan WHERE k.id='$id_subkegiatan' ");
        return $hasil->result();
    }
    
    function getsubkegiatan($id_kegiatan){
		$hasil=$this->db->query("SELECT * FROM m_listkegiatan WHERE id_kegiatan='$id_kegiatan' AND id NOT IN (SELECT nama_kegiatan FROM m_jeniskegiatan) ");
        return $hasil->result();
    }
}