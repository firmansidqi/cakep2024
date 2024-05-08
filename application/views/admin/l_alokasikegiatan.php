<?php 
if($this->uri->segment(4)== NULL)
{  
	$hariini=date("d-m-Y");
	$bulanini = substr($hariini,3,2);
	$uri4=$bulanini;
}
else
{	
	$uri4 = $this->uri->segment(4);
}
?>

<script>
	function OnSelectionChange()
	{
		var pilihbulan  = document.getElementById('pilih_bulan');
		var id_bulan = pilihbulan.value;
		var base_url='<?php echo base_url();?>';
		var loc = base_url+"index.php/admin/alokasikegiatan/pilih_kegiatan/"+id_bulan ;
		window.location.assign(loc);
	}
</script>

<div class="row col-md-12" style="margin:80px 0px">
	<div class="panel panel-info">
		<div class="panel-heading">
		    <h4>DAFTAR SEMUA KEGIATAN</h4>
		</div>
		<div class="panel-body">

			<!-- accordion -->
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php
				$options_bulan = array(
					'00'         => 'Semua Bulan',
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
				<div style="border-radius: 16px 16px 0px 0px; overflow:hidden; ">
                    <table class="table" style="height: 60px">
                        <thead>
                            <tr>
                                <th width="3%">No.</th>
                                <th width="25%">Nama Kegiatan</th>
                                <th width="13%">Unit Kerja</th>
                                <th width="13%">Penanggung Jawab</th>
                                <th width="8%">Satuan</th>
                                <th width="8%">Target</th>
                                <th width="10%">Realisasi</th>
                                <th width="14%">Batas Waktu</th>
                                <th width="5%">Aksi</th>
                                <th width="1%"></th>
                            </tr>
                        </thead>
                    </table>
				</div>
				
				<div style="border-radius: 0px 0px 16px 16px; max-height:615px; overflow:auto">
                    <table class="table table-striped table-hover" style="border-radius:0px; x">
                        <tbody>
                            <?php 
                            if (empty($data)) {
                                echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
                            } else {
                                $no 	        = 1;
                                $targetkum      = 0;
                                $realkum        = 0;
                                $idkegiatan     = $data[0]->idkgt;
                                for($i = 0; $i < count($data); $i++){
                                    if($i == (count($data)-1)){
                                        $targetkum      = $targetkum + $data[$i]->target_mingguan;
                                        $realkum        = $realkum + $data[$i]->real_mingguan;
                                        ?>
                                        <tr>
                                            <td width="3%" align="center"><?php echo $no;?></td>
                                            <td width="25%"><a href="<?php echo base_URL()?>index.php/admin/alokasikegiatan/view/<?php echo $data[$i]->id_jeniskegiatan; ?>"><?php echo $data[$i]->nmkegiatan;?></a></td>
                                            <td width="13%"><?php echo $data[$i]->tim;?></td>
                                            <td width="13%"><?php echo $this->M_kelolakegiatan->getPgwTerpilih($data[$i]->ketua); ?></td>
                                            <td width="8%" align="center"><?php echo $data[$i]->nama_satuan;?></td>
                                            <td width="8%" align="center"><?php echo $targetkum;?></td>
                                            <td width="10%">
                                                <?php
                                                    if($targetkum == 0)
                                                    {
                                                        if($realkum == 0){
                                                            
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
                                                    $persen     = 0.00;
                                                    ?>
                                            </td>
                                            <td width="14%" align="center"><?php echo tgl_jam_sql($data[$i]->mulai) . " - " . tgl_jam_sql($data[$i]->batas_waktu); ?></td>
                                            <td width="5%" class="ctr">
                                                <div class="btn-group">
                                                    <!-- <a href="<?php echo base_URL()?>index.php/admin/alokasikegiatan/ubahtarget/<?php echo $data[$i]->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Ubah target"><i class="icon-edit icon-white"> </i></a> -->
                                                    <a href="#" class="btn btn-info btn-xs open_modal_ketuatim" title="Alokasikan PJ" id="<?php echo $data[$i]->idkgt ;?>"><i class="icon-user icon-white"></i></a>
                                                </div>	
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    else
                                    {
                                        if($idkegiatan == $data[$i+1]->idkgt)
                                        {
                                            $targetkum      = $targetkum + $data[$i]->target_mingguan;
                                            $realkum        = $realkum + $data[$i]->real_mingguan;
                                            
                                        }
                                        else
                                        {
                                            $targetkum      = $targetkum + $data[$i]->target_mingguan;
                                            $realkum        = $realkum + $data[$i]->real_mingguan;
                                            ?>
                                            <tr>
                                                <td width="3%" align="center"><?php echo $no;?></td>
                                                <td width="25%"><a href="<?php echo base_URL()?>index.php/admin/alokasikegiatan/view/<?php echo $data[$i]->id_jeniskegiatan; ?>"><?php echo $data[$i]->nmkegiatan;?></a></td>
                                                <td width="13%"><?php echo $data[$i]->tim;?></td>
                                                <td width="13%"><?php echo $this->M_kelolakegiatan->getPgwTerpilih($data[$i]->ketua); ?></td>
                                                <td width="8%" align="center"><?php echo $data[$i]->nama_satuan;?></td>
                                                <td width="8%" align="center"><?php echo $targetkum;?></td>
                                                <td width="10%">
                                                    <?php
                                                    if($targetkum == 0)
                                                    {
                                                        if($realkum == 0){
                                                            
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
                                                    $persen     = 0.00;
                                                    ?>
                                                </td>
                                                <td width="14%" align="center"><?php echo tgl_jam_sql($data[$i]->mulai) . " - " . tgl_jam_sql($data[$i]->batas_waktu); ?></td>
                                                <td width="5%" class="ctr">
                                                    <div class="btn-group">
                                                        <!-- <a href="<?php echo base_URL()?>index.php/admin/alokasikegiatan/ubahtarget/<?php echo $data[$i]->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Ubah target"><i class="icon-edit icon-white"> </i></a> -->
                                                        <a href="#" class="btn btn-info btn-xs open_modal_ketuatim" title="Alokasikan PJ" id="<?php echo $data[$i]->id_jeniskegiatan ;?>"><i class="icon-user icon-white"></i></a>
                                                    </div>	
                                                </td>
                                            </tr>
                                            <?php
                                            $no++;
                                            $targetkum  = 0;
                                            $realkum    = 0;
                                            $idkegiatan = $data[$i+1]->idkgt;
                                        }
                                    }
                                }
                                
                            }
                            ?>
                        </tbody>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Popup Alokasi Ketua Tim--> 
<div id="ModalKetua" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<!-- Javascript untuk popup modal Alokasi Ketua Tim--> 
<script type="text/javascript">
	$(document).ready(function () {
		$(".open_modal_ketuatim").click(function(e) {
			var m = $(this).attr("id");
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/admin/alokasikegiatan/ketua/"+m,
				type: "GET",
				success: function (ajaxData){
					$("#ModalKetua").html(ajaxData);
					$("#ModalKetua").modal('show',{backdrop: 'true'});
				}
			});
		});
	});
</script>
