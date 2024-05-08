<?php
$mode		= $this->uri->segment(3);

if($mode == "edt" || $mode == "act_edt"){
	$id_kegiatan        = $datpil->id_kegiatan;
	$nama_kegiatan      = $datpil->kegiatan;
	$id_subkegiatan     = $datpil->id;
	$nama_subkegiatan   = $datpil->nama_kegiatan;
	$id_satuan          = $datpil->satuan;
	$nama_satuan        = $datpil->nama_satuan;
	$id_komponen        = $datpil->id_komponen;
	$nama_komponen      = $datpil->kd_komponen.' '.$datpil->komponen;
}else{
	$act                = "act_add";
	$id_kegiatan        = "";
	$nama_kegiatan      = "";
	$id_subkegiatan     = "";
	$nama_subkegiatan   = "";
	$id_satuan          = "";
	$nama_satuan        = "";
	$id_komponen        = "";
}

?>

<div class="modal-dialog">
	<div class="modal-content">
		<?php
		if ($mode == "edt" || $mode == "act_edt"){
			?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Edit Master Sub Kegiatan</h4>
			</div>

			<div class="modal-body">
				<form action="<?php echo base_URL()?>index.php/admin/listkegiatan/act_edt/" name="modal_popup" enctype="multipart/form-data" method="POST">
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="kegiatan">Nama Kegiatan </label>
						<select name="kegiatan" id="kegiatan" class="form-control" tabindex="1" required>
							<option selected value="<?php echo $id_kegiatan; ?>" >
								<?php echo $nama_kegiatan; ?>
							</option>
							<?php
							$tkegiatan      = $this->db->query("select * from m_kegiatan")->result();
							foreach($tkegiatan as $dat){
								echo "<option value='".$dat->id_kegiatan."'>".$dat->kegiatan."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="tim">Nama Sub Kegiatan</label>
						<input type="text" name="nama_subkegiatan" id="nama_subkegiatan"  class="form-control" value="<?php echo $nama_subkegiatan; ?>" tabindex="2" required>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="satuan">Satuan</label>
						<select name="satuan" id="satuan" class="form-control" tabindex="3" required>
							<option selected value="<php echo $id_satuan; ?>" >
								<?php echo $nama_satuan; ?>
							</option>
							<?php
							$satuan         = $this->db->query("select * from m_satuan")->result();
							foreach($satuan as $dat){
								echo "<option value='".$dat->id_satuan."'>".$dat->satuan."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="komponen">Kode Komponen</label>
						<select name="komponen" id="komponen" class="form-control" tabindex="4" required>
							<option selected value="<php echo $id_komponen; ?>" >
								<?php echo $nama_komponen; ?>
							</option>
							<?php
							$komponen       = $this->db->query("select * from m_komponen")->result();
							foreach($komponen as $dat){
								echo "<option value='".$dat->id."'>".$dat->id_komponen." ".$dat->komponen."</option>\n";
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
				<h4 class="modal-title" id="myModalLabel">Tambah Master Sub Kegiatan</h4>
			</div>

			<div class="modal-body">
				<form action="<?php echo base_URL()?>index.php/admin/listkegiatan/act_add/" name="modal_popup" enctype="multipart/form-data" method="POST">
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="kegiatan">Nama Kegiatan </label>
						<select name="kegiatan" id="kegiatan" class="form-control" tabindex="1" required>
							<option selected value="" >
								<?php echo "-- Pilih Kegiatan --"; ?>
							</option>
							<?php
							$tkegiatan      = $this->db->query("select * from m_kegiatan")->result();
							foreach($tkegiatan as $dat){
								echo "<option value='".$dat->id_kegiatan."'>".$dat->kegiatan."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="tim">Nama Sub Kegiatan</label>
						<input type="text" name="nama_subkegiatan" id="nama_subkegiatan"  class="form-control" value="" tabindex="2" required>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="satuan">Satuan</label>
						<select name="satuan" id="satuan" class="form-control" tabindex="3" required>
							<option selected value="" >
								<?php echo "-- Pilih Satuan --"; ?>
							</option>
							<?php
							$satuan         = $this->db->query("select * from m_satuan")->result();
							foreach($satuan as $dat){
								echo "<option value='".$dat->id_satuan."'>".$dat->satuan."</option>\n";
							}
							?>
						</select>
					</div>
					
					<div class="form-group" style="padding-bottom: 20px;">
						<label for="komponen">Kode Komponen</label>
						<select name="komponen" id="komponen" class="form-control" tabindex="4" required>
							<option selected value="" >
								<?php echo "-- Pilih Kode Komponen --"; ?>
							</option>
							<?php
							$komponen       = $this->db->query("select * from m_komponen")->result();
							foreach($komponen as $dat){
								echo "<option value='".$dat->id."'>".$dat->id_komponen." ".$dat->komponen."</option>\n";
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