<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ambil database */
function gli($tabel, $field_kunci, $pad) {
	$CI 	=& get_instance();
	$nama	= $CI->db->query("SELECT max($field_kunci) AS last FROM $tabel")->row();
	$data	= (intval($nama->last)) + 1;
	$last	= str_pad($data, $pad, '0', STR_PAD_LEFT);
	return $last;
}
function gval($tabel, $field_kunci, $diambil, $where) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT $diambil FROM $tabel WHERE $field_kunci = '$where'")->row();
	$data	= empty($nama) ? "-" : $nama->$diambil;
	return $data;
}

function konversi_level($id) {
	if ($id == "1") {
		echo "Admin Super";
	} else {
		echo "Admin Pos";
	}
}

function getjenisnilai($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_jenis_nilai WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getmapel($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_mapel WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getkelas($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_kelas WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getguru($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_guru WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}
function getsiswa($id) {
	$CI =& get_instance();	
	$nama	= $CI->db->query("SELECT nama FROM tr_siswa WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

/* fungsi non database */
function tgl_jam_sql ($tgl) {
	$pc_satu	= explode(" ", $tgl);
	if (count($pc_satu) < 2) {	
		$tgl1		= $pc_satu[0];
		$jam1		= "";
	} else {
		$jam1		= $pc_satu[1];
		$tgl1		= $pc_satu[0];
	}
	
	$pc_dua		= explode("-", $tgl1);
	$tgl		= $pc_dua[2];
	$bln		= $pc_dua[1];
	$thn		= $pc_dua[0];
	
	
	if ($bln == "01") { $bln_txt = "Jan"; }  
	else if ($bln == "02") { $bln_txt = "Feb"; }  
	else if ($bln == "03") { $bln_txt = "Mar"; }  
	else if ($bln == "04") { $bln_txt = "Apr"; }  
	else if ($bln == "05") { $bln_txt = "Mei"; }  
	else if ($bln == "06") { $bln_txt = "Jun"; }  
	else if ($bln == "07") { $bln_txt = "Jul"; }  
	else if ($bln == "08") { $bln_txt = "Ags"; }  
	else if ($bln == "09") { $bln_txt = "Sep"; }  
	else if ($bln == "10") { $bln_txt = "Okt"; }  
	else if ($bln == "11") { $bln_txt = "Nov"; }  
	else if ($bln == "12") { $bln_txt = "Des"; }  	
	else { $bln_txt = ""; }
	
	return $tgl." ".$bln_txt." ".$thn."  ".$jam1;
}

/* penyederhanaan fungsi */
function _page($total_row, $per_page, $uri_segment, $url) {
	$CI 	=& get_instance();
	$CI->load->library('pagination');
	$config['base_url'] 	= $url;
	$config['total_rows'] 	= $total_row;
	$config['uri_segment'] 	= $uri_segment;
	$config['per_page'] 	= $per_page; 
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close']= '</li>';
	$config['prev_link'] 	= '&lt;';
	$config['prev_tag_open']='<li>';
	$config['prev_tag_close']='</li>';
	$config['next_link'] 	= '&gt;';
	$config['next_tag_open']='<li>';
	$config['next_tag_close']='</li>';
	$config['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
	$config['cur_tag_close']='</a></li>';
	$config['first_tag_open']='<li>';
	$config['first_tag_close']='</li>';
	$config['last_tag_open']='<li>';
	$config['last_tag_close']='</li>';
	
	$CI->pagination->initialize($config); 
	return $CI->pagination->create_links();
}

function _print_pdf($file, $data) {
	require_once('h2p/html2fpdf.php');          // agar dapat menggunakan fungsi-fungsi html2pdf
	ob_start();                            		// memulai buffer
	error_reporting(1);                     	// turn off warning for deprecated functions
	$pdf= new HTML2FPDF();                  	// membuat objek HTML2PDF
	$pdf->DisplayPreferences('Fullscreen');
	
	$html = $data;               		// mengambil data dengan format html, dan disimpan di variabel
	ob_end_clean();                         	// mengakhiri buffer dan tidak menampilkan data dalam format html
	$pdf->addPage();                        	// menambah halaman di file pdf
	$pdf->WriteHTML($html);                 	// menuliskan data dengan format html ke file pdf
	return $pdf->Output($file,'D'); 
}

//Perubahan April-Mei 2023
function getMinggu($bln){
    $CI         =& get_instance();
    $date       = date("d-".$bln."-Y");
    $bulan      = date("F", strtotime($date));
    $tahun      = date("o", strtotime($date));
    $firstfriday= date("d", strtotime("first Friday of ".$bulan." ".$tahun)); 
    $lastfriday = date("d", strtotime("last Friday of ".$bulan." ".$tahun));
    $lastdate   = date("t", strtotime($date));
    $jMinggu    = ($lastfriday - $firstfriday)/7+1;
    $friday[0]  = date("Y-m-d", strtotime("first Friday of ".$bulan." ".$tahun));
    if($firstfriday < 3){
        $jMinggu--;
        $friday[0] = date("Y-m-d", strtotime('next friday'.$friday[0]));
    };
    $sls        = $lastdate-$lastfriday;
    if($sls == 5 || $sls == 6){
        $jMinggu++;
    };
    for($i = 1; $i < $jMinggu; $i++){
        $friday[$i] = date("Y-m-d", strtotime('next friday'.$friday[$i-1]));
    };
    return [$jMinggu, $friday] ;
}

function isMinggu($tgl1, $tgl2, $batas){
    $CI         =& get_instance();
    $day1       = date("Y-m-d", strtotime($tgl1));
    $day2       = date("Y-m-d", strtotime($tgl2)); 
    $day3       = date("Y-m-d", strtotime($batas)); 
    if ($day3 > $day1 && $day3 <= $day2){
        return TRUE;
    }else{
        return FALSE;
    };
}

function getFridayKgt($mulai, $batas){
	    $fday       = date("d-m-Y", strtotime($mulai));
	    $lday       = date("d-m-Y", strtotime($batas));
        $ffriday    = date("d-m-Y", strtotime("this Friday".$fday));
        $lfriday    = date("d-m-Y", strtotime("this Friday".$lday));
        $sfriday    = $lfriday-$ffriday;
        $jfriday    = 1;
        $friday[0]  = date("Y-m-d", strtotime($ffriday));
        if($sfriday == 0){
            if(date("N", strtotime($lday)) == 6 || date("N", strtotime($lday)) == 7){
                $friday[0]  = date("Y-m-d", strtotime("previous Friday".$friday[0]));
            };
        }else{
            $jfriday = $sfriday/7+1;
            if(($lfriday-$lday) >= 5){
                $jfriday--;
            }
        };
        if($jfriday > 1){
            for($i = 1; $i < $jfriday; $i++){
                $friday[$i] = date("Y-m-d", strtotime('next friday'.$friday[$i-1]));
            };
        };
        $data   =  array("jfriday" => $jfriday,
                        "friday" => $friday,);
        return [$jfriday, $friday];
    }

function isFriday($tgl){
    $CI         =& get_instance();
    $tFriday    = date("Y-m-d", strtotime("this friday ".$tgl));
}

function getWeek($bln){
    $CI         =& get_instance();
    $date       = date("d-".$bln."-Y");
    $bulan      = date("F", strtotime($date));
    $tahun      = date("o", strtotime($date));
    $firstfriday= date("d", strtotime("first Friday of ".$bulan." ".$tahun)); 
    $lastfriday = date("d", strtotime("last Friday of ".$bulan." ".$tahun));
    $lastdate   = date("t", strtotime($date));
    $jMinggu    = ($lastfriday - $firstfriday)/7+1;
    $friday[0]  = date("Y-m-d", strtotime("first Friday of ".$bulan." ".$tahun));
    if($firstfriday < 3){
        $jMinggu--;
        $friday[0] = date("Y-m-d", strtotime('next friday'.$friday[0]));
    };
    $sls        = $lastdate-$lastfriday;
    if($sls == 5 || $sls == 6){
        $jMinggu++;
    };
    for($i = 1; $i < $jMinggu; $i++){
        $friday[$i] = date("Y-m-d", strtotime('next friday'.$friday[$i-1]));
    };
    return [$jMinggu, $friday] ;
}
