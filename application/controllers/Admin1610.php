<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('M_kelolakegiatan');
		$this->load->library('encryption'); //in controller
	}
	
	public function index() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		//variabel untuk select dropdown
		$kab = $this->input->get('pilih_kab');
		$bulan = $this->input->get('bln');
		$tahun = $this->input->get('Tahun');
		
		//tes highchart
		$a['report'] = $this->M_kelolakegiatan->reportDashboard($kab, $bulan, $tahun);
		$a['report2'] = $this->M_kelolakegiatan->cobaJumlahKegiatanPerbidang();
		$a['report3'] = $this->M_kelolakegiatan->cobaJumlahKegiatanPerbulan();
		$a['report4'] = $this->M_kelolakegiatan->cobaReportKegiatanPerbidang();
		$a['report5'] = $this->M_kelolakegiatan->cobaJumlahKegiatanPerkabkot();
		//$this->load->view('dashboard', $a);

		//$this->load->model('M_kelolakegiatan');
		$hasil = $this->M_kelolakegiatan->cobaLaporanDashboard($kab, $bulan, $tahun);
		$hasil2 = $this->M_kelolakegiatan->jumlahKegiatanPerbidang();
		$hasil3 = $this->M_kelolakegiatan->jumlahKegiatanPerbulan();
		$hasil4 = $this->M_kelolakegiatan->ReportKegiatanPerbidang();
		$hasil5 = $this->M_kelolakegiatan->jumlahKegiatanPerkabkot();
		
		$a['hasil'] = $hasil;
		$a['hasil2'] = $hasil2;
		$a['hasil3'] = $hasil3;
		$a['hasil4'] = $hasil4;
		$a['hasil5'] = $hasil5;
		$a['page']	= "dashboard_komplit";
		$a['kab'] = $kab;
		$a['bulan'] = $bulan;
		$a['tahun'] = $tahun;
		
		$this->load->view('admin/index', $a);

		$this->input->get();
		/*
		$data = $this->mymodel->cobaLaporan();
		foreach ($data as $tabel) {
			echo "ID Kegiatan".$tabel['id_jeniskegiatan']."<br/>";
		}*/
	}
	
	public function kalender() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		$a['page']	= "f_kalender";
		
		$this->load->view('admin/index', $a);
	}

	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}		
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		
		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$nama					= addslashes($this->input->post('nama'));
		$alamat					= addslashes($this->input->post('alamat'));
		$kepsek					= addslashes($this->input->post('kepsek'));
		$nip_kepsek				= addslashes($this->input->post('nip_kepsek'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('logo')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepsek = '$kepsek', nip_kepsek = '$nip_kepsek', logo = '".$up_data['file_name']."' WHERE id = '$idp'");

			} else {
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepsek = '$kepsek', nip_kepsek = '$nip_kepsek' WHERE id = '$idp'");
			}		

			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/admin/pengguna');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('admin/index', $a);	
	}
	
	public function manage_admin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_admin")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/manage_admin/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$username				= addslashes($this->input->post('username'));
		$password				= md5(addslashes($this->input->post('password')));
		$nama					= addslashes($this->input->post('nama'));
		$nip					= addslashes($this->input->post('nip'));
		$level					= addslashes($this->input->post('level'));
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_admin WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_admin WHERE nama LIKE '%$cari%' ORDER BY id DESC")->result();
			$a['page']		= "l_manage_admin";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_admin WHERE id = '$idu'")->row();	
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "act_add") {	
			$cek_user_exist = $this->db->query("SELECT username FROM t_admin WHERE username = '$username'")->num_rows();

			if (strlen($username) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username minimal 4 huruf</div>");
				redirect('index.php/admin/manage_admin');
			} else if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username telah dipakai. Ganti yang lain..!</div>");
				redirect('index.php/admin/manage_admin');	
			} else {
				$this->db->query("INSERT INTO t_admin VALUES (NULL, '$username', '$password', '$nama', '$nip', '$level')");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "act_edt") {
			if ($password == md5("-")) {
				$this->db->query("UPDATE t_admin SET username = '$username', nama = '$nama', nip = '$nip', level = '$level' WHERE id = '$idp'");
			} else {
				$this->db->query("UPDATE t_admin SET username = '$username', password = '$password', nama = '$nama', nip = '$nip', level = '$level' WHERE id = '$idp'");
			}
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated </div>");			
			redirect('index.php/admin/manage_admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_admin LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_manage_admin";
		}
		
		$this->load->view('admin/index', $a);
	}

	public function get_klasifikasi() {
		$kode 				= $this->input->post('kode',TRUE);
		
		$data 				=  $this->db->query("SELECT id, kode, nama FROM ref_klasifikasi WHERE kode LIKE '%$kode%' ORDER BY id ASC")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$json_array				= array();
            $json_array['value']	= $d->kode;
			$json_array['label']	= $d->kode." - ".$d->nama;
			$klasifikasi[] 			= $json_array;
		}
		
		echo json_encode($klasifikasi);
	}
	
	//tambahan
	public function get_bidang() {
		$kode 				= $this->input->post('kpd_yth',TRUE);
		
		$data 				=  $this->db->query("SELECT * FROM m_bidang WHERE nama_bidang LIKE '%$kode%' ORDER BY id_bidang ASC")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$json_array				= array();
            $json_array['value']	= $d->id_bidang." - ".$d->nama_bidang;
			$json_array['label']	= $d->id_bidang." - ".$d->nama_bidang;
			$klasifikasi[] 			= $json_array;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function get_instansi_lain() {
		$kode 				= $this->input->post('dari',TRUE);
		
		$data 				=  $this->db->query("SELECT dari FROM t_surat_masuk WHERE dari LIKE '%$kode%' GROUP BY dari")->result();
		
		$klasifikasi 		=  array();
        foreach ($data as $d) {
			$klasifikasi[] 	= $d->dari;
		}
		
		echo json_encode($klasifikasi);
	}
	
	public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ke				= $this->uri->segment(3);
		$id_user		= $this->session->userdata('admin_id');
		
		//var post
		$p1				= md5($this->input->post('p1'));
		$p2				= md5($this->input->post('p2'));
		$p3				= md5($this->input->post('p3'));
		
		if ($ke == "simpan") {
			$cek_password_lama	= $this->db->query("SELECT password FROM t_admin WHERE id = $id_user")->row();
			//echo 
			
			if ($cek_password_lama->password != $p1) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Lama tidak sama</div>');
				redirect('index.php/admin/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('index.php/admin/passwod');
			} else {
				$this->db->query("UPDATE t_admin SET password = '$p3' WHERE id = ".$id_user."");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('index.php/admin/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('admin/index', $a);
	}
	
	//login
	public function login() {
		$this->load->view('admin/login');
	}
	
	public function do_login() {
		$u 		= $this->security->xss_clean($this->input->post('u'));
		$ta 	= $this->security->xss_clean($this->input->post('ta'));
        $p 		= md5($this->security->xss_clean($this->input->post('p')));
         
		$q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$u."' AND password = '".$p."'");
		$j_cek	= $q_cek->num_rows();
		$d_cek	= $q_cek->row();
		//echo $this->db->last_query();
		
        if($j_cek == 1) {
            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->nama,
                    'admin_ta' => $ta,
                    'admin_level' => $d_cek->level,
					'admin_valid' => true
                    );
            $this->session->set_userdata($data);
            redirect('index.php/admin');
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('index.php/admin/login');
		}
	}
	
	public function logout(){
        $this->session->sess_destroy();
		redirect('index.php/admin/login');
    }
	
	public function progress() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination 	
		$total_row_all		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan")->num_rows();
		$total_row_tu		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351'")->num_rows();
		$total_row_sos		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352'")->num_rows();
		$total_row_prod		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353'")->num_rows();
		$total_row_dist		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354'")->num_rows();
		$total_row_ner		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355'")->num_rows();
		$total_row_ipds		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagiall']	= _page($total_row_all, $per_page, 4, base_url()."index.php/admin/progress/p");
		$a['pagitu']	= _page($total_row_tu, $per_page, 4, base_url()."index.php/admin/progress/p");
		$a['pagisos']	= _page($total_row_sos, $per_page, 4, base_url()."index.php/admin/progress/p");
		$a['pagiprod']	= _page($total_row_prod, $per_page, 4, base_url()."index.php/admin/progress/p");
		$a['pagidist']	= _page($total_row_dist, $per_page, 4, base_url()."index.php/admin/progress/p");
		$a['paginer']	= _page($total_row_ner, $per_page, 4, base_url()."index.php/admin/progress/p");
		$a['pagiipds']	= _page($total_row_ipds, $per_page, 4, base_url()."index.php/admin/progress/p");
		*/
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));
		$cari					= addslashes($this->input->post('q'));

		if ($mau_ke == "detail") 
		{
			//echo $idu;
			$a['dataall']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu'")->result();
			$a['datatu']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,4)='3351'")->result();
			$a['datasos']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,4)='3352'")->result();
			$a['dataprod']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,4)='3353'")->result();
			$a['datadist']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,4)='3354'")->result();
			$a['datanerwil']	= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,4)='3355'")->result();
			$a['dataipds']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,4)='3356'")->result();
			$a['page']			= "l_progress_kab";
		} 
		else {
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']		= "l_progress";
		}
		
		$this->load->view('admin/index', $a);
	}

	public function get_kegiatan() {
		$unitkerja=$this->input->post('unitkerja');
		$bidang = substr($unitkerja,1,4);
		$query 	=  $this->db->query("SELECT * FROM m_jeniskegiatan WHERE substring(id_jeniskegiatan,1,4)='$bidang'");
		?>
		<option value="Kosong">-- Pilih Nama Kegiatan--<?php echo $bidang;?></option>
		<?php
        foreach($query->result() as $row)
        { 
             echo "<option value='".$row->id_jeniskegiatan."'>".$row->nama_kegiatan."</option>";
        }
	}
	
public function entry() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		$kabkota=$this->session->userdata('admin_user') ;
		/* pagination */	
		$total_row		= $this->db->query("SELECT k.*,(k.realisasi/k.target*100) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/entry/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$id_jeniskegiatan		= addslashes($this->input->post('id_jeniskegiatan'));
		$nama_kegiatan			= addslashes($this->input->post('nama_kegiatan'));
		$target					= addslashes($this->input->post('target'));
		$realisasi				= addslashes($this->input->post('realisasi'));
		$bukti					= addslashes($this->input->post('bukti'));
		$newrealisasi			= addslashes($this->input->post('newrealisasi'));

		$tgl_entri				= date('Y-m-d');

		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_masuk';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "edt") {
			$kabkota =$this->uri->segment(5);
			$a['datpil']	= $this->db->query("SELECT k.*,m.nama_kegiatan,w.nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab WHERE k.id_jeniskegiatan = '$idu' and k.id_kab='$kabkota'")->row();	
			$a['page']		= "f_entry";
		} 
		else if ($mau_ke == "act_edt")
		{
			if($newrealisasi > $target)
			{
			$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Realisasi Tidak Boleh Melebihi Target</div>");	
			redirect('index.php/admin/entry/edt/'.$id_jeniskegiatan);
			}
			else
			{	
				$tab				= addslashes($this->input->post('tab'));
				if($this->session->userdata('admin_user') != "3300")
				{
				$queryrealisasisekarang =$this->db->query("select realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' ")->result();
				//$datarealisasisekarang = mysql_fetch_array($queryrealisasisekarang);
				$realisasisekarang = $queryrealisasisekarang->realisasi;
				$realisasiterbaru = $queryrealisasisekarang->realisasi + $newrealisasi ;
				
				
				$this->db->query("UPDATE t_kegiatan SET realisasi = '$newrealisasi', tgl_entri = '$tgl_entri', flag_konfirm='2', bukti='$bukti' WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$kabkota'");
				if($realisasiterbaru < $target)
				{
				$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$realisasiterbaru' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
				}
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
				redirect('index.php/admin/entry/');
				}
				else
				{
				$kabkota			= addslashes($this->input->post('kabkota'));
				
				$this->db->query("UPDATE t_kegiatan SET realisasi = '$newrealisasi', tgl_entri = '$tgl_entri' , flag_konfirm='2' WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$kabkota'");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
				redirect('index.php/admin/entry/');
				}
			}
		} else {
		if($this->session->userdata('admin_user') == "3300")
			{
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2)  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2)  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2)  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' ")->result();
			$a['page']			= "l_entry";
			}
		else
		{
			$a['dataall']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota' and k.target <> 0 order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3351' and id_kab='$kabkota' and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3352' and id_kab='$kabkota' and k.target <> 0   order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3353' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where substring(k.id_jeniskegiatan,1,4)='3354' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3355' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc  ")->result();
			$a['dataipds']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3356' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc  ")->result();
			$a['page']		= "l_entry";
		
		
		}
		}
		
		$this->load->view('admin/index', $a);
	}
	
	
public function kelolakegiatan() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT *,(realisasi/target*100) as persen  FROM m_jeniskegiatan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/kelolakegiatan/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$cari					= addslashes($this->input->post('q'));
	
		//ambil variabel post
		
		$idp					= addslashes($this->input->post('idp'));
		$unitkerja				= addslashes($this->input->post('unitkerja'));
		$tahun					= addslashes($this->input->post('tahun'));
		//ambil max id
		
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$nama_kegiatan			= addslashes($this->input->post('nama_kegiatan'));
		$dasar_surat			= addslashes($this->input->post('dasar_surat'));
		//$targetprop				= addslashes($this->input->post('targetprop'));
		$tab					= addslashes($this->input->post('tab'));
		//$realisasiprop			= addslashes($this->input->post('realisasiprop'));
		$satuan					= addslashes($this->input->post('satuan'));
		$_3301 					=addslashes($this->input->post('_3301'));
		$_3302 					=addslashes($this->input->post('_3302'));
		$_3303					=addslashes($this->input->post('_3303'));
		$_3304					=addslashes($this->input->post('_3304'));
		$_3305					=addslashes($this->input->post('_3305'));
		$_3306					=addslashes($this->input->post('_3306'));
		$_3307					=addslashes($this->input->post('_3307'));
		$_3308					=addslashes($this->input->post('_3308'));
		$_3309					=addslashes($this->input->post('_3309'));
		$_3310					=addslashes($this->input->post('_3310'));
		$_3311					=addslashes($this->input->post('_3311'));
		$_3312					=addslashes($this->input->post('_3312'));
		$_3313					=addslashes($this->input->post('_3313'));
		$_3314					=addslashes($this->input->post('_3314'));
		$_3315					=addslashes($this->input->post('_3315'));
		$_3316					=addslashes($this->input->post('_3316'));
		$_3317					=addslashes($this->input->post('_3317'));
		$_3318					=addslashes($this->input->post('_3318'));
		$_3319					=addslashes($this->input->post('_3319'));
		$_3320					=addslashes($this->input->post('_3320'));
		$_3321					=addslashes($this->input->post('_3321'));
		$_3322					=addslashes($this->input->post('_3322'));
		$_3323					=addslashes($this->input->post('_3323'));
		$_3324					=addslashes($this->input->post('_3324'));
		$_3325					=addslashes($this->input->post('_3325'));
		$_3326					=addslashes($this->input->post('_3326'));
		$_3327					=addslashes($this->input->post('_3327'));
		$_3328					=addslashes($this->input->post('_3328'));
		$_3329					=addslashes($this->input->post('_3329'));
		$_3371					=addslashes($this->input->post('_3371'));
		$_3372					=addslashes($this->input->post('_3372'));
		$_3373					=addslashes($this->input->post('_3373'));
		$_3374					=addslashes($this->input->post('_3374'));
		$_3375					=addslashes($this->input->post('_3375'));
		$_3376					=addslashes($this->input->post('_3376'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/bukti_kirim';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if($mau_ke == "del")
		{
			$id_delete = $this->input->get('delete_id');;
			?>
			<script>
			//window.alert('<?php echo $id_delete;?>');</script>
			<?php
			$a['datpil']	= $this->db->query("select m.* from m_jeniskegiatan as m where m.id_jeniskegiatan='$id_delete'")->row();	
			$a['page']		= "f_del";
		
		}
		else if ($mau_ke == "act_del") {
			$id_jeniskegiatan = addslashes($this->input->post('id_jeniskegiatan'));
			$tab = addslashes($this->input->post('tab'));
			$this->db->query("DELETE FROM m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
			$this->db->query("DELETE FROM t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil dihapus </div>");
			redirect('index.php/admin/kegiatan/');
		} else if ($mau_ke == "cari") {
			if($this->session->userdata('admin_user') == "3300")
			{
			$a['dataall']		= $this->db->query("SELECT *,round((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where m.nama_kegiatan  LIKE '%$cari%' ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' and nama_kegiatan like '%$cari%'")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' and nama_kegiatan like '%$cari%' ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' and nama_kegiatan like '%$cari%'")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' and nama_kegiatan like '%$cari%'")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' and nama_kegiatan like '%$cari%'")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' and nama_kegiatan like '%$cari%'")->result();
			$a['page']		= "l_kelolakegiatan";
			}
		else
		{
			$kabkota=$this->session->userdata('admin_user') ;
			$a['dataall']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota' and m.nama_kegiatan like '%$cari%' ")->result();
			$a['datatu']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3351' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
			$a['datasos']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3352' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
			$a['dataprod']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3353' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
			$a['datadist']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where substring(k.id_jeniskegiatan,1,4)='3354' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
			$a['datanerwil']	= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3355' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
			$a['dataipds']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3356' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
			$a['page']		= "l_kelolakegiatan";
		}
			$a['page']		= "l_kelolakegiatan";
		} else if ($mau_ke == "add") {
			$tab			= $this->uri->segment(4);
			$a['page']		= "f_kelolakegiatan";
		} else if ($mau_ke == "edt") {
			$tab			= $this->uri->segment(5);
			$a['datpil']	= $this->db->query("SELECT k.*,m.nama_kegiatan,m.satuan,m.batas_waktu,m.dasar_surat, w.nama_kab,m.target as targetprop, m.realisasi as realisasiprop,m.batas_waktu as batas_waktu FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab WHERE k.id_jeniskegiatan = '$idu'")->row();	
			$a['page']		= "f_kelolakegiatan";
		} else if ($mau_ke == "act_add") {
			$query = $this->db->query("select max(substring(id_jeniskegiatan,10,2)) as maxID from m_jeniskegiatan where substring(id_jeniskegiatan,6,4)='$tahun' and substring(id_jeniskegiatan,1,5)='$unitkerja'")->row();
			//$data = mysql_fetch_array($query);
			$idMax = $query->maxID;
			$noUrut = (int)$idMax;
			$noUrut++;
			$id_jeniskegiatan = $unitkerja.''.$tahun.''.sprintf("%02s",$noUrut);
		
			$targetkabkumulatif=0; 
			$wilayah=$this->db->query("select * from m_kab")->result();
			foreach ($wilayah as $row)
			{
				$kode_kab = $row->id_kab;
				$data_kab = addslashes($this->input->post('_'.$kode_kab));
				$targetkabkumulatif+=$data_kab;
			}
			
			/*if($targetkabkumulatif > $targetprop)
			{
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Jumlah Target Kabkota Tidak Boleh Melebihi Target Propinsi</div>");	
				redirect('index.php/admin/kegiatan/add/');
			}
			else
			{*/
				$wilayah=$this->db->query("select * from m_kab")->result();
				$bataswaktuplussatu = new DateTime($batas_waktu);
				date_modify($bataswaktuplussatu, '+1 day');
				$bataslewat = date_format($bataswaktuplussatu, 'Y-m-d');
				foreach ($wilayah as $row)
				{
					$kode_kab = $row->id_kab;
					$data_kab = addslashes($this->input->post('_'.$kode_kab));
					$this->db->query("INSERT INTO t_kegiatan VALUES (NULL,'$id_jeniskegiatan', '$kode_kab','$data_kab',0,'$bataslewat','1','-','0','-','-1','0','0','','','0','')");
				}
				$this->db->query("INSERT INTO m_jeniskegiatan VALUES (NULL,'$id_jeniskegiatan', '$nama_kegiatan', $targetkabkumulatif,0, '$satuan', '$batas_waktu','$dasar_surat')");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
				redirect('index.php/admin/kegiatan/');
			//}
		} 
		else if ($mau_ke == "act_edt") {

			$id_jeniskegiatan =$this->uri->segment(4);
			$realisasiprop = 0;
			$targetkabkumulatif=0; 
			$wilayah=$this->db->query("select * from m_kab")->result();
			foreach ($wilayah as $row)
			{
				$kode_kab = $row->id_kab;
				$data_kab = addslashes($this->input->post('_'.$kode_kab));
				$realisasi_kab= addslashes($this->input->post('realisasi_'.$kode_kab));
				$realisasiprop+=$realisasi_kab;
				$targetkabkumulatif+=$data_kab;
			}
			
			/*if($targetkabkumulatif > $targetprop || $realisasiprop > $targetprop)
			{
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Jumlah Target atau Realisasi Kabkota Tidak Boleh Melebihi Target Propinsi</div>");	
				echo "<script type='text/javascript'>alert('submitted failed!')</script>";
				redirect('index.php/admin/kelolakegiatan/edt/'.$id_jeniskegiatan);
				
			}
			else
			{
				echo 'target'.$targetkabkumulatif ;*/
			//	echo 'realisasi'.$realisasiprop;
				$this->db->query("UPDATE m_jeniskegiatan SET nama_kegiatan ='$nama_kegiatan', target= $targetkabkumulatif, realisasi=$realisasiprop, satuan = '$satuan', batas_waktu = '$batas_waktu',dasar_surat='$dasar_surat' where id_jeniskegiatan='$id_jeniskegiatan'");
				$wilayah=$this->db->query("select * from m_kab")->result();
						
				foreach ($wilayah as $row)
				{
					$kode_kab = $row->id_kab;
					$data_kab = addslashes($this->input->post('_'.$kode_kab));
					$realisasi_kab= addslashes($this->input->post('realisasi_'.$kode_kab));
					if($realisasi_kab == '0')
					{
						$tgl_entri		='0000-00-00';
					}
					else
					{
						$tgl_entri		= date('Y-m-d');
					}
					if($realisasi_kab != 0)
					{
					$query_realisasi=$this->db->query("select realisasi from t_kegiatan  where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' LIMIT 1")->row();
					$realisasi_sekarang=$query_realisasi->realisasi;
					if($realisasi_sekarang != $realisasi_kab)
						{
						$this->db->query("UPDATE t_kegiatan SET target = '$data_kab', realisasi = '$realisasi_kab', tgl_entri='$tgl_entri', flag_konfirm='1', bukti='Realisasi Di Update Provinsi Tanggal $tgl_entri' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab'" );
						}
					else
						{
						$this->db->query("UPDATE t_kegiatan SET target = '$data_kab' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab'" );
						}
					}
					else
					{
					$this->db->query("UPDATE t_kegiatan SET target = '$data_kab' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab'" );
					}
				
				}
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");
				redirect('index.php/admin/kegiatan/');
			//}
		} 
		else {
		if($this->session->userdata('admin_user') == "3300")
			{
			$a['dataall']		= $this->db->query("SELECT *,round ((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round ((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where substring(id_jeniskegiatan,1,4)='3351' order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round ((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where substring(id_jeniskegiatan,1,4)='3352' order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round ((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where substring(id_jeniskegiatan,1,4)='3353' order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round ((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where substring(id_jeniskegiatan,1,4)='3354' order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round ((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where substring(id_jeniskegiatan,1,4)='3355' order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round ((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where substring(id_jeniskegiatan,1,4)='3356' order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
			$a['page']			= "l_kelolakegiatan";
			}
		else
		{
			$kabkota=$this->session->userdata('admin_user') ;
			$a['dataall']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota' order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc")->result();
			$a['datatu']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3351' and id_kab='$kabkota'")->result();
			$a['datasos']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3352' and id_kab='$kabkota' ")->result();
			$a['dataprod']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3353' and id_kab='$kabkota' ")->result();
			$a['datadist']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where substring(k.id_jeniskegiatan,1,4)='3354' and id_kab='$kabkota' ")->result();
			$a['datanerwil']	= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3355' and id_kab='$kabkota' ")->result();
			$a['dataipds']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,4)='3356' and id_kab='$kabkota'  ")->result();
			$a['page']		= "l_kelolakegiatan";

		}
		}
		
		$this->load->view('admin/index', $a);
	}



public function satuan() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM m_satuan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/satuan/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$satuan				= addslashes($this->input->post('satuan'));
	
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM m_satuan WHERE id_satuan = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('index.php/admin/satuan');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM m_satuan WHERE satuan LIKE '%$cari%' ORDER BY id_satuan DESC")->result();
			$a['page']		= "l_satuan";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_satuan";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM m_satuan WHERE id_satuan = '$idu'")->row();	
			$a['page']		= "f_satuan";
		} else if ($mau_ke == "act_add") {	
			
				$this->db->query("INSERT INTO m_satuan VALUES (NULL, '$satuan')");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			redirect('index.php/admin/satuan');
		} else if ($mau_ke == "act_edt") {
			
				$this->db->query("UPDATE m_satuan SET satuan = '$satuan' where id_satuan = '$idp'");
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated </div>");			
			redirect('index.php/admin/satuan');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM m_satuan LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_satuan";
		}
		
		$this->load->view('admin/index', $a);
	}

public function konfirmasi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		parse_str($_SERVER['QUERY_STRING'], $_GET);  
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT distinct(m.nama_kegiatan),m.*,count(k.id_kab) as jumlah_dikonfirm FROM m_jeniskegiatan m inner join t_kegiatan k on k.id_jeniskegiatan=m.id_jeniskegiatan where k.flag_konfirm='2' and k.realisasi <> '0' group by k.id_jeniskegiatan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/konfirmasi/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$idp					= addslashes($this->input->post('idp'));
		$cari					= addslashes($this->input->post('q'));
		
		if ($mau_ke == "edt") {
			$id_edit 		  = $this->input->get('konfirmasi_id');
			$id_jeniskegiatan = substr($id_edit,0,11);

			$id_kab=substr($id_edit,11,4);
			$a['datpil']	= $this->db->query("select k.id_jeniskegiatan,m.nama_kegiatan,k.id_kab,w.nama_kab,k.target,k.realisasi,k.bukti from t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$id_jeniskegiatan' and k.id_kab='$id_kab'")->row();	
			$a['page']		= "f_konfirmasi";
		}
		else if ($mau_ke == "act_edt")
		{
				$tab_aktif=addslashes($this->input->post('tab_aktif'));
				$id_jeniskegiatan = addslashes($this->input->post('id_jeniskegiatan'));
				$id_kab = addslashes($this->input->post('id_kab'));
				$this->db->query("update t_kegiatan set flag_konfirm='1' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$id_kab'");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data sudah dikonfirmasi</div>");
				//echo "<script>  window.location.reload(); </script>";
				//redirect('index.php/admin/unitkerjakabkota');
				redirect('index.php/admin/kegiatan/view/'.$id_jeniskegiatan);
		
		}
		$this->load->view('admin/index', $a);
	}

public function kegiatan()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
	
		if ($mau_ke == "pilih_kegiatan")
		{
			if($idu == '00')
			{
				if($this->session->userdata('admin_user') != '3300')
				{	
				$bidangku = $this->session->userdata('admin_user');
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan where YEAR(k.batas_waktu)='$tahun'  and substring(u.id_unitkerja,1,4) = '$bidangku' order by k.batas_waktu desc")->result();
				}
				else
				{
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan where YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
				}
				$a['page']		= "l_kegiatan";	
			}
			else
			{
				if($this->session->userdata('admin_user') != '3300')
				{	
				$bidangku = $this->session->userdata('admin_user');
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(u.id_unitkerja,1,4) = '$bidangku' order by k.batas_waktu desc")->result();
				}
				else
				{
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
				}
				$a['page']		= "l_kegiatan";	
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu'  and k.target <> '0'")->result();	
			$a['page']		= "v_kegiatan_detail";
		}
		else
		{
			if($this->session->userdata('admin_user') != '3300')
			{
			$bidangku = $this->session->userdata('admin_user');
			$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(u.id_unitkerja,1,4) = '$bidangku' order by k.batas_waktu desc")->result();
			}
			else
			{
			$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
			}
			$a['page']		= "l_kegiatan";	
		}
		
		$this->load->view('admin/index', $a);
	}

public function kegiatan_bidang()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
		redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
	
		if ($mau_ke == "pilih_kegiatan") {
			if($idu == '00')
			{
			$a['data33511']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33511'")->result();
			$a['data33512']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33512'")->result();
			$a['data33513']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33513'")->result();
			$a['data33514']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33514'")->result();
			$a['data33515']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33515'")->result();
			$a['data33521']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33521'")->result();
			$a['data33522']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33522'")->result();
			$a['data33523']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33523'")->result();
			$a['data33531']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33531'")->result();
			$a['data33532']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33532'")->result();
			$a['data33533']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33533'")->result();
			$a['data33541']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33541'")->result();
			$a['data33542']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33542'")->result();
			$a['data33543']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33543'")->result();
			$a['data33551']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33551'")->result();
			$a['data33552']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33552'")->result();
			$a['data33553']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33553'")->result();
			$a['data33561']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33561'")->result();
			$a['data33562']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33562'")->result();
			$a['data33563']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33563'")->result();
			$a['page']		= "l_kegiatan_bidang";
			}
			else
			{
			$a['data33511']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33511'")->result();
			$a['data33512']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33512'")->result();
			$a['data33513']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33513'")->result();
			$a['data33514']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33514'")->result();
			$a['data33515']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33515'")->result();
			$a['data33521']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33521'")->result();
			$a['data33522']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33522'")->result();
			$a['data33523']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33523'")->result();
			$a['data33531']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33531'")->result();
			$a['data33532']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33532'")->result();
			$a['data33533']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33533'")->result();
			$a['data33541']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33541'")->result();
			$a['data33542']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33542'")->result();
			$a['data33543']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33543'")->result();
			$a['data33551']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33551'")->result();
			$a['data33552']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33552'")->result();
			$a['data33553']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33553'")->result();
			$a['data33561']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33561'")->result();
			$a['data33562']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33562'")->result();
			$a['data33563']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33563'")->result();
			$a['page']		= "l_kegiatan_bidang";
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu'  and k.target <> '0'")->result();		
			$a['page']		= "v_kegiatan_detail";
		}
		else{
			$a['data33511']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33511'")->result();
			$a['data33512']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33512'")->result();
			$a['data33513']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33513'")->result();
			$a['data33514']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33514'")->result();
			$a['data33515']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33515'")->result();
			$a['data33521']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33521'")->result();
			$a['data33522']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33522'")->result();
			$a['data33523']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33523'")->result();
			$a['data33531']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33531'")->result();
			$a['data33532']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33532'")->result();
			$a['data33533']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33533'")->result();
			$a['data33541']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33541'")->result();
			$a['data33542']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33542'")->result();
			$a['data33543']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33543'")->result();
			$a['data33551']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33551'")->result();
			$a['data33552']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33552'")->result();
			$a['data33553']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33553'")->result();
			$a['data33561']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33561'")->result();
			$a['data33562']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33562'")->result();
			$a['data33563']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='33563'")->result();
			$a['page']		= "l_kegiatan_bidang";
		}
		
		
	
		$this->load->view('admin/index', $a);
	}
	
	public function unitkerjaprov()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
	
		if ($mau_ke == "pilih_kegiatan")
		{
			if($idu == '00')
			{
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where YEAR(batas_waktu)='$tahun'  order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']			= "l_kegiatanunitkerja";	
			}
			else
			{
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun'  order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' and MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' and MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']			= "l_kegiatanunitkerja";	
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu'  and k.target <> '0'")->result();		
			$a['page']		= "v_kegiatan_unitkerja_detail";
		}
		else
		{
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']			= "l_kegiatanunitkerja";	
		}
		
		$this->load->view('admin/index', $a);
	}
	
	public function unitkerjakabkota()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id_bulan				= $this->uri->segment(4);
		$id_kabkota				= $this->uri->segment(5);
		$tahun					= $this->session->userdata('admin_ta');
	
		if ($mau_ke == "pilih_kegiatan")
		{
			if($id_bulan == '00')
			{
				if($id_kabkota == '3300')
				{
					$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
					$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
				else
				{
					$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,t.id_kab,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join t_kegiatan t on k.id_jeniskegiatan=t.id_jeniskegiatan  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and t.id_kab='$id_kabkota' and t.target <> '0' order by k.batas_waktu desc")->result();
					$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
		
			}
			else
			{
				if($id_kabkota == '3300')
				{
				$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan   where YEAR(k.batas_waktu)='$tahun' and MONTH(k.batas_waktu)='$id_bulan' order by k.batas_waktu desc")->result();
				$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
				else
				{
					$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,t.id_kab,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join t_kegiatan t on k.id_jeniskegiatan=t.id_jeniskegiatan  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and t.id_kab='$id_kabkota' and MONTH(k.batas_waktu)='$id_bulan'  and t.target <> '0' order by k.batas_waktu desc")->result();
					$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']		= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$id_bulan'")->row();	
			$a['datprogress']	= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$id_bulan' and k.target <> '0'")->result();		
			$a['page']			= "v_kegiatan_unitkerja_detail";
		}
		else
		{
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and MONTH(k.batas_waktu)='$bulanini' order by k.batas_waktu desc")->result();
			$a['page']			= "l_kegiatanunitkerjakabkota";	
		}
		
		$this->load->view('admin/index', $a);
	}
	
	public function unitkerjakabkotadetail()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id_bulan				= $this->uri->segment(4);
		//$id_kabkota				= $this->uri->segment(5);
		$tahun					= $this->session->userdata('admin_ta');
	
		if ($mau_ke == "pilih_kegiatan")
		{
			if($id_bulan == '00')
			{
				$id_kabkota 		= $this->session->userdata('admin_user');
				$a['data']			= $this->db->query("select t.id_kab,t.id_jeniskegiatan, m.nama_kegiatan,u.unitkerja, m.batas_waktu, t.target, t.realisasi, s.satuan,t.tgl_entri,t.flag_konfirm from t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on m.satuan=s.id_satuan where t.id_kab='$id_kabkota' and t.target <> '0' order by t.id_jeniskegiatan asc, m.batas_waktu asc")->result();
				$a['page']			= "l_unitkerjakabkotadetail";	
			}
			else
			{
				$id_kabkota 		= $this->session->userdata('admin_user');
				$a['data']			= $this->db->query("select t.id_kab,t.id_jeniskegiatan, m.nama_kegiatan,u.unitkerja, m.batas_waktu, t.target, t.realisasi, s.satuan,t.tgl_entri,t.flag_konfirm from t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on m.satuan=s.id_satuan where t.id_kab='$id_kabkota' and MONTH(m.batas_waktu)='$id_bulan' and t.target <> '0' order by t.id_jeniskegiatan asc, m.batas_waktu asc")->result();
				$a['page']			= "l_unitkerjakabkotadetail";	
			}
		}

		else
		{
			$hariini			= date("d-m-Y");
			$bulanini 			= substr($hariini,3,2);
			$id_kabkota 		= $this->session->userdata('admin_user');
			$a['data']			= $this->db->query("select t.id_kab,t.id_jeniskegiatan, m.nama_kegiatan,u.unitkerja, m.batas_waktu, t.target, t.realisasi, s.satuan,t.tgl_entri,t.flag_konfirm from t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on m.satuan=s.id_satuan where t.id_kab='$id_kabkota' and MONTH(m.batas_waktu)='$bulanini' and t.target <> '0' order by t.id_jeniskegiatan asc, m.batas_waktu asc")->result();
			$a['page']			= "l_unitkerjakabkotadetail";	
		}
		
		$this->load->view('admin/index', $a);
	}
	
	public function unitkerjaprovuntukkab()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
	
		if ($mau_ke == "pilih_kegiatan")
		{
			if($idu == '00')
			{
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where YEAR(batas_waktu)='$tahun'  order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']			= "l_kegiatanunitkerjauntukkab";	
			}
			else
			{
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun'  order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' and MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' and MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']			= "l_kegiatanunitkerjauntukkab";	
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu'  and k.target <> '0'")->result();		
			$a['page']		= "v_kegiatan_unitkerja_detailkab";
		}
		else
		{
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3351' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3352' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3353' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3354' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3355' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,4)='3356' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']			= "l_kegiatanunitkerjauntukkab";	
		}
		
		$this->load->view('admin/index', $a);
	}
	
	
public function entry_unitkerja() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		//$kabkota=$this->session->userdata('admin_user') ;
		$kabkota=$this->uri->segment(5);
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT k.*,(k.realisasi/k.target*100) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/entry/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$id_jeniskegiatan		= addslashes($this->input->post('id_jeniskegiatan'));
		$nama_kegiatan			= addslashes($this->input->post('nama_kegiatan'));
		$target					= addslashes($this->input->post('target'));
		$realisasi				= addslashes($this->input->post('realisasi'));
		$bukti					= addslashes($this->input->post('bukti'));
		$newrealisasi			= addslashes($this->input->post('newrealisasi'));
		$link_pengiriman		= addslashes($this->input->post('link_pengiriman'));
		$tgl_entri				= addslashes($this->input->post('tgl_entri'));
		//$tgl_entri				= date('Y-m-d');
		
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_masuk';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "edt") {
			$kabkota =$this->uri->segment(5);
			$a['datpil']	= $this->db->query("SELECT k.*,m.nama_kegiatan,w.nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab WHERE k.id_jeniskegiatan = '$idu' and k.id_kab='$kabkota'")->row();	
			$a['page']		= "f_entry_unitkerja";
		} 
		else if ($mau_ke == "act_edt")
		{
			if($newrealisasi > $target)
			{
				$kabkota					= addslashes($this->input->post('kabkota'));
				$id_kabkota 				= substr($kabkota,0,4);	
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Realisasi Tidak Boleh Melebihi Target</div>");	
				redirect('index.php/admin/entry_unitkerja/edt/'.$id_jeniskegiatan.'/'.$id_kabkota);
			}
			else
			{	
				if($this->session->userdata('admin_user') == "3300"|| $this->session->userdata('admin_user') == '3356' || $this->session->userdata('admin_user') == '3355' || $this->session->userdata('admin_user') == '3354' || $this->session->userdata('admin_user') == '3353' || $this->session->userdata('admin_user') == '3352' || $this->session->userdata('admin_user') == '3351')
						{
						$kabkota			= addslashes($this->input->post('kabkota'));
						$id_kabkota 				= substr($kabkota,0,4);
						
						//$queryrealisasisekarang 	= mysql_query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' ");
						//$datarealisasisekarang 		= mysql_fetch_array($queryrealisasisekarang);
						
						$datarealisasisekarang 	= $this->db->query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'")->row();
						
						//$queryrealisasikabsekarang 	= mysql_query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ");
						//$datarealisasikabsekarang 	= mysql_fetch_array($queryrealisasikabsekarang);
						$queryrealisasikabsekarang 	= $this->db->query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ")->row();
						$realisasikabsekarang		= $queryrealisasikabsekarang->realisasi;
						
						
						$targetprov		 			= $datarealisasisekarang->target;
						$realisasisekarang 			= $datarealisasisekarang->realisasi;
						$realisasiterbaru 			= $datarealisasisekarang->realisasi - $realisasikabsekarang + $newrealisasi ;
						$persen_realisasi			= $newrealisasi/$target*100;
						
						$query_batas_waktu			= $this->db->query("select batas_waktu from m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();
						$batas_waktu				= new DateTime($query_batas_waktu->batas_waktu);
						
						$tglentriconvert			=new DateTime($tgl_entri);
						$newformatbatas_waktu		=date_format($batas_waktu,"d-m-Y");
						$newformattgl_entri			=date_format($tglentriconvert,"d-m-Y");
							
						$datetime1 					= new DateTime($newformattgl_entri);
						$datetime2 					= new DateTime($newformatbatas_waktu);
						
						$difference 				= $datetime1->diff($datetime2);
						$selisih_pengiriman 	= $difference->d ;
						//$selisih_pengiriman			= $selisih_pengirimanhitung + 1;
						
						if($persen_realisasi >= '95' && $persen_realisasi <= '100')
						{
							$nilai_volume = '4';
						}
						else if($persen_realisasi >= '80' && $persen_realisasi <= '94')
						{
							$nilai_volume = '3';
						}
						else if($persen_realisasi >= '60' && $persen_realisasi <= '79')
						{
							$nilai_volume = '2';
						}		
						else 
						{
							$nilai_volume = '1';
						}
						
						if($selisih_pengiriman >= '2' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="4";
						}
						else if($selisih_pengiriman == '1' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="3";
						}
						else if($selisih_pengiriman == '0' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="2";
						}
						else
						{
							$nilai_deadline ="1";
						}
						$nilai_total 				= 0.7 * $nilai_volume + 0.3 * $nilai_deadline ;
						
						$this->db->query("UPDATE t_kegiatan SET realisasi = '$newrealisasi', tgl_entri = '$tgl_entri', flag_konfirm='1', bukti='$bukti', persen_realisasi='$persen_realisasi', link_pengiriman='$link_pengiriman', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline', nilai_total='$nilai_total' WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota'");
						if($realisasiterbaru <= $targetprov)
						{
						$querykumulatifrealisasi=$this->db->query("select sum(realisasi) as jumlah_realisasi from t_kegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();	
						$kumulatifrealisasi=$querykumulatifrealisasi->jumlah_realisasi;
						
						$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$kumulatifrealisasi' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
						
						//$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$realisasiterbaru' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
						}
										
						$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
						
						//redirect('index.php/admin/entry_unitkerja/edt/'.$id_jeniskegiatan.'/'.$id_kabkota);
						//redirect('index.php/admin/unitkerjakabkota/');
						redirect('index.php/admin/unitkerjaprov/view/'.$id_jeniskegiatan);
						}
				else
						{
						$kabkota					= addslashes($this->input->post('kabkota'));
						$id_kabkota 				= substr($kabkota,0,4);	
							
						/*$queryrealisasisekarang 	= mysql_query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' ");
						$datarealisasisekarang 		= mysql_fetch_array($queryrealisasisekarang);
						
						$queryrealisasikabsekarang 	= mysql_query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ");
						$datarealisasikabsekarang 	= mysql_fetch_array($queryrealisasikabsekarang);
						$realisasikabsekarang		= $datarealisasikabsekarang['realisasi'];
						
						
						$targetprov		 			= $datarealisasisekarang['target'];
						$realisasisekarang 			= $datarealisasisekarang['realisasi'];
						$realisasiterbaru 			= $datarealisasisekarang['realisasi'] - $realisasikabsekarang + $newrealisasi ;
						$persen_realisasi			= $newrealisasi/$target*100;*/
						
						$datarealisasisekarang 	= $this->db->query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'")->row();
						$queryrealisasikabsekarang 	= $this->db->query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ")->row();
						$realisasikabsekarang		= $queryrealisasikabsekarang->realisasi;
						
						
						$targetprov		 			= $datarealisasisekarang->target;
						$realisasisekarang 			= $datarealisasisekarang->realisasi;
						$realisasiterbaru 			= $datarealisasisekarang->realisasi - $realisasikabsekarang + $newrealisasi ;
						$persen_realisasi			= $newrealisasi/$target*100;
						
						$query_batas_waktu			= $this->db->query("select batas_waktu from m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();
						$batas_waktu				= new DateTime($query_batas_waktu->batas_waktu);
						
						$tglentriconvert			=new DateTime($tgl_entri);
						$newformatbatas_waktu		=date_format($batas_waktu,"d-m-Y");
						$newformattgl_entri			=date_format($tglentriconvert,"d-m-Y");
							
						$datetime1 					= new DateTime($newformattgl_entri);
						$datetime2 					= new DateTime($newformatbatas_waktu);
						$difference 				= $datetime2->diff($datetime1);
						$selisih_pengiriman		 	= $difference->d ;
						//$selisih_pengiriman			= $selisih_pengirimanhitung + 1;
						
						if($persen_realisasi >= '95' && $persen_realisasi <= '100')
						{
							$nilai_volume = '4';
						}
						else if($persen_realisasi >= '80' && $persen_realisasi <= '94')
						{
							$nilai_volume = '3';
						}
						else if($persen_realisasi >= '60' && $persen_realisasi <= '79')
						{
							$nilai_volume = '2';
						}		
						else 
						{
							$nilai_volume = '1';
						}
						
						if($selisih_pengiriman >= '2' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="4";
						}
						else if($selisih_pengiriman == '1' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="3";
						}
						else if($selisih_pengiriman == '0' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="2";
						}
						else
						{
							$nilai_deadline ="1";
						}
						
						$nilai_total 				= 0.7 * $nilai_volume + 0.3 * $nilai_deadline ;

						$this->db->query("UPDATE t_kegiatan SET realisasi = '$newrealisasi', tgl_entri = '$tgl_entri', flag_konfirm='2', bukti='$bukti', persen_realisasi='$persen_realisasi', link_pengiriman='$link_pengiriman', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline', nilai_total='$nilai_total' WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota'");
						if($realisasiterbaru <= $targetprov)
						{
						$querykumulatifrealisasi=$this->db->query("select sum(realisasi) as jumlah_realisasi from t_kegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();	
						$kumulatifrealisasi=$querykumulatifrealisasi->jumlah_realisasi;
						
						$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$kumulatifrealisasi' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
						}
						$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
						
						//redirect('index.php/admin/entry_unitkerja/edt/'.$id_jeniskegiatan.'/'.$id_kabkota);
						redirect('index.php/admin/unitkerjaprov/view/'.$id_jeniskegiatan);
						}
			}
		} 
		
		$this->load->view('admin/index', $a);
	}
	
	
	public function entry_unitkerjakab() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		//$kabkota=$this->session->userdata('admin_user') ;
		$kabkota=$this->uri->segment(5);
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT k.*,(k.realisasi/k.target*100) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/entry/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
		$id_jeniskegiatan		= addslashes($this->input->post('id_jeniskegiatan'));
		$nama_kegiatan			= addslashes($this->input->post('nama_kegiatan'));
		$target					= addslashes($this->input->post('target'));
		$realisasi				= addslashes($this->input->post('realisasi'));
		$bukti					= addslashes($this->input->post('bukti'));
		$newrealisasi			= addslashes($this->input->post('newrealisasi'));
		$link_pengiriman		= addslashes($this->input->post('link_pengiriman'));
		$tgl_entri				= addslashes($this->input->post('tgl_entri'));
		//$tgl_entri				= date('Y-m-d');
		
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload/surat_masuk';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "edt") {
			$kabkota =$this->uri->segment(5);
			$a['datpil']	= $this->db->query("SELECT k.*,m.nama_kegiatan,w.nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab WHERE k.id_jeniskegiatan = '$idu' and k.id_kab='$kabkota'")->row();	
			$a['page']		= "f_entry_unitkerjakab";
		} 
		else if ($mau_ke == "act_edt")
		{
			if($newrealisasi > $target)
			{
				$kabkota					= addslashes($this->input->post('kabkota'));
				$id_kabkota 				= substr($kabkota,0,4);	
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Realisasi Tidak Boleh Melebihi Target</div>");	
				redirect('index.php/admin/entry_unitkerjakab/edt/'.$id_jeniskegiatan.'/'.$id_kabkota);
			}
			else
			{	
				if($this->session->userdata('admin_user') == "3300"|| $this->session->userdata('admin_user') == '3356' || $this->session->userdata('admin_user') == '3355' || $this->session->userdata('admin_user') == '3354' || $this->session->userdata('admin_user') == '3353' || $this->session->userdata('admin_user') == '3352' || $this->session->userdata('admin_user') == '3351')
						{
						$kabkota			= addslashes($this->input->post('kabkota'));
						$id_kabkota 				= substr($kabkota,0,4);
						
						//$queryrealisasisekarang 	= mysql_query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' ");
						//$datarealisasisekarang 		= mysql_fetch_array($queryrealisasisekarang);
						
						$datarealisasisekarang 	= $this->db->query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'")->row();
						
						//$queryrealisasikabsekarang 	= mysql_query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ");
						//$datarealisasikabsekarang 	= mysql_fetch_array($queryrealisasikabsekarang);
						$queryrealisasikabsekarang 	= $this->db->query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ")->row();
						$realisasikabsekarang		= $queryrealisasikabsekarang->realisasi;
						
						
						$targetprov		 			= $datarealisasisekarang->target;
						$realisasisekarang 			= $datarealisasisekarang->realisasi;
						$realisasiterbaru 			= $datarealisasisekarang->realisasi - $realisasikabsekarang + $newrealisasi ;
						$persen_realisasi			= $newrealisasi/$target*100;
						
						$query_batas_waktu			= $this->db->query("select batas_waktu from m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();
						$batas_waktu				= new DateTime($query_batas_waktu->batas_waktu);
						
						$tglentriconvert			=new DateTime($tgl_entri);
						$newformatbatas_waktu		=date_format($batas_waktu,"d-m-Y");
						$newformattgl_entri			=date_format($tglentriconvert,"d-m-Y");
							
						$datetime1 					= new DateTime($newformattgl_entri);
						$datetime2 					= new DateTime($newformatbatas_waktu);
						
						$difference 				= $datetime1->diff($datetime2);
						$selisih_pengiriman 	= $difference->d ;
						//$selisih_pengiriman			= $selisih_pengirimanhitung + 1;
						
						if($persen_realisasi >= '95' && $persen_realisasi <= '100')
						{
							$nilai_volume = '4';
						}
						else if($persen_realisasi >= '80' && $persen_realisasi <= '94')
						{
							$nilai_volume = '3';
						}
						else if($persen_realisasi >= '60' && $persen_realisasi <= '79')
						{
							$nilai_volume = '2';
						}		
						else 
						{
							$nilai_volume = '1';
						}
						
						if($selisih_pengiriman >= '2' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="4";
						}
						else if($selisih_pengiriman == '1' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="3";
						}
						else if($selisih_pengiriman == '0' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="2";
						}
						else
						{
							$nilai_deadline ="1";
						}
						$nilai_total 				= 0.7 * $nilai_volume + 0.3 * $nilai_deadline ;
						
						$this->db->query("UPDATE t_kegiatan SET realisasi = '$newrealisasi', tgl_entri = '$tgl_entri', flag_konfirm='1', bukti='$bukti', persen_realisasi='$persen_realisasi', link_pengiriman='$link_pengiriman', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline', nilai_total='$nilai_total' WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota'");
						if($realisasiterbaru <= $targetprov)
						{
						$querykumulatifrealisasi=$this->db->query("select sum(realisasi) as jumlah_realisasi from t_kegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();	
						$kumulatifrealisasi=$querykumulatifrealisasi->jumlah_realisasi;
						
						$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$kumulatifrealisasi' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
						
						//$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$realisasiterbaru' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
						}
										
						$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
						
						//redirect('index.php/admin/entry_unitkerja/edt/'.$id_jeniskegiatan.'/'.$id_kabkota);
						redirect('index.php/admin/unitkerjakabkotadetail/');
						//redirect('index.php/admin/unitkerjaprov/view/'.$id_jeniskegiatan);
						}
				else
						{
						$kabkota					= addslashes($this->input->post('kabkota'));
						$id_kabkota 				= substr($kabkota,0,4);	
							
						/*$queryrealisasisekarang 	= mysql_query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' ");
						$datarealisasisekarang 		= mysql_fetch_array($queryrealisasisekarang);
						
						$queryrealisasikabsekarang 	= mysql_query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ");
						$datarealisasikabsekarang 	= mysql_fetch_array($queryrealisasikabsekarang);
						$realisasikabsekarang		= $datarealisasikabsekarang['realisasi'];
						
						
						$targetprov		 			= $datarealisasisekarang['target'];
						$realisasisekarang 			= $datarealisasisekarang['realisasi'];
						$realisasiterbaru 			= $datarealisasisekarang['realisasi'] - $realisasikabsekarang + $newrealisasi ;
						$persen_realisasi			= $newrealisasi/$target*100;*/
						
						$datarealisasisekarang 	= $this->db->query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'")->row();
						$queryrealisasikabsekarang 	= $this->db->query("select realisasi from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' ")->row();
						$realisasikabsekarang		= $queryrealisasikabsekarang->realisasi;
						
						
						$targetprov		 			= $datarealisasisekarang->target;
						$realisasisekarang 			= $datarealisasisekarang->realisasi;
						$realisasiterbaru 			= $datarealisasisekarang->realisasi - $realisasikabsekarang + $newrealisasi ;
						$persen_realisasi			= $newrealisasi/$target*100;
						
						$query_batas_waktu			= $this->db->query("select batas_waktu from m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();
						$batas_waktu				= new DateTime($query_batas_waktu->batas_waktu);
						
						$tglentriconvert			=new DateTime($tgl_entri);
						$newformatbatas_waktu		=date_format($batas_waktu,"d-m-Y");
						$newformattgl_entri			=date_format($tglentriconvert,"d-m-Y");
							
						$datetime1 					= new DateTime($newformattgl_entri);
						$datetime2 					= new DateTime($newformatbatas_waktu);
						$difference 				= $datetime2->diff($datetime1);
						$selisih_pengiriman		 	= $difference->d ;
						//$selisih_pengiriman			= $selisih_pengirimanhitung + 1;
						
						if($persen_realisasi >= '95' && $persen_realisasi <= '100')
						{
							$nilai_volume = '4';
						}
						else if($persen_realisasi >= '80' && $persen_realisasi <= '94')
						{
							$nilai_volume = '3';
						}
						else if($persen_realisasi >= '60' && $persen_realisasi <= '79')
						{
							$nilai_volume = '2';
						}		
						else 
						{
							$nilai_volume = '1';
						}
						
						if($selisih_pengiriman >= '2' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="4";
						}
						else if($selisih_pengiriman == '1' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="3";
						}
						else if($selisih_pengiriman == '0' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="2";
						}
						else
						{
							$nilai_deadline ="1";
						}
						
						$nilai_total 				= 0.7 * $nilai_volume + 0.3 * $nilai_deadline ;

						$this->db->query("UPDATE t_kegiatan SET realisasi = '$newrealisasi', tgl_entri = '$tgl_entri', flag_konfirm='2', bukti='$bukti', persen_realisasi='$persen_realisasi', link_pengiriman='$link_pengiriman', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline', nilai_total='$nilai_total' WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota'");
						if($realisasiterbaru <= $targetprov)
						{
						$querykumulatifrealisasi=$this->db->query("select sum(realisasi) as jumlah_realisasi from t_kegiatan where id_jeniskegiatan='$id_jeniskegiatan'")->row();	
						$kumulatifrealisasi=$querykumulatifrealisasi->jumlah_realisasi;
						
						$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$kumulatifrealisasi' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
						}
						$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated. ".$this->upload->display_errors()."</div>");			
						
						//redirect('index.php/admin/entry_unitkerja/edt/'.$id_jeniskegiatan.'/'.$id_kabkota);
						//redirect('index.php/admin/unitkerjaprov/view/'.$id_jeniskegiatan);
						redirect('index.php/admin/unitkerjakabkotadetail/');
						}
			}
		} 
		
		$this->load->view('admin/index', $a);
	}
	
	
	
	public function laporan_kab()
	{
		//variabel untuk select dropdown
		$kab = $this->input->get('pilih_kab');
		$bulan = $this->input->get('bln');
		$tahun = $this->input->get('Tahun');
		
		//tes highchart
		$a['report'] = $this->M_kelolakegiatan->report($kab, $bulan, $tahun);
		//$this->load->view('dashboard', $a);

		//$this->load->model('M_kelolakegiatan');
		$hasil = $this->M_kelolakegiatan->cobaLaporan($kab, $bulan, $tahun);
		$a['hasil'] = $hasil;
		$a['page']	= "laporan_kab";
		$a['kab'] = $kab;
		$a['bulan'] = $bulan;
		$a['tahun'] = $tahun;
		
		$this->load->view('admin/index', $a);

		$this->input->get();
		
	}

	public function laporan_prov()
	{
		//variabel untuk select dropdown
		$kab = $this->input->get('pilih_kab');
		$bulan = $this->input->get('bln');
		$tahun = $this->input->get('Tahun');
		
		//tes highchart
		$a['report'] = $this->M_kelolakegiatan->reportProv($kab, $bulan, $tahun);
		//$this->load->view('dashboard', $a);

		//$this->load->model('M_kelolakegiatan');
		$hasil = $this->M_kelolakegiatan->cobaLaporanProv($kab, $bulan, $tahun);
		$a['hasil'] = $hasil;
		$a['page']	= "laporan_prov";
		$a['kab'] = $kab;
		$a['bulan'] = $bulan;
		$a['tahun'] = $tahun;
		
		$this->load->view('admin/index', $a);

		$this->input->get();
		
	}
	
	public function kegiatankabkota()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
	
		if ($mau_ke == "pilih_kegiatan")
		{
			if($idu == '00')
			{
				if($this->session->userdata('admin_user') != '3300')
				{	
				$bidangku = $this->session->userdata('admin_user');
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan where YEAR(k.batas_waktu)='$tahun'  and substring(u.id_unitkerja,1,4) = '$bidangku' order by k.batas_waktu desc")->result();
				}
				else
				{
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan where YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
				}
				$a['page']		= "l_kegiatankabkota";	
			}
			else
			{
				if($this->session->userdata('admin_user') != '3300')
				{	
				$bidangku = $this->session->userdata('admin_user');
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(u.id_unitkerja,1,4) = '$bidangku' order by k.batas_waktu desc")->result();
				}
				else
				{
				$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
				}
				$a['page']		= "l_kegiatankabkota";	
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu'  and k.target <> '0'")->result();	
			$a['page']		= "v_kegiatan_detail";
		}
		else
		{
			if($this->session->userdata('admin_user') != '3300')
			{
			$bidangku = $this->session->userdata('admin_user');
			$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(u.id_unitkerja,1,4) = '$bidangku' order by k.batas_waktu desc")->result();
			}
			else
			{
			$a['data']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
			}
			$a['page']		= "l_kegiatankabkota";	
		}
		
		$this->load->view('admin/index', $a);
	}
}
