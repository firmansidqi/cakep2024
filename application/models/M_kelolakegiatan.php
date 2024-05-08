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
	function cobaLaporan($bln)
	{
		/*$hariini=date("d-m-Y");
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
		$query = $this->db->get();*/
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		/*$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_unitkerja','substring(m_jeniskegiatan.id_jeniskegiatan,1,5)= m_unitkerja.id_unitkerja');
		$this->db->join('m_satuan','m_jeniskegiatan.satuan = m_satuan.id_satuan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		$this->db->where('t_kegiatan.target <> ', '0');
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();*/
		$tahunini = $this->session->userdata('admin_ta');
		if ($bln) 
		{
		$query = $this->db->query("select n.id_kab, n.nama_kab, p.target as target , n.jmlh_kegiatan, n.nilai, n.rata2nilai from 
			(select m.id_kab, m.nama_kab, count(m.id_jeniskegiatan) as jmlh_kegiatan,sum(m.total_nilai) as nilai,sum(m.total_nilai)/count(m.id_jeniskegiatan) as rata2nilai from 
			(select t.id_kab, k.nama_kab, t.id_jeniskegiatan, sum(t.nilai_total) as total_nilai from t_kegiatan t left join m_kab k on t.id_kab=k.id_kab left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and t.flag_konfirm='1'and month(j.batas_waktu)='$bln' and year(j.batas_waktu)='$tahunini' group by t.id_kab, t.id_jeniskegiatan ) as m group by m.id_kab) as n join 
			(select t.id_kab, count(t.id_jeniskegiatan) as target from t_kegiatan t left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and month(j.batas_waktu)='$bln' and year(j.batas_waktu)='$tahunini' group by t.id_kab) as p on n.id_kab=p.id_kab ");	
		
		}
		else
		{
		$query = $this->db->query("select n.id_kab, n.nama_kab, p.target as target , n.jmlh_kegiatan, n.nilai, n.rata2nilai from 
				(select m.id_kab, m.nama_kab, count(m.id_jeniskegiatan) as jmlh_kegiatan,sum(m.total_nilai) as nilai,sum(m.total_nilai)/count(m.id_jeniskegiatan) as rata2nilai from 
				(select t.id_kab, k.nama_kab, t.id_jeniskegiatan, sum(t.nilai_total) as total_nilai from t_kegiatan t left join m_kab k on t.id_kab=k.id_kab left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and t.flag_konfirm='1' and year(j.batas_waktu)='$tahunini' group by t.id_kab, t.id_jeniskegiatan ) as m group by m.id_kab) as n join 
				(select t.id_kab, count(t.id_jeniskegiatan) as target from t_kegiatan t left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and year(j.batas_waktu)='$tahunini' group by t.id_kab) as p on n.id_kab=p.id_kab");	
		}
		return $query->result_array();
		
	}

	//query untuk grafik laporan
	function report($bln)
	{
		/*$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_unitkerja','substring(m_jeniskegiatan.id_jeniskegiatan,1,5)= m_unitkerja.id_unitkerja');
		$this->db->join('m_satuan','m_jeniskegiatan.satuan = m_satuan.id_satuan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		$this->db->where('t_kegiatan.target <> ', '0');
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($Tahun) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $Tahun);
		}
		$query = $this->db->get();*/
		
		//$query2 = $this->db->query("SELECTt t.id_jeniskegiatan, m.nama_kegiatan, t.id_kab, k.nama_kab, t.tgl_entri, m.batas_waktu, t.realisasi, t.target, t.nilai_volume, t.nilai_deadline, t.nilai_total, COUNT(t.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t.id_jeniskegiatan) as total_nilai 
						//FROM t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_unitkerja u on substring(m.id_jeniskegiatan,1,5) = u.id_unitkerja 
						//left join m_satuan s on m.satuan=s.id_satuan left join m_kab k on t.id_kab=k.id_kab
						//WHERE k.nama_kab='$kab' and MONTH(m.batas_waktu)='$bln' and YEAR(m.batas_waktu) = '$Tahun' and t.target <> '0' and t.flag_konfirm='1' 
						//group by t.id_kab");
		$tahunini = $this->session->userdata('admin_ta');
		if ($bln) 
		{
		$query = $this->db->query("select n.id_kab, n.nama_kab, p.target as target , n.jmlh_kegiatan, n.nilai, n.rata2nilai from 
			(select m.id_kab, m.nama_kab, count(m.id_jeniskegiatan) as jmlh_kegiatan,sum(m.total_nilai) as nilai,sum(m.total_nilai)/count(m.id_jeniskegiatan) as rata2nilai from 
			(select t.id_kab, k.nama_kab, t.id_jeniskegiatan, sum(t.nilai_total) as total_nilai from t_kegiatan t left join m_kab k on t.id_kab=k.id_kab left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and t.flag_konfirm='1'and month(j.batas_waktu)='$bln' and year(j.batas_waktu)='$tahunini' group by t.id_kab, t.id_jeniskegiatan ) as m group by m.id_kab) as n join 
			(select t.id_kab, count(t.id_jeniskegiatan) as target from t_kegiatan t left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and month(j.batas_waktu)='$bln' and year(j.batas_waktu)='$tahunini' group by t.id_kab) as p on n.id_kab=p.id_kab ");	
		
		}
		else
		{
		$query = $this->db->query("select n.id_kab, n.nama_kab, p.target as target , n.jmlh_kegiatan, n.nilai, n.rata2nilai from 
				(select m.id_kab, m.nama_kab, count(m.id_jeniskegiatan) as jmlh_kegiatan,sum(m.total_nilai) as nilai,sum(m.total_nilai)/count(m.id_jeniskegiatan) as rata2nilai from 
				(select t.id_kab, k.nama_kab, t.id_jeniskegiatan, sum(t.nilai_total) as total_nilai from t_kegiatan t left join m_kab k on t.id_kab=k.id_kab left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and t.flag_konfirm='1' and year(j.batas_waktu)='$tahunini' group by t.id_kab, t.id_jeniskegiatan ) as m group by m.id_kab) as n join 
				(select t.id_kab, count(t.id_jeniskegiatan) as target from t_kegiatan t left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and year(j.batas_waktu)='$tahunini' group by t.id_kab) as p on n.id_kab=p.id_kab");	
		}
		
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
		$tahunini = $this->session->userdata('admin_ta');
		$query2 = $this->db->query("SELECT substring(t.id_jeniskegiatan,1,4) as bidang, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata_rata FROM `t_kegiatan` t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where t.nilai_total <> ''  and t.flag_konfirm='1' and t.target <> '0' and YEAR(m.batas_waktu) = '$tahunini' group by bidang");

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
		$tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT substring(t.id_jeniskegiatan,1,3) as bidang, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata_rata FROM `t_kegiatan` t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where t.nilai_total <> ''  and t.target <> '0' and YEAR(m.batas_waktu) = '$tahunini' and t.flag_konfirm='1' group by bidang")->result();
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
	
	function cobaLaporanDashboard()
	{
		
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$tahunini = $this->session->userdata('admin_ta');
		/*$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bulanini);
		$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $tahunini);
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		$this->db->where('t_kegiatan.target <> ', '0');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($tahunini) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $tahunini);
		}
		$query = $this->db->get();*/
		$query = $this->db->query("select n.id_kab, n.nama_kab, p.target as target , n.jmlh_kegiatan, n.nilai, n.rata2nilai from 
			(select m.id_kab, m.nama_kab, count(m.id_jeniskegiatan) as jmlh_kegiatan,sum(m.total_nilai) as nilai,sum(m.total_nilai)/count(m.id_jeniskegiatan) as rata2nilai from 
			(select t.id_kab, k.nama_kab, t.id_jeniskegiatan, sum(t.nilai_total) as total_nilai from t_kegiatan t left join m_kab k on t.id_kab=k.id_kab left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and t.flag_konfirm='1'and month(j.batas_waktu)='$bulanini' and year(j.batas_waktu)='$tahunini' group by t.id_kab, t.id_jeniskegiatan ) as m group by m.id_kab) as n join 
			(select t.id_kab, count(t.id_jeniskegiatan) as target from t_kegiatan t left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and month(j.batas_waktu)='$bulanini' and year(j.batas_waktu)='$tahunini' group by t.id_kab) as p on n.id_kab=p.id_kab ");	
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
	
	function reportDashboard()
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$tahunini = $this->session->userdata('admin_ta');
	/*	$this->db->select("t_kegiatan.id_jeniskegiatan, m_jeniskegiatan.nama_kegiatan, t_kegiatan.id_kab, m_kab.nama_kab, t_kegiatan.tgl_entri, m_jeniskegiatan.batas_waktu, t_kegiatan.realisasi, t_kegiatan.target, t_kegiatan.nilai_volume, t_kegiatan.nilai_deadline, t_kegiatan.nilai_total, COUNT(t_kegiatan.id_jeniskegiatan) AS total_kegiatan, sum(nilai_total)/count(t_kegiatan.id_jeniskegiatan) as total_nilai");
		$this->db->from('t_kegiatan');
		$this->db->join('m_jeniskegiatan', 't_kegiatan.id_jeniskegiatan = m_jeniskegiatan.id_jeniskegiatan');
		$this->db->join('m_kab', 't_kegiatan.id_kab = m_kab.id_kab');
		$this->db->group_by('t_kegiatan.id_kab');
		$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bulanini);
		$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $tahunini);
		$this->db->where('t_kegiatan.flag_konfirm', '1');
		$this->db->where('t_kegiatan.target <> ', '0');
		
		if ($kab) {
			$this->db->where('m_kab.nama_kab', $kab);
		}if ($bln) {
			$this->db->where('MONTH(m_jeniskegiatan.batas_waktu)', $bln);
		}if ($tahunini) {
			$this->db->where('YEAR(m_jeniskegiatan.batas_waktu)', $tahunini);
		}
		$query = $this->db->get();
*/
	$query = $this->db->query("select n.id_kab, n.nama_kab, p.target as target , n.jmlh_kegiatan, n.nilai, n.rata2nilai from 
			(select m.id_kab, m.nama_kab, count(m.id_jeniskegiatan) as jmlh_kegiatan,sum(m.total_nilai) as nilai,sum(m.total_nilai)/count(m.id_jeniskegiatan) as rata2nilai from 
			(select t.id_kab, k.nama_kab, t.id_jeniskegiatan, sum(t.nilai_total) as total_nilai from t_kegiatan t left join m_kab k on t.id_kab=k.id_kab left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and t.flag_konfirm='1'and month(j.batas_waktu)='$bulanini' and year(j.batas_waktu)='$tahunini' group by t.id_kab, t.id_jeniskegiatan ) as m group by m.id_kab) as n join 
			(select t.id_kab, count(t.id_jeniskegiatan) as target from t_kegiatan t left join m_jeniskegiatan j on t.id_jeniskegiatan=j.id_jeniskegiatan where t.target <> '0' and month(j.batas_waktu)='$bulanini' and year(j.batas_waktu)='$tahunini' group by t.id_kab) as p on n.id_kab=p.id_kab ");	
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
	    $tahunini = $this->session->userdata('admin_ta');
		$query3 = $this->db->query("SELECT MONTH(m.batas_waktu) as bulan, count(m.id_jeniskegiatan) as jumlah_kegiatan FROM `m_jeniskegiatan` m WHERE year(m.batas_waktu)='$tahunini' group By MONTH(m.batas_waktu)");

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
	    $tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT MONTH(m.batas_waktu) as bulan, count(m.id_jeniskegiatan) as jumlah_kegiatan FROM `m_jeniskegiatan` m WHERE year(m.batas_waktu)='$tahunini' group By MONTH(m.batas_waktu)")->result();
	}
	
	function ReportKegiatanPerbidang()
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$tahunini = $this->session->userdata('admin_ta');
		$query4 = $this->db->query("SELECT substring(t.id_jeniskegiatan,1,4) as id_bidang, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata_rata FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and MONTH(m.batas_waktu)='$bulanini' and YEAR(m.batas_waktu)='$tahunini' and t.flag_konfirm='1' and t.target <> '0' group by id_bidang");

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
		$tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT substring(t.id_jeniskegiatan,1,3) as id_bidang, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata_rata FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and MONTH(m.batas_waktu)='$bulanini' and YEAR(m.batas_waktu)='$tahunini' and t.target <> '0' and t.flag_konfirm='1' group by id_bidang")->result();
	}
	
	function jumlahKegiatanPerkabkot()
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$tahunini = $this->session->userdata('admin_ta');
		$query5 = $this->db->query("SELECT t.id_kab, k.nama_kab,COUNT(t.id_jeniskegiatan) AS total_kegiatan
			FROM t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_kab k on t.id_kab=k.id_kab
			WHERE MONTH(m.batas_waktu)='$bulanini' and YEAR(m.batas_waktu)='$tahunini' and t.target <> '0'
			group by t.id_kab");

		if ($query5->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query5->result() as $data5) {
				$hasil5[] = $data5;
			}
			return $hasil5;
		}
	}
	
	function cobaJumlahKegiatanPerkabkot()
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT t.id_kab, k.nama_kab,COUNT(t.id_jeniskegiatan) AS total_kegiatan
		FROM t_kegiatan t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan left join m_kab k on t.id_kab=k.id_kab
		WHERE MONTH(m.batas_waktu)='$bulanini' and YEAR(m.batas_waktu)='$tahunini' and t.target <> '0'
		group by t.id_kab")->result();
	}
	
	//query database laporan Pengguna
	function cobaLaporanUser($bln)
	{
		$hariini=date("d-m-Y");
		$bulanini = substr($hariini,3,2);
		$tahunini = $this->session->userdata('admin_ta');
		if ($bln) 
		{
		$query = $this->db->query("SELECT l.username, count(l.logindate)  as jmlhlogin, u.loginterakhir,a.nama FROM evita_userlog AS l
			INNER JOIN (SELECT username, MAX(logindate)  AS loginterakhir FROM evita_userlog  GROUP BY username) u
			ON l.username = u.username left join t_admin a on l.username=a.username where month(l.logindate)='$bln' group by l.username");	
		}
		else
		{
		$query = $this->db->query("SELECT l.username, count(l.logindate)  as jmlhlogin, u.loginterakhir,a.nama FROM evita_userlog AS l
			INNER JOIN (SELECT username, MAX(logindate)  AS loginterakhir FROM evita_userlog  GROUP BY username) u
			ON l.username = u.username left join t_admin a on l.username=a.username group by l.username");	
		}
		return $query->result_array();
		
	}

	//query untuk grafik laporan pengguna
	function reportuser($bln)
	{
		$tahunini = $this->session->userdata('admin_ta');
		if ($bln) 
		{
		$query = $this->db->query("SELECT l.username, count(l.logindate)  as jmlhlogin, u.loginterakhir,a.nama FROM evita_userlog AS l
			INNER JOIN (SELECT username, MAX(logindate)  AS loginterakhir FROM evita_userlog  GROUP BY username) u
			ON l.username = u.username left join t_admin a on l.username=a.username where month(l.logindate)='$bln' group by l.username");	
		
		}
		else
		{
		$query = $this->db->query("SELECT l.username, count(l.logindate)  as jmlhlogin, u.loginterakhir,a.nama FROM evita_userlog AS l
			INNER JOIN (SELECT username, MAX(logindate)  AS loginterakhir FROM evita_userlog  GROUP BY username) u
			ON l.username = u.username left join t_admin a on l.username=a.username group by l.username");	
		}
		
		if ($query->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($query->result() as $datauser) {
				$hasiluser[] = $datauser;
			}
			return $hasiluser;
		}
	}
	
	//tambahan 22 januari 2021
	function laporanbagbid($bulan)
	{
		$tahunini = $this->session->userdata('admin_ta');
		if ($bulan) 
		{
		$querylaporanbagbid = $this->db->query("SELECT substring(t.id_jeniskegiatan,1,3) as id_bidang, sum(t.target) as target, sum(t.realisasi) as realisasi, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata2nilai FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and MONTH(m.batas_waktu)='$bulan' and YEAR(m.batas_waktu)='$tahunini' and t.target <> '0' and t.flag_konfirm='1' group by id_bidang");
		}
		else
		{
		$querylaporanbagbid = $this->db->query("SELECT substring(t.id_jeniskegiatan,1,3) as id_bidang, sum(t.target) as target, sum(t.realisasi) as realisasi, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata2nilai FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and YEAR(m.batas_waktu)='$tahunini' and t.target <> '0' and t.flag_konfirm='1' group by id_bidang");
		}
		
		if ($querylaporanbagbid->num_rows() > 0 ) {
			//print_r($query->result());
			foreach ($querylaporanbagbid->result() as $datalaporanbagbid) {
				$hasillaporanbagbid[] = $datalaporanbagbid;
			}
			return $hasillaporanbagbid;
		}
	}
	
	function cobalaporanbagbid($bulan)
	{
		$tahunini = $this->session->userdata('admin_ta');
		if ($bulan) 
		{
		return $this->db->query("SELECT substring(t.id_jeniskegiatan,1,3) as id_bidang, sum(t.target) as target, sum(t.realisasi) as realisasi, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata2nilai FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and MONTH(m.batas_waktu)='$bulan' and YEAR(m.batas_waktu)='$tahunini' and t.target <> '0' and t.flag_konfirm='1' group by id_bidang")->result();
		}
		else
		{
		return $this->db->query("SELECT substring(t.id_jeniskegiatan,1,3) as id_bidang, sum(t.target) as target, sum(t.realisasi) as realisasi, sum(t.nilai_total) as nilai, count(t.id_jeniskegiatan) jmlh, sum(t.nilai_total)/count(t.id_jeniskegiatan) as rata2nilai FROM `t_kegiatan` as t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where nilai_total <> '' and YEAR(m.batas_waktu)='$tahunini' and t.target <> '0' and t.flag_konfirm='1' group by id_bidang")->result();
		}
	}
	//end of tambahan 22 januari 2020
	
	//tambahan 9 Maret 2021
	function gettargetkabkota()
	{
		$bulanini = date("m");
		$tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT id_kab,sum(t.target) as target FROM `t_kegiatan` t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where month(batas_waktu)='$bulanini' and year(batas_waktu)='$tahunini' group by t.id_kab order by t.id_kab ")->result();
	}
	
	function getrealisasikabkota()
	{
		$bulanini = date("m");
		$tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT id_kab,sum(t.realisasi) as realisasi FROM `t_kegiatan` t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where month(batas_waktu)='$bulanini' and year(batas_waktu)='$tahunini'  group by t.id_kab order by t.id_kab ")->result();
		
	}
	
	function gettargetkabkotakumulatif()
	{
		$bulanini = date("m");
		$tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT id_kab,sum(t.target) as target FROM `t_kegiatan` t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where month(batas_waktu)<='$bulanini' and year(batas_waktu)='$tahunini' group by t.id_kab order by t.id_kab ")->result();
	}
	
	function getrealisasikabkotakumulatif()
	{
		$bulanini = date("m");
		$tahunini = $this->session->userdata('admin_ta');
		return $this->db->query("SELECT id_kab,sum(t.realisasi) as realisasi FROM `t_kegiatan` t left join m_jeniskegiatan m on t.id_jeniskegiatan=m.id_jeniskegiatan where month(batas_waktu)<='$bulanini' and year(batas_waktu)='$tahunini'  group by t.id_kab order by t.id_kab ")->result();
		
	}
	//end of tambahan 9 maret 2021
	
	//Perubahan April-Mei 2023
	function getPgwTerpilih($nip){
	    $db2 = $this->load->database('db2',TRUE);
	    if(empty($nip)){
	        return "";
	    }else{
	        $pgw = $db2->query("SELECT gelar_depan, nama, gelar_belakang, path_image FROM master_pegawai WHERE niplama='$nip' LIMIT 1")->row();
	        return $pgw->gelar_depan." ".$pgw->nama." ".$pgw->gelar_belakang;
	    }
	}
	
	function getProgresWil($idkeg, $wil, $minggu){
	    $data = $this->db->query("SELECT * FROM t_kegiatan WHERE id_jeniskegiatan ='$idkeg' AND id_kab = '$wil' AND minggu_ke = '$minggu' order by minggu_ke")->result();	
	    return $data;
	}
	function getKegiatanWil($idkeg, $wil){
	    $data = $this->db->query("SELECT * FROM t_kegiatan WHERE id_jeniskegiatan ='$idkeg' AND id_kab = '$wil' order by id_jeniskegiatan, minggu_ke")->result();	
	    return $data;
	}
	function getKegiatanAll($idkeg){
	    $data = $this->db->query("SELECT * FROM t_kegiatan WHERE id_jeniskegiatan ='$idkeg' order by id_jeniskegiatan, minggu_ke")->result();	
	    return $data;
	}
	function getTargetRealisasi($idkeg, $minggu){
	    $data = $this->db-query("SELECT SUM(target) as target, SUM(realisasi) as realisasi FROM t_kegiatan WHERE id_jeniskegiatan='$idkeg' AND minggu_ke=$minggu")->result();
	    return $data;
	}
	function getKgtWeekly($friday){
	    $data = $this->db-query("SELECT DISTINCT m.*, round((m.realisasi/m.target*100),2) as persen, t.batas_minggu  FROM m_jeniskegiatan m LEFT JOIN t_kegiatan t ON m.id_jeniskegiatan=t.id_jeniskegiatan where t.batas_minggu='$tFriday' order by substring(m.id_jeniskegiatan,0,5) asc , substring(m.id_jeniskegiatan,10,2) asc ")->result();
	    return $data;
	}
}