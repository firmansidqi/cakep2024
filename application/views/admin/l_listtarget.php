<?php
if ($this->uri->segment(4) == NULL) {
	$hariini = date("d-m-Y");
	$bulanini = substr($hariini, 3, 2);
	$uri4 = $bulanini;
} else {
	$uri4 = $this->uri->segment(4);
}
?>

<script>
	function OnSelectionChange() {
		var pilihbulan = document.getElementById('pilih_bulan');
		var id_bulan = pilihbulan.value;
		var base_url = '<?php echo base_url(); ?>';
		var loc = base_url + "index.php/admin/kegiatan/pilih_kegiatan/" + id_bulan;
		window.location.assign(loc);
	}
</script>

<div class="row col-md-12" style="margin-top:80px">
	<div class="panel panel-info">
		<div class="panel-heading"> DAFTAR PENGAJUAN PERUBAHAN TARGET MINGGUAN
			<div class="btn-group pull-right">
			    <a href="<?php echo base_URL() ?>index.php/admin/approval/" class="btn btn-warning btn-sm"><i class="icon-check icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Approval Target</a>
				<a href="<?php echo base_URL() ?>index.php/admin/kelolakegiatan/add" class="btn btn-success btn-sm"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
			</div>
		</div>
		<div class="panel-body">

			<!-- accordion -->
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php
				/*$options_bulan = array(
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

				echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'") . "";*/
				?>

				<table class="table table table-hover">
				<thead>
					<tr>
						<th width = 10%>No.</th>
						<th style="text-align:center">Nama Kegiatan</th>
						<th style="text-align:center">Kabupaten/Kota</th>
						<th style="text-align:center">Status</th>
						<th style="text-align:center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no     = 1;
					foreach($data as $dat){
						?>
						<tr>
							<td align = center><?php echo $no; ?></td>
							<td><?php echo $dat->nama_kegiatan; ?></td>
							<td><?php echo $dat->nama_kab; ?></td>
							<td>
							    <?php
							    if($dat->flag_approval == 2){
							        echo "Pengajuan Kabkota";
							    }elseif($dat->flag_approval == 1){
							        echo "Disetujui";
							    }else{
							        echo "Ditolak";
							    }
							    ?>
							</td>
							<td align = center>
								<div class="btn-group btn-group-sm">
									<button type="button" class="btn btn-success btn-sm">
										<a href="<?php echo base_URL() ?>index.php/admin/approval/approv/<?php echo $dat->id_pengajuan ?>">
											<i class="icon-edit icon-white"></i>
										</a>
									</button>
								</div>
							</td>
						</tr>
						<?php
						$no++;
					}
					?>
				</tbody>
				
			</table>
			</div>
		</div>
	</div>
</div>
