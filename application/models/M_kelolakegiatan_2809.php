<?php
class M_kelolakegiatan extends CI_Model{
    private $table="t_data";
    
    function cek($id,$data){
        $this->db->where("id",$id);
        $this->db->where("data",$data);
        return $this->db->get("t_data");
    }
    
    function semua($limit=10,$offset=0,$order_column='',$order_type='asc'){
       // return $this->db->get("m_kab");
	    if(empty($order_column) || empty($order_type))
            $this->db->order_by($this->primary,'asc');
        else
            $this->db->order_by($order_column,$order_type);
        return $this->db->get($this->table,$limit,$offset);
    }
    
	function semuabyskpd($limit=10,$offset=0,$order_column='',$order_type='asc'){
       // return $this->db->get("m_kab");
	   $skpd=$this->session->userdata('level');
	    if(empty($order_column) || empty($order_type))
			{$this->db->where("skpd1",$skpd);
			$this->db->or_where("skpd2",$skpd);
            $this->db->order_by($this->primary,'asc');}
        else
			{$this->db->where("skpd1",$skpd);
			$this->db->or_where("skpd2",$skpd);
            $this->db->order_by($order_column,$order_type);}
        return $this->db->get($this->table,$limit,$offset);
    }
	
	function jumlah(){
        return $this->db->count_all($this->table);
    }
	
    function cekKode($kode){
        $this->db->where("kode_indikator",$kode);
        return $this->db->get("m_indikator");
    }
	
	function viewdata($kode){
        $this->db->select('d.data,d.id_kab,k.nama_kab,i.nama_indikator,t.tahun,d.kode_indikator,d.flag,d.id,d.username,d.level');
		$this->db->from('t_data as d');
		$this->db->join('m_indikator as i', 'd.kode_indikator = i.kode_indikator');
		$this->db->join('m_tahun as t', 'd.tahun = t.id');
		$this->db->join('m_kab as k', 'd.id_kab = k.id_kab');	
		$this->db->where("d.kode_indikator",$kode);
        return $this->db->get();
    }
	
	
	function viewdataringkas($kode){
        $this->db->select('distinct(d.kode_indikator),d.data, i.nama_indikator,t.tahun,d.flag,d.id,d.username,d.level');
		$this->db->from('t_data as d');
		$this->db->join('m_indikator as i', 'd.kode_indikator = i.kode_indikator');
		$this->db->join('m_tahun as t', 'd.tahun = t.id');
		$this->db->where("d.kode_indikator",$kode);
		$this->db->where("d.id_kab",'3301');
        return $this->db->get();
    }
	
	function viewsdata($kode,$level){
        $this->db->select('d.data,d.id_kab,,k.nama_kab,i.nama_indikator,t.tahun,d.kode_indikator,d.flag,d.id,d.username,d.level');
		$this->db->from('t_data as d');
		$this->db->join('m_indikator as i', 'd.kode_indikator = i.kode_indikator');
		$this->db->join('m_tahun as t', 'd.tahun = t.id');
		$this->db->join('m_kab as k', 'd.id_kab = k.id_kab');	
		$this->db->where("d.kode_indikator",$kode);
		$this->db->where("d.level",$level);
        return $this->db->get();
    }
	
	function cekDataEdit($tahun, $kode_indikator){
        $this->db->select('d.data, i.nama_indikator,h.tahun,d.kode_indikator,d.kode_goal,d.kode_target,d.flag,t.nama_target, g.nama_goal,d.id');
		$this->db->from('t_data as d');
		$this->db->join('m_indikator as i', 'd.kode_indikator = i.kode_indikator');
		$this->db->join('m_tahun as h', 'd.tahun = h.id');
		$this->db->join('m_target as t', 'd.kode_target = t.kode_target');
		$this->db->join('m_goal as g', 'd.kode_goal = g.kode_goal');
		$this->db->where("h.tahun",$tahun);
		$this->db->where("d.kode_indikator",$kode_indikator);
		$this->db->where("d.id_kab",'3301');
        return $this->db->get();
    }
	
	function cekDataEditLengkap($tahun, $kode_indikator){
           return $this->db->query("select d.*,k.nama_kab from t_data as d inner join m_kab as k on d.id_kab=k.id_kab inner join m_tahun as t on d.tahun=t.id where d.kode_indikator='$kode_indikator' and t.tahun='$tahun'");
    }
	
	function cekData($tahun,$kode_goal,$kode_target,$kode_indikator){
        $this->db->where("tahun",$tahun);
		$this->db->where("kode_goal",$kode_goal);
		$this->db->where("kode_target",$kode_target);
		$this->db->where("kode_indikator",$kode_indikator);
		$this->db->where("id_kab",'3301');
        return $this->db->get("t_data");
    }
    
    function cekId($kode){
        //$this->db->where("kode_indikator",$kode);
		$this->db->select('i.*, t.nama_target, g.nama_goal');
		$this->db->from('m_indikator as i');
		$this->db->join('m_target as t', 'i.kode_target = t.kode_target');
		$this->db->join('m_goal as g', 'i.kode_goal = g.kode_goal');
		$this->db->where("i.kode_indikator",$kode);
		return $this->db->get();
        //return $this->db->get("m_indikator");
    }
    
    function update($id,$info){
        $this->db->where("kode_indikator",$id);
        $this->db->update("m_indikator",$info);
    }
    
	function updatedata($id,$info){
        $this->db->where("id",$id);
        $this->db->update("t_data",$info);
    }
	
    function inputdata($info){
        $this->db->insert("t_data",$info);
    }
    
    function hapus($tahunbeneran,$kode_indikator){
        $this->db->where("tahun",$tahunbeneran);
		$this->db->where("kode_indikator",$kode_indikator);
        $this->db->delete("t_data");
    }
	
	 function verifikasi($kode_indikator,$tahunbeneran,$info){
		$this->db->where("tahun",$tahunbeneran);
        $this->db->where("kode_indikator",$kode_indikator);
        $this->db->update("t_data",$info);
    }
	
	function getIndikator($kode){
		$this->db->select('kode_indikator');
		$this->db->from('t_data');
		$this->db->where("id",$kode);
		return $this->db->get()->row('kode_indikator');
	}
	
	function getTahun($idtahun)
	{
		$this->db->select('id');
		$this->db->from('m_tahun');
		$this->db->where("tahun",$idtahun);
		return $this->db->get()->row('id');
	}

	//query database laporan
	function cobaLaporan($kab, $bln, $Tahun)
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		//$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bulanini);
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();
		return $query->result_array();
		
	}

	//query untuk grafik laporan
	function report($kab, $bln, $Tahun)
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		//$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bulanini);
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
		
	
	}
	
	function jumlahKegiatanPerbidang()
	{
		/*$this->db->select("substring(id_jeniskegiatan,1,4) as id_bidang,count(id_jeniskegiatan) as jumlah");
		$this->db->from("m_jeniskegiatan");
		$this->db->group_by('substring(id_jeniskegiatan,1,4)');*/
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$query2 = $this->db->query("SELECT substring(id_jeniskegiatan,1,4) as bidang, sum(nilai_total) as nilai, count(id_jeniskegiatan) jmlh, sum(nilai_total)/count(id_jeniskegiatan) as rata_rata FROM `t_kegiatan` where nilai_total <> '' group by bidang");

		if ($query2->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query2->result() as $data2) {
				$hasil2[] = $data2;
			}
			return $hasil2;
		}
	}
	
	function cobaJumlahKegiatanPerbidang()
	{
		/*$this->db->select("substring(id_jeniskegiatan,1,4) as id_bidang,count(id_jeniskegiatan) as jumlah");
		$this->db->from("m_jeniskegiatan");
		$this->db->group_by('substring(id_jeniskegiatan,1,4)');
		$query2 = $this->db->get();
		return $query->result_array();*/
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		return $this->db->query("SELECT substring(id_jeniskegiatan,1,4) as id_bidang, sum(nilai_total) as nilai, count(id_jeniskegiatan) jmlh, sum(nilai_total)/count(id_jeniskegiatan) as rata_rata FROM `t_kegiatan` where nilai_total <> '' group by id_bidang")->result();
	}
	
	
	function cobaLaporanProv($kab, $bln, $Tahun)
	{
		$this->db->select("MONTH(m.batas_waktu) as bulan,m.nama_kegiatan, m.batas_waktu,s.satuan,m.target,m.realisasi ");
		$this->db->from('m_jeniskegiatan as m');
		$this->db->join('m_satuan as s', 'm.satuan=s.id_satuan');
		$this->db->order_by('bulan');
		$this->db->order_by('id_jeniskegiatan');
		//$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('substring(m.id_jeniskegiatan,1,4)', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();
		return $query->result_array();
		
	}
	
	function reportProv($kab, $bln, $Tahun)
	{
		$this->db->select("MONTH(m.batas_waktu) as bulan,m.nama_kegiatan, m.batas_waktu,s.satuan,m.target,m.realisasi ");
		$this->db->from('m_jeniskegiatan as m');
		$this->db->join('m_satuan as s', 'm.satuan=s.id_satuan');
		$this->db->order_by('bulan');
		$this->db->order_by('id_jeniskegiatan');
		//$this->db->where('t_kegiatan.flag_konfirm', '1');
		if ($kab) {
			$this->db->where('substring(m.id_jeniskegiatan,1,4)', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
	}
	
	function cobaLaporanDashboard($kab, $bln, $Tahun)
	{
		
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bulanini);
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();
		return $query->result_array();
		
		
		/*$this->db->select("MONTH(m.batas_waktu) as bulan,m.nama_kegiatan, m.batas_waktu,s.satuan,m.target,m.realisasi ");
		$this->db->from('m_jeniskegiatan as m');
		$this->db->join('m_satuan as s', 'm.satuan=s.id_satuan');
		$this->db->order_by('bulan');
		$this->db->order_by('id_jeniskegiatan');
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('substring(m.id_jeniskegiatan,1,4)', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();
		return $query->result_array();
		*/
	}
	
	function reportDashboard($kab, $bln, $Tahun)
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bulanini);
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}
		
		
		
		/*$this->db->select("MONTH(m.batas_waktu) as bulan,m.nama_kegiatan, m.batas_waktu,s.satuan,m.target,m.realisasi ");
		$this->db->from('m_jeniskegiatan as m');
		$this->db->join('m_satuan as s', 'm.satuan=s.id_satuan');
		$this->db->order_by('bulan');
		$this->db->order_by('id_jeniskegiatan');
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		if ($kab) {
			$this->db->where('substring(m.id_jeniskegiatan,1,4)', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}
			return $hasil;
		}*/
	}
	
	function jumlahKegiatanPerbulan()
	{
		$query3 = $this->db->query("SELECT MONTH(m.batas_waktu) as bulan, count(m.id_jeniskegiatan) as jumlah_kegiatan FROM `m_jeniskegiatan` m WHERE year(m.batas_waktu)='2019' group By MONTH(m.batas_waktu)");

		if ($query3->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query3->result() as $data3) {
				$hasil3[] = $data3;
			}
			return $hasil3;
		}
	}
	
	function cobaJumlahKegiatanPerbulan()
	{
		return $this->db->query("SELECT MONTH(m.batas_waktu) as bulan, count(m.id_jeniskegiatan) as jumlah_kegiatan FROM `m_jeniskegiatan` m WHERE year(m.batas_waktu)='2019' group By MONTH(m.batas_waktu)")->result();
	}
	
	
	function ReportKegiatanPerbidang()
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$query4 = $this->db->query("SELECT substring(t.id_jeniskegiatan,1,4) as id_bidang, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata_rata FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and MONTH(m.batas_waktu)='$bulanini' group by id_bidang");

		if ($query4->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query4->result() as $data4) {
				$hasil4[] = $data4;
			}
			return $hasil4;
		}
	}
	
	function cobaReportKegiatanPerbidang()
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		return $this->db->query("SELECT substring(t.id_jeniskegiatan,1,4) as id_bidang, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata_rata FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and MONTH(m.batas_waktu)='$bulanini' group by id_bidang")->result();
	}
}