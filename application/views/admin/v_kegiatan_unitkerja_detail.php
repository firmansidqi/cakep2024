<?php 
$uri4 = $this->uri->segment(4);
$uri5 = $this->uri->segment(5);
$uri6 = $this->uri->segment(6);
$db2        = $this->load->database('db2',TRUE);
$this->load->model('M_kelolakegiatan');
?>

<div class="row col-md-12" style="margin-top:80px">
    <div class="panel panel-info">
        <div class="panel-heading">DETAIL KEGIATAN
        </div>
        
        <div class="panel-body">

            <div class="col-lg-12 alert alert-warning" style="margin-bottom: 20px">
                <div class="col-md-12">
                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <tr><td>Nama Sub Kegiatan</td><td><?php echo $datview->nmkegiatan; ?></td></tr>
                        <tr>
                            <td>Nama Ketua Tim</td>
                            <td><?php echo $this->M_kelolakegiatan->getPgwTerpilih($datview->ketua_tim); ?></td>
                        </tr>
                        <tr><td>Target</td><td><?php echo $datview->target;?></td></tr>
                        <tr><td>Satuan</td><td><?php echo $datview->nama_satuan;?></td></tr>
                        <tr><td>Rentang Waktu</td><td><?php echo tgl_jam_sql($datview->mulai)." - ".tgl_jam_sql($datview->batas_waktu); ?> </td></tr>
                    </table>
                </div>
            </div>
            
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <?php echo 'Minggu ' . $uri5 . ' (' . tgl_jam_sql($uri6) . ')' ?>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th width="10%">Kabupaten/Kota</th>
                                <th width="18%">Ketua Tim</th>
                                <th width="10%">Target</th>
                                <th width="10%">Target Kumulatif</th>
                                <th width="10%">Realisasi</th>
                                <th>Realisasi Kumulatif</th>
                                <th width="7%">Aksi</th>
                                <th width="12%">Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no         = 1;
                            $kode_kab   = $datprogress[0] -> id_kab;
                            $targetKum  = 0;
                            $realKum    = 0;

                            for ($i = 0; $i < count($datprogress); $i++){
                                if($i == (count($datprogress)-1)){
                                    $targetKum  += $datprogress[$i] -> target;
                                    $realKum    += $datprogress[$i] -> realisasi;
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $no; ?></td>
                                        <td align="center"><?php echo $datprogress[$i]->id_kab; ?></td>
                                        <td align="center">
                                            <?php
                                            echo $this->M_kelolakegiatan->getPgwTerpilih($datprogress[$i]->ketua_tim);
                                            ?>
                                        </td>
                                        <td align="center"><?php echo $datprogress[$i]->target; ?></td>
                                        <td align="center"><?php echo $targetKum; ?></td>
                                        <td align="center"><?php echo $datprogress[$i]->realisasi; ?></td>
                                        <td align="center">
                                            <?php
                                            $persen =0.00;
                                            if($targetKum == 0){
                                                if($realKum == 0 ){
                                                }else{
                                                    $persen = 100.00;
                                                }
                                            }else{
                                                $persen = round($realKum/$targetKum*100.00,2);
                                            }
                                            if ($persen > 100){
                                                $persen = 100;
                                            }
                                            echo $realKum;
                                            if($persen >= 0 && $persen < 50){
                                                ?>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>">
                                                        <?php echo $persen." %"; ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }elseif($persen >= 50 && $persen < 90  ){
                                                ?>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>">
                                                        <?php echo $persen." %"; ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>">
                                                        <?php echo $persen." %"; ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                            if($this->session->userdata('admin_level') == 'userprov' && $datprogress[$i]->realisasi != 0 && $datprogress[$i]->flag_konfirm =='2')
                                            {
                                                $id_konfirm = $datprogress[$i]->id_jeniskegiatan.''.$datprogress[$i]->id_kab.''.$datprogress[$i]->minggu_ke; ?>
                                                <div class="btn-group">
                                                    <a href="#<?=$no;?>" class="open_modal_konfirm btn btn-success btn-xs"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> </a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td align="center"><?php echo tgl_jam_sql($datprogress[$i]->tgl_entri); ?></td>
                                    </tr>
                                    <?php
                                }
                                else
                                {
                                    if($kode_kab == $datprogress[$i+1]->id_kab){
                                        $targetKum      = $targetKum + $datprogress[$i] -> target;
                                        $realKum        = $realKum + $datprogress[$i] -> realisasi;
                                    }
                                    else
                                    {
                                        $kode_kab   = $datprogress[$i+1] -> id_kab;
                                        $targetKum  += $datprogress[$i] -> target;
                                        $realKum    += $datprogress[$i] -> realisasi;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $no; ?></td>
                                            <td align="center"><?php echo $datprogress[$i]->id_kab; ?></td>
                                            <td align="center">
                                                <?php
                                                echo $this->M_kelolakegiatan->getPgwTerpilih($datprogress[$i]->ketua_tim);
                                                ?>
                                            </td>
                                            <td align="center"><?php echo $datprogress[$i]->target; ?></td>
                                            <td align="center"><?php echo $targetKum; ?></td>
                                            <td align="center"><?php echo $datprogress[$i]->realisasi; ?></td>
                                            <td align="center">
                                                <?php
                                                $persen =0.00;
                                                if($targetKum == 0){
                                                    if($realKum == 0 ){
                                                    }else{
                                                        $persen = 100.00;
                                                    }
                                                }else{
                                                    $persen = round($realKum/$targetKum*100.00,2);
                                                }
                                                if ($persen > 100){
                                                    $persen = 100;
                                                }
                                                echo $realKum;
                                                if($persen >= 0 && $persen < 50){
                                                    ?>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>">
                                                            <?php echo $persen." %"; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }elseif($persen >= 50 && $persen < 90  ){
                                                    ?>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>">
                                                            <?php echo $persen." %"; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>">
                                                            <?php echo $persen." %"; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td align="center">
                                                <?php
                                                if($this->session->userdata('admin_level') == 'userprov' && $datprogress[$i]->flag_konfirm =='2')
                                                {
                                                    $id_konfirm = $datprogress[$i]->id_jeniskegiatan.''.$datprogress[$i]->id_kab.''.$datprogress[$i]->minggu_ke; ?>
                                                    <div class="btn-group">
                                                        <a href="#<?=$no;?>" class="open_modal_konfirm btn btn-success btn-xs"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td align="center"><?php echo tgl_jam_sql($datprogress[$i]->tgl_entri); ?></td>
                                        </tr>
                                        <?php
                                        $targetKum  = 0;
                                        $realKum    = 0;
                                        $no++;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <a href="javascript:history.back()" tabindex="10" class="btn btn-danger"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
        </div>
    </div>
</div>

<!-- Modal Popup untuk Edit--> 
<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

    <!-- Javascript untuk popup modal Edit--> 
    <script type="text/javascript">
        $(document).ready(function () {
            $(".open_modal_konfirm").click(function(e) {
                var m = $(this).attr("id");
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/admin/konfirmasi/edt/",
                    type: "GET",
                    data : {konfirmasi_id: m,},
                    success: function (ajaxData){
                        $("#ModalEdit").html(ajaxData);
                        $("#ModalEdit").modal('show',{backdrop: 'true'});
                    }
                });
            });
        });
    </script>