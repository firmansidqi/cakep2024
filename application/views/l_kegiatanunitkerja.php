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
  var base_url='<?php echo base_url();?>';
  var loc = base_url+"index.php/admin/unitkerjaprov/pilih_kegiatan/"+id_bulan;
  window.location.assign(loc); 
 }
</script>

<div class="row col-md-12">
  <div class="panel panel-info">
  	 <div class="panel-heading"> DAFTAR SEMUA KEGIATAN BERDASARKAN BAGIAN/FUNGSI
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

		echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'")."";
		?>
		<br>
					<!-- UMUM-->
					<div class="panel panel-warning">
						<div class="panel-heading">BAGIAN UMUM
						</div>
					</div>
					<div class="panel panel-default">

						  <div class="panel-body">

							<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<tr>
									<th width="10%">No.</th>
									<th width="10%">ID Kegiatan</th>
									<th width="30%">Nama Kegiatan</th>
									<th width="15%">Tanggal Berakhir</th>
									<th width="10%">Target</th>
									<th width="10%">Realisasi</th>
									<th width="15%">Persentase</th>
									
								</tr>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (empty($datatu)) {
									echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
								} else {
									$no 	= 1;
									foreach ($datatu as $b) {
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td><?php echo $b->id_jeniskegiatan;?></td>
									<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Dasar :'.$b->dasar_surat ;?>"><a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
									<td><?php echo tgl_jam_sql($b->batas_waktu);?></td>
									<td align="center"><?php echo $b->target; ?></td>
									<td align="center"><?php echo $b->realisasi;?></td>
									<?php
									if($b->persen >= '0' && $b->persen <= '50')
									{
									?>
									<td  align="center" style="background-color:red"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else if($b->persen > '50' && $b->persen <= '90')
									{
									?>
									<td  align="center" style="background-color:orange"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else
									{
									?>
									<td  align="center" style="background-color:green"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									?>
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
					<!-- END BAGIAN UMUM -->
						
				
				<!-- SOSIAL-->
					<div class="panel panel-warning">
						<div class="panel-heading">FUNGSI STATISTIK SOSIAL
						</div>
					</div>
					<div class="panel panel-default">

						  <div class="panel-body">

							<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<tr>
									<th width="10%">No.</th>
									<th width="10%">ID Kegiatan</th>
									<th width="30%">Nama Kegiatan</th>
									<th width="15%">Tanggal Berakhir</th>
									<th width="10%">Target</th>
									<th width="10%">Realisasi</th>
									<th width="15%">Persentase</th>
									
								</tr>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (empty($datasos)) {
									echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
								} else {
									$no 	= 1;
									foreach ($datasos as $b) {
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td><?php echo $b->id_jeniskegiatan;?></td>
									<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Dasar :'.$b->dasar_surat ;?>"><a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
									<td><?php echo tgl_jam_sql($b->batas_waktu);?></td>
									<td align="center"><?php echo $b->target; ?></td>
									<td align="center"><?php echo $b->realisasi;?></td>
									<?php
									if($b->persen >= '0' && $b->persen <= '50')
									{
									?>
									<td  align="center" style="background-color:red"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else if($b->persen > '50' && $b->persen <= '90')
									{
									?>
									<td  align="center" style="background-color:orange"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else
									{
									?>
									<td  align="center" style="background-color:green"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									?>
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
					<!-- END FUNGSI SOSIAL -->
					
					
					<!-- PRODUKSI-->
					<div class="panel panel-warning">
						<div class="panel-heading">FUNGSI STATISTIK PRODUKSI
						</div>
					</div>
					<div class="panel panel-default">

						  <div class="panel-body">

							<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<tr>
									<th width="10%">No.</th>
									<th width="10%">ID Kegiatan</th>
									<th width="30%">Nama Kegiatan</th>
									<th width="15%">Tanggal Berakhir</th>
									<th width="10%">Target</th>
									<th width="10%">Realisasi</th>
									<th width="15%">Persentase</th>
									
								</tr>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (empty($dataprod)) {
									echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
								} else {
									$no 	= 1;
									foreach ($dataprod as $b) {
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td><?php echo $b->id_jeniskegiatan;?></td>
									<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Dasar :'.$b->dasar_surat ;?>"><a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
									<td><?php echo tgl_jam_sql($b->batas_waktu);?></td>
									<td align="center"><?php echo $b->target; ?></td>
									<td align="center"><?php echo $b->realisasi;?></td>
									<?php
									if($b->persen >= '0' && $b->persen <= '50')
									{
									?>
									<td  align="center" style="background-color:red"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else if($b->persen > '50' && $b->persen <= '90')
									{
									?>
									<td  align="center" style="background-color:orange"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else
									{
									?>
									<td  align="center" style="background-color:green"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									?>
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
					<!-- END FUNGSI PRODUKSI -->
					
					
					<!-- DISTRIBUSI-->
					<div class="panel panel-warning">
						<div class="panel-heading">FUNGSI STATISTIK DISTRIBUSI
						</div>
					</div>
					<div class="panel panel-default">

						  <div class="panel-body">

							<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<tr>
									<th width="10%">No.</th>
									<th width="10%">ID Kegiatan</th>
									<th width="30%">Nama Kegiatan</th>
									<th width="15%">Tanggal Berakhir</th>
									<th width="10%">Target</th>
									<th width="10%">Realisasi</th>
									<th width="15%">Persentase</th>
									
								</tr>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (empty($datadist)) {
									echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
								} else {
									$no 	= 1;
									foreach ($datadist as $b) {
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td><?php echo $b->id_jeniskegiatan;?></td>
									<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Dasar :'.$b->dasar_surat ;?>"><a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
									<td><?php echo tgl_jam_sql($b->batas_waktu);?></td>
									<td align="center"><?php echo $b->target; ?></td>
									<td align="center"><?php echo $b->realisasi;?></td>
									<?php
									if($b->persen >= '0' && $b->persen <= '50')
									{
									?>
									<td  align="center" style="background-color:red"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else if($b->persen > '50' && $b->persen <= '90')
									{
									?>
									<td  align="center" style="background-color:orange"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else
									{
									?>
									<td  align="center" style="background-color:green"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									?>
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
					<!-- END FUNGSI DISTRIBUSI -->
					
					
					
					<!-- NERWILIS-->
					<div class="panel panel-warning">
						<div class="panel-heading">FUNGSI NERACA WILAYAH DAN ANALISIS STATISTIK
						</div>
					</div>
					<div class="panel panel-default">

						  <div class="panel-body">

							<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<tr>
									<th width="10%">No.</th>
									<th width="10%">ID Kegiatan</th>
									<th width="30%">Nama Kegiatan</th>
									<th width="15%">Tanggal Berakhir</th>
									<th width="10%">Target</th>
									<th width="10%">Realisasi</th>
									<th width="15%">Persentase</th>
									
								</tr>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (empty($datanerwil)) {
									echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
								} else {
									$no 	= 1;
									foreach ($datanerwil as $b) {
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td><?php echo $b->id_jeniskegiatan;?></td>
									<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Dasar :'.$b->dasar_surat ;?>"><a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
									<td><?php echo tgl_jam_sql($b->batas_waktu);?></td>
									<td align="center"><?php echo $b->target; ?></td>
									<td align="center"><?php echo $b->realisasi;?></td>
									<?php
									if($b->persen >= '0' && $b->persen <= '50')
									{
									?>
									<td  align="center" style="background-color:red"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else if($b->persen > '50' && $b->persen <= '90')
									{
									?>
									<td  align="center" style="background-color:orange"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else
									{
									?>
									<td  align="center" style="background-color:green"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									?>
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
					<!-- END FUNGSI NERWILIS -->
					
					
					<!-- IPDS-->
					<div class="panel panel-warning">
						<div class="panel-heading">FUNGSI INTEGRASI PENGOLAHAN DAN DISEMINASI STATISTIK
						</div>
					</div>
					<div class="panel panel-default">

						  <div class="panel-body">

							<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<tr>
									<th width="10%">No.</th>
									<th width="10%">ID Kegiatan</th>
									<th width="30%">Nama Kegiatan</th>
									<th width="15%">Tanggal Berakhir</th>
									<th width="10%">Target</th>
									<th width="10%">Realisasi</th>
									<th width="15%">Persentase</th>
									
								</tr>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (empty($dataipds)) {
									echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
								} else {
									$no 	= 1;
									foreach ($dataipds as $b) {
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td><?php echo $b->id_jeniskegiatan;?></td>
									<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo 'Dasar :'.$b->dasar_surat ;?>"><a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
									<td><?php echo tgl_jam_sql($b->batas_waktu);?></td>
									<td align="center"><?php echo $b->target; ?></td>
									<td align="center"><?php echo $b->realisasi;?></td>
									<?php
									if($b->persen >= '0' && $b->persen <= '50')
									{
									?>
									<td  align="center" style="background-color:red"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else if($b->persen > '50' && $b->persen <= '90')
									{
									?>
									<td  align="center" style="background-color:orange"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									else
									{
									?>
									<td  align="center" style="background-color:green"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
									<?php
									}
									?>
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
					<!-- END FUNGSI IPDS -->
					
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