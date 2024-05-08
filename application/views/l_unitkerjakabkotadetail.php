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

<div class="row col-md-12">
  <div class="panel panel-info">
  	 <div class="panel-heading"> KEGIATAN BERDASARKAN KABUPATEN/KOTA
      <div class="btn-group pull-right">
            <a href="<?php echo base_URL()?>index.php/admin/unitkerjaprovuntukkab/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Provinsi</a>
            <a href="<?php echo base_URL()?>index.php/admin/unitkerjakabkotadetail/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kabupaten/Kota</a>
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

		/*$options_kabkota = array(
							'6500'         => 'Semua Kabkota',
							'6501'         => 'Kabupaten Malinau',
							'6502'         => 'Kabupaten Bulungan',
							'6503'         => 'Kabupaten Tana Tidung',
							'6504'         => 'Kabupaten Nunukan',
							'6571'         => 'Kota Tarakan',
							
							);
					*/
		echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'")."";
	//	echo form_dropdown("pilih_kabkota", $options_kabkota, $uri5, "id='pilih_kabkota' class='form-control' onchange='OnSelectionChange()'")."";
		
		?>
		<br>
		<!--?php 
		    print_r ($this->session->userdata());
		?-->
<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
				<thead>
					<tr class="Success">
						<th width="3%">No.</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="20%">Asal Kegiatan</th>
						<th width="5%">Target</th>
						<th width="5%" colspan="2">Realisasi</th>
						<th width="5%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="10%">Tgl Realisasi</th>
						<th width="15%">Keterangan</th>
					<?php
					if ($this->session->userdata('admin_level') != "userkabkota") 
					{?>
						<th width="7%">Aksi</th>
					<?php
					}
					?>
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
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td>
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry_unitkerjakab/edt/<?php echo $b->id_jeniskegiatan; ?>/<?php echo $b->id_kab; ?>" class="btn btn-danger btn-xs" title="Update Data"><i class="icon-plus icon-white"> </i></a>
							</div>
						</td>
						<td  align="left"><?php echo $b->satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->tgl_entri);?></td>
						<?php
						if($b->flag_konfirm == '2' && $b->tgl_entri != '0000-00-00')
						{
							$ket='Realisasi Belum Dikonfirmasi SM Provinsi';
						}
						else
						{
							$ket = '';
						}
						?>
						<td  align="center"><?php echo $ket;?></td>
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