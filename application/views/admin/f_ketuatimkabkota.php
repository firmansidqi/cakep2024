<?php
$mode		    = $this->uri->segment(3);
$idkab          = $this->session->userdata('admin_nip');
$db2            = $this->load->database('db2',TRUE);

$act		    = "act_ketua";
$idkegiatan     = $datpil->id_jeniskegiatan;
$namakegiatan   = $datpil->nmkegiatan;
$ketuatim       = $ketua->ketua_tim;

?>

<div class="modal-dialog">
	<div class="modal-content" style="margin-top:80px">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Ketua Tim Kegiatan</h4>
		</div>
		
		<div class="modal-body">
		    <form action="<?php echo base_URL()?>index.php/admin/alokasikegiatan/<?php echo $act;?>/" name="modal_popup" enctype="multipart/form-data" method="POST">
		        <div class="form-group" style="padding-bottom: 20px;">
					<label for="kegiatan">Nama Kegiatan </label>
					<input type="hidden" name="id_jeniskegiatan"  class="form-control" value="<?php echo $idkegiatan; ?>" />
					<input type="text" name="nama_kegiatan"  class="form-control" value="<?php echo $namakegiatan ; ?>" disabled/>
				</div>
				
				<div class="form-group" style="padding-bottom: 20px;">
					<label for="ketua_tim">Ketua Tim </label>
					<?php
					$namaketua  = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$idkab' AND niplama = '$ketuatim' LIMIT 1")->row();
					$pegawai    = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$idkab' ORDER BY id_org ")->result();
					?>
					<select name="ketua_tim" id="ketua_tim" class="form-control" tabindex="2" required>
					    <?php
					    if($ketuatim == ''){
					        ?>
					        <option selected value="" >
    							<?php echo "-- Pilih Ketua Tim --"; ?>
    						</option>
					        <?php
					    }else{
					        ?>
					        <option selected value="<?php echo $ketuatim ; ?> ">
    							<?php echo $namaketua->gelar_depan." ".$namaketua->nama." ".$namaketua->gelar_belakang; ?>
    						</option>
					        <?php
					    }
						foreach($pegawai as $dat){
							echo "<option value='".$dat->niplama."'>".$dat->gelar_depan." ".$dat->nama." ".$dat->gelar_belakang."</option>\n";
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
	</div>
</div>