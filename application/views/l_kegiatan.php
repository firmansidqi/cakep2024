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
        var loc = base_url+"index.php/admin/kegiatan/pilih_kegiatan/"+id_bulan ;
        window.location.assign(loc);
    }
</script>

<div class="row col-md-12">
    <div class="panel panel-info">
        <div class="panel-heading"> DAFTAR SEMUA KEGIATAN
            <div class="btn-group pull-right">
                <a href="<?php echo base_URL()?>index.php/admin/kegiatan/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Semua Kegiatan</a>
                <a href="<?php echo base_URL()?>index.php/admin/kegiatan_bidang/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Bagian/Fungsi</a>
                <a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/add" class="btn btn-success btn-sm"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
            </div>
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
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="3%">No.</th>
                        <th width="7%">ID Kegiatan</th>
                        <th width="30%">Nama Kegiatan</th>
                        <th width="25%">Unit Kerja</th>
                        <th width="6%">Target</th>
                        <th width="6%">Realisasi</th>
                        <th width="6%">Satuan</th>
                        <th width="10%">Batas Waktu</th>
                        <th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="left"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->mulai)."-".tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
							</div>	
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
      </div>
    </div>
  </div>

  
  <!-- Modal Popup untuk Delete--> 
<div id="ModalDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Edit--> 
<script type="text/javascript">
   $(document).ready(function () {
   $(".open_modal").click(function(e) {
      var m = $(this).attr("id");
		   $.ajax({
    			   url: "<?php echo base_url(); ?>index.php/admin/kelolakegiatan/del/",
    			   type: "GET",
    			   data : {delete_id: m,},
    			   success: function (ajaxData){
      			   $("#ModalDelete").html(ajaxData);
      			   $("#ModalDelete").modal('show',{backdrop: 'true'});
      		   }
    		   });
        });
      });
</script>