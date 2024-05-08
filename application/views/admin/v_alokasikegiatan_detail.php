<?php
$uri4 = $this->uri->segment(4);
$this->load->model('M_kelolakegiatan');
?>

<div class="row col-md-12" style="margin:80px 0px">
    <div class="panel panel-info" >
        <div class="panel-heading">
            <!-- <a href="javascript:history.back()" class="btn btn-sm"><i class="icon icon-arrow-left"></i></a> -->
            <h4>DETAIL KEGIATAN</h4>
        </div>
        
        <div class="panel-body">
            
            <div class="col-lg-12 alert alert-warning" style="margin-bottom: 20px">
                <div class="col-md-12">
                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <tr>
                            <td>Nama Sub Kegiatan</td>
                            <td>
                                <?php echo $datview[0]->nmkegiatan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Satuan</td>
                            <td width="70%">
                                <?php echo $datview[0]->nama_satuan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Ketua Tim</td>
                            <td width="70%">
                                <?php echo $this->M_kelolakegiatan->getPgwTerpilih($datview[0]->ketua_tim); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <?php
                                $target = 0;
                                foreach ($datview as $data){
                                    $target += $data->target;
                                }
                                echo $target; 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Rentang Waktu</td>
                            <td>
                                <?php echo tgl_jam_sql($datview[0]->mulai) . " - " . tgl_jam_sql($datview[0]->batas_waktu); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <div class="btn-group ">
                                    <?php
                                    if(!empty($datubah)){
                                        echo "Terdapat Pengajuan Ubah Target";
                                    }
                                    else
                                    {
                                    ?>
                                        <a href="<?php echo base_URL()?>index.php/admin/alokasikegiatan/ubahtarget/<?php echo $datview[0]->id_jeniskegiatan; ?>/" class="btn btn-success btn-xs" title="Ubah target">
                                            <i class="icon-edit icon-white"></i> Ubah Target
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="col-lg-12" style="margin-bottom: 20px">
                <table class="table" style="margin-bottom: 0px">
                    <thead>
                        <tr align="center">
                            <th width="10%"><b>No.</b></td>
                            <th width="15%"><b>Minggu</b></td>
                            <th width="10%"><b>Target</b></td>
                            <th width="10%"><b>Realisasi</b></td>
                            <th width="12%"><b>Target Kumulatif</b></td>
                            <th width="12%"><b>Realisasi Kumulatif</b></td>
                            <th width="31%"><b>Realisasi Kumulatif</b></td>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no             = 1;
                        $targetkum      = 0;
                        $realkum        = 0;
                        $persen         = 0;
                        foreach($datview as $data){
                            echo "<tr align='center'>";
                                echo "<td>".$no."</td>";
                                echo "<td>Minggu ".$data->minggu_ke." (".tgl_jam_sql($data->batas_minggu).")</td>";
                                echo "<td>".$data->target."</td>";
                                echo "<td>".$data->realisasi."</td>";
                                $targetkum  = $targetkum + $data->target;
                                echo "<td>".$targetkum."</td>";
                                $realkum    = $realkum + $data->realisasi;
                                echo "<td>".$realkum."</td>";
                                echo "<td>";
                                    if($targetkum == 0){
                                        if($realkum == 0){
                                            /*if($countflag == 0){
                                                $persen = '0';
                                            }
                                            else
                                            {
                                                 $persen = round($countflag/5*100,2);
                                            }*/
                                        }
                                        else
                                        {
                                            $persen     = '100.00';
                                        }
                                    }
                                    else
                                    {
                                        $persen = round($realkum/$targetkum*100.00,2);
                                    }
                                    
                                    if($persen >= 0 && $persen < 50){
                                    ?>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                <?php echo $persen." %"; ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    elseif($persen >= 50 && $persen < 90)
                                    {
                                    ?>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                <?php echo $persen." %"; ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                <?php echo $persen." %"; ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
            <a href="<?php echo base_URL() ?>index.php/admin/alokasikegiatan/" tabindex="10" class="btn btn-danger"><i
                    class="icon icon-arrow-left icon-white"></i>
                    Kembali
                </a>
            

        </div>
    </div>
</div>
