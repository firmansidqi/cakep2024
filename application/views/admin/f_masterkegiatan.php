<?php
$mode		= $this->uri->segment(3);

if($mode == "edt" || $mode == "act_edt"){
	$id_kegiatan        = $datpil->id_kegiatan;
	$nama_kegiatan      = $datpil->kegiatan;
	$id_tim             = $datpil->id_tim;
	$tim                = $datpil->tim;
	$id_unitkerja       = $datpil->id_unitkerja;
	$unitkerja          = $datpil->unitkerja;
	$id_ro              = $datpil->id_ro;
}else{
	$act                = "act_add";
	$id_kegiatan        = "";
	$nama_kegiatan      = "";
	$id_tim             = "";
	$tim                = "";
	$id_unitkerja       = "";
	$unitkerja          = "";
	$id_ro              = "";
}

?>

<div class="modal-dialog">
	<div class="modal-content">
		<?php
		if ($mode == "edt" || $mode == "act_edt"){
			?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Edit Master Kegiatan</h4>
			</div>

			<div class="modal-body">
				<form action="<?php echo base_URL()?>index.php/admin/master_kegiatan/act_edt/" name="modal_popup" enctype="multipart/form-data" method="POST">
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="Kegiatan Name">Nama Kegiatan </label>
						<input type="text" name="nama_kegiatan" id="nama_kegiatan"  class="form-control" value="<?php echo $nama_kegiatan; ?>" tabindex="1" required>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="tim">Tim Kerja</label>
						<select name="tim" id="tim" class="form-control" tabindex="2" required>
							<option selected value="<?php echo $id_tim; ?>" >
								<?php echo $tim; ?>
							</option>
							<?php
							$tim_kerja = $this->db->query("select * from m_tim")->result();
							foreach($tim_kerja as $dat){
								echo "<option value='".$dat->id_tim."'>".$dat->tim."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="subtim">Sub Tim Kerja</label>
						<select name="subtim" id="subtim" class="form-control" tabindex="3" required>
							<option selected value="<?php echo $id_unitkerja; ?>" >
								<?php echo $unitkerja; ?>
							</option>
							<?php
							$subtim_kerja = $this->db->query("select * from m_unitkerja")->result();
							foreach($subtim_kerja as $dat){
								echo "<option value='".$dat->id_unitkerja."'>".$dat->unitkerja."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="ro">Kode Rincian Output</label>
						<select name="ro" id="ro" class="form-control" tabindex="4" required>
							<option selected value="<?php echo $id_ro; ?>" >
								<?php echo $id_ro; ?>
							</option>
							<?php
							$ro = $this->db->query("select * from m_rincianoutput")->result();
							foreach($ro as $dat){
								echo "<option value='".$dat->id_ro."'>".$dat->id_ro."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="modal-footer">
						<button class="btn btn-success" type="submit" tabindex="5" >
							Simpan
						</button>
						<button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true" tabindex="6" >
							Batal
						</button>
					</div>
				</form>
			</div>
			<?php
		}
		else
		{
		    ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Master Kegiatan</h4>
			</div>

			<div class="modal-body">
				<form action="<?php echo base_URL()?>index.php/admin/master_kegiatan/act_add/" name="modal_popup" enctype="multipart/form-data" method="POST">
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="Kegiatan Name">Nama Kegiatan </label>
						<input type="text" name="nama_kegiatan" id="nama_kegiatan"  class="form-control" value="" tabindex="1" required>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="tim">Tim Kerja</label>
						<select name="tim" id="tim" class="form-control" tabindex="2" required>
							<option selected value="" >
								<?php echo "-- Pilih Tim Kerja --"; ?>
							</option>
							<?php
							$tim_kerja = $this->db->query("select * from m_tim")->result();
							foreach($tim_kerja as $dat){
								echo "<option value='".$dat->id_tim."'>".$dat->tim."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="subtim">Sub Tim Kerja</label>
						<select name="subtim" id="subtim" class="form-control" tabindex="3" required>
							<option selected value="" >
								<?php echo "-- Pilih Sub Tim Kerja --"; ?>
							</option>
							<?php
							$subtim_kerja = $this->db->query("select * from m_unitkerja")->result();
							foreach($subtim_kerja as $dat){
								echo "<option value='".$dat->id_unitkerja."'>".$dat->unitkerja."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="ro">Kode Rincian Output</label>
						<select name="ro" id="ro" class="form-control" tabindex="4" required>
							<option selected value="" >
								<?php echo "-- Pilih Kode Rincian Output --"; ?>
							</option>
							<?php
							$ro = $this->db->query("select * from m_rincianoutput")->result();
							foreach($ro as $dat){
								echo "<option value='".$dat->id_ro."'>".$dat->id_ro."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="modal-footer">
						<button class="btn btn-success" type="submit" tabindex="5" >
							Simpan
						</button>
						<button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true" tabindex="6" >
							Batal
						</button>
					</div>
				</form>
			</div>
			<?php
		}
		?>

	</div>
</div>