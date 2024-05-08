<?php
$id_jeniskegiatan=$this->uri->segment(4);
$nama_kegiatan_ini=$this->db->query("SELECT nama_kegiatan FROM m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan' LIMIT 1")->row();

$tab=1;
if(null!==$this->uri->segment(5))
{
	$tab = $this->uri->segment(5);
}

?>

<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>


<div class="clearfix">
<div class="row">
  <div class="col-lg-12">
	<div class="navbar navbar-inverse">
	
		<div class="navbar-header">
			<span class="navbar-brand" href="#">Konfirmasi Realisasi Kegiatan Dari Kabupaten/Kota : <?php echo $nama_kegiatan_ini->nama_kegiatan;?> </span>
		</div>

</div><!-- /.navbar -->
  
	
	<div class="container">
	<div class="row">
    <div class="col-sm-12 blog-main">
	<div class="tabs">
        <!-- content blog anda isikan disini-->
		<ul class="nav nav-tabs" id="prodTabs">
			<li <?php echo $tab==1?"class='active'":"" ?> ><a href="#all" data-toggle="tab">All</a></li>
			<li <?php echo $tab==2?"class='active'":"" ?>><a href="#tu" data-toggle="tab">Bagian Umum</a></li>
			<li <?php echo $tab==3?"class='active'":"" ?>><a href="#sos" data-toggle="tab">Fungsi Statistik Sosial</a></li>
			<li <?php echo $tab==4?"class='active'":"" ?>><a href="#prod" data-toggle="tab">Fungsi Statistik Produksi</a></li>
			<li <?php echo $tab==5?"class='active'":"" ?>><a href="#dist" data-toggle="tab">Fungsi Statistik Distribusi</a></li>
			<li <?php echo $tab==6?"class='active'":"" ?>><a href="#ner" data-toggle="tab">Fungsi Nerwilis</a></li>
			<li <?php echo $tab==7?"class='active'":"" ?>><a href="#ipds" data-toggle="tab">Fungsi IPDS</a></li>
	  </ul>
      <!-- Tab panes content dari tab di atas -->
      <div class="tab-content">
      <div class="tab-pane <?php echo $tab==1?"active":"" ?>" id="all"><br>
	   		<table class="table table-bordered table-striped  table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Tgl Update Terakhir</th>
						<th width="10%">Konfirmasi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($dataall)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($dataall as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td  style="display:none"><?php echo $b->id_jeniskegiatan;?></td>
						<td  style="display:none"><?php echo $b->nama_kegiatan;?></td>
						<td><?php echo $b->id_kab.' '.$b->nama_kab; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td align="center"><?php 
							if($b->tgl_entri=='0000-00-00')
							{
								echo '-';
							}
							else
							{
							echo tgl_jam_sql($b->tgl_entri);
							}
							?>
						</td>
						<td  align="center">
								<?php $id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab;
								//echo $id_konfirm;
								?>
								<a href="#" class="open_modal" id="<?php echo $id_konfirm;?>"><i class="icon-question-sign"></i>Konfirmasi</a>		
						</td>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
		
	    </div>
        <div class="tab-pane <?php echo $tab==2?"active":"" ?>" id="tu"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Tgl Update Terakhir</th>
						<th width="10%">Konfirmasi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($datatu)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($datatu as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td  style="display:none"><?php echo $b->id_jeniskegiatan;?></td>
						<td  style="display:none"><?php echo $b->nama_kegiatan;?></td>
						<td><?php echo $b->id_kab.' '.$b->nama_kab; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td align="center"><?php 
							if($b->tgl_entri=='0000-00-00')
							{
								echo '-';
							}
							else
							{
							echo tgl_jam_sql($b->tgl_entri);
							}
							?>
						</td>
						<td  align="center">
								<?php $id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab;
								//echo $id_konfirm;
								?>
								<a href="#" class="open_modal" id="<?php echo $id_konfirm;?>"><i class="icon-question-sign"></i>Konfirmasi</a>		
						</td>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
			<center><ul class="pagination"><?php echo $pagi; ?></ul></center>
		</div>
        <div class="tab-pane <?php echo $tab==3?"active":"" ?>" id="sos"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Tgl Update Terakhir</th>
						<th width="10%">Konfirmasi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($datasos)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($datasos as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td  style="display:none"><?php echo $b->id_jeniskegiatan;?></td>
						<td  style="display:none"><?php echo $b->nama_kegiatan;?></td>
						<td><?php echo $b->id_kab.' '.$b->nama_kab; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td align="center"><?php 
							if($b->tgl_entri=='0000-00-00')
							{
								echo '-';
							}
							else
							{
							echo tgl_jam_sql($b->tgl_entri);
							}
							?>
						</td>
						<td  align="center">
								<?php $id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab;
								//echo $id_konfirm;
								?>
								<a href="#" class="open_modal" id="<?php echo $id_konfirm;?>"><i class="icon-question-sign"></i>Konfirmasi</a>		
						</td>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
		
		
		</div>
        <div class="tab-pane <?php echo $tab==4?"active":"" ?>" id="prod"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Tgl Update Terakhir</th>
						<th width="10%">Konfirmasi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($dataprod)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($dataprod as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td  style="display:none"><?php echo $b->id_jeniskegiatan;?></td>
						<td  style="display:none"><?php echo $b->nama_kegiatan;?></td>
						<td><?php echo $b->id_kab.' '.$b->nama_kab; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td align="center"><?php 
							if($b->tgl_entri=='0000-00-00')
							{
								echo '-';
							}
							else
							{
							echo tgl_jam_sql($b->tgl_entri);
							}
							?>
						</td>
						<td  align="center">
								<?php $id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab;
								//echo $id_konfirm;
								?>
								<a href="#" class="open_modal" id="<?php echo $id_konfirm;?>"><i class="icon-question-sign"></i>Konfirmasi</a>		
						</td>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
		
		</div>
		<div class="tab-pane <?php echo $tab==5?"active":"" ?>" id="dist"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Tgl Update Terakhir</th>
						<th width="10%">Konfirmasi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($datadist)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($datadist as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td  style="display:none"><?php echo $b->id_jeniskegiatan;?></td>
						<td  style="display:none"><?php echo $b->nama_kegiatan;?></td>
						<td><?php echo $b->id_kab.' '.$b->nama_kab; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td align="center"><?php 
							if($b->tgl_entri=='0000-00-00')
							{
								echo '-';
							}
							else
							{
							echo tgl_jam_sql($b->tgl_entri);
							}
							?>
						</td>
						<td  align="center">
								<?php $id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab;
								//echo $id_konfirm;
								?>
								<a href="#" class="open_modal" id="<?php echo $id_konfirm;?>"><i class="icon-question-sign"></i>Konfirmasi</a>		
						</td>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
		
		
		</div>
		<div class="tab-pane <?php echo $tab==6?"active":"" ?> " id="ner"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Tgl Update Terakhir</th>
						<th width="10%">Konfirmasi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($datanerwil)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($datanerwil as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td  style="display:none"><?php echo $b->id_jeniskegiatan;?></td>
						<td  style="display:none"><?php echo $b->nama_kegiatan;?></td>
						<td><?php echo $b->id_kab.' '.$b->nama_kab; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td align="center"><?php 
							if($b->tgl_entri=='0000-00-00')
							{
								echo '-';
							}
							else
							{
							echo tgl_jam_sql($b->tgl_entri);
							}
							?>
						</td>
						<td  align="center">
								<?php $id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab;
								//echo $id_konfirm;
								?>
								<a href="#" class="open_modal" id="<?php echo $id_konfirm;?>"><i class="icon-question-sign"></i>Konfirmasi</a>		
						</td>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
	
		
		</div>
		<div class="tab-pane <?php echo $tab==7?"active":"" ?> " id="ipds"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Tgl Update Terakhir</th>
						<th width="10%">Konfirmasi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($dataipds)) {
						echo "<tr><td colspan='5' style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($dataipds as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td  style="display:none"><?php echo $b->id_jeniskegiatan;?></td>
						<td  style="display:none"><?php echo $b->nama_kegiatan;?></td>
						<td><?php echo $b->id_kab.' '.$b->nama_kab; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td align="center"><?php 
							if($b->tgl_entri=='0000-00-00')
							{
								echo '-';
							}
							else
							{
							echo tgl_jam_sql($b->tgl_entri);
							}
							?>
						</td>
						<td  align="center">
								<?php $id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab;
								//echo $id_konfirm;
								?>
								<a href="#" class="open_modal" id="<?php echo $id_konfirm;?>"><i class="icon-question-sign"></i>Konfirmasi</a>		
						</td>
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
	</div>
	 <a href="javascript:history.back()" style="font-size:16px" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
    </div><!-- /.blog-main -->
	</div>
	</div><!-- /.container -->

  
	
	</div>
  </div>
</div>

<?php echo $this->session->flashdata("k");?>

<!-- Modal Popup untuk Edit--> 
<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Edit--> 
<script type="text/javascript">
   $(document).ready(function () {
   $(".open_modal").click(function(e) {
      var m = $(this).attr("id");
		   $.ajax({
    			   url: "<?php echo base_url(); ?>index.php/admin/konfirmasi/edt/",
    			   type: "GET",
    			   data : {konfirmasi_id: m,},
    			   success: function (ajaxData){
      			   $("#ModalEdit").html(ajaxData);
      			   $("#ModalEdit").modal('show',{backdrop: 'true'});
      		   }
    		   });
        });
      });
</script>	
<!--	
<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <strong>Well done!</strong> You successfully read <a href="http://bootswatch.com/amelia/#" class="alert-link">this important alert message</a>.
</div>
	
<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <strong>Oh snap!</strong> <a href="http://bootswatch.com/amelia/#" class="alert-link">Change a few things up</a> and try submitting again.
</div>	
-->



