<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$id_jeniskegiatan		= $datpil->id_jeniskegiatan;
	$nama_kegiatan			= $datpil->nama_kegiatan;
	$target					= $datpil->target;
	$realisasi				= $datpil->realisasi;
	$bukti					= $datpil->bukti;
	$kabkota				= $datpil->id_kab.' '.$datpil->nama_kab ;
	//$tab					= $datpil->tab;
	
} else {
	$act		= "act_add";
	$id_jeniskegiatan		= "";
	$nama_kegiatan			= "";
	$target					= "";
	$realisasi				= "";
	$bukti					= "";
	$kabkota				= "";
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
<div class="navbar navbar-inverse">
	<div class="container z0">
		<div class="navbar-header">
			<span class="navbar-brand" href="#">Entri Progress Kegiatan</span>
		</div>
	</div><!-- /.container -->
</div><!-- /.navbar -->

<?php echo $this->session->flashdata("k");?>
	
<form action="<?php echo base_URL()?>index.php/admin/entry/<?php echo $act; ?>" method="post" accept-charset="utf-8" role="form" enctype="multipart/form-data">
	
	<!--<input type="hidden" name="idp" value="<?php// echo $idp; ?>">-->
	
	<div class="row-fluid well" style="overflow: hidden">
	
	<div class="col-lg-8">
		<table width="100%" class="table-form">
		<?php
			if ($this->session->userdata('admin_user') == "3300") 
			{
			?>
			<tr>
			<td width="20%">Kab/Kota</td>
			<td width="20%">
			<select name="kabkota" class="form-control" tabindex="3" style="width: 400px" onchange="selectkegiatan()" required>
                    <option value="Kosong">--Pilih--</option>
                        <?php
                        //mengambil nama-nama jenis yang ada di database
                        $kabkota = mysql_query("select * from m_kab");
                        while($p=mysql_fetch_array($kabkota)){
                        echo "<option value=\"$p[id_kab]\">$p[nama_kab]</option>\n";
                        }
                        ?>
            </select>
			</td></tr>
			<?php
			}
			else
			{
			?>
		
			<tr>
			<td width="20%">Kab/Kota</td>
			<td><b><input type="text" tabindex="1" name="kabkota" id="kabkota" required value="<?php echo $kabkota; ?>" style="width: 400px" class="form-control" readonly></b></td></tr>
			<?php
			}
			?>
			<tr>
			<td width="20%">ID Kegiatan</td>
			<td><b><input type="text" tabindex="1"  name="id_jeniskegiatan" id="id_jeniskegiatan" required value="<?php echo $id_jeniskegiatan; ?>" style="width: 400px" class="form-control" readonly></b></td></tr>
		<tr>
			<td width="20%">Nama Kegiatan</td>
			<td><b><input type="text" tabindex="1"  name="nama_kegiatan" id="nama_kegiatan" required value="<?php echo $nama_kegiatan; ?>" style="width: 400px" class="form-control" readonly></b></td>
		</tr>
	
	<!--	
	<tr><td width="20%">Asal Kegiatan</td><td><b>
			<select name="unitkerja" id="unitkerja"  class="form-control" tabindex="3" style="width: 400px" onchange="selectkegiatan()">
                    <option value="Kosong">--Pilih--</option>
                        <?php
                        //mengambil nama-nama jenis yang ada di database
                        $unitkerja = mysql_query("select * from m_unitkerja where substring(id_unitkerja,4,1) <> '0' and substring(id_unitkerja,5,1) = '0'");
                        while($p=mysql_fetch_array($unitkerja)){
                        echo "<option value='.$p[id_unitkerja].'>$p[unitkerja]</option>\n";
                        }
                        ?>
            </select>
		</b></td></tr>		
		<tr><td width="20%">Nama Kegiatan</td><td><b>
		<select name="jeniskegiatan" id="jeniskegiatan" class="form-control"style="width: 400px" onchange="selecttarget()">
             <option value="Kosong">-- Pilih Nama Kegiatan--</option>
         </select>
		</td></tr>
		-->
		<tr>
			<td width="20%">Target</td>
			<td><b><input type="text" tabindex="5" name="target" required value="<?php echo $target; ?>" id="target" style="width: 100px" class="form-control" readonly></b>
			</td>
		</tr>
		<tr style="display:none">
			<td width="20%">Tab</td>
			<td><b><input type="text" tabindex="2" name="tab" required value="<?php echo $tab; ?>" id="tab" style="width: 100px" class="form-control"></b>
			</td>
		</tr>	
		<tr>
			<td width="20%">Realisasi</td><td><b><input type="text" tabindex="5" name="realisasi" required value="<?php echo $realisasi; ?>" id="realisasi" style="width: 100px" class="form-control" readonly></b>
			</td>
		</tr>	
		<tr>
			<td width="20%">Update Realisasi</td><td><b><input type="text" autofocus tabindex="6" name="newrealisasi" required  id="newrealisasi" style="width: 100px" class="form-control"></b>
			Masukkan Realisasi Kumulatif sampai Tanggal Pelaporan</td>
		</tr>
		<tr>
			<td width="20%">Bukti Realisasi Kegiatan</td>
			<td><b><input type="text" tabindex="7" name="bukti" id="bukti" required value="<?php echo $bukti; ?>" style="width: 400px" class="form-control"></b></td></tr>		
		<tr><td colspan="2">
		<br><a href="javascript:history.back()" tabindex="10" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Batal</a>
		<button type="submit" class="btn btn-primary" tabindex="9" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>
		
		</td></tr>
		
		</table>
	</div>
	
	</div>
	
	</form>
