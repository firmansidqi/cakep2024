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
$uri5 = $this->uri->segment(5);
?>

<script>
 function OnSelectionChange()
 {
  var pilihbulan  = document.getElementById('pilih_bulan');
  var id_bulan = pilihbulan.value;
  var pilihkabkota  = document.getElementById('pilih_kabkota');
  var id_kabkota = pilihkabkota.value;
  var base_url='<?php echo base_url();?>';
  var loc = base_url+"index.php/admin/unitkerjakabkota/pilih_kegiatan/"+id_bulan+"/"+id_kabkota ;
  window.location.assign(loc); 
 }
</script>

<div class="row col-md-12">
  <div class="panel panel-info">
  	 <div class="panel-heading"> DAFTAR SEMUA KEGIATAN BERDASARKAN KABUPATEN/KOTA
      <div class="btn-group pull-right">
            <a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Provinsi</a>
            <a href="<?php echo base_URL()?>index.php/admin/unitkerjakabkota/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kabupaten/Kota</a>
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

		$options_kabkota = array(
							'6500'         => 'Semua Kabkota',
							'6501'         => 'Kabupaten Malinau',
							'6502'         => 'Kabupaten Bulungan',
							'6503'         => 'Kabupaten Tana Tidung',
							'6504'         => 'Kabupaten Nunukan',
							'6571'         => 'Kota Tarakan',

							);
					
		echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'")."";
		echo form_dropdown("pilih_kabkota", $options_kabkota, $uri5, "id='pilih_kabkota' class='form-control' onchange='OnSelectionChange()'")."";
		
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
						<td><a href="<?php echo base_URL()?>index.php/admin/unitkerjakabkota/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="left"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						
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