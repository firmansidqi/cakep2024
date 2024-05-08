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

<div class="row col-md-12" style="margin:80px 0px">
	<div class="panel panel-info">
		<div class="panel-heading">
			DAFTAR SEMUA KEGIATAN
			<?php
				if ($this->session->userdata('admin_level') == "Super Admin" || $this->session->userdata('admin_level') == "userprov")
				{
				?>
					<div class="btn-group pull-right">
						<a href="<?php echo base_URL() ?>index.php/admin/approval/" class="btn btn-warning btn-sm"><i class="icon-check icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Approval Target</a>
						<a href="<?php echo base_URL() ?>index.php/admin/kelolakegiatan/add" class="btn btn-success btn-sm"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
					</div>
				<?php
				}
				else
				{
				    
				}
			?>
			
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
				
				echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'") . "";
				
				foreach($datatim as $tim){
					if ($this->session->userdata('admin_nip') == '6500' || $this->session->userdata('admin_nip') == $tim->id_tim || $this->session->userdata('admin_level') == "pemantau")
					{
						?>
						
						<!-- ACORDION PER TIM -->
						<br>
						<div class="panel panel-warning">
							<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $tim->id_tim; ?>" aria-expanded="true" aria-controls="collapseOne" style="cursor:pointer;">
								<b>
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $tim->id_tim; ?>" aria-expanded="true" aria-controls="collapseOne" style="text-transform:uppercase">
										<?php echo  "TIM ".$tim->tim; ?>
									</a>
								</b>
							</div>
							
							<?php
							if($this->session->userdata('admin_nip') == $tim->id_tim){
							?>
								<div id="collapse<?php echo $tim->id_tim; ?>" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
							<?php
							}else{
								if($tim->id_tim == '65510'){
									?>
									<div id="collapse<?php echo $tim->id_tim; ?>" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
									<?php
							    }
								else{
							        ?>
									<div id="collapse<?php echo $tim->id_tim; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									<?php
							    }
								?>
							<?php
							}
							?>
								<div class="panel-body">
									<div style="max-height:650px; overflow:auto">
										<table class="table table-striped table-hover">
											<thead style="position:sticky; top: 0">
												<tr style="height:60px">
													<th width="5%" style="vertical-align:middle">No.</th>
													<th width="28%" style="vertical-align:middle">Nama Kegiatan</th>
													<th width="10%" style="vertical-align:middle">Target Kumulatif</th>
													<th width="10%" style="vertical-align:middle">Realisasi Kumulatif</th>
													<th width="20%" style="vertical-align:middle">Persentase Kumulatif</th>
													<th width="10%" style="vertical-align:middle">Satuan</th>
													<th width="18%" style="vertical-align:middle">Batas Waktu</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no 	= 1;
												foreach ($data as $dat) {
													if($dat->id_tim == $tim->id_tim){
														?>
														<tr>
															<td align="center"><?php echo $no; ?></td>
															<td><a href="<?php echo base_URL() ?>index.php/admin/kegiatan/view/<?php echo $dat->id_jeniskegiatan; ?>"><?php echo $dat->nmkegiatan; ?></a></td>
															<td align="center"><?php echo $dat->target; ?></td>
															<td align="center"><?php echo $dat->realisasi; ?></td>
															<td align="center">
																<?php
																$targetKum  = $dat->target;
																$realKum    = $dat->realisasi;
																if ($targetKum == 0) {
																	if ($realKum == 0) {
																	} else {
																		$persen = 100.00;
																	}
																} else {
																	$persen = round($realKum / $targetKum * 100.00, 2);
																}
																if ($persen >= 0 && $persen < 50) {
																	?>
																	<div class="progress">
																		<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
																			<?php echo $persen . " %"; ?>
																		</div>
																	</div>
																	<?php
																} elseif ($persen >= 50 && $persen < 90) {
																	?>
																	<div class="progress">
																		<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
																			<?php echo $persen . " %"; ?>
																		</div>
																	</div>
																	<?php
																} else {
																	?>
																	<div class="progress">
																		<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100" style="<?php echo 'width: '.$persen."%"; ?>; max-width:100%; ">
																			<?php echo $persen . " %"; ?>
																		</div>
																	</div>
																	<?php
																}
																?>
																</td>
															<td align="center"><?php echo $dat->nama_satuan; ?></td>
															<td align="center"><?php echo tgl_jam_sql($dat->mulai) . " - " . tgl_jam_sql($dat->batas_waktu); ?></td>
														</tr>
														<?php
														$no++;
													}
												}
												if($no == 1){
													echo "<tr><td colspan='6'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
												}


												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
