<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$id_jeniskegiatan		= $datpil->id_jeniskegiatan;
	$nama_kegiatan			= $datpil->nama_kegiatan;
	$target					= $datpil->target;
	$tgl_entri				= $datpil->tgl_entri;
	$realisasi				= $datpil->realisasi;
	$bukti					= $datpil->bukti;
	$kabkotalengkap			= $datpil->id_kab.' '.$datpil->nama_kab ;
	$link_pengiriman		= $datpil->link_pengiriman;
	
} else {
	$act		= "act_add";
	$id_jeniskegiatan		= "";
	$nama_kegiatan			= "";
	$target					= "";
	$tgl_entri				= "";
	$realisasi				= "";
	$bukti					= "";
	$link_pengiriman		= "";
	$kabkotalengkap			= "";
}
?>
<script type="text/javascript">
	function selectkegiatan()
			{
			   var unitkerja=$('#unitkerja').val();
			 
			 $.post('<?php echo base_url();?>index.php/admin/get_kegiatan/',
			 {
			 unitkerja:unitkerja
			 
			 },
			 function(data) 
			 {
			 $('#jeniskegiatan').html(data);
			 }); 
			 
			}
</script>
<script type="text/javascript">			
	function selecttarget()
			{
			window.alert ('Halooo');
			 var kabkota=$('#kabkota').val();
			 var jeniskegiatan=$('#jeniskegiatan').val();
			 
			 $.post('<?php echo base_url();?>index.php/admin/get_target/',
			 {
			 kabkota:kabkota
			 jeniskegiatan:jeniskegiatan
			 },
			 function(data) 
			 {
				$('#target').html(data);
				$('#realisasi').html(data);
			 }); 
			 
			}
	
</script>


<script type="text/javascript">		
		function callTarget(){
			window.alert ('Halooo');
			var kabkota=$('#kabkota').val();
			var jeniskegiatan=$('#jeniskegiatan').val();
		if(kabkota&&jeniskegiatan){
			
			$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/admin/get_target/",
			data: { kabkota:kabkota
					jeniskegiatan:jeniskegiatan
			}
			}).done(function(data) {
			$("#target").val(data);
			});
		}
		}
</script>

<?php echo $this->session->flashdata("k");?>

<div class="row col-md-12">
  <div class="panel panel-info">
  	 <div class="panel-heading"> KETERANGAN PENGIRIMAN REALISASI KEGIATAN
      <div class="btn-group pull-right">
            <a href="<?php echo base_URL()?>index.php/admin/unitkerjaprov/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Provinsi</a>
            <a href="<?php echo base_URL()?>index.php/admin/unitkerjakabkota/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kabupaten/Kota</a>
       </div>
    </div>
    <div class="panel-body">


	
<form action="<?php echo base_URL()?>index.php/admin/entry_unitkerja/<?php echo $act; ?>" method="post" accept-charset="utf-8" role="form" enctype="multipart/form-data">
	

	
	<div class="row-fluid well" style="overflow: hidden">
	
	<div class="col-lg-8">
		<table width="100%" class="table-form">
		
		
			<tr>
			<td width="20%">Kab/Kota</td>
			<td><b><input type="text" tabindex="1" name="kabkota" id="kabkota" required value="<?php echo $kabkotalengkap; ?>" style="width: 400px" class="form-control" readonly></b></td></tr>
			<?php
			//}
			?>
			<tr>
			<td width="20%">ID Kegiatan</td>
			<td><b><input type="text" tabindex="1"  name="id_jeniskegiatan" id="id_jeniskegiatan" required value="<?php echo $id_jeniskegiatan; ?>" style="width: 400px" class="form-control" readonly></b></td></tr>
		<tr>
			<td width="20%">Nama Kegiatan</td>
			<td><b><input type="text" tabindex="1"  name="nama_kegiatan" id="nama_kegiatan" required value="<?php echo $nama_kegiatan; ?>" style="width: 400px" class="form-control" readonly></b></td>
		</tr>
	

		<tr>
			<td width="20%">Target</td>
			<td><b><input type="text" tabindex="5" name="target" required value="<?php echo $target; ?>" id="target" style="width: 100px" class="form-control" readonly></b>
			</td>
		</tr>
		
		<tr>
			<td width="20%">Realisasi</td><td><b><input type="text" tabindex="5" name="realisasi" required value="<?php echo $realisasi; ?>" id="realisasi" style="width: 100px" class="form-control" readonly></b>
			</td>
		</tr>
		<tr>
			<td width="20%">Tanggal Realisasi</td><td><b><input type="text" tabindex="5" name="tgl_entri" required value="<?php echo $tgl_entri; ?>" id="tgl_entri" style="width: 100px" class="form-control"></b>
			</td>
		</tr>		
		<tr>
			<td width="20%">Update Realisasi</td><td><b><input type="text" autofocus tabindex="6" name="newrealisasi" required  id="newrealisasi" style="width: 100px" class="form-control"></b>
			Masukkan Realisasi Kumulatif sampai Tanggal Pelaporan</td>
		</tr>
		<tr>
			<td width="20%">Dikirim Melalui</td>
			<td><b><input type="text" tabindex="7" name="bukti" id="bukti" required value="<?php echo $bukti; ?>" style="width: 400px" class="form-control"></b></td></tr>		
		<tr>
			<td width="20%">Link Pengiriman</td>
			<td><b><input type="text" tabindex="7" required name="link_pengiriman" id="link_pengiriman" value="<?php echo $link_pengiriman; ?>" style="width: 400px" class="form-control"></b></td></tr>		
		<tr><td colspan="2">
		<br><a href="javascript:history.back()" tabindex="10" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Batal</a>
		<button type="submit" class="btn btn-primary" tabindex="9" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>
		
		</td></tr>
		
		</table>
	</div>
	
	</div>
	
	</form>
      </div>
    </div>
  </div>