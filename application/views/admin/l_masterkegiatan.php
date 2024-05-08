<div class="row col-md-12">
	<div class="panel panel-info" style="margin-top:80px">
		<div class="panel-heading"> DAFTAR MASTER KEGIATAN
			<div class="btn-group pull-right">
				<a href="#" title="Tambah Data" class="btn btn-success btn-sm open_modal_tambah"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
			</div>
		</div>
		<div class="panel-body">
			
			<table class="table table table-hover">
				<thead>
					<tr>
						<th width = 10%>No.</th>
						<th style="text-align:center">Nama Kegiatan</th>
						<th style="text-align:center">Tim Kerja</th>
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
							<td><?php echo $dat->kegiatan?></td>
							<td><?php echo $dat->tim?></td>
							<td align = center>
								<div class="btn-group btn-group-sm">
									<button type="button" class="btn btn-success">
										<a href="#" title="Edit Data" class="open_modal_edit" id="<?php echo $dat->id_kegiatan; ?>">
											<i class="icon-edit icon-white"></i>
										</a>
									</button>
									<button type="button" class="btn btn-danger">
										<i class="icon-trash icon-white"></i>
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

<!-- Modal Popup untuk Tambah-->
<div id="ModalTambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Edit-->
<script type="text/javascript">
	$(document).ready(function() {
		$(".open_modal_tambah").click(function(e) {
			var m = $(this).attr("id");
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/admin/master_kegiatan/add",
				type: "GET",
				data: {
					delete_id: m,
				},
				success: function(ajaxData) {
					$("#ModalTambah").html(ajaxData);
					$("#ModalTambah").modal('show', {
						backdrop: 'true'
					});
				}
			});
		});
	});
</script>

<!-- Modal Popup untuk Edit-->
<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Edit-->
<script type="text/javascript">
	$(document).ready(function() {
		$(".open_modal_edit").click(function(e) {
			var m = $(this).attr("id");
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/admin/master_kegiatan/edt/"+m,
				type: "GET",
				data: {
					delete_id: m,
				},
				success: function(ajaxData) {
					$("#ModalEdit").html(ajaxData);
					$("#ModalEdit").modal('show', {
						backdrop: 'true'
					});
				}
			});
		});
	});
</script>