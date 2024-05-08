<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$idp		= $datpil->id_satuan;
	$satuan	= $datpil->satuan;
		
} else {
	$act		= "act_add";
	$idp		= "";
	$satuan	= "";
}
?>
<div class="navbar navbar-inverse">
	<div class="container" style="z-index: 0">
		<div class="navbar-header">
			<span class="navbar-brand" href="#">Master Satuan</span>
		</div>
	</div><!-- /.container -->
</div><!-- /.navbar -->
	
	<form action="<?php echo base_URL(); ?>index.php/admin/satuan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	<input type="hidden" name="idp" value="<?php echo $idp; ?>">
	
	<div class="row-fluid well" style="overflow: hidden">
	
	<div class="col-lg-12">
		<table width="100%" class="table-form">
		<tr><td width="20%">Satuan</td><td><b><input type="text" name="satuan" required value="<?php echo $satuan; ?>" style="width: 300px" class="form-control" tabindex="1" autofocus></b></td></tr>
		
		<tr><td colspan="2">
		<br><a href="<?php echo base_URL(); ?>index.php/admin/satuan" class="btn btn-success" tabindex="8" ><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
		<button type="submit" class="btn btn-primary" tabindex="7" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>
		
		</td></tr>
		</table>
	</div>
	
	
	
	</div>
	
	</form>
