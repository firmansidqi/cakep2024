<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('M_kelolakegiatan');
		$this->load->model('M_getfunction');
		$this->load->library('encryption'); //in controllerfun
		$this->load->helper('my_helper');
	}
	
	public function index() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		//ambil variabel URL
		$nip    				= $this->session->userdata('admin_nip');
		
		//variabel untuk select dropdown
		$kab = $this->input->get('pilih_kab');
		$bulan = $this->input->get('bln');
		$tahun = $this->input->get('Tahun');
		
		//tes highchart
		$a['report']                = $this->M_kelolakegiatan->reportDashboard();
		$a['report2']               = $this->M_kelolakegiatan->cobaJumlahKegiatanPerbidang();
		$a['report3']               = $this->M_kelolakegiatan->cobaJumlahKegiatanPerbulan();
		$a['report4']               = $this->M_kelolakegiatan->cobaReportKegiatanPerbidang();
		$a['report5']               = $this->M_kelolakegiatan->cobaJumlahKegiatanPerkabkot();
		$a['target']                = $this->M_kelolakegiatan->gettargetkabkota();
		$a['realisasi']             = $this->M_kelolakegiatan->getrealisasikabkota();
		$a['targetkumulatif']       = $this->M_kelolakegiatan->gettargetkabkotakumulatif();
		$a['realisasikumulatif']    = $this->M_kelolakegiatan->getrealisasikabkotakumulatif();
		//$this->load->view('dashboard', $a);

		//$this->load->model('M_kelolakegiatan');
		$hasil                  = $this->M_kelolakegiatan->cobaLaporanDashboard();
		$hasil2                 = $this->M_kelolakegiatan->jumlahKegiatanPerbidang();
		$hasil3                 = $this->M_kelolakegiatan->jumlahKegiatanPerbulan();
		$hasil4                 = $this->M_kelolakegiatan->ReportKegiatanPerbidang();
		$hasil5                 = $this->M_kelolakegiatan->jumlahKegiatanPerkabkot();
		
		$a['hasil']             = $hasil;
		$a['hasil2']            = $hasil2;
		$a['hasil3']            = $hasil3;
		$a['hasil4']            = $hasil4;
		$a['hasil5']            = $hasil5;
		$a['page']	            = "dashboard_komplit";
		$a['kab']               = $kab;
		$a['bulan']             = $bulan;
		$a['tahun']             = $tahun;
		
		$a['notif']	= $this->db->query("SELECT COUNT(id) as sum FROM t_notifikasi WHERE tujuan = '$nip'")->row();
		
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
		$kepala					= addslashes($this->input->post('kepsek'));
		$nip_kepala				= addslashes($this->input->post('nip_kepsek'));
		
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
				
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepala	 = '$kepala', nip_kepala = '$nip_kepala', logo = '".$up_data['file_name']."' WHERE id = '$idp'");

			} else {
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', kepala	 = '$kepala', nip_kepala = '$nip_kepala' WHERE id = '$idp'");
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
		if($this->session->userdata('admin_valid'))
			redirect('index.php/admin');

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
				'admin_valid' => true,
				'admin_nip' => $d_cek->nip
			);
			$this->session->set_userdata($data);
			$username = $this->session->userdata('admin_user');
			date_default_timezone_set("Asia/Bangkok");
			$logindate = date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO evita_userlog VALUES (NULL,'$username','login','$logindate','')");
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

	public function kegiatan()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
		$idkab                  = $this->uri->segment(5);
		
		if ($mau_ke == "pilih_kegiatan")
		{
			/* == Menampilkan Halaman Kegiatan Berdasarkan Pilihan Bulan == */
			$bulanlalu          = $idu-1;
			$nfriday            = getMinggu($idu)[0];
			$firstfriday        = getMinggu($idu)[1][0];
			$lastfriday         = getMinggu($idu)[1][$nfriday-1];
			$nfridaylmonth      = getMinggu($bulanlalu)[0];
			$lfridaylmonth      = getMinggu($bulanlalu)[1][$nfridaylmonth-1];
			if($idu == '00')
			{
				$a['datatim']       = $this->db->query("SELECT * FROM m_tim ORDER BY id_tim ASC")->result();
			    $a['data']          = $this->db->query("SELECT jnsk.*, s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, k.* FROM m_jeniskegiatan jnsk LEFT JOIN m_satuan s ON jnsk.satuan = s.id_satuan LEFT JOIN m_listkegiatan subk on jnsk.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE YEAR(jnsk.batas_waktu)='$tahun' ORDER BY jnsk.batas_waktu asc")->result();
				$a['page']		= "l_kegiatan";	
			}
			else
			{
				$a['datatim']       = $this->db->query("SELECT * FROM m_tim ORDER BY id_tim ASC")->result();
			    $a['data']          = $this->db->query("SELECT jnsk.*, s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, k.* FROM m_jeniskegiatan jnsk LEFT JOIN m_satuan s ON jnsk.satuan = s.id_satuan LEFT JOIN m_listkegiatan subk on jnsk.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE ((MONTH(jnsk.mulai)<='$idu' AND jnsk.batas_waktu>='$lfridaylmonth') OR (MONTH(jnsk.mulai)>'$idu' AND jnsk.mulai<='$lastfriday')) and YEAR(jnsk.batas_waktu)='$tahun' ORDER BY jnsk.batas_waktu asc")->result();
				$a['page']		= "l_kegiatan";	
			}
			/* == Menampilkan Menampilkan Halaman Kegiatan Berdasarkan Pilihan Bulan == */
		}
		else if($mau_ke == "view")
		{
			/* == Menampilkan Halaman Detail Kegiatan == */
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan left join m_listkegiatan subk on m.nama_kegiatan=subk.id where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' ORDER BY k.batas_minggu")->result();	
			$a['wilayah']   = $this->db->query("SELECT * FROM m_kab")->result();	
			$a['page']		= "v_kegiatan_detail";
			/* == Akhir Menampilkan Halaman Detail Kegiatan == */
		}
		else if ($mau_ke == "pilih_wilayah")
		{
			/* == Menampilkan Halaman Kegiatan Berdasarkan Pilihan Bulan == */
			if($idu == '6500')
			{
				$a['datatim']       = $this->db->query("SELECT * FROM m_tim ORDER BY id_tim ASC")->result();
			    $a['data']          = $this->db->query("SELECT jnsk.*, s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, k.* FROM m_jeniskegiatan jnsk LEFT JOIN m_satuan s ON jnsk.satuan = s.id_satuan LEFT JOIN m_listkegiatan subk on jnsk.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE (MONTH(jnsk.mulai)<='$idu' AND MONTH(jnsk.batas_waktu)>='$idu' ) and YEAR(jnsk.batas_waktu)='$tahun' ORDER BY jnsk.batas_waktu asc")->result();
				$a['page']		= "l_kegiatan";	
			}
			else
			{
				$a['datatim']       = $this->db->query("SELECT * FROM m_tim ORDER BY id_tim ASC")->result();
			    $a['data']          = $this->db->query("SELECT t.id_jeniskegiatan, SUM(t.target) as target, SUM(t.realisasi) as realisasi, subk.nama_kegiatan as nmkegiatan, s.satuan as nama_satuan, m.mulai, m.batas_waktu FROM t_kegiatan t LEFT JOIN m_listkegiatan subk ON SUBSTRING(t.id_jeniskegiatan,5,4)=subk.id LEFT JOIN m_jeniskegiatan m ON t.id_jeniskegiatan=m.id_jeniskegiatan LEFT JOIN m_satuan s ON m.satuan=s.id_satuan WHERE (MONTH(m.mulai)<='$idu' AND MONTH(m.batas_waktu)>='$idu' ) AND YEAR(m.batas_waktu)='$tahun' AND t.id_kab=6501 GROUP BY id_jeniskegiatan ORDER BY m.batas_waktu ASC")->result();
				$a['page']		= "l_kegiatan";	
			}
			/* == Menampilkan Menampilkan Halaman Kegiatan Berdasarkan Pilihan Bulan == */
		}
		else
		{
			/* == Menampilkan Halaman Kegiatan Default == */
			$hariini            = date("d-m-Y");
			$bulanini           = substr($hariini,3,2);
			$bulanlalu          = $bulanini-1;
			$nfriday            = getMinggu($bulanini)[0];
			$firstfriday        = getMinggu($bulanini)[1][0];
			$lastfriday         = getMinggu($bulanini)[1][$nfriday-1];
			$nfridaylmonth      = getMinggu($bulanlalu)[0];
			$lfridaylmonth      = getMinggu($bulanlalu)[1][$nfridaylmonth-1];
			$a['datatim']       = $this->db->query("SELECT * FROM m_tim ORDER BY id_tim ASC")->result();
			$a['data']          = $this->db->query("SELECT jnsk.*, s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, k.* FROM m_jeniskegiatan jnsk LEFT JOIN m_satuan s ON jnsk.satuan = s.id_satuan LEFT JOIN m_listkegiatan subk on jnsk.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE ((MONTH(jnsk.mulai)<='$bulanini' AND jnsk.batas_waktu>'$lfridaylmonth') OR (MONTH(jnsk.mulai)>'$bulanini' AND jnsk.mulai<='$lastfriday')) and YEAR(jnsk.batas_waktu)='$tahun' ORDER BY jnsk.batas_waktu asc")->result();
			$a['page']          = "l_kegiatan";
			$a['ffri']          = $firstfriday;
			$a['lfri']          = $lastfriday;
			/* == Akhir Menampilkan Halaman Kegiatan Default == */
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
		$tahun					= addslashes($this->input->post('tahun'));
		$kegiatan               = addslashes($this->input->post('kegiatan'));
		$subkegiatan			= addslashes($this->input->post('subkegiatan'));
		$tab					= addslashes($this->input->post('tab'));
		$satuan					= addslashes($this->input->post('satuan'));
		$ketua_tim_prov         = addslashes($this->input->post('ketua_tim_prov'));
		$mulai  				= addslashes($this->input->post('mulai'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$dasar_surat			= addslashes($this->input->post('dasar_surat'));
		$_6501 					= $this->input->post('_6501');
		$_6502 					= $this->input->post('_6502');
		$_6503					= $this->input->post('_6503');
		$_6504					= $this->input->post('_6504');
		$_6571					= $this->input->post('_6571');

		
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
			$a['datpil']	= $this->db->query("select m.*, subk.nama_kegiatan as nmkegiatan from m_jeniskegiatan as m LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id where m.id_jeniskegiatan='$id_delete'")->row();	
			$a['page']		= "f_del";
			
		}
		else if ($mau_ke == "act_del") {
			$id_jeniskegiatan = addslashes($this->input->post('id_jeniskegiatan'));
			$tab = addslashes($this->input->post('tab'));
			$this->db->query("DELETE FROM m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
			$this->db->query("DELETE FROM t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
			$this->db->query("DELETE FROM m_ubahtarget WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
			$this->db->query("DELETE FROM t_notifikasi WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
			$this->db->query("DELETE FROM t_ubahtarget WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil dihapus </div>");
			redirect('index.php/admin/kegiatan/');
		} else if ($mau_ke == "cari") {
			if($this->session->userdata('admin_user') == "6500")
			{
				$a['dataall']		= $this->db->query("SELECT *,round((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where m.nama_kegiatan  LIKE '%$cari%' ")->result();
				$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' and nama_kegiatan like '%$cari%'")->result();
				$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' and nama_kegiatan like '%$cari%' ")->result();
				$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' and nama_kegiatan like '%$cari%'")->result();
				$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' and nama_kegiatan like '%$cari%'")->result();
				$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' and nama_kegiatan like '%$cari%'")->result();
				$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' and nama_kegiatan like '%$cari%'")->result();
				$a['page']		= "l_kelolakegiatan";
			}
			else
			{
				$kabkota=$this->session->userdata('admin_user') ;
				$a['dataall']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota' and m.nama_kegiatan like '%$cari%' ")->result();
				$a['datatu']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='921' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['datasos']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='922' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['dataprod']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='923' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['datadist']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where substring(k.id_jeniskegiatan,1,3)='924' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['datanerwil']	= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='925' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['dataipds']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='926' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['page']		= "l_kelolakegiatan";
			}
			$a['page']		= "l_kelolakegiatan";
		}
		else if ($mau_ke == "add")
		{
			/* == Menampilkan Halaman Formulir Tambah Kegiatan == */
			$tab			= $this->uri->segment(4);
			$a['page']		= "f_tambahkegiatan";
			/* == Akhir Menampilkan Halaman Formulir Tambah Kegiatan == */
			
		}
		else if ($mau_ke == "edt")
		{
			/* == Menampilkan Halaman Formulir Edit Kegiatan == */
			$tab			= $this->uri->segment(5);
			$a['datpil']	= $this->db->query("SELECT k.*,m.nama_kegiatan,m.satuan,m.batas_waktu,m.ketua_tim, m.mulai, m.dasar_surat, w.nama_kab,m.target as targetprop, m.realisasi as realisasiprop,m.batas_waktu as batas_waktu FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab WHERE k.id_jeniskegiatan = '$idu' ORDER BY k.batas_minggu ASC")->row();	
			$a['page']		= "f_kelolakegiatan";
			/* == Akhir Menampilkan Halaman Formulir Edit Kegiatan == */
		}
		else if ($mau_ke == "act_add")
		{
			
			/* == Menambahkan ke Target Kegiatan Baru == */
			$id_jeniskegiatan = $tahun.''.$subkegiatan;
			
			$targetkabkumulatif=0; 
			$wilayah=$this->db->query("select * from m_kab")->result();
			
			$bataswaktuplussatu = new DateTime($batas_waktu);
			date_modify($bataswaktuplussatu, '+1 day');
			$bataslewat = date_format($bataswaktuplussatu, 'Y-m-d');
			
			foreach ($wilayah as $row)
			{
				$kode_kab   = $row->id_kab;
				
				/* == Menambahkan ke Tabel Kegiatan == */
				$data_kab   = $this->input->post('_'.$kode_kab);
				$friday[0]  = date("Y-m-d", strtotime("this Friday".$mulai));
				$m_ke       =  1;
				for($i = 0; $i < count($data_kab); $i++)
				{
					$this->db->query("INSERT INTO t_kegiatan VALUES (NULL,'$id_jeniskegiatan', '$kode_kab', '$m_ke','','$data_kab[$i]','$friday[$i]','0','$bataslewat','1','-','0','-','-','-1','0','0','','','0','',FALSE)");
					$friday[$i+1] = date("Y-m-d", strtotime('next friday'.$friday[$i]));
					$m_ke++;
					$targetkabkumulatif += $data_kab[$i];
				};
				/* == Akhir Menambahkan ke Tabel Kegiatan == */
				
				/* == Menambahkan ke Tabel Notifikasi == */
				$query              = $this->db->query("select max(convert((id),SIGNED INTEGER)) as  maxID from t_kegiatan ")->row();
				$id                 = $query->maxID;
				$noUrut             = (int)$id;
				$asal               = $this->db->query("SELECT id_tim FROM m_kegiatan WHERE id_kegiatan = '$kegiatan'")->row();
				$created_on         = date('Y-m-d H:i:s');
				$this->db->query("INSERT INTO t_notifikasi VALUES ('','$asal->id_tim', '4', '$kode_kab','$noUrut','$id_jeniskegiatan' ,'1','$created_on')");
				/* == Akhir Menambahkan ke Tabel Notifikasi == */
				
			}
			
			/* == Menambahkan ke Tabel Jenis Kegiatan == */
			$this->db->query("INSERT INTO m_jeniskegiatan VALUES (NULL,'$id_jeniskegiatan', '$subkegiatan', '$ketua_tim_prov', $targetkabkumulatif, 0, '$satuan', '$mulai', '$batas_waktu','$dasar_surat')");
			/* == Akhir Menambahkan ke Tabel Jenis Kegiatan == */
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			redirect('index.php/admin/kegiatan/view/'.$id_jeniskegiatan.'/');
			/* == Akhir Menambahkan ke Target Kegiatan Baru == */
			
		} 
		else if ($mau_ke == "act_edt")
		{
		    
		    /* == Memperbaharui Target Kegiatan == */
			$id_jeniskegiatan       = $this->uri->segment(4);
			$targetkumnew           = 0; 
			$wilayah                = $this->db->query("select * from m_kab")->result();
			$id_jeniskegiatannew    = $tahun.''.$subkegiatan;
			
			$fday                   = date("d-m-Y", strtotime($mulai));
			$lday                   = date("d-m-Y", strtotime($batas_waktu));
			$ffriday                = date("d-m-Y", strtotime("this Friday".$fday));
			$lfriday                = date("d-m-Y", strtotime("this Friday".$lday));
			$sfriday                = floor((strtotime($lfriday)-strtotime($ffriday)) / (60 * 60 * 24));
			$jfriday                = $sfriday / 7 + 1;
			$friday[0]              = date("Y-m-d", strtotime($ffriday));
			for($i = 1; $i < $jfriday; $i++){
				$friday[$i] = date("Y-m-d", strtotime('next friday'.$friday[$i-1]));
			}
			
			foreach ($wilayah as $row)
			{
				$kode_kab           = $row->id_kab;
				
				/* == Memperbaharui Tabal Kegiatan == */
				$data_baru          = $this->input->post('_'.$kode_kab);
				$data               = $this->db->query("select realisasi, tgl_entri, flag_konfirm, nilai_total from t_kegiatan  where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' ORDER BY batas_minggu")->result();
				$bataswaktuplussatu = new DateTime($batas_waktu);
				date_modify($bataswaktuplussatu, '+1 day');
				$bataslewat         = date_format($bataswaktuplussatu, 'Y-m-d');
				$minggu             = 1;
				$realkum            = 0;
				$target_newKum      = 0;
				
				if(count($data) > count($data_baru))
				{
					for($i = count($data_baru); $i < count($data); $i++){
						$this->db->query("DELETE FROM t_kegiatan WHERE id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' and minggu_ke='$i+1'");
						$this->db->query("DELETE FROM t_ubahtarget WHERE id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' and minggu_ke='$i+1'");
					}  
				};
				
				for($i = 0; $i < count($data_baru); $i++)
				{
					$flag                  = $data[$i]->flag_konfirm;
                    if($i < count($data)){
                        if ($flag != 1){
                            $realkum                    = $realkum + $data[$i]->realisasi;
                            $tgl_entri_sekarang         = $data[$i]->tgl_entri;
                            $target_newKum              = $target_newKum + $data_baru[$i];
                            
                            $batas_waktu_new            = new DateTime($friday[$i]);
                            if($i == (count($data_baru)-1)){
                                $batas_waktu_new        = new DateTime($lday);
                            }else{
                                $batas_waktu_new        = new DateTime($friday[$i]);
                            }
                            
                            $tglentriconvert            = new DateTime($tgl_entri_sekarang);
                            
                            $newformatbatas_waktu       = date_format($batas_waktu_new,"d-m-Y");
                            $newformattgl_entri         = date_format($tglentriconvert,"d-m-Y");
                            
                            $datetime1                  = new DateTime($newformattgl_entri);
                            $datetime2                  = new DateTime($newformatbatas_waktu);
                            $difference                 = $datetime2->diff($datetime1);
                            $selisih_pengiriman         = $difference->d ;
                            
                            if($target_newKum != '0')
                            {
                                $persen_realisasi       = $realkum/$target_newKum*100;
                            }
                            else
                            {
                                if($realkum != 0)
                                {
                                    $persen_realisasi   = '150';
                                }
                                else
                                {
                                    $persen_realisasi   = '100';
                                }
                            };
                            
                            if($persen_realisasi >= '100')
                            {
                                $nilai_volume           = '3';
                            }
                            else if($persen_realisasi >= '90' && $persen_realisasi < '100')
                            {
                                $nilai_volume           = '2';
                            }
                            else if($persen_realisasi < '90')
                            {
                                $nilai_volume           = '1';
                            };
                            
                            if($datetime1 <= $datetime2)
                            {
                                $nilai_deadline         = "2";
                            }else
                            {
                                $nilai_deadline         = "1";
                            };
                            
                            $nilai_total                = $data[$i]->nilai_total;
                            
                            
                        }
                        else
                        {
                            $persen_realisasi           = '0';
                            $selisih_pengiriman         = '-1';
                            $nilai_volume               = '0';
                            $nilai_deadline             = '0';
                            $nilai_total                = '0';
                        }
                        
                        if ($id_jeniskegiatan == $id_jeniskegiatannew)
                        {
                            $this->db->query("UPDATE t_kegiatan SET target = '$data_baru[$i]', batas_minggu = '$friday[$i]', persen_realisasi='$persen_realisasi', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline', nilai_total='$nilai_total' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' and minggu_ke = '$minggu'" );
                        }
                        else
                        {
                            $this->db->query("UPDATE t_kegiatan SET id_jeniskegiatan = '$id_jeniskegiatannew', target = '$data_baru[$i]', batas_minggu = '$friday[$i]', persen_realisasi='$persen_realisasi', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline', nilai_total='$nilai_total' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' and minggu_ke = '$minggu'" );
                        }

                    }
					else
					{
					    if ($id_jeniskegiatan == $id_jeniskegiatannew)
					    {
					        $this->db->query("INSERT INTO t_kegiatan VALUES (NULL,'$id_jeniskegiatan', '$kode_kab', '$minggu','','$data_baru[$i]','$friday[$i]','0','$bataslewat','1','-','0','-','-','-1','0','0','','','0','',FALSE)");
					    }
					    else
					    {
					        $this->db->query("INSERT INTO t_kegiatan VALUES (NULL,'$id_jeniskegiatannew', '$kode_kab', '$minggu','','$data_baru[$i]','$friday[$i]','0','$bataslewat','1','-','0','-','-','-1','0','0','','','0','',FALSE)");
					    }
					    
					    
					};
					
					$targetkumnew += $data_baru[$i];
					$minggu++;
					
				}
				/* == Akhir Memperbaharui Tabal Kegiatan == */
				
				/* == Menambahkan ke Tabel Notifikasi == */
				$asal               = $this->db->query("SELECT id_tim FROM m_kegiatan WHERE id_kegiatan = '$kegiatan'")->row();
				$created_on         = date('Y-m-d H:i:s');
				$this->db->query("INSERT INTO t_notifikasi VALUES ('','$asal->id_tim', '5', '$kode_kab','','$id_jeniskegiatan' ,'1','$created_on')");
				/* == Akhir Menambahkan ke Tabel Notifikasi == */
				
			};
			
			/* == Memperbaharui Tabel Jenis Kegiatan == */
			if ($id_jeniskegiatan == $id_jeniskegiatannew)
			{
			    $this->db->query("UPDATE m_jeniskegiatan SET ketua_tim ='$ketua_tim_prov', target= $targetkumnew, mulai = '$mulai', batas_waktu = '$batas_waktu', dasar_surat='$dasar_surat' where id_jeniskegiatan='$id_jeniskegiatan'");
			    $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil diubah. ".$this->upload->display_errors()."</div>");
			    redirect('index.php/admin/kegiatan/view/'.$id_jeniskegiatan.'/');
			}
			else
			{
			    $this->db->query("UPDATE m_jeniskegiatan SET id_jeniskegiatan = '$id_jeniskegiatannew', nama_kegiatan = '$subkegiatan', ketua_tim ='$ketua_tim_prov', target= $targetkumnew, satuan = '$satuan', mulai = '$mulai', batas_waktu = '$batas_waktu', dasar_surat='$dasar_surat' where id_jeniskegiatan='$id_jeniskegiatan'");
			    $this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil diubah. ".$this->upload->display_errors()."</div>");
			    redirect('index.php/admin/kegiatan/view/'.$id_jeniskegiatannew.'/');
			}
			/* == Akhir Memperbaharui Tabel Jenis Kegiatan == */
			
			/* == Akhir Memperbaharui Target Kegiatan == */
			
		} 
		else
		{
			$a['data']      = $this->db->query("SELECT k.*, u.tim FROM m_kegiatan k LEFT JOIN m_tim u ON k.id_tim = u.id_tim ORDER BY k.kegiatan ASC ")->result();
			$a['page']		= "l_kelolakegiatan";
		}
		
		$this->load->view('admin/index', $a);
	}

	public function master_kegiatan() {
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
		$kegiatan               = addslashes($this->input->post('nama_kegiatan'));
		$tim                    = addslashes($this->input->post('tim'));
		$subtim                 = addslashes($this->input->post('subtim'));
		$id_ro                  = addslashes($this->input->post('ro'));
		
		
		//ambil max id
		
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$subkegiatan			= addslashes($this->input->post('subkegiatan'));
		$dasar_surat			= addslashes($this->input->post('dasar_surat'));
		$tab					= addslashes($this->input->post('tab'));
		$satuan					= addslashes($this->input->post('satuan'));

		
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
			$a['datpil']	= $this->db->query("select m.*, subk.nama_kegiatan as nmkegiatan from m_jeniskegiatan as m LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id where m.id_jeniskegiatan='$id_delete'")->row();	
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
			if($this->session->userdata('admin_user') == "6500")
			{
				$a['dataall']		= $this->db->query("SELECT *,round((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where m.nama_kegiatan  LIKE '%$cari%' ")->result();
				$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' and nama_kegiatan like '%$cari%'")->result();
				$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' and nama_kegiatan like '%$cari%' ")->result();
				$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' and nama_kegiatan like '%$cari%'")->result();
				$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' and nama_kegiatan like '%$cari%'")->result();
				$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' and nama_kegiatan like '%$cari%'")->result();
				$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' and nama_kegiatan like '%$cari%'")->result();
				$a['page']		= "l_kelolakegiatan";
			}
			else
			{
				$kabkota=$this->session->userdata('admin_user') ;
				$a['dataall']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota' and m.nama_kegiatan like '%$cari%' ")->result();
				$a['datatu']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='921' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['datasos']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='922' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['dataprod']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='923' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['datadist']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where substring(k.id_jeniskegiatan,1,3)='924' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['datanerwil']	= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='925' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['dataipds']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='926' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['page']		= "l_kelolakegiatan";
			}
			$a['page']		= "l_kelolakegiatan";
		} else if ($mau_ke == "add") {
			$tab			= $this->uri->segment(4);
			$a['page']		= "f_masterkegiatan";
		} else if ($mau_ke == "edt") {
			$tab			= $this->uri->segment(5);
			$a['datpil']	= $this->db->query("SELECT k.*, u.tim, subu.unitkerja FROM m_kegiatan k LEFT JOIN m_tim u ON k.id_tim = u.id_tim LEFT JOIN m_unitkerja subu ON k.id_unitkerja = subu.id_unitkerja WHERE k.id_kegiatan = $idu")->row();	
			$a['page']		= "f_masterkegiatan";
		} else if ($mau_ke == "act_add") {
		    
			$query          = $this->db->query("select max(convert((id_kegiatan),SIGNED INTEGER)) as  maxID from m_kegiatan ")->row();
			$idMax          = $query->maxID;
			$noUrut         = (int)$idMax;
			$noUrut++;
			$id_kegiatan    = sprintf("%03s",$noUrut);
			
			$this->db->query("INSERT INTO m_kegiatan VALUES ('$id_kegiatan', '$kegiatan', '$tim', '$subtim', '$id_ro')");
			redirect('index.php/admin/master_kegiatan/');
		} 
		else if ($mau_ke == "act_edt") {

			$id_jeniskegiatan       = $this->uri->segment(4);
			$realisasiprop          = 0;
			$targetkabkumulatif     = 0; 
			$wilayah                = $this->db->query("select * from m_kab")->result();
			$id_jeniskegiatannew    = $tahun.''.$subkegiatan;
			
			$fday                   = date("d-m-Y", strtotime($mulai));
			$lday                   = date("d-m-Y", strtotime($batas_waktu));
			$ffriday                = date("d-m-Y", strtotime("this Friday".$fday));
			$lfriday                = date("d-m-Y", strtotime("this Friday".$lday));
			$sfriday                = floor((strtotime($lfriday)-strtotime($ffriday)) / (60 * 60 * 24));
			$jfriday                = $sfriday / 7 + 1;
			$friday[0]              = date("Y-m-d", strtotime($ffriday));
			for($i = 1; $i < $jfriday; $i++){
				$friday[$i] = date("Y-m-d", strtotime('next friday'.$friday[$i-1]));
			}
			
			foreach ($wilayah as $row)
			{
				$kode_kab       = $row->id_kab;
				$data_kab       = $this->input->post('_'.$kode_kab);
				$data           = $this->db->query("select realisasi,tgl_entri from t_kegiatan  where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' ORDER BY minggu_ke")->result();
				$bataswaktuplussatu = new DateTime($batas_waktu);
				date_modify($bataswaktuplussatu, '+1 day');
				$bataslewat = date_format($bataswaktuplussatu, 'Y-m-d');
				$minggu         = 1;
				$realkum        = 0;
				
				if(count($data) > count($data_kab)){
					for($i = count($data_kab); $i < count($data); $i++){
						$this->db->query("DELETE FROM t_kegiatan WHERE id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' and minggu_ke='$i+1'");
					}  
				};
				
				for($i = 0; $i < count($data_kab); $i++){
					$targetkabkumulatif+=$data_kab[$i];
					if($i < count($data)){
						$realisasi_sekarang         = $data[$i]->realisasi;
						$realkum                    = $realkum + $data[$i]->realisasi;
						$tgl_entri_sekarang         = $data[$i]->tgl_entri;
						$target_new                 = $data_kab[$i];
						
						$batas_waktu_new            = new DateTime($friday[$i]);
						if($i == (count($data)-1)){
							$batas_waktu_new        = new DateTime($lday);
						}else{
							$batas_waktu_new	        = new DateTime($friday[$i]);
						}
						
						$tglentriconvert		    = new DateTime($tgl_entri_sekarang);
						$newformatbatas_waktu	    = date_format($batas_waktu_new,"d-m-Y");
						$newformattgl_entri		    = date_format($tglentriconvert,"d-m-Y");
						
						$datetime1 					= new DateTime($newformattgl_entri);
						$datetime2 					= new DateTime($newformatbatas_waktu);
						$difference 				= $datetime2->diff($datetime1);
						$selisih_pengiriman		 	= $difference->d ;
						
						if($target_new != '0')
						{
							$realisasiterbaru 			= $realkum/$target_new;
							$persen_realisasi			= $realkum/$target_new*100;
						}else{
							$realisasiterbaru   = $realkum;
							$persen_realisasi   = '0';
						}
						
						if($persen_realisasi >= '100')
						{
							$nilai_volume = '3';
						}else if($persen_realisasi >= '90' && $persen_realisasi < '100')
						{
							$nilai_volume = '2';
						}else if($persen_realisasi < '90')
						{
							$nilai_volume = '1';
						}else 
						{
						};
						if($datetime1 <= $datetime2)
						{
							$nilai_deadline ="2";
						}else
						{
							$nilai_deadline ="1";
						};
						
						$nilai_total            = 0;
						if($nilai_volume == 3 &&  $nilai_deadline == 2){
							$nilai_total        = 100;
						}
						
						$this->db->query("UPDATE t_kegiatan SET target = '$data_kab[$i]', batas_minggu = '$friday[$i]', persen_realisasi='$persen_realisasi', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline', nilai_total='$nilai_total' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$kode_kab' and minggu_ke = '$minggu'" );

					}else{
					};
					$minggu++;
				}
			}
			$this->db->query("UPDATE m_jeniskegiatan SET nama_kegiatan ='$subkegiatan', ketua_tim ='$ketua_tim_prov', target= $targetkabkumulatif, mulai = '$mulai', batas_waktu = '$batas_waktu', dasar_surat='$dasar_surat' where id_jeniskegiatan='$id_jeniskegiatan'");

			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil diubah. ".$this->upload->display_errors()."</div>");
			redirect('index.php/admin/kegiatan/');
		} 
		else {
			$a['data']      = $this->db->query("SELECT k.*, u.tim FROM m_kegiatan k LEFT JOIN m_tim u ON k.id_tim = u.id_tim ORDER BY k.kegiatan ASC ")->result();
			$a['page']		= "l_masterkegiatan";
		}
		
		$this->load->view('admin/index', $a);
	}
	
	public function listkegiatan()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM m_listkegiatan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/listkegiatan/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		///ambil variabel post
		$kegiatan               = addslashes($this->input->post('kegiatan'));
		$subkegiatan            = addslashes($this->input->post('nama_subkegiatan'));
		$satuan                 = addslashes($this->input->post('satuan'));
		$komponen               = addslashes($this->input->post('komponen'));
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM m_listkegiatan WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data telah dihapus </div>");
			redirect('index.php/admin/listkegiatan');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT l.id, l.nama_kegiatan, l.id_unitkerja, u.unitkerja, l.satuan,s.satuan as nama_satuan FROM m_listkegiatan l left join m_satuan s on l.satuan=s.id_satuan left join m_unitkerja u on l.id_unitkerja=u.id_unitkerja where l.nama_kegiatan like '%$cari%' order by l.id")->result();
			$a['page']		= "l_listkegiatan";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_listkegiatan";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT subk.*, k.kegiatan, s.satuan AS nama_satuan, kom.id_komponen as kd_komponen, kom.komponen FROM m_listkegiatan subk LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_satuan s ON subk.satuan = s.id_satuan LEFT JOIN m_komponen kom ON subk.id_komponen = kom.id WHERE subk.id = '$idu'")->row();	
			$a['page']		= "f_listkegiatan";
		} else if ($mau_ke == "act_add") {	
			
			$query          = $this->db->query("select max(convert((id),SIGNED INTEGER)) as  maxID from m_listkegiatan ")->row();
			$idMax          = $query->maxID;
			$noUrut         = (int)$idMax;
			$noUrut++;
			$id_subkegiatan = sprintf("%04s",$noUrut);
			
			$this->db->query("INSERT INTO m_listkegiatan VALUES ('$id_subkegiatan', '$subkegiatan', '$satuan', '$kegiatan', '$komponen')");
			redirect('index.php/admin/listkegiatan/');
			
		} else if ($mau_ke == "act_edt") {
			
			$this->db->query("UPDATE m_listkegiatan SET nama_kegiatan = '$nama_kegiatan', id_unitkerja='$unitkerja', satuan='$satuan' where id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil ditambahkan </div>");			
			redirect('index.php/admin/listkegiatan');
		} else {
			$a['data']      = $this->db->query("SELECT subk.*, k.kegiatan, s.satuan AS nama_satuan FROM m_listkegiatan subk LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_satuan s ON subk.satuan = s.id_satuan ORDER BY k.kegiatan, subk.nama_kegiatan ASC ")->result();
			$a['page']		= "l_listkegiatan";
		}
		
		$this->load->view('admin/index', $a);
	}

	public function progress() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$ta = $this->session->userdata('admin_ta');
		
		/* pagination 	
		$total_row_all		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan")->num_rows();
		$total_row_tu		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921'")->num_rows();
		$total_row_sos		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922'")->num_rows();
		$total_row_prod		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923'")->num_rows();
		$total_row_dist		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924'")->num_rows();
		$total_row_ner		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925'")->num_rows();
		$total_row_ipds		= $this->db->query("SELECT *,(realisasi/target*100) as persen FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926'")->num_rows();
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
			$a['datatu']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,3)='921'")->result();
			$a['datasos']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,3)='922'")->result();
			$a['dataprod']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,3)='923'")->result();
			$a['datadist']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,3)='924'")->result();
			$a['datanerwil']	= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,3)='925'")->result();
			$a['dataipds']		= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' and substring(k.id_jeniskegiatan,1,3)='926'")->result();
			$a['page']			= "l_progress_kab";
		} 
		else {
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['page']		= "l_progress";
		}
		
		$this->load->view('admin/index', $a);
	}
	
	public function approval() {
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
		$subkegiatan			= addslashes($this->input->post('subkegiatan'));
		$dasar_surat			= addslashes($this->input->post('dasar_surat'));
		$tab					= addslashes($this->input->post('tab'));
		$satuan					= addslashes($this->input->post('satuan'));
		$_6501 					=$this->input->post('_6501');
		$_6502 					=$this->input->post('_6502');
		$_6503					=$this->input->post('_6503');
		$_6504					=$this->input->post('_6504');
		$_6571					=$this->input->post('_6571');
		//Perubahan April-Mei 2023
		$ketua_tim_prov				=addslashes($this->input->post('ketua_tim_prov'));
		$mulai  				=addslashes($this->input->post('mulai'));
		$pj_6501 				=addslashes($this->input->post('pj_6501'));
		$pj_6502 				=addslashes($this->input->post('pj_6502'));
		$pj_6503				=addslashes($this->input->post('pj_6503'));
		$pj_6504				=addslashes($this->input->post('pj_6504'));
		$pj_6571				=addslashes($this->input->post('pj_6571'));
		
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
			$a['datpil']	= $this->db->query("select m.*, subk.nama_kegiatan as nmkegiatan from m_jeniskegiatan as m LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id where m.id_jeniskegiatan='$id_delete'")->row();	
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
			if($this->session->userdata('admin_user') == "6500")
			{
				$a['dataall']		= $this->db->query("SELECT *,round((m.realisasi/m.target*100),2) as persen  FROM m_jeniskegiatan m inner join m_satuan s on m.satuan=s.id_satuan where m.nama_kegiatan  LIKE '%$cari%' ")->result();
				$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' and nama_kegiatan like '%$cari%'")->result();
				$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' and nama_kegiatan like '%$cari%' ")->result();
				$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' and nama_kegiatan like '%$cari%'")->result();
				$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' and nama_kegiatan like '%$cari%'")->result();
				$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' and nama_kegiatan like '%$cari%'")->result();
				$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' and nama_kegiatan like '%$cari%'")->result();
				$a['page']		= "l_kelolakegiatan";
			}
			else
			{
				$kabkota=$this->session->userdata('admin_user') ;
				$a['dataall']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota' and m.nama_kegiatan like '%$cari%' ")->result();
				$a['datatu']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='921' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['datasos']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='922' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['dataprod']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='923' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['datadist']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where substring(k.id_jeniskegiatan,1,3)='924' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['datanerwil']	= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='925' and id_kab='$kabkota' and m.nama_kegiatan like '%$cari%'")->result();
				$a['dataipds']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='926' and id_kab='$kabkota'  and m.nama_kegiatan like '%$cari%'")->result();
				$a['page']		= "l_kelolakegiatan";
			}
			$a['page']		= "l_kelolakegiatan";
		} else if ($mau_ke == "approv") {
			$id_pengajuan	= $this->uri->segment(4);
			$tahun          = $this->session->userdata('admin_ta');
			$tim            = $this->session->userdata('admin_nip');
			$a['data']      = $this->db->query("SELECT target.*, subk.nama_kegiatan, mtarget.alasan, mtarget.flag_approval FROM t_ubahtarget target LEFT JOIN m_listkegiatan subk ON SUBSTRING(target.id_jeniskegiatan,5,4) = subk.id LEFT JOIN m_ubahtarget mtarget ON target.id_pengajuan = mtarget.id_pengajuan WHERE target.id_pengajuan = '$id_pengajuan' ")->result();
			$a['page']		= "f_approvtarget";
		} 
		else if ($mau_ke == "act_approv") {

			$id_pengajuan           = addslashes($this->input->post('idpengajuan'));
			$id_jeniskegiatan       = addslashes($this->input->post('idkegiatan'));
			$id_kab                 = addslashes($this->input->post('idkab'));
			$datanew				= $this->input->post('_'.$id_kab.'new');
			$persetujuan            = addslashes($this->input->post('persetujuan'));
			$id_notif               = 0;
			
			if($persetujuan == '1'){
				$datakab                = $this->db->query("select target, realisasi, flag_konfirm, nilai_deadline from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kab' ORDER BY minggu_ke")->result();
				$targetkum              = 0;
				$targetkumnew           = 0;
				$realisasikum           = 0;
				
				$dataprov               = $this->db->query("select target, realisasi from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'")->row();
				$targetprov             = $dataprov->target;
				
				$minggu                 = 1;
				for($i = 0; $i < count($datanew); $i++){
				    $targetnew          = $datanew[$i];
				    $targetkum          = $targetkum + $datakab[$i]->target;
				    $targetkumnew       = $targetkumnew + $targetnew;
				    $realisasikum       = $realisasikum + $datakab[$i]->realisasi;
				    $flag               = $datakab[$i]->flag_konfirm;
				    
					if($flag != 1){
                        if($targetnew != '0')
                        {
                            $persen_realisasi       = $realisasikum/$targetnew*100;
                        }
                        else
                        {
                            if($realisasikum != 0)
                            {
                                $persen_realisasi   = '150';
                            }
                            else
                            {
                                $persen_realisasi   = '0';
                            }
                        };
                        
                        if($persen_realisasi >= '100')
                        {
                            $nilai_volume           = '3';
                        }
                        else if($persen_realisasi >= '90' && $persen_realisasi < '100')
                        {
                            $nilai_volume           = '2';
                        }
                        else if($persen_realisasi < '90')
                        {
                            $nilai_volume           = '1';
                        };
                        
                        $nilai_total                = $nilai_volume + $datakab[$i]->nilai_deadline;
                        $this->db->query("UPDATE t_kegiatan SET target = '$targetnew', persen_realisasi='$persen_realisasi', nilai_volume='$nilai_volume', nilai_total='$nilai_total' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$id_kab' and minggu_ke = '$minggu'" );
					}
					else
					{
				        $this->db->query("UPDATE t_kegiatan SET target = '$targetnew' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$id_kab' and minggu_ke = '$minggu'" );
					}
					$minggu++;
				}
				$targetprov             = $targetprov - $targetkum + $targetkumnew;
				$this->db->query("UPDATE m_ubahtarget SET flag_approval = '1' WHERE id_pengajuan = '$id_pengajuan'" );
				
				$this->db->query("UPDATE m_jeniskegiatan SET target = '$targetprov' WHERE id_jeniskegiatan='$id_jeniskegiatan'" );
				$id_notif               = 7;
			}
			else if ($persetujuan == 3){
			    $id_notif               = 8;
			    $this->db->query("UPDATE m_ubahtarget SET flag_approval = '3' WHERE id_pengajuan = '$id_pengajuan'" );
			}
			
			/* == Menambahkan ke Tabel Notifikasi == */
			$querytujuan        = $this->db->query("SELECT k.id_tim FROM m_listkegiatan subk LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE subk.id = SUBSTRING($id_jeniskegiatan,5,4)")->row();
			$asal               = $querytujuan->id_tim;
			$created_on         = date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO t_notifikasi VALUES ('','$asal', '$id_notif', '$id_kab','$id_pengajuan','$id_jeniskegiatan' ,'1','$created_on')");
			/* == Akhir Menambahkan ke Tabel Notifikasi == */
			
			redirect('index.php/admin/kegiatan/view/'.$id_jeniskegiatan.'/');
		} 
		else {
			$tab			= $this->uri->segment(4);
			$tahun          = $this->session->userdata('admin_ta');
			$tim            = $this->session->userdata('admin_nip');
			if($this->session->userdata('admin_user') == "6500")
			{
			    $a['data']      = $this->db->query("SELECT target.*, subk.nama_kegiatan, kab.nama_kab FROM m_ubahtarget target LEFT JOIN m_listkegiatan subk ON SUBSTRING(target.id_jeniskegiatan,5,4) = subk.id LEFT JOIN m_kab as kab ON SUBSTRING(target.id_pengajuan,5,4) = kab.id_kab WHERE SUBSTRING(target.id_pengajuan,1,4) = '$tahun' ORDER BY target.id")->result();
			}else{
			    $a['data']      = $this->db->query("SELECT target.*, subk.nama_kegiatan, kab.nama_kab FROM m_ubahtarget target LEFT JOIN m_listkegiatan subk ON SUBSTRING(target.id_jeniskegiatan,5,4) = subk.id LEFT JOIN m_kab as kab ON SUBSTRING(target.id_pengajuan,5,4) = kab.id_kab LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE SUBSTRING(target.id_pengajuan,1,4) = '$tahun' AND  k.id_tim = '$tim' ORDER BY target.id" )->result();
			}
			$a['page']		= "l_listtarget";
		}
		
		$this->load->view('admin/index', $a);
	}

	public function get_kegiatan() {
		$unitkerja=$this->input->post('unitkerja');
		$bidang = substr($unitkerja,1,3);
		$query 	=  $this->db->query("SELECT * FROM m_jeniskegiatan WHERE substring(id_jeniskegiatan,1,3)='$bidang'");
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
				if($this->session->userdata('admin_user') != "6500")
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
			if($this->session->userdata('admin_user') == "6500")
			{
				$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan ")->result();
				$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' ")->result();
				$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' ")->result();
				$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' ")->result();
				$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' ")->result();
				$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' ")->result();
				$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' ")->result();
				$a['page']			= "l_entry";
			}
			else
			{
				$a['dataall']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where id_kab='$kabkota' and k.target <> 0 order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
				$a['datatu']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='921' and id_kab='$kabkota' and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
				$a['datasos']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='922' and id_kab='$kabkota' and k.target <> 0   order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
				$a['dataprod']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='923' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
				$a['datadist']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan where substring(k.id_jeniskegiatan,1,3)='924' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
				$a['datanerwil']	= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan  FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='925' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc  ")->result();
				$a['dataipds']		= $this->db->query("SELECT k.*,round((k.realisasi/k.target*100),2) as persen,m.nama_kegiatan FROM t_kegiatan  k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan  where substring(k.id_jeniskegiatan,1,3)='926' and id_kab='$kabkota'  and k.target <> 0  order by substring(m.id_jeniskegiatan,1,5) asc , substring(m.id_jeniskegiatan,10,2) asc  ")->result();
				$a['page']		= "l_entry";
				
				
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
			$a['data']		= $this->db->query("SELECT * FROM m_satuan WHERE satuan LIKE '%$cari%' ORDER BY satuan ASC, id_satuan DESC")->result();
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
			$a['data']		= $this->db->query("SELECT * FROM m_satuan ORDER BY satuan LIMIT $awal, $akhir ")->result();
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
			$id_edit          = $this->input->get('konfirmasi_id');
			$id_jeniskegiatan = substr($id_edit,0,strlen($id_edit)-5);

			$id_kab         =substr($id_edit,strlen($id_edit)-5,4);
			$minggu         =substr($id_edit,strlen($id_edit)-1,1);
			$a['datpil']    = $this->db->query("select k.id_jeniskegiatan,subk.nama_kegiatan as nmkegiatan,k.id_kab,w.nama_kab,k.target,k.realisasi,k.bukti,k.link_pengiriman, k.minggu_ke, k.batas_minggu from t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id where k.id_jeniskegiatan='$id_jeniskegiatan' and k.id_kab='$id_kab' and k.minggu_ke='$minggu'")->row();    
			$a['page']      = "f_konfirmasi";
		}
		else if ($mau_ke == "act_edt")
		{
			$tab_aktif=addslashes($this->input->post('tab_aktif'));
			$id_jeniskegiatan   = addslashes($this->input->post('id_jeniskegiatan'));
			$id_kab             = addslashes($this->input->post('id_kab'));
			$minggu_ke          = $this->uri->segment(4);
			$batas_minggu       = $this->uri->segment(5);
			$konfirm_ket        = addslashes($this->input->post('konfirm_ket'));
			
			$data               = $this->db->query("SELECT nilai_volume, nilai_deadline FROM t_kegiatan WHERE id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$id_kab' and minggu_ke = '$minggu_ke'")->row();
			$nilai_volume       = $data->nilai_volume;
			$nilai_deadline     = $data->nilai_deadline;
			
			if($nilai_volume == 3){
			    if($nilai_deadline == 2){
			        $nilai_total    = 100;
			    }elseif($nilai_deadline == 1){
			        $nilai_total    = 99;
			    }
			}elseif($nilai_volume == 2){
			    if($nilai_deadline == 2){
			        $nilai_total    = 99;
			    }elseif($nilai_deadline == 1){
			        $nilai_total    = 98;
			    }
			}elseif($nilai_volume == 1){
			    if($nilai_deadline == 2){
			        $nilai_total    = 98;
			    }
			}
			
			$this->db->query("update t_kegiatan set flag_konfirm='3', nilai_total='$nilai_total', konfirm_ket='$konfirm_ket' where id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$id_kab' and minggu_ke = '$minggu_ke'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data sudah dikonfirmasi</div>");
				//echo "<script>  window.location.reload(); </script>";
				
			/* == Menambahkan ke Tabel Notifikasi == */
			$querytujuan        = $this->db->query("SELECT k.id_tim FROM m_listkegiatan subk LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE subk.id = SUBSTRING($id_jeniskegiatan,5,4)")->row();
			$asal               = $querytujuan->id_tim;
			$queryid            = $this->db->query("SELECT id FROM t_kegiatan WHERE id_jeniskegiatan='$id_jeniskegiatan' and id_kab='$id_kab' and minggu_ke = '$minggu_ke' LIMIT 1")->row();
			$idt                = $queryid->id;
			$created_on         = date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO t_notifikasi VALUES ('','$asal', '3', '$id_kab','$idt','$id_jeniskegiatan' ,'1','$created_on')");
			/* == Akhir Menambahkan ke Tabel Notifikasi == */
			
			redirect('index.php/admin/unitkerjaprov/view/'.$id_jeniskegiatan.'/'.$minggu_ke.'/'.$batas_minggu.'/');
			
		}
		$this->load->view('admin/index', $a);
	}


	public function alokasikegiatan()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$id_kabkota				= $this->session->userdata('admin_nip');
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
		$unitkerja				= addslashes($this->input->post('unitkerja'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$dasar_surat			= addslashes($this->input->post('dasar_surat'));
		$pj_prov				=addslashes($this->input->post('pj_prov'));
		$alasan_perubahan		=addslashes($this->input->post('alasan_perubahan'));
		$dasar_perubahan		=addslashes($this->input->post('dasar_perubahan'));
		
		//upload config 
		$config['upload_path'] 		= './upload/bukti_kirim';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		$nama_kegiatan			= addslashes($this->input->post('nama_kegiatan'));
		$mulai  				=addslashes($this->input->post('mulai'));
		
		if ($mau_ke == "pilih_kegiatan")
		{
			if($idu == '00')
			{
				if($this->session->userdata('admin_nip') != '6500')
				{	
					$bidangku = $this->session->userdata('admin_nip');
					$a['data']		= $this->db->query("SELECT t.id_jeniskegiatan as idkgt, t.target as target_mingguan, t.realisasi as real_mingguan, m.*,u.tim,s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, t.ketua_tim as ketua FROM m_jeniskegiatan m LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim u ON k.id_tim = u.id_tim left join m_satuan s on m.satuan=s.id_satuan left join t_kegiatan t on m.id_jeniskegiatan = t.id_jeniskegiatan where YEAR(m.batas_waktu)='$tahun' and t.id_kab=$id_kabkota order by k.id_tim ASC, t.id_jeniskegiatan, t.batas_minggu asc")->result();
				}
				$a['page']		= "l_alokasikegiatan";	
			}
			else
			{
				if($this->session->userdata('admin_nip') != '6500')
				{	
					$bidangku = $this->session->userdata('admin_nip');
					$a['data']		= $this->db->query("SELECT t.id_jeniskegiatan as idkgt, t.target as target_mingguan, t.realisasi as real_mingguan, m.*,u.tim,s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, t.ketua_tim as ketua FROM m_jeniskegiatan m LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim u ON k.id_tim = u.id_tim left join m_satuan s on m.satuan=s.id_satuan left join t_kegiatan t on m.id_jeniskegiatan = t.id_jeniskegiatan where (MONTH(m.mulai)<='$idu' AND MONTH(m.batas_waktu)>='$idu' ) and YEAR(m.batas_waktu)='$tahun' and t.id_kab=$id_kabkota order by k.id_tim ASC, t.id_jeniskegiatan, t.batas_minggu asc")->result();
				}
				$a['page']		= "l_alokasikegiatan";	
			}
		}
		else if($mau_ke == "ubahtarget")
		{
			/* == Menampilkan Form Pengajuan Ubah Target == */
			$a['datpil']	= $this->db->query("select t.*, subk.nama_kegiatan as nmkegiatan, k.kegiatan, j.mulai, j.batas_waktu, s.satuan as nama_satuan from t_kegiatan as t left join m_jeniskegiatan AS j ON t.id_jeniskegiatan = j.id_jeniskegiatan LEFT JOIN m_listkegiatan subk ON j.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_satuan s on j.satuan=s.id_satuan where t.id_jeniskegiatan='$idu' AND t.id_kab = '$id_kabkota' ORDER BY t.minggu_ke")->result();;	
			$a['page']		= "f_ubahtarget";
			/* == Akhir Menampilkan Form Pengajuan Ubah Target == */
			
		}
		else if ($mau_ke == "act_ubahtarget") 
		{
		    
			$id_jeniskegiatan =$this->uri->segment(4);
			$realisasiprop = 0;
			$targetkabkumulatif=0; 
			$wilayah=$this->db->query("select * from m_kab")->result();
			
			$query = $this->db->query("select max(convert((substring(id_pengajuan,9,length(id_pengajuan-8))),SIGNED INTEGER)) as  maxID from m_ubahtarget where substring(id_pengajuan,1,4)='$tahun' and substring(id_pengajuan,5,4)='$id_kabkota'")->row();
			$idMax = $query->maxID;
			$noUrut = (int)$idMax;
			$noUrut++;
			$id_pengajuan   = $tahun.''.$id_kabkota.''.sprintf("%03s",$noUrut);
			$alasan         = addslashes($this->input->post('alasan_perubahan'));
			$dasar          = addslashes($this->input->post('dasar_perubahan'));
			$m_ke           = 1;
			$data_kab_lama  = $this->input->post('_'.$id_kabkota);
			$data_kab_new   = $this->input->post('_'.$id_kabkota.'new');
			
			for($i = 0; $i < count($data_kab_new); $i++){
				$this->db->query("INSERT INTO t_ubahtarget VALUES (NULL,'$id_pengajuan', '$id_jeniskegiatan', '$id_kabkota', '$m_ke','$data_kab_lama[$i]','$data_kab_new[$i]')");
				$m_ke++;
			};
			
			$this->db->query("INSERT INTO m_ubahtarget VALUES (NULL,'$id_pengajuan', '$id_jeniskegiatan', '2','$alasan','$dasar')");
			
			/* == Menambahkan ke Tabel Notifikasi == */
			$querytujuan        = $this->db->query("SELECT k.id_tim FROM m_listkegiatan subk LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE subk.id = SUBSTRING($id_jeniskegiatan,5,4)")->row();
			$tujuan             = $querytujuan->id_tim;
			$created_on         = date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO t_notifikasi VALUES ('','$id_kabkota', '6', '$tujuan','$id_pengajuan','$id_jeniskegiatan' ,'1','$created_on')");
			/* == Akhir Menambahkan ke Tabel Notifikasi == */
			
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil diubah. ".$this->upload->display_errors()."</div>");
			redirect('index.php/admin/alokasikegiatan/');
		}
		else if($mau_ke == "view")
		{
			/* == Menampilkan Halaman Detail Alokasi Kegiatan Kabupaten/Kota == */
			$a['datview']	= $this->db->query("select t.*, subk.nama_kegiatan as nmkegiatan, j.mulai, j.batas_waktu, s.satuan as nama_satuan from t_kegiatan as t left join m_jeniskegiatan AS j ON t.id_jeniskegiatan = j.id_jeniskegiatan LEFT JOIN m_listkegiatan subk ON j.nama_kegiatan = subk.id LEFT JOIN m_satuan s on j.satuan=s.id_satuan where t.id_jeniskegiatan='$idu' AND t.id_kab = '$id_kabkota' ORDER BY t.minggu_ke")->result();	
			$a['datubah']   = $this->db->query("SELECT id_pengajuan FROM m_ubahtarget WHERE id_jeniskegiatan='$idu' AND flag_approval = '2'")->row();
			$a['page']		= "v_alokasikegiatan_detail";
			/* == Akhir Menampilkan Halaman Detail Alokasi Kegiatan Kabupaten/Kota == */
		}
		else if($mau_ke == "ketua")
		{
			$tab			= $this->uri->segment(5);
			$a['datpil']	= $this->db->query("SELECT m.id_jeniskegiatan, subk.nama_kegiatan as nmkegiatan FROM m_jeniskegiatan m LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id WHERE m.id_jeniskegiatan = '$idu'")->row();
			$a['ketua']     = $this->db->query("SELECT id_jeniskegiatan, ketua_tim FROM t_kegiatan WHERE id_jeniskegiatan = '$idu' AND id_kab = '$id_kabkota' LIMIT 1")->row();
			$a['page']		= "f_ketuatimkabkota";
			
		}
		else if($mau_ke == "act_ketua")
		{
			$idkegiatan     = addslashes($this->input->post('id_jeniskegiatan'));
			$ketua          = addslashes($this->input->post('ketua_tim'));
			$ndata          = $this->db->query("SELECT COUNT('id_jeniskegiatan') as ndata FROM t_kegiatan WHERE id_jeniskegiatan = '$idkegiatan' AND id_kab = '$id_kabkota'")->row();
			for($i = 1; $i <= $ndata->ndata; $i++){
			    $this->db->query("UPDATE t_kegiatan SET ketua_tim = '$ketua' WHERE id_jeniskegiatan = '$idkegiatan' AND id_kab = '$id_kabkota' AND minggu_ke = '$i'");
			}
			redirect('index.php/admin/alokasikegiatan/');
			
		}
		else
		{
			/* == Menampilkan Halaman Alokasi Kegiatan Kabupaten/Kota == */
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['data']		= $this->db->query("SELECT t.id_jeniskegiatan as idkgt, t.target as target_mingguan, t.realisasi as real_mingguan, m.*,u.tim,s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, t.ketua_tim as ketua FROM m_jeniskegiatan m LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim u ON k.id_tim = u.id_tim left join m_satuan s on m.satuan=s.id_satuan left join t_kegiatan t on m.id_jeniskegiatan = t.id_jeniskegiatan where (MONTH(m.mulai)<='$bulanini' AND MONTH(m.batas_waktu)>='$bulanini' ) and YEAR(m.batas_waktu)='$tahun' and t.id_kab=$id_kabkota order by k.id_tim ASC, t.id_jeniskegiatan, t.batas_minggu asc")->result();
			$a['page']		= "l_alokasikegiatan";
			/* == Akhir Menampilkan Halaman Alokasi Kegiatan Kabupaten/Kota == */
		}
		
		$this->load->view('admin/index', $a);
	}
	
	public function notifikasi()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}

		//ambil variabel URL
		$nip    				= $this->session->userdata('admin_nip');
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		$tahun					= $this->session->userdata('admin_ta');
		$unitkerja				= addslashes($this->input->post('unitkerja'));
		$batas_waktu			= addslashes($this->input->post('batas_waktu'));
		$dasar_surat			= addslashes($this->input->post('dasar_surat'));
		$pj_prov				=addslashes($this->input->post('pj_prov'));
		$alasan_perubahan		=addslashes($this->input->post('alasan_perubahan'));
		$dasar_perubahan		=addslashes($this->input->post('dasar_perubahan'));
		
		//upload config 
		$config['upload_path'] 		= './upload/bukti_kirim';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		$nama_kegiatan			= addslashes($this->input->post('nama_kegiatan'));
		$mulai  				=addslashes($this->input->post('mulai'));
		
		if($mau_ke == "view")
		{
			/* == Redirect Halaman Notifikasi == */
			$data           = $this->db->query("SELECT * FROM t_notifikasi WHERE id='$idu'")->row();
			$this->db->query("UPDATE t_notifikasi SET status = '2' WHERE id='$idu'");
			if($data->id_notif == '1')
			{
			    $idpil          = $data->id_tkegiatan;
			    $datpil         = $this->db->query("SELECT * FROM t_kegiatan WHERE id='$idpil'")->row();
			    $idjkegiatan    = $datpil->id_jeniskegiatan;
			    $minggu         = $datpil->minggu_ke;
			    $friday         = $datpil->batas_minggu;
			    redirect('index.php/admin/unitkerjaprov/view/'.$idjkegiatan.'/'.$minggu.'/'.$friday.'/');
			}
			else if($data->id_notif == '2')
			{
			    redirect('index.php/admin/unitkerjaprov/');
			}
			else if($data->id_notif == '3')
			{
			    redirect('index.php/admin/unitkerjakabkotadetail/');
			}
			else if($data->id_notif == '4')
			{
				redirect('index.php/admin/alokasikegiatan/view/'.$data->id_jeniskegiatan);
			}
			else if($data->id_notif == '5')
			{
				redirect('index.php/admin/alokasikegiatan/');
			}
			else if($data->id_notif == '6')
			{
				redirect('index.php/admin/approval/approv/'.$data->id_tkegiatan);
			}
			else if($data->id_notif == '7')
			{
				redirect('index.php/admin/alokasikegiatan/view/'.$data->id_jeniskegiatan);
			}
			else if($data->id_notif == '8')
			{
				redirect('index.php/admin/alokasikegiatan/view/'.$data->id_jeniskegiatan);
			};
			/* == Akhir Redirect Halaman Notifikasi == */
		}
		else
		{
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['data']		= $this->db->query("SELECT tn.*, n.jenis_notif, u.nama FROM t_notifikasi tn LEFT JOIN m_notifikasi n ON tn.id_notif = n.id_notif LEFT JOIN t_admin u ON tn.asal = u.nip WHERE tujuan = '$nip' AND (status = 1 OR status = 2) ORDER BY created_on asc")->result();
			$a['page']		= "l_notifikasi";	
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
				$a['data92110']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92110'")->result();
				$a['data92120']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92120'")->result();
				$a['data92130']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92130'")->result();
				$a['data92140']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92140'")->result();
				$a['data92150']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92150'")->result();
				$a['data92210']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92210'")->result();
				$a['data92220']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92220'")->result();
				$a['data92230']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92230'")->result();
				$a['data92310']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92310'")->result();
				$a['data92320']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92320'")->result();
				$a['data92330']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92330'")->result();
				$a['data92410']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92410'")->result();
				$a['data92420']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92420'")->result();
				$a['data92430']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92430'")->result();
				$a['data92510']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92510'")->result();
				$a['data92520']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92520'")->result();
				$a['data92530']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92530'")->result();
				$a['data92610']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92610'")->result();
				$a['data92620']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92620'")->result();
				$a['data92630']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92630'")->result();
				$a['page']		= "l_kegiatan_bidang";
			}
			else
			{
				$a['data92110']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92110'")->result();
				$a['data92120']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92120'")->result();
				$a['data92130']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92130'")->result();
				$a['data92140']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92140'")->result();
				$a['data92150']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92150'")->result();
				$a['data92210']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92210'")->result();
				$a['data92220']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92220'")->result();
				$a['data92230']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92230'")->result();
				$a['data92310']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92310'")->result();
				$a['data92320']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92320'")->result();
				$a['data92330']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92330'")->result();
				$a['data92410']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92410'")->result();
				$a['data92420']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92420'")->result();
				$a['data92430']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92430'")->result();
				$a['data92510']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92510'")->result();
				$a['data92520']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92520'")->result();
				$a['data92530']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92530'")->result();
				$a['data92610']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92610'")->result();
				$a['data92620']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92620'")->result();
				$a['data92630']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$idu' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92630'")->result();
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
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['data92110']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92110'")->result();
			$a['data92120']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92120'")->result();
			$a['data92130']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92130'")->result();
			$a['data92140']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92140'")->result();
			$a['data92150']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92150'")->result();
			$a['data92210']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92210'")->result();
			$a['data92220']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92220'")->result();
			$a['data92230']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92230'")->result();
			$a['data92310']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92310'")->result();
			$a['data92320']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92320'")->result();
			$a['data92330']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92330'")->result();
			$a['data92410']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92410'")->result();
			$a['data92420']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92420'")->result();
			$a['data92430']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92430'")->result();
			$a['data92510']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92510'")->result();
			$a['data92520']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92520'")->result();
			$a['data92530']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92530'")->result();
			$a['data92610']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92610'")->result();
			$a['data92620']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92620'")->result();
			$a['data92630']		= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan  FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan  where MONTH(k.batas_waktu)='$bulanini' and YEAR(k.batas_waktu)='$tahun' and substring(k.id_jeniskegiatan,1,5)='92630'")->result();
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
		$minggu                 = $this->uri->segment(5);
		$friday                 = $this->uri->segment(6);
		
		if ($mau_ke == "pilih_kegiatan")
		{
			if($idu == '00')
			{
				$hariini    = date("d-m-Y");
				//$bulanini = substr($hariini,3,2);
				$tFriday    = date("Y-m-d", strtotime("this friday ".$hariini));
				
				$a['data']          = $this->db->query("SELECT t.*, m.nama_kegiatan, m.batas_waktu, m.dasar_surat, u.unitkerja FROM t_kegiatan t LEFT JOIN m_jeniskegiatan m ON t.id_jeniskegiatan=m.id_jeniskegiatan LEFT JOIN m_unitkerja u ON substring(t.id_jeniskegiatan,1,5)=u.id_unitkerja WHERE AND YEAR(batas_waktu)='$tahun' ORDER BY t.id_jeniskegiatan ASC, t.batas_minggu ASC, t.id_kab ASC")->result();
				$a['page']			= "l_kegiatanunitkerja";	
			}
			else
			{
				$hariini            = date("d-m-Y");
				$bulanini           = substr($hariini,3,2);
				$bulanlalu          = $bulanini-1;
				$nfriday            = getMinggu($bulanini)[0];
				$lastfriday         = getMinggu($bulanini)[1][$nfriday-1];
				$nfridaylmonth      = getMinggu($bulanlalu)[0];
				$lfridaylmonth      = getMinggu($bulanlalu)[1][$nfridaylmonth-1];
				$a['datatim']       = $this->db->query("SELECT * FROM m_tim ORDER BY id_tim ASC")->result();
				$a['data']          = $this->db->query("SELECT t.*, m.nama_kegiatan, m.batas_waktu, m.dasar_surat, u.tim, s.satuan, subk.nama_kegiatan as nmkegiatan FROM t_kegiatan t LEFT JOIN m_jeniskegiatan m ON t.id_jeniskegiatan=m.id_jeniskegiatan LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan=subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim u ON k.id_tim=u.id_tim LEFT JOIN m_satuan s ON m.satuan=s.id_satuan WHERE MONTH(m.mulai)<=('$idu') AND MONTH(m.batas_waktu)>=('$idu') AND YEAR(m.batas_waktu)='$tahun' ORDER BY k.id_tim ASC,m.batas_waktu ASC, t.id_jeniskegiatan ASC, t.batas_minggu ASC, t.id_kab ASC")->result();
				$a['data2']          = $this->db->query("SELECT * FROM (SELECT jnsk.*,t.target AS target_mingguan,t.batas_minggu,t.realisasi AS real_mingguan, s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, k.* FROM m_jeniskegiatan jnsk LEFT JOIN m_satuan s ON jnsk.satuan = s.id_satuan LEFT JOIN m_listkegiatan subk on jnsk.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan JOIN t_kegiatan t on jnsk.id_jeniskegiatan = t.id_jeniskegiatan WHERE ((MONTH(jnsk.mulai)<='$bulanini' AND jnsk.batas_waktu>'$lfridaylmonth') OR (MONTH(jnsk.mulai) > '$bulanini' AND jnsk.mulai<='$lastfriday')) and MONTH(t.batas_minggu) = '$idu' and YEAR(jnsk.batas_waktu)='$tahun') AS kegiatan JOIN (SELECT id_jeniskegiatan, SUM(target) AS total_target, SUM(realisasi) AS total_realisasi FROM t_kegiatan GROUP BY id_jeniskegiatan) AS total_target ON kegiatan.id_jeniskegiatan = total_target.id_jeniskegiatan ORDER BY kegiatan.batas_waktu asc")->result();
			$a['page']			= "l_kegiatanunitkerja";
				$a['page']			= "l_kegiatanunitkerja";	
			}
		}
		else if($mau_ke == "view")
    	{
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan from m_jeniskegiatan as m left join m_listkegiatan subk ON m.nama_kegiatan = subk.id LEFT JOIN m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen, w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' AND k.batas_minggu <= '$friday' ORDER BY k.id_kab, k.batas_minggu")->result();		
			$a['wilayah']   = $this->db->query("SELECT * FROM m_kab")->result();	
			$a['page']		= "v_kegiatan_unitkerja_detail";
		}
		else
		{
			$hariini            = date("d-m-Y");
			$bulanini           = substr($hariini,3,2);
			$bulan              = date("m", strtotime($hariini));
			$firstFriday        = getMinggu($bulanini)[1][0];
            $a['coba']          = $firstFriday;
			$bulanlalu          = $bulanini-1;
			$nfriday            = getMinggu($bulanini)[0];
			$lastfriday         = getMinggu($bulanini)[1][$nfriday-1];
			$nfridaylmonth      = getMinggu($bulanlalu)[0];
			$lfridaylmonth      = getMinggu($bulanlalu)[1][$nfridaylmonth-1];
			$a['a'] = $lfridaylmonth;
			$a['datatim']       = $this->db->query("SELECT * FROM m_tim ORDER BY id_tim ASC")->result();
			$a['data']          = $this->db->query("SELECT t.*, m.nama_kegiatan, m.batas_waktu, m.dasar_surat, u.tim, s.satuan, subk.nama_kegiatan as nmkegiatan FROM t_kegiatan t LEFT JOIN m_jeniskegiatan m ON t.id_jeniskegiatan=m.id_jeniskegiatan LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan=subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim u ON k.id_tim=u.id_tim LEFT JOIN m_satuan s ON m.satuan=s.id_satuan WHERE MONTH(m.mulai)<=('$bulanini') AND MONTH(m.batas_waktu)>=('$bulanini') AND YEAR(m.batas_waktu)='$tahun' ORDER BY k.id_tim ASC,m.batas_waktu ASC, t.id_jeniskegiatan ASC, t.batas_minggu ASC, t.id_kab ASC")->result();
			$a['data2']          = $this->db->query("SELECT * FROM (SELECT m.id_jeniskegiatan,l.nama_kegiatan,m.mulai,m.batas_waktu, MAX(t.batas_minggu) AS batas_minggu_akhir,SUM(t.target) AS target_month,SUM(t.realisasi) AS realisasi_month, s.satuan, k.id_tim, mt.tim FROM `m_jeniskegiatan` m INNER JOIN t_kegiatan t ON m.id_jeniskegiatan = t.id_jeniskegiatan LEFT JOIN m_listkegiatan l ON m.nama_kegiatan = l.id LEFT JOIN m_satuan s ON m.satuan = s.id_satuan LEFT JOIN m_kegiatan k ON l.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim mt ON k.id_tim = mt.id_tim WHERE MONTH(m.mulai) <= '$bulanini' AND MONTH(t.batas_minggu) >= '$bulanini' GROUP by m.id_jeniskegiatan) AS a JOIN ( SELECT id_jeniskegiatan, SUM(target) AS target_kum, SUM(realisasi) AS realisasi_kum FROM t_kegiatan GROUP BY id_jeniskegiatan) AS b ON a.id_jeniskegiatan = b.id_jeniskegiatan ORDER BY a.id_tim ASC, a.id_jeniskegiatan ASC")->result();
			$a['data3']          = $this->db->query("SELECT * FROM (SELECT jnsk.*,t.target AS target_mingguan,t.batas_minggu,t.realisasi AS real_mingguan, s.satuan as nama_satuan, subk.nama_kegiatan as nmkegiatan, k.* FROM m_jeniskegiatan jnsk LEFT JOIN m_satuan s ON jnsk.satuan = s.id_satuan LEFT JOIN m_listkegiatan subk on jnsk.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan JOIN t_kegiatan t on jnsk.id_jeniskegiatan = t.id_jeniskegiatan WHERE ((MONTH(jnsk.mulai)<='$bulanini' AND jnsk.batas_waktu>'$lfridaylmonth') OR (MONTH(jnsk.mulai) > '$bulanini' AND jnsk.mulai<='$lastfriday')) and MONTH(t.batas_minggu) = '$bulanini' and YEAR(jnsk.batas_waktu)='$tahun') AS kegiatan JOIN (SELECT id_jeniskegiatan, SUM(target) AS total_target, SUM(realisasi) AS total_realisasi FROM t_kegiatan GROUP BY id_jeniskegiatan) AS total_target ON kegiatan.id_jeniskegiatan = total_target.id_jeniskegiatan ORDER BY kegiatan.batas_waktu asc")->result();
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
		$id_kabkota			= $this->uri->segment(5);
		//$id_kabkota				= $this->session->userdata('admin_nip');
		$tahun					= $this->session->userdata('admin_ta');
		
		if ($mau_ke == "pilih_kegiatan")
		{
			if($id_bulan == '00')
			{
				if($id_kabkota == '6500')
				{
					$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
					$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
				else
				{
					//$id_kabkota 		= $this->session->userdata('admin_user');
					$a['data']			= $this->db->query("select t.id_kab,t.id_jeniskegiatan, m.nama_kegiatan,u.unitkerja, m.batas_waktu, t.target, t.realisasi, t.batas_minggu, s.satuan,t.tgl_entri,t.flag_konfirm from t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on m.satuan=s.id_satuan where t.id_kab='$id_kabkota' and and YEAR(batas_waktu)='$tahun' t.target <> '0' order by t.id_jeniskegiatan asc, m.batas_waktu asc")->result();
					$a['page']			= "l_kegiatanunitkerjakabkotafilter";
					//$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,t.id_kab,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join t_kegiatan t on k.id_jeniskegiatan=t.id_jeniskegiatan  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and t.id_kab='$id_kabkota' and t.target <> '0' order by k.batas_waktu desc")->result();
					//$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
				
			}
			else
			{
				if($id_kabkota == '6500')
				{
					$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on k.satuan=s.id_satuan   where YEAR(k.batas_waktu)='$tahun' and MONTH(k.batas_waktu)='$id_bulan' order by k.batas_waktu desc")->result();
					$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
				else
				{
					$a['data']			= $this->db->query("select t.id_kab,t.id_jeniskegiatan, m.nama_kegiatan,u.unitkerja, m.batas_waktu, t.target, t.realisasi, s.satuan,t.tgl_entri,t.flag_konfirm, t.batas_minggu from t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on m.satuan=s.id_satuan where t.id_kab='$id_kabkota' and MONTH(t.batas_minggu)>=('$id_bulan'-1) and MONTH(t.batas_minggu)<=('$id_bulan'+1) and YEAR(batas_waktu)='$tahun' and t.target <> '0' order by t.id_jeniskegiatan asc, m.batas_waktu asc, t.batas_minggu asc")->result();
					$a['page']			= "l_kegiatanunitkerjakabkotafilter";
					//$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,t.id_kab,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja left join t_kegiatan t on k.id_jeniskegiatan=t.id_jeniskegiatan  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and t.id_kab='$id_kabkota' and MONTH(k.batas_waktu)='$id_bulan'  and t.target <> '0' order by k.batas_waktu desc")->result();
					//$a['page']			= "l_kegiatanunitkerjakabkota";	
				}
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']		= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$id_bulan'")->row();	
			$a['datprogress']	= $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$id_bulan' and k.target <> '0'")->result();		
			$a['wilayah']   = $this->db->query("SELECT * FROM m_kab")->result();
			$a['page']			= "v_kegiatan_unitkerja_detail";
		}
		else
		{
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['data']			= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan  where YEAR(k.batas_waktu)='$tahun' and MONTH(k.batas_waktu)='$bulanini' order by substring(k.id_jeniskegiatan,1,5) asc")->result();
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
		$id_kabkota				= $this->session->userdata('admin_nip');
		$tahun					= $this->session->userdata('admin_ta');
		
		if ($mau_ke == "pilih_kegiatan")
		{
			if($id_bulan == '00')
			{
				$hariini			= date("d-m-Y");
				$bulanini 			= substr($hariini,3,2);
				//$id_kabkota 		= $this->session->userdata('admin_user');
				$a['data']			= $this->db->query("select t.id_kab,t.id_jeniskegiatan, m.nama_kegiatan,u.unitkerja, m.mulai, m.batas_waktu, t.target, t.realisasi, s.satuan,t.tgl_entri,t.flag_konfirm from t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja left join m_satuan s on m.satuan=s.id_satuan where t.id_kab='$id_kabkota' and YEAR(m.batas_waktu) = '$tahun' order by t.id_jeniskegiatan asc, t.minggu_ke asc, m.batas_waktu asc")->result();
				$a['data2']		= $this->db->query("SELECT * FROM (SELECT m.id_jeniskegiatan,l.nama_kegiatan,m.mulai,m.batas_waktu, MAX(t.batas_minggu) AS batas_minggu_akhir,SUM(t.target) AS target_month,SUM(t.realisasi) AS realisasi_month, s.satuan, k.id_tim, mt.tim FROM `m_jeniskegiatan` m INNER JOIN t_kegiatan t ON m.id_jeniskegiatan = t.id_jeniskegiatan LEFT JOIN m_listkegiatan l ON m.nama_kegiatan = l.id LEFT JOIN m_satuan s ON m.satuan = s.id_satuan LEFT JOIN m_kegiatan k ON l.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim mt ON k.id_tim = mt.id_tim WHERE MONTH(m.mulai) <= '$id_bulan' AND MONTH(t.batas_minggu) >= '$id_bulan' AND t.id_kab = '$id_kabkota' GROUP by m.id_jeniskegiatan) AS a JOIN ( SELECT id_jeniskegiatan, SUM(target) AS target_kum, SUM(realisasi) AS realisasi_kum FROM t_kegiatan WHERE id_kab = '$id_kabkota' GROUP BY id_jeniskegiatan) AS b ON a.id_jeniskegiatan = b.id_jeniskegiatan ORDER BY a.id_tim ASC, a.id_jeniskegiatan ASC;")->result();
				$a['page']			= "l_unitkerjakabkotadetail";	
			}
			else
			{
				$hariini			= date("d-m-Y");
				$bulanini 			= substr($hariini,3,2);
				//$id_kabkota 		= $this->session->userdata('admin_user');
				$a['data']          = $this->db->query("SELECT t.*, subk.nama_kegiatan as nmkegiatan, m.batas_waktu, u.tim, s.satuan FROM t_kegiatan t LEFT JOIN m_jeniskegiatan m ON t.id_jeniskegiatan=m.id_jeniskegiatan LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim u ON k.id_tim = u.id_tim LEFT JOIN m_satuan s ON m.satuan=s.id_satuan WHERE t.id_kab=$id_kabkota AND MONTH(t.batas_minggu)>=('$id_bulan'-1) AND MONTH(t.batas_minggu)<=('$id_bulan'+1) AND YEAR(t.batas_minggu)='$tahun' ORDER BY t.id_jeniskegiatan ASC ")->result();
				$a['data2']		= $this->db->query("SELECT * FROM (SELECT m.id_jeniskegiatan,l.nama_kegiatan,m.mulai,m.batas_waktu, MAX(t.batas_minggu) AS batas_minggu_akhir,SUM(t.target) AS target_month,SUM(t.realisasi) AS realisasi_month, s.satuan, k.id_tim, mt.tim FROM `m_jeniskegiatan` m INNER JOIN t_kegiatan t ON m.id_jeniskegiatan = t.id_jeniskegiatan LEFT JOIN m_listkegiatan l ON m.nama_kegiatan = l.id LEFT JOIN m_satuan s ON m.satuan = s.id_satuan LEFT JOIN m_kegiatan k ON l.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim mt ON k.id_tim = mt.id_tim WHERE MONTH(m.mulai) <= '$id_bulan' AND MONTH(t.batas_minggu) >= '$id_bulan' AND t.id_kab = '$id_kabkota' GROUP by m.id_jeniskegiatan) AS a JOIN ( SELECT id_jeniskegiatan, SUM(target) AS target_kum, SUM(realisasi) AS realisasi_kum FROM t_kegiatan WHERE id_kab = '$id_kabkota' GROUP BY id_jeniskegiatan) AS b ON a.id_jeniskegiatan = b.id_jeniskegiatan ORDER BY a.id_tim ASC, a.id_jeniskegiatan ASC;")->result();
				$a['page']			= "l_unitkerjakabkotadetail";	
			}
		}

		else
		{
			$hariini			= date("d-m-Y");
			$bulanini 			= substr($hariini,3,2);
			//$id_kabkota 		= $this->session->userdata('admin_user');
			$a['data']          = $this->db->query("SELECT t.*, subk.nama_kegiatan as nmkegiatan, m.batas_waktu, u.tim, s.satuan FROM t_kegiatan t LEFT JOIN m_jeniskegiatan m ON t.id_jeniskegiatan=m.id_jeniskegiatan LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim u ON k.id_tim = u.id_tim LEFT JOIN m_satuan s ON m.satuan=s.id_satuan WHERE t.id_kab=$id_kabkota AND MONTH(t.batas_minggu)>=('$bulanini'-1) AND MONTH(t.batas_minggu)<=('$bulanini'+1) AND YEAR(t.batas_minggu)='$tahun' ORDER BY k.id_tim ASC, t.id_jeniskegiatan ASC ")->result();
			$a['data2']		= $this->db->query("SELECT * FROM (SELECT m.id_jeniskegiatan,l.nama_kegiatan,m.mulai,m.batas_waktu, MAX(t.batas_minggu) AS batas_minggu_akhir,SUM(t.target) AS target_month,SUM(t.realisasi) AS realisasi_month, s.satuan, k.id_tim, mt.tim FROM `m_jeniskegiatan` m INNER JOIN t_kegiatan t ON m.id_jeniskegiatan = t.id_jeniskegiatan LEFT JOIN m_listkegiatan l ON m.nama_kegiatan = l.id LEFT JOIN m_satuan s ON m.satuan = s.id_satuan LEFT JOIN m_kegiatan k ON l.id_kegiatan = k.id_kegiatan LEFT JOIN m_tim mt ON k.id_tim = mt.id_tim WHERE MONTH(m.mulai) <= '$bulanini' AND MONTH(t.batas_minggu) >= '$bulanini' AND t.id_kab = '$id_kabkota' GROUP by m.id_jeniskegiatan) AS a JOIN ( SELECT id_jeniskegiatan, SUM(target) AS target_kum, SUM(realisasi) AS realisasi_kum FROM t_kegiatan WHERE id_kab = '$id_kabkota' GROUP BY id_jeniskegiatan) AS b ON a.id_jeniskegiatan = b.id_jeniskegiatan ORDER BY a.id_tim ASC, a.id_jeniskegiatan ASC;")->result();
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
				$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['page']			= "l_kegiatanunitkerjauntukkab";	
			}
			else
			{
				$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun'  order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' and MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' and MONTH(batas_waktu)='$idu' and YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' and MONTH(batas_waktu)='$idu' and  YEAR(batas_waktu)='$tahun' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
				$a['page']			= "l_kegiatanunitkerjauntukkab";	
			}
		}
		else if($mau_ke == "view")
		{
			$a['datview']	= $this->db->query("select m.*,s.satuan as nama_satuan from m_jeniskegiatan as m left join m_satuan s on m.satuan=s.id_satuan where m.id_jeniskegiatan='$idu'")->row();	
			$a['datprogress'] = $this->db->query("select k.*,m.nama_kegiatan,round((k.realisasi/k.target*100),2) as persen,w.nama_kab as nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan=m.id_jeniskegiatan inner join m_kab w on k.id_kab=w.id_kab where k.id_jeniskegiatan='$idu' ORDER BY ")->result();		
			$a['page']		= "v_kegiatan_unitkerja_detailkab";
		}
		else
		{
			$hariini=date("d-m-Y");
			$bulanini = substr($hariini,3,2);
			$a['dataall']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen FROM m_jeniskegiatan where YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datatu']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='921' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datasos']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='922' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataprod']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='923' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datadist']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='924' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['datanerwil']	= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='925' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
			$a['dataipds']		= $this->db->query("SELECT *,round((realisasi/target*100),2) as persen  FROM m_jeniskegiatan where substring(id_jeniskegiatan,1,3)='926' and YEAR(batas_waktu)='$tahun' and MONTH(batas_waktu)='$bulanini' order by substring(id_jeniskegiatan,1,5) asc , substring(id_jeniskegiatan,10,2) asc ")->result();
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
				if($this->session->userdata('admin_user') == "6500"|| $this->session->userdata('admin_nip') == '921' || $this->session->userdata('admin_nip') == '922' || $this->session->userdata('admin_nip') == '923' || $this->session->userdata('admin_nip') == '924' || $this->session->userdata('admin_nip') == '925' || $this->session->userdata('admin_nip') == '926')
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
					
						//perubahan 2 Februari 2023
						//sebelum 2 Februari 2023
						/*if($persen_realisasi >= '95' && $persen_realisasi <= '100')
						{
							$nilai_volume = '4';
						}*/
						//setelah 2 Februari 2023
						if($persen_realisasi >= '95')
						{
							$nilai_volume = '4';
						}
						//end of perubahan 2 Februari 2023
						
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
						
						//Sebelum 22 Maret 2022	
						/*if($selisih_pengiriman >= '2' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="4";
						}
						else if($selisih_pengiriman == '1' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="3";
						}
						else if($selisih_pengiriman == '0' && $datetime1 == $datetime2)
						{
							$nilai_deadline ="2";
						}
						else
						{
							$nilai_deadline ="1";
						}*/

						//--Perubahan 22 Maret 2022
						if($datetime1 <= $datetime2)
						{
							$nilai_deadline ="4";
						}else
						{
							$nilai_deadline ="3";
						}
						//--End of Perubahan 22 Maret 2022
						
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
						redirect('index.php/admin/kegiatan/view/'.$id_jeniskegiatan);
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
						
						//perubahan 2 Februari 2023
						//sebelum 2 Februari 2023
						/*if($persen_realisasi >= '95' && $persen_realisasi <= '100')
						{
							$nilai_volume = '4';
						}*/
						//setelah 2 Februari 2023
						if($persen_realisasi >= '95')
						{
							$nilai_volume = '4';
						}
						//end of perubahan 2 Februari 2023
						
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
						
						//Sebelum 22 Maret 2022	
						/*if($selisih_pengiriman >= '2' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="4";
						}
						else if($selisih_pengiriman == '1' && $datetime1 < $datetime2)
						{
							$nilai_deadline ="3";
						}
						else if($selisih_pengiriman == '0' && $datetime1 == $datetime2)
						{
							$nilai_deadline ="2";
						}
						else
						{
							$nilai_deadline ="1";
						}*/
						
						//--Perubahan 22 Maret 2022
						if($datetime1 <= $datetime2)
						{
							$nilai_deadline ="4";
						}else
						{
							$nilai_deadline ="3";
						}
						//--End of Perubahan 22 Maret 2022
						
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
						redirect('index.php/admin/kegiatan/view/'.$id_jeniskegiatan);
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
			$minggu                 = $this->uri->segment(6);
			
			$cari					= addslashes($this->input->post('q'));

		//ambil variabel post
			$id_jeniskegiatan		= addslashes($this->input->post('id_jeniskegiatan'));
			$nama_kegiatan			= addslashes($this->input->post('nama_kegiatan'));
			$target					= addslashes($this->input->post('target'));
			$realisasi				= addslashes($this->input->post('realisasi'));
			$bukti					= addslashes($this->input->post('bukti'));
			$newrealisasi			= addslashes($this->input->post('newrealisasi'));
			$link_pengiriman		= addslashes($this->input->post('link_pengiriman'));
			$keterangan             = addslashes($this->input->post('keterangan'));
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
				$a['datpil']	= $this->db->query("SELECT k.*,subk.nama_kegiatan as nmkegiatan,w.nama_kab FROM t_kegiatan k inner join m_jeniskegiatan m on k.id_jeniskegiatan = m.id_jeniskegiatan inner join m_kab w on  k.id_kab=w.id_kab LEFT JOIN m_listkegiatan subk ON m.nama_kegiatan = subk.id WHERE k.id_jeniskegiatan = '$idu' and k.id_kab='$kabkota' and k.minggu_ke = '$minggu'")->row();	
				$a['page']		= "f_entry_unitkerjakab";
			} 
			else if ($mau_ke == "act_edt")
			{
				$id_kabkota 				= $this->session->userdata('admin_nip');
				$minggu                     = $this->uri->segment(4);
				
				$dataprov                   = $this->db->query("select realisasi, batas_waktu from m_jeniskegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan'")->row();
				$datakab                    = $this->db->query("select target, realisasi, minggu_ke from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' and batas_minggu<='$minggu' ORDER BY batas_minggu")->result();
				$datakabmingguini           = $this->db->query("SELECT realisasi, batas_minggu from t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' and batas_minggu='$minggu' ")->row();
				
				$realisasiprov              = $dataprov->realisasi;
				$realisasiprovnew           = ($dataprov->realisasi) - ($datakabmingguini->realisasi) + $newrealisasi;
				
				$targetkumkab               = 0;
				$realisasikumkab            = 0;
				for($i = 0; $i < count($datakab); $i++){
				    if($i < (count($datakab)-1)){
				        $targetkumkab       = $targetkumkab + $datakab[$i]->target;
				        $realisasikumkab    = $realisasikumkab + $datakab[$i]->realisasi;
				    }else{
				        $targetkumkab       = $targetkumkab + $datakab[$i]->target;
				        $realisasikumkab    = $realisasikumkab + $newrealisasi;
				        if($targetkumkab == 0){
				            if($realisasikumkab == 0){
				                $persen_realisasi   ='100';
				            }else{
				                $persen_realisasi   ='150';
				            }
				        }else{
				            $persen_realisasi   = round($realisasikumkab/$targetkumkab*100,2);
				        }
				    }
				}
				
				$batas_waktu                = new DateTime($dataprov->batas_waktu);
				$batas_minggu               = new DateTime($datakabmingguini->batas_minggu);
				$tglentriconvert			= new DateTime($tgl_entri);
				
				$newformatbatas_waktu		= date_format($batas_waktu,"d-m-Y");
				$newformatbatas_minggu      = date_format($batas_minggu,"d-m-Y");
				$newformattgl_entri			= date_format($tglentriconvert,"d-m-Y");
				
				$datetime1 					= new DateTime($newformatbatas_waktu);
				$datetime2 					= new DateTime($newformatbatas_minggu);
				$datetime3                  = new DateTime($newformattgl_entri);

				//nilai realisasi kumulatif
				if($persen_realisasi >= '100'){
				    $nilai_volume           = 3;
				}
				elseif($persen_realisasi >= '90' && $persen_realisasi < '100'){
				    $nilai_volume           = 2;
				}else{
				    $nilai_volume           = 1;
				}
				
				//nilai tanggal entri
				if($datetime2 < $datetime1){
				    if($datetime3 <= $datetime2){
				        $nilai_deadline     = 2;
				    }elseif($datetime3 > $datetime2){
				        $nilai_deadline     = 1;
				    }
				    $diff                   = $datetime3->diff($datetime2);
				    $selisih_pengiriman     = $diff->d;
				}else{
				    if($datetime3 <= $datetime1){
				        $nilai_deadline     = 2;
				    }elseif($datetime3 > $datetime1){
				        $nilai_deadline     = 1;
				    }
				    $diff                   = $datetime3->diff($datetime2);
				    $selisih_pengiriman     = $diff->d;
				}
				
				$this->db->query("UPDATE t_kegiatan SET realisasi = '$newrealisasi', tgl_entri = '$tgl_entri', flag_konfirm='2', bukti='$bukti', persen_realisasi='$persen_realisasi', link_pengiriman='$link_pengiriman', selisih_pengiriman='$selisih_pengiriman', nilai_volume='$nilai_volume', nilai_deadline='$nilai_deadline' WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' AND batas_minggu='$minggu' ");
				$this->db->query("UPDATE m_jeniskegiatan SET realisasi = '$realisasiprovnew' WHERE id_jeniskegiatan = '$id_jeniskegiatan'");
				
				/* == Menambahkan ke Tabel Notifikasi == */
			$querytujuan            = $this->db->query("SELECT k.id_tim FROM m_listkegiatan subk LEFT JOIN m_kegiatan k ON subk.id_kegiatan = k.id_kegiatan WHERE subk.id = SUBSTRING($id_jeniskegiatan,5,4)")->row();
			$tujuan                 = $querytujuan->id_tim;
			$queryidt               = $this->db->query("SELECT id FROM t_kegiatan WHERE id_jeniskegiatan = '$id_jeniskegiatan' and id_kab='$id_kabkota' AND batas_minggu='$minggu' LIMIT 1")->row();
			$idt                    = $queryidt->id;
			$created_on             = date('Y-m-d H:i:s');
			$this->db->query("INSERT INTO t_notifikasi VALUES ('','$id_kabkota', '1', '$tujuan','$idt','$id_jeniskegiatan' ,'1','$created_on')");
			/* == Akhir Menambahkan ke Tabel Notifikasi == */
				
				
				redirect('index.php/admin/unitkerjakabkotadetail/');
			} 
			
			$this->load->view('admin/index', $a);
		}
		
		
		
		public function laporan_kab()
		{
	    //variabel untuk select dropdown
	//	$kab = $this->input->get('pilih_kab');
			$bulan = $this->input->get('bln');
	//	$tahun = $this->input->get('Tahun');
			
		//tes highchart
		//$a['report'] = $this->M_kelolakegiatan->report($kab, $bulan, $tahun);
			$a['report'] = $this->M_kelolakegiatan->report($bulan);
		//$this->load->view('dashboard', $a);

		//$this->load->model('M_kelolakegiatan');
		//$hasil = $this->M_kelolakegiatan->cobaLaporan($kab, $bulan, $tahun);
			$hasil = $this->M_kelolakegiatan->cobaLaporan($bulan);
			$a['hasil'] = $hasil;
			$a['page']	= "laporan_kab";
	//	$a['kab'] = $kab;
			$a['bulan'] = $bulan;
	//	$a['tahun'] = $tahun;
			
			$this->load->view('admin/index', $a);

			$this->input->get();
			
			
		//variabel untuk select dropdown
		/*$kab = $this->input->get('pilih_kab');
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
		*/
	}
	
	public function laporan_pengguna()
	{
	    //variabel untuk select dropdown
		$bulan = $this->input->get('bln');
		$a['report'] = $this->M_kelolakegiatan->reportuser($bulan);
		$hasiluser = $this->M_kelolakegiatan->cobaLaporanUser($bulan);
		$a['hasiluser'] = $hasiluser;
		$a['page']	= "laporan_pengguna";
		$a['bulan'] = $bulan;
		
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
				if($this->session->userdata('admin_user') != '6500')
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
				if($this->session->userdata('admin_user') != '6500')
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
			if($this->session->userdata('admin_user') != '6500')
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
	
	
	
	public function duplikasikegiatan()
	{
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		$act					= $this->uri->segment(3);
		
		$user  = $this->session->userdata('admin_nip');
		$tahun = $this->session->userdata('admin_ta');
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		
		if ($this->session->userdata('admin_user') == "rizchi" || $this->session->userdata('admin_user') == "6500" ) {
			if($this->uri->segment(3)) $user = $this->uri->segment(3);
			if($this->uri->segment(4)) $bulanini = $this->uri->segment(4);
			
			if($user && $bulanini)
				$a['datakegiatan']	= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u 
					on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where substring(id_jeniskegiatan,1,3)='$user' and MONTH(k.batas_waktu) = '$bulanini' and YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
		} else {
			$a['datakegiatan']	= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u 
				on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where substring(id_jeniskegiatan,1,3)='$user' and MONTH(k.batas_waktu) = '$bulanini' and YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
		}
		
		if($act == 'duplikat' )
		{
			if( $this->input->post('duplikat') != false )
			{
				$duplikat=$this->input->post('duplikat');
				foreach($duplikat as $id_jeniskegiatan)
				{
					$datakegiatanduplikasi =$this->db->query("Select * from t_kegiatan where id_jeniskegiatan ='$id_jeniskegiatan'")->result();	
					
					$masterkegiatanduplikasi=$this->db->query("Select * from m_jeniskegiatan where id_jeniskegiatan ='$id_jeniskegiatan'")->row();
					$tglBatassekarang=$masterkegiatanduplikasi->batas_waktu;
					
					$tanggal			= substr($tglBatassekarang,0,2);
					$bulan				= addslashes($this->input->post('bulan_duplikasi'));
					$tahun				= addslashes($this->input->post('tahun_duplikasi'));
					//$tahun				= $this->session->userdata('admin_ta');
					$tglbatasgabungan 	= $tahun.'-'.$bulan.'-'.$tanggal;
					$tglbatasbaru		= new DateTime($tglbatasgabungan);
					
					$bataswaktuplussatu = new DateTime($tglbatasgabungan);
					date_modify($bataswaktuplussatu, '+1 day');
					$bataslewat = date_format($bataswaktuplussatu, 'Y-m-d');
					
					$nama_kegiatan = $masterkegiatanduplikasi->nama_kegiatan;
					$satuan = $masterkegiatanduplikasi->satuan;
					$dasar_surat = $masterkegiatanduplikasi->dasar_surat;
					
					
					$tglBataswaktu = date('Y-m-d', strtotime('+1 months', strtotime($tglBatassekarang)));
					//$bataswaktuplussatu = new DateTime($tglBataswaktu);
					//date_modify($bataswaktuplussatu, '+1 day');
					//$bataslewat = date_format($bataswaktuplussatu, 'Y-m-d');
					
					
					$unitkerja = substr($id_jeniskegiatan,0,5);
					$query = $this->db->query("select max(convert((substring(id_jeniskegiatan,10,length(id_jeniskegiatan-9))),SIGNED INTEGER)) as maxID from m_jeniskegiatan where substring(id_jeniskegiatan,6,4)='$tahun' and substring(id_jeniskegiatan,1,5)='$unitkerja'")->row();

					$idMax = $query->maxID;
					$noUrut = (int)$idMax;
					$noUrut++;
					$id_jeniskegiatannew = $unitkerja.''.$tahun.''.sprintf("%03s",$noUrut);
					$targetkabkumulatif=0;
					foreach ($datakegiatanduplikasi as $d) 
					{
						$targetkabkumulatif+=$d->target;
						$this->db->query("INSERT INTO t_kegiatan VALUES (NULL,'$id_jeniskegiatannew','$d->id_kab','$d->target',0,'$bataslewat','1','-','0','-','-1','0','0','','','0','')");
					}
					//$this->db->query("INSERT INTO m_jeniskegiatan VALUES (NULL,'$id_jeniskegiatannew', '$nama_kegiatan', $targetkabkumulatif,0, '$satuan', '$tglBataswaktu','$dasar_surat')");
					$this->db->query("INSERT INTO m_jeniskegiatan VALUES (NULL,'$id_jeniskegiatannew', '$nama_kegiatan', $targetkabkumulatif,0, '$satuan', '$tglbatasgabungan','$dasar_surat')");
				}
			}
		}			
		else if($act == 'pilih_kegiatanduplikasi')
		{
			$id_bulan				= $this->uri->segment(4);
			$id_tahun				= $this->uri->segment(5);
			$a['datakegiatan']	= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u 
				on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where substring(id_jeniskegiatan,1,3)='$user' and MONTH(k.batas_waktu) = '$id_bulan' and YEAR(k.batas_waktu)='$id_tahun' order by k.batas_waktu desc")->result();
		}
		else
		{
			$a['datakegiatan']	= $this->db->query("SELECT k.*,u.unitkerja,s.satuan as nama_satuan FROM m_jeniskegiatan k left join m_unitkerja u 
				on substring(k.id_jeniskegiatan,1,5) = u.id_unitkerja  left join m_satuan s on k.satuan=s.id_satuan where substring(id_jeniskegiatan,1,3)='$user' and MONTH(k.batas_waktu) = '$bulanini' and YEAR(k.batas_waktu)='$tahun' order by k.batas_waktu desc")->result();
		}
		$a['page']	= "l_duplikasikegiatan";
		$this->load->view('admin/index', $a);
	}

	public function login_sso()
	{
		$provider = new JKD\SSO\Client\Provider\Keycloak([
			'authServerUrl'         => 'https://sso.bps.go.id',
			'realm'                 => 'pegawai-bps',
			'clientId'              => '13300-evita-4ed',
			'clientSecret'          => 'ef75e3c8-88d8-4c57-a2a7-7732a924144f',
			'redirectUri'           => 'https://webapps.bps.go.id/jateng/evita/index.php/admin/login_sso'
		]);

		if (!isset($_GET['code'])) {

		    // Untuk mendapatkan authorization code
			$authUrl = $provider->getAuthorizationUrl();
			$_SESSION['oauth2state'] = $provider->getState();
			header('Location: '.$authUrl);
			exit;

		// Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
		} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

			unset($_SESSION['oauth2state']);
			exit('Invalid state');

		} else {

			try {
				$token = $provider->getAccessToken('authorization_code', [
					'code' => $_GET['code']
				]);
			} catch (Exception $e) {
				exit('Gagal mendapatkan akses token : '.$e->getMessage());
			}

		    // Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
			try {

				$user 			= $provider->getResourceOwner($token);
				$organisasi 	= $user->getKodeOrganisasi();
				
				if(substr($organisasi,0,2)=='65'){  
					$admin_level 	= substr($organisasi,2,2)=='00' ? 'userprov' : 'userkabkota'; 
		        //$admin_user 	= substr($organisasi,2,2)=='00' ? '335'.substr($organisasi,9,1) : substr($organisasi,0,4);
					$data = array(
						'admin_id'		=> $user->getNip(),
						'admin_user' 	=> $admin_user,
						'admin_nama' 	=> $user->getName(),
						'admin_ta' 		=> date('Y'),
						'admin_level' 	=> $admin_level,
						'admin_valid' 	=> true,
						'username'		=> $user->getUsername(),
						'access_token'	=> $token->getToken(),
						'logout_url'    => $provider->getLogoutUrl(),
					);
					$this->session->set_userdata($data);

					$username = $this->session->userdata('username');
					date_default_timezone_set("Asia/Bangkok");
					$logindate = date('Y-m-d H:i:s');
					$this->db->query("INSERT INTO evita_userlog VALUES (NULL,'$username','login','$logindate','')");

					redirect('index.php/admin');
				} else {
					echo 'Anda login SSO sebagai <b>'.$user->getName().'</b> ['.substr($organisasi,0,4).'] .<br>';
					echo 'Wilayah Anda tidak terdaftar dalam sistem ini.<br>';
					echo 'Silakan '.anchor($provider->getLogoutUrl(),'logout SSO').' terlebih dahulu';
                //$this->session->sess_destroy();
					exit();
				}

/*		        $userdata = array(
			            'nama'          => $user->getName(),
			            'niplama'       => $user->getNip(),
			            'nipbaru'       => $user->getNipBaru(),
			            'id_wilayah'    => substr($organisasi, 0, 4),
			            'id_unitkerja'  => substr($organisasi, 7, 4),
			            'url_foto'      => $user->getUrlFoto(),
			            'url_logout'    => $provider->getLogoutUrl(),
			        );
		        $_SESSION['userdata'] = $userdata;
*/		        
		    } catch (Exception $e) {
		    	exit('Gagal Mendapatkan Data Pengguna: '.$e->getMessage());
		    }

		    // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
//		    $access_token   = $token->getToken();
		}
//		echo '<pre>'; print_r($_SESSION); echo '</pre>';

	}

	public function info_sso()
	{
		echo '<pre>'; print_r($_SESSION); echo '</pre>';
	}
	
	public function set_tahun($tahun=null)
	{
		if(!$tahun)
			$tahun=date('Y');
		
		$this->session->set_userdata('admin_ta',$tahun);
		redirect('index.php/admin/index');
	}
	
    //tambahan 22 Januari 2021
	public function laporan_bagbid()
	{
		//variabel untuk select dropdown
		$bulan = $this->input->get('bln');
		
		//tes highchart
		$a['reportlaporanbagbid'] = $this->M_kelolakegiatan->laporanbagbid($bulan);
		//$this->load->view('dashboard', $a);

		//$this->load->model('M_kelolakegiatan');
		//$hasil = $this->M_kelolakegiatan->cobaLaporan($kab, $bulan, $tahun);
		$hasillaporanbagbid = $this->M_kelolakegiatan->cobalaporanbagbid($bulan);
		$a['hasillaporanbagbid'] = $hasillaporanbagbid;
		$a['page']	= "laporan_bagbid";
		$a['bulan'] = $bulan;
		
		$this->load->view('admin/index', $a);
		
		$this->input->get();
		
	}
	
	function getPegawaiTerpilih($nip){
		$db2 = $this->load->database('db2',TRUE);
		$pegawai = $db2->query("SELECT gelar_depan, nama, gelar_belakang FROM master_pegawai WHERE niplama='$pj_kab' LIMIT 1");
		return $pegawai->row();
	}
	
	function getsatuan(){
		$id_subkegiatan = $this->uri->segment(3);
		$datasatuan=$this->M_getfunction->getsatuan($id_subkegiatan);
		echo json_encode($datasatuan);
	}
	
	function getsubkegiatan(){
		$id_kegiatan = $this->uri->segment(3);
		$subkegiatan=$this->M_getfunction->getsubkegiatan($id_kegiatan);
		echo json_encode($subkegiatan);
	}
	
	function getjumat(){
		$fday       = date("d-m-Y", strtotime($this->uri->segment(3)));
		$lday       = date("d-m-Y", strtotime($this->uri->segment(4)));
		$ffriday    = date("d-m-Y", strtotime("this Friday".$fday));
		$lfriday    = date("d-m-Y", strtotime("this Friday".$lday));
		$sfriday    = floor((strtotime($lfriday)-strtotime($ffriday)) / (60 * 60 * 24));
		$jfriday    = $sfriday/7+1  ;
		$friday[0]  = date("Y-m-d", strtotime($ffriday));
		$friday2[0] = tgl_jam_sql($friday[0]);
		
        /*if($sfriday == 0){
            if(date("N", strtotime($lday)) == 6 || date("N", strtotime($lday)) == 7){
                $friday[0]  = date("Y-m-d", strtotime("previous Friday".$friday[0]));
            };
        }else{
            $jfriday = $sfriday/7+1;
            if(($lfriday-$lday) >= 5){
                $jfriday--;
            }
        };*/
        
        if($sfriday > 0){
        	for($i = 1; $i < $jfriday; $i++){
        		$friday[$i] = date("Y-m-d", strtotime('next friday'.$friday[$i-1]));
        		$friday2[$i] = tgl_jam_sql($friday[$i]);
        	}
        }
        $data   =  array("jfriday" => $jfriday,
        	"friday" => $friday,
        	"friday2" => $friday2,);
        echo json_encode($data);
    }
}
