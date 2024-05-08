<?php 
if($this->uri->segment(4)== NULL)
{
    $hariini=date("d-m-Y");
    $bulanini = substr($hariini,3,2);
    $uri4=$bulanini;
}else{
    $uri4 = $this->uri->segment(4);
}
$uri5 = $this->uri->segment(5);
?>

<script>
    function OnSelectionChange(){
        var pilihbulan  = document.getElementById('pilih_bulan');
        var id_bulan = pilihbulan.value;
        var base_url='<?php echo base_url();?>';
        var loc = base_url+"index.php/admin/unitkerjaprov/pilih_kegiatan/"+id_bulan;
        window.location.assign(loc); 
    }
</script>

<div class="row col-md-12" style="margin:80px 0px">
    <div class="panel panel-info">
        <div class="panel-heading"> DAFTAR SEMUA KEGIATAN BERDASARKAN TIM
        </div>
        <div class="panel-body">
            
            <!-- accordion -->
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                
                <?php 
                $options_bulan = array(
                    //'00'         => 'Semua Bulan',
                    '01'         => 'Januari',
                    '02'         => 'Februari',
                    '03'         => 'Maret',
                    '04'         => 'April',
                    '05'         => 'Mei',
                    '06'         => 'Juni',
                    '07'         => 'Juli',
                    '08'         => 'Agustus',
                    '09'         => 'September',
                    '10'         => 'Oktober',
                    '11'         => 'November',
                    '12'         => 'Desember',
                );
                
                echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'")."";
                ?>
                <br>
                <div class="row">
                    <div class="col-md">
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li><a href="#tab_1" data-toggle="tab">Mingguan</a></li>
                          <li class="active"><a href="#tab_2" data-toggle="tab">Bulanan</a></li>
                          
                          <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="tab_1">
                                <div class="panel-body">
                                <?php
                                for($i = 0; $i < getMinggu($uri4)[0]; $i++){
                                    $Friday    = date("Y-m-d", strtotime("this friday ".date("d-m-Y")));
                                ?>
                                    <br>
                                    <div class="panel panel-warning">
                                        <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne" style="cursor:pointer;">
                                            <b>
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                    <?php echo "Minggu ".($i+1)." ( ".tgl_jam_sql(getMinggu($uri4)[1][$i]).")"; ?>
                                                </a>
                                            </b>
                                        </div>
                                        <?php
                                        if($Friday == getMinggu($uri4)[1][$i]){
                                            ?>
                                            <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                            <?php
                                        }else{
                                            ?>
                                            <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <?php
                                        }
                                        ?>
                                        
                                        <div class="panel-body">
                                            <div style="max-height:650px; overflow:auto">
                                                <table class="table table-striped table-hover">
                                                    <thead style="position:sticky; top: 0">
                                                        <tr style="height:60px">
                                                            <th width="4%" style="vertical-align:middle">No.</th>
                                                            <th width="14%" style="vertical-align:middle">Tim Kerja</th>
                                                            <th width="26%" style="vertical-align:middle">Nama Kegiatan</th>
                                                            <th width="10%" style="vertical-align:middle">Batas Waktu</th>
                                                            <th width="10%" style="vertical-align:middle">Satuan</th>
                                                            <th width="5%" style="vertical-align:middle">Target</th>
                                                            <th width="5%" style="vertical-align:middle">Realisasi</th>
                                                            <th width="13%" style="vertical-align:middle">Persentase</th>
                                                            <th width="13%" style="vertical-align:middle">Persentase Kumulatif</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $targetKum              = 0;
                                                        $realKum                = 0;
                                                        $no                     = 1;
                                                        $persen                 = 0.00;
                                                        $flag                   = 1;
                                                        $targetKumAll           = 0;
                                                        $realKumAll             = 0;
                                                        $persenAll              = 0.00;
                                                        $countflag              = 0;
                                                        foreach($data as $dat){
                                                            //echo $coba;
                                                            if($dat->batas_minggu <= getMinggu($uri4)[1][$i]){
                                                                if($dat->batas_minggu == getMinggu($uri4)[1][$i]){
                                                                    if($dat->id_kab == "6571"){
                                                                        $targetKum      = $targetKum + $dat->target;
                                                                        $realKum        = $realKum + $dat->realisasi;
                                                                        $targetKumAll   = $targetKumAll + $dat->target;
                                                                        $realKumAll     = $realKumAll + $dat->realisasi;
                                                                        ?>
                                                                        <tr>
                                                                            <td align="center"><?php echo $no;?></td>
                                                                            <td><?php echo $dat->tim;?></td>
                                                                            <td data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Dasar :'.$dat->dasar_surat ;?>">
                                                                                <a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/view/<?php echo $dat->id_jeniskegiatan."/".$dat->minggu_ke."/".$dat->batas_minggu."/"; ?>">
                                                                                    <?php echo $dat->nmkegiatan;
                                                                                    if($flag == 2){
                                                                                        ?>
                                                                                        <span class="badge rounded-pill text-dark" style="background-color:#dc3545">New Real</span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </a>
                                                                            </td>
                                                                            <td align="center"><?php echo tgl_jam_sql($dat->batas_waktu);?></td>
                                                                            <td align="center"><?php echo $dat->satuan;?></td>
                                                                            <td align="center"><?php echo $targetKum;?></td>
                                                                            <td align="center"><?php echo $realKum;?></td>
                                                                            <td align="center">
                                                                                <?php 
                                                                                if($targetKum == 0 && $realKum != 0) {
                                                                                    $persen = 100.00;
                                                                                } elseif($targetKum != 0) {
                                                                                    $persen = round($realKum / $targetKum * 100.00, 2);
                                                                                }

                                                                                $progressClass = '';
                                                                                if ($persen >= 0 && $persen < 50) {
                                                                                    $progressClass = 'progress-bar-danger';
                                                                                } elseif ($persen >= 50 && $persen < 90) {
                                                                                    $progressClass = 'progress-bar-warning';
                                                                                } else {
                                                                                    $progressClass = 'progress-bar-success';
                                                                                }
                                                                                ?>

                                                                                <div class="progress">
                                                                                    <div class="progress-bar <?php echo $progressClass; ?>" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                                                        <?php echo $persen." %"; ?>
                                                                                    </div>
                                                                                </div>

                                                                                <?php
                                                                                $persen = 0.00;
                                                                                ?>

                                                                            </td>
                                                                            <td align="center">
                                                                                <?php
                                                                                if($targetKumAll == 0){
                                                                                    if($realKumAll == 0){
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $persenAll  = '100.00';
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    $persenAll = round($realKumAll/$targetKumAll*100.00,2);
                                                                                }
                                                                                if($persenAll >= 0 && $persenAll < 50){
                                                                                ?>
                                                                                    <div class="progress">
                                                                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $persenAll; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persenAll."%"; ?>; max-width:100%; ">
                                                                                            <?php echo $persenAll." %"; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                                }elseif($persenAll >= 50 && $persenAll < 90){
                                                                                ?>
                                                                                    <div class="progress">
                                                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $persenAll; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persenAll."%"; ?>; max-width:100%; ">
                                                                                            <?php echo $persenAll." %"; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                                }else{
                                                                                ?>
                                                                                    <div class="progress">
                                                                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $persenAll; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persenAll."%"; ?>; max-width:100%; ">
                                                                                            <?php echo $persenAll." %"; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                                }
                                                                                $persenAll     = 0.00;
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $targetKum              = 0;
                                                                        $realKum                = 0;
                                                                        $targetKumAll           = 0;
                                                                        $realKumAll             = 0;
                                                                        $flag                   = 1;
                                                                        $countflag              = 0;
                                                                        $no++;
                                                                    }
                                                                    else
                                                                    {
                                                                        $targetKum      = $targetKum + $dat->target;
                                                                        $realKum        = $realKum + $dat->realisasi;
                                                                        $targetKumAll   = $targetKumAll + $dat->target;
                                                                        $realKumAll     = $realKumAll + $dat->realisasi;
                                                                        if($dat->flag_konfirm == 2){
                                                                            $flag               = $dat->flag_konfirm;
                                                                            $countflag          = $countflag + 1;
                                                                        }
                                                                    }
                                                                    
                                                                }
                                                                else
                                                                {
                                                                    $targetKumAll   = $targetKumAll + $dat->target;
                                                                    $realKumAll     = $realKumAll + $dat->realisasi;
                                                                    
                                                                }
                                                            }
                                                        };
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="tab_2">
                                <?php foreach($datatim as $tim){
                                    if ($this->session->userdata('admin_nip') == '6500' || $this->session->userdata('admin_nip') == $tim->id_tim || $this->session->userdata('admin_level') == "pemantau")
                                    { ?>
                                        <br>
                                        <div class="panel-body">
                                            <div style="max-height:650px; overflow:auto">
                                                <table class="table table-striped table-hover">
                                                    <thead style="position:sticky; top: 0">
                                                        <tr style="height:60px">
                                                            <th width="5%" rowspan="2" style="vertical-align:middle">No.</th>
                                                            <th width="28%" rowspan="2" style="vertical-align:middle">Nama Kegiatan</th>
                                                            <th width="10%" colspan="2" style="vertical-align:middle">Bulanan</th>
                                                            <th width="1%" rowspan="2" style="vertical-align:middle"></th>
                                                            <th width="10%" colspan="2" style="vertical-align:middle">Kumulatif</th>
                                                            <th width="20%" rowspan="2" style="vertical-align:middle">Persentase Kumulatif</th>
                                                            <th width="10%" rowspan="2" style="vertical-align:middle">Satuan</th>
                                                        </tr>
                                                        <tr>
                                                            <th width="5%"style="vertical-align:middle">T</th>
                                                            <th width="5%"style="vertical-align:middle">R</th>
                                                            <th width="5%"style="vertical-align:middle">T</th>
                                                            <th width="5%"style="vertical-align:middle">R</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no             = 1;
                                                        $targetkum      = 0;
                                                        $realkum        = 0;
                                                        $idkegiatan     = $data2[0]->id_jeniskegiatan;
                                                        for($i = 0; $i < count($data2); $i++){
                                                            if($i == (count($data2)-1)){
                                                            $targetkum += $data2[$i]->target_mingguan;
                                                            $realkum = $realkum + $data2[$i]->real_mingguan;
                                                            ?>
                                                            <tr>
                                                                <td align="center"><?php echo $no; ?></td>
                                                                <td><?php echo $data2[$i]->nmkegiatan; ?></td>
                                                                <td align="center"><?php echo $targetkum; ?></td>
                                                                <td align="center"><?php echo $realkum; ?></td>
                                                                <td align="center"></td>
                                                                <td align="center"><?php echo $data2[$i]->total_target; ?></td>
                                                                <td align="center"><?php echo $data2[$i]->total_realisasi; ?></td>
                                                                <td align="center">
                                                                    <?php
                                                                    $targetKum = $data2[$i]->target;
                                                                    $realKum = $data2[$i]->realisasi;
                                                                    $persen = ($targetKum == 0) ? (($realKum == 0) ? null : 100.00) : round($realKum / $targetKum * 100.00, 2);
                                                                    $progressClass = ($persen >= 0 && $persen < 50) ? 'progress-bar-danger' : (($persen >= 50 && $persen < 90) ? 'progress-bar-warning' : 'progress-bar-success');
                                                                    ?>

                                                                    <div class="progress">
                                                                        <div class="progress-bar <?php echo $progressClass; ?>" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                                            <?php echo $persen . " %"; ?>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td align="center"><?php echo $data2[$i]->nama_satuan; ?></td>
                                                            </tr>
                                                            <?php
                                                            }else{
                                                                if($idkegiatan == $data2[$i+1]->id_jeniskegiatan)
                                                                {
                                                                    $targetkum  += $data2[$i]->target_mingguan;
                                                                    $realkum    += $data2[$i]->real_mingguan;    
                                                                }
                                                                else
                                                                {
                                                                    $targetkum  += $data2[$i]->target_mingguan;
                                                                    $realkum    += $data2[$i]->real_mingguan;
                                                                ?>
                                                                    <tr>
                                                                        <td align="center"><?php echo $no; ?></td>
                                                                        <td><?php echo $data2[$i]->nmkegiatan; ?></td>
                                                                        <td align="center"><?php echo $targetkum; ?></td>
                                                                        <td align="center"><?php echo $realkum; ?></td>
                                                                        <td align="center"></td>
                                                                        <td align="center"><?php echo $data2[$i]->total_target; ?></td>
                                                                        <td align="center"><?php echo $data2[$i]->total_realisasi; ?></td>
                                                                        <td align="center">
                                                                            <?php
                                                                            $targetKum = $data2[$i]->target;
                                                                            $realKum = $data2[$i]->realisasi;
                                                                            $persen = ($targetKum == 0) ? ($realKum == 0 ? null : 100.00) : round($realKum / $targetKum * 100.00, 2);
                                                                            $progressClass = ($persen >= 0 && $persen < 50) ? 'progress-bar-danger' : (($persen >= 50 && $persen < 90) ? 'progress-bar-warning' : 'progress-bar-success');
                                                                            ?>
                                                                            <div class="progress">
                                                                                <div class="progress-bar <?php echo $progressClass; ?>" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                                                    <?php echo $persen . " %"; ?>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td align="center"><?php echo $data2[$i]->nama_satuan; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                    $targetkum  = 0;
                                                                    $realkum    = 0;
                                                                    $idkegiatan = $data2[$i+1]->id_jeniskegiatan;
                                                                    $no++;
                                                                }
                                                            
                                                            }}
                                                            if($no == 1){
                                                                echo "<tr><td colspan='6'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
    </div>
</div>
