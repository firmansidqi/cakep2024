<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sso extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('encryption'); //in controller
	}
	
	public function index() {
	    if($this->session->userdata('admin_valid') && $this->session->userdata('admin_id')){
	        echo json_encode(array(
	            'status'    => 'success',
	            'nama'      => $this->session->userdata('admin_nama'),
	            'tahun'     => $this->session->userdata('admin_ta')
	       ));
	    } else {
	        echo json_encode(array(
                'status'    => 'error',
                'message'   => 'Anda belum login ke dalam sistem'
            ));
	    }
	}
	
	public function login() {
	    $result = array( 'status' => 'error');
	    
	    if($this->session->userdata('admin_valid') && $this->session->userdata('admin_id')){
            $result = array(
	            'status'    => 'success',
	            'nama'      => $this->session->userdata('admin_nama'),
	            'tahun'     => $this->session->userdata('admin_ta'),
            );
	    } else {
    		$user	= $this->security->xss_clean($this->input->post('username'));
            $pass	= md5($this->security->xss_clean($this->input->post('password')));
    		$tahun 	= $this->security->xss_clean($this->input->post('tahun'));
    		
    		$q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$user."' AND password = '".$pass."'");
    		$j_cek	= $q_cek->num_rows();
    		$d_cek	= $q_cek->row();
    		
            if($j_cek == 1) {
                $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->nama,
                    'admin_ta' => $ta,
                    'admin_level' => $d_cek->level,
					'admin_valid' => true,
					'admin_nip' => $d_cek->nip
                );
                $this->session->set_userdata($data);

                $result = array(
    	            'status'    => 'success',
    	            'nama'      => $this->session->userdata('admin_nama'),
    	            'tahun'     => $this->session->userdata('admin_ta'),
                );
            }
            
            echo json_encode($result);
	    }
	}
	
	public function kegiatan() {
	    // admin/unitkerjakabkotadetail
	    $result = array( 'status' => 'error');

	    if($this->session->userdata('admin_valid') && $this->session->userdata('admin_id')){
            $id_kabkota	= $this->session->userdata('admin_user');
            $tahun      = $this->session->userdata('admin_ta');
            $id_bulan   = $this->uri->segment(3);
            if(!$id_bulan)  $id_bulan = date('m');
            
            $rows		= $this->db->query("select t.id_kab,t.id_jeniskegiatan, m.nama_kegiatan,u.unitkerja, m.batas_waktu, t.target, t.realisasi, s.satuan,t.tgl_entri,t.flag_konfirm from t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on m.satuan=s.id_satuan where t.id_kab='$id_kabkota' and t.target <> '0' and YEAR(m.batas_waktu) = '$tahun' and MONTH(m.batas_waktu) = '$id_bulan' order by t.id_jeniskegiatan asc, m.batas_waktu asc")->result();
            if($rows){
                $data = array();
                foreach($rows as $row){
                    $data[] = $row;
                }
                $result['status'] = 'success';
                $result['data'] = $data;
            }
        }
	    
        echo json_encode($result);
	}
	
	public function view() {
	    $result = array( 'status' => 'error');

	    if($this->session->userdata('admin_valid') && $this->session->userdata('admin_id')){
            $kabkota	= $this->session->userdata('admin_user');
            $idu        = $this->uri->segment(3);

//			$row	= $this->db->query("SELECT k.*,m.nama_kegiatan,w.nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab WHERE k.id_jeniskegiatan = '$idu' and k.id_kab='$kabkota'")->row();	
			$row	= $this->db->query("SELECT k.id_jeniskegiatan, k.id_kab, k.target, k.realisasi, k.tgl_entri, k.flag_konfirm, k.bukti, k.link_pengiriman,m.nama_kegiatan,w.nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab WHERE k.id_jeniskegiatan = '$idu' and k.id_kab='$kabkota'")->row();	
            if($row){
                $result['status'] = 'success';
                $result['data'] = $row;
            }
	    }
	    
        echo json_encode($result);
	}
	
	public function update() {
	    $result = array( 'status' => 'error');

	    if($this->session->userdata('admin_valid') && $this->session->userdata('admin_id')){
            $kabkota        	= $this->session->userdata('admin_user');
    		$id_jeniskegiatan	= $this->security->xss_clean($this->input->post('id_jeniskegiatan'));
    		$realisasi      	= $this->security->xss_clean($this->input->post('realisasi'));
    		$tgl_entri      	= $this->security->xss_clean($this->input->post('tgl_entri'));
    		$bukti	            = $this->security->xss_clean($this->input->post('bukti'));
    		$link_pengiriman	= $this->security->xss_clean($this->input->post('link_pengiriman'));
    		
			$row	= $this->db->query("SELECT * FROM t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$kabkota'")->row();	
    		if($row && $kabkota && $id_jeniskegiatan && $realisasi && $tgl_entri && $bukti && $link_pengiriman){
    		    $data = array(
    		        'realisasi' => $realisasi,
    		        'tgl_entri' => $tgl_entri,
    		        'bukti'     => $bukti,
    		        'link_pengiriman'   => $link_pengiriman
                );
    		    $this->db->query("UPDATE t_kegiatan SET ".implode("," , $data)." WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$kabkota'");

    			$row	= $this->db->query("SELECT * FROM t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$kabkota'")->row();	
                if($row->realisasi==$realisasi && $row->tgl_entri==$tgl_entri && $row->bukti==$bukti && $row->link_pngiriman==$link_pengiriman){
                    $result['status'] = 'success';
                    $result['data'] = array('id_jeniskegiatan' => $id_jeniskegiatan) + $data;
                }
    		}
    		
	    }
	    
	    echo json_encode($result);
	}
}