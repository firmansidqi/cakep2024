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
                          <li class="active"><a href="#tab_1" data-toggle="tab">Mingguan</a></li>
                          <li><a href="#tab_2" data-toggle="tab">Bulanan</a></li>
                          
                          <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="panel-body">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne" style="cursor:pointer;">
                                        <b>
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne">
                                            <?php echo "Minggu 1 ( )"; ?>
                                            </a>
                                        </b>
                                    </div>
                                </div>
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
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_2">
                            <div class="panel-body">
                            The European languages are members of the same family. Their separate existence is a myth.
                            For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                            in their grammar, their pronunciation and their most common words. Everyone realizes why a
                            new common language would be desirable: one could refuse to pay expensive translators. To
                            achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                            words. If several languages coalesce, the grammar of the resulting language is more simple
                            and regular than that of the individual languages.
                            </div>
                          </div>
                          <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- nav-tabs-custom -->
                    </div>
                    <!-- /.col -->

                    
                </div>
                <!-- ACORDION PER MINGGU -->
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
                                                                    if($targetKum == 0){
                                                                        if($realKum == 0){
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
                                                                        $persen = round($realKum/$targetKum*100.00,2);
                                                                    }
                                                                    if($persen >= 0 && $persen < 50){
                                                                    ?>
                                                                        <div class="progress">
                                                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                                                <?php echo $persen." %"; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }elseif($persen >= 50 && $persen < 90){
                                                                    ?>
                                                                        <div class="progress">
                                                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                                                <?php echo $persen." %"; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                        <div class="progress">
                                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
                                                                                <?php echo $persen." %"; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    $persen     = 0.00;
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
                <?php
                }
                ?>
                <!-- AKHIR ACORDION PER MINGGU -->
            </div>
        </div>
    </div>
</div>
