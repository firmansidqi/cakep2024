<?php
$mode		= $this->uri->segment(3);
$wilayah	= $this->db->query("select * from m_kab where id_kab <> '6500'")->result();
$db2        = $this->load->database('db2',TRUE);
$this->load->model('M_kelolakegiatan');


$id_jeniskegiatan		= $this->uri->segment(4);
$act					= "act_ubahtarget/".$id_jeniskegiatan;
$idunitkerja			= substr($id_jeniskegiatan,0,5);
$tahun					= substr($id_jeniskegiatan,0,4);
?>

<?php echo $this->session->flashdata("k");?>
<div class="row col-md-12" style="margin-top:80px">
    <div class="panel panel-info">
        <div class="panel-heading"> PENGAJUAN UBAH TARGET MINGGUAN
        </div>
        
        <div class="scroll" style="height: auto;">
            <form action="<?php echo base_URL()?>index.php/admin/alokasikegiatan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="row-fluid well" style="overflow: hidden">
                    <div class="row col-md-12">
                        <table width="100%" class="table-form">
                            <tr>
                                <td width="20%">Tahun Kegiatan</td>
                                <td>: <?php echo $tahun; ?></td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Nama Kegiatan</td>
                                <td>: <?php echo $datpil[0]->kegiatan; ?></td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Nama Sub Kegiatan</td>
                                <td>: <?php echo $datpil[0]->nmkegiatan; ?></td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Satuan</td>
                                <td>: <?php echo $datpil[0]->nama_satuan; ?></td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Nama Ketua Tim</td>
                                <td>
                                    <?php
                                    if(empty($datpil[0]->ketua_tim))
                                    {
                                        echo ": ";
                                    }
                                    else
                                    {
                                        $nip        = $datpil[0]->ketua_tim;
                                        $pegawai    = $db2->query("SELECT gelar_depan, nama, gelar_belakang FROM master_pegawai WHERE niplama = '$nip' LIMIT 1")->row();
                                        echo ": ".$pegawai->gelar_depan." ".$pegawai->nama." ".$pegawai->gelar_belakang;
                                    }
                                    ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%" >Rentang Waktu</td>
                                <td>: <?php echo tgl_jam_sql($datpil[0]->mulai) . " - " . tgl_jam_sql($datpil[0]->batas_waktu); ?></td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Alasan perubahan</td>
                                <td><b><input type="text" name="alasan_perubahan" tabindex="8" id="alasan_perubahan" style="width: 500px" class="form-control"></b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Dasar Perubahan</td>
                                <td><b><input type="file" tabindex="9" name="dasar_perubahan" value="" id="dasar_surat" style="width: 500px" class="form-control"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="row col-md-12">
                        <hr>
                        <table width = 100%>
                            <tr>
                                <th width="100%" style="text-align:center; font-size:16pt; padding-bottom:12px;"><b>Alokasi</b></th>
                            </tr>
                            
                            <table width="100%" class="table table-striped" id="targetTable">
                                <tr>
                                    <th style="text-align:center" width=5%>No.</th>
                                    <th style="text-align:center" width=10%>Jenis Target</th>
                                    <?php
                                    $friday = $this->db->query("select batas_minggu from t_kegiatan where id_kab='6501' and id_jeniskegiatan='$id_jeniskegiatan' ORDER BY minggu_ke")->result();
                                    if(!empty($friday)){
                                        for($i = 1; $i <= count($friday); $i++){
                                            echo "<th style='text-align:center' id='tgt'>Minggu ".$i."<br>(".tgl_jam_sql($friday[$i-1]->batas_minggu).")</th>";
                                        }
                                    };?>
                                </tr>
                                <?php
                                    echo "<tr>";?>
                                        <td style="text-align:center">1</td>
                                        <td >Target Lama</td>
                                        <?php
                                        if(!empty($datpil))
                                        {
                                            foreach($datpil as $data)
                                            {
                                            ?>
                                                <td id="tgt" ><input type="text" name="<?php echo '_'.$data->id_kab.'[]'; ?>" id="<?php echo '_'.$data->id_kab.'[]'; ?>" class="form-control" size='60px' value="<?php echo $data->target; ?>" targetkab readonly></td>
                                                <?php
                                            }
                                        }
                                    echo "</tr>";
                                ?>
                                <tr>
                                    <td style="text-align:center">2</td>
                                    <td >Target Baru</td>
                                    <?php
                                        if(!empty($datpil))
                                        {
                                            foreach($datpil as $data)
                                            {
                                            ?>
                                                <td id="tgt" ><input type="text" name="<?php echo '_'.$data->id_kab.'new[]'; ?>" id="<?php echo '_'.$data->id_kab.'new[]'; ?>" class="form-control" size='60px' value="" targetkabnew ></td>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tr>
                            </table>
                        </table>
                        
                        <a href="javascript:history.back()" tabindex="10" class="btn btn-primary"><i class="icon icon-arrow-left icon-white"></i> Batal</a>
                        <button type="submit" class="btn btn-success" tabindex="9" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>
                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
