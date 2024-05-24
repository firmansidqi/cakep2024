<?php
$this->load->model('M_kelolakegiatan');
$hariini=date("d-m-Y");
if($this->uri->segment(4)== NULL)
{
    $bulanini = substr($hariini,3,2);
    $uri4=$bulanini;
}
else
{   
    $uri4 = $this->uri->segment(4);
}
//$uri5 = $this->uri->segment(5);
?>

<style style type="text/css">
    table.dataTable thead .sorting { background: url('/evita/aset/img/sort_both.png') no-repeat center right; }
    table.dataTable thead .sorting_asc { background: url('/evita/aset/img/sort_asc.png') no-repeat center right; }
    table.dataTable thead .sorting_desc { background: url('/evita/aset/img/sort_desc.png') no-repeat center right; }
    table.dataTable thead .sorting_asc_disabled { background: url('/evita/aset/img/sort_asc_disabled.png') no-repeat center right; }
    table.dataTable thead .sorting_desc_disabled { background: url('/evita/aset/img/sort_desc_disabled.png') no-repeat center right; }
</style>

<script>
    $(document).ready(function () {
        $('#dtBasicExample').DataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false,
            "searching": false
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>

<script>
    function OnSelectionChange()
    {
        var pilihbulan  = document.getElementById('pilih_bulan');
        var id_bulan = pilihbulan.value;
        //var pilihkabkota  = document.getElementById('pilih_kabkota');
        //var id_kabkota = pilihkabkota.value;
        var base_url='<?php echo base_url();?>';
        var loc = base_url+"index.php/admin/unitkerjakabkotadetail/pilih_kegiatan/"+id_bulan ;
        window.location.assign(loc); 
    }
</script>

<div class="row col-md-12" style="margin:80px 0px">
    <div class="panel panel-info">
        
        <div class="panel-heading">KEGIATAN BERDASARKAN KABUPATEN/KOTA
            <!--div class="btn-group pull-right">
                <a href="<?php echo base_URL()?>index.php/admin/unitkerjaprovuntukkab/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Provinsi</a>
                <a href="<?php echo base_URL()?>index.php/admin/unitkerjakabkotadetail/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kabupaten/Kota</a>
            </div-->
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
                                    <marquee style="animation: marquee 10s linear infinite;font-size: 1em;color: #333;"><b>Entri seluruh kegiatan pada masing-masing minggu, sehingga seluruh kegiatan berstatus <i>approve</i>. Jika terdapat kegiatan yang telah selesai pada minggu sebelumnya, isikan realisasi sebesar 0 pada minggu saat ini/setelahnya. Begitu pula, Jika terdapat kegiatan memiliki target sebesar 0, isikan realisasi sebesar 0. || Jika ada pertanyaan/permasalahan silahkan akses s.bps.go.id/cakepkaltara</b></marquee>
                                <div class="panel-body">
                                    <?php
                                    for($i = 0; $i < getMinggu($uri4)[0]; $i++)
                                    {
                                        $no = 1;
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
                                            <?php }else{ ?>
                                            <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <?php } ?>
                                                <div class="panel-body">
                                                    <div style="max-height:650px; overflow:auto">
                                                        <table class="table table-striped table-hover">
                                                            <thead style="position:sticky; top: 0; z-index:2">
                                                                <tr style="height:60px">
                                                                    <th width="4%" style="vertical-align:middle">No.</th>
                                                                    <th width="17%" style="vertical-align:middle">Tim Kerja</th>
                                                                    <th width="30%" style="vertical-align:middle">Nama Kegiatan</th>
                                                                    <th width="10%" style="vertical-align:middle">Satuan</th>
                                                                    <th width="5%" style="vertical-align:middle">Target</th>
                                                                    <th width="10%" colspan="2" style="vertical-align:middle">Realisasi</th>
                                                                    <th width="10%" style="vertical-align:middle">Batas Waktu</th>
                                                                    <th width="14%" style="vertical-align:middle">Keterangan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                                //$konfirm = 1;
                                                                foreach($data as $d){
                                                                    if($d->batas_minggu == getMinggu($uri4)[1][$i]){
                                                                        ?>
                                                                        <tr>
                                                                            <td align="center"><?php echo $no; $no++?></td>
                                                                            
                                                                            <td><?php echo $d->tim;?></td>
                                                                            <td>
                                                                                <?php 
                                                                                echo $d->nmkegiatan;
                                                                                if($d->flag_konfirm == 1)
                                                                                {
                                                                                ?>
                                                                                    <span class="badge rounded-pill text-dark" style="background-color:#8da3b9">Belum Entri</span>
                                                                                <?php
                                                                                }
                                                                                else if($d->flag_konfirm == 2)
                                                                                {
                                                                                ?>
                                                                                    <span class="badge rounded-pill text-dark" style="background-color:#ff9c07">Approval</span>
                                                                                <?php
                                                                                }else if($d->flag_konfirm == 3)
                                                                                {
                                                                                ?>
                                                                                    <span class="badge rounded-pill text-dark" style="background-color:#41a341">Approve</span>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td align="center"><?php echo $d->satuan;?></td>
                                                                            <td align="center">
                                                                                <?php echo $d->target;?>       
                                                                            </td>
                                                                            <td align="center">
                            
                                                                            <?php 
                                                                                if($d->flag_konfirm == 1)
                                                                                {
                                                                                    echo "-";    
                                                                                }else{
                                                                                    echo $d->realisasi;
                                                                                }
                                                                            ?>        
                                                                            </td>
                                                                            <td align="center">
                                                                                <div class="btn-group">
                                                                                    <a href="<?php echo base_URL()?>index.php/admin/entry_unitkerjakab/edt/<?php echo $d->id_jeniskegiatan; ?>/<?php echo $d->id_kab; ?>/<?php echo $d->minggu_ke; ?>" class="btn btn-danger btn-xs" title="Update Data"><i class="icon-plus icon-white"> </i></a>
                                                                                </div>
                                                                            </td>
                                                                            <td align="center"><?php echo tgl_jam_sql($d->batas_waktu);?></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    <?php      
                                                                    }
                                                                }
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
                          <div class="tab-pane" id="tab_2">
                            <div class="panel-body">
                                <!-- isi tab 2 -->
                                <div style="border-radius: 16px 16px 0px 0px; overflow:hidden; ">
                                    <table class="table" style="height: 60px">
                                        <thead>
                                            <tr>
                                                <th width="3%" rowspan="2">No.</th>
                                                <th width="30%" rowspan="2">Nama Kegiatan</th>
                                                <th width="15%" rowspan="2">Unit Kerja</th>
                                                <th width="8%" colspan="2" title="bulbul">Bulanan</th>
                                                <th width="1%" rowspan="2"></th>
                                                <th width="8%" colspan="2">Kumulatif</th>
                                                <th width="20%" rowspan="2">Persentase Kumulatif</th>
                                                <th width="5%" rowspan="2">Ket</th>
                                                <th width="2%" rowspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th width="4%">T</th>
                                                <th width="4%">R</th>
                                                <th width="4%">T</th>
                                                <th width="4%">R</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                
                                <div style="border-radius: 0px 0px 16px 16px; max-height:615px; overflow:auto">
                                    <table class="table table-striped table-hover" style="border-radius:0px; x">
                                        <tbody>
                                            <?php 
                                            if (empty($data2)) {
                                                echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
                                            } else {
                                                $no             = 1;
                                                for($i = 0; $i < count($data2); $i++){
                                                    ?>
                                                    <tr>
                                                        <td width="3%" align="center"><?php echo $no;?></td>
                                                        <td width="30%"><?php echo $data2[$i]->nama_kegiatan;?></td>
                                                        <td width="15%"><?php echo $data2[$i]->tim;?></td>
                                                        <td width="4%" align="center"><?php echo $data2[$i]->target_month;?></td>
                                                        <td width="4%" align="center"><?php echo $data2[$i]->realisasi_month;?></td>
                                                        <td width="4%" align="center"><?php echo $data2[$i]->target_kum;?></td>
                                                        <td width="4%" align="center"><?php echo $data2[$i]->realisasi_kum;?></td>
                                                        <td width="20%">
                                                            <?php
                                                                if($data2[$i]->target_kum == 0)
                                                                {
                                                                    $persen = ($data2[$i]->realisasi_kum == 0) ? 'tidak ada target' : '100.00'; 
                                                                }
                                                                else
                                                                {
                                                                    $persen = round($data2[$i]->realisasi_kum/$data2[$i]->target_kum*100.00,2);
                                                                    
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
                                                        <td width="4%" class="ctr">     
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                }
                                                 
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- akhir isi tab 2 -->
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
            </div>
        </div>
    </div>
</div>
