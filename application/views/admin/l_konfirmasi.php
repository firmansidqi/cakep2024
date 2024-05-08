<div class="clearfix">
<div class="row">
  <div class="col-lg-12">
	<div class="navbar navbar-inverse">
	
		<div class="navbar-header">
			<span class="navbar-brand" href="#">Konfirmasi Realisasi Kegiatan Dari Kabupaten/Kota</span>
		</div>

</div><!-- /.navbar -->
	
  
	 <?php echo $this->session->flashdata("k");?> 
	<div class="container">
	<div class="row">
    <div class="col-sm-12 blog-main">
	<div class="tabs">
        <!-- content blog anda isikan disini-->
		<ul class="nav nav-tabs" id="prodTabs">
			<li class="active"><a href="#all" data-toggle="tab">All</a></li>
			<li><a href="#tu" data-toggle="tab">Bagian Umum</a></li>
			<li><a href="#sos" data-toggle="tab">Fungsi Statistik Sosial</a></li>
			<li><a href="#prod" data-toggle="tab">Fungsi Statistik Produksi</a></li>
			<li><a href="#dist" data-toggle="tab">Fungsi Statistik Distribusi</a></li>
			<li><a href="#ner" data-toggle="tab">Fungsi Nerwilis</a></li>
			<li><a href="#ipds" data-toggle="tab">Fungsi IPDS</a></li>
	  </ul>
      <!-- Tab panes content dari tab di atas -->
      <div class="tab-content">
      <div class="tab-pane active" id="all"><br>
	   		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						
						<th width="10%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="27%">Nama Kegiatan</th>
						<th width="25%">Jumlah Yang Harus Dikonfirmasi</th>
			
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
						<td align="center"><?php echo $no;?></td>
						<td align="center" ><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/konfirmasi/detail/<?php echo $b->id_jeniskegiatan; ?>/1"><?php echo $b->nama_kegiatan;?></a></td>
						<td align="center"><?php echo $b->jumlah_dikonfirm; ?></td>
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
        <div class="tab-pane" id="tu"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="27%">Nama Kegiatan</th>
						<th width="25%">Jumlah Yang Harus Dikonfirmasi</th>
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
						<td align="center"><?php echo $no;?></td>
						<td align="center" ><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/konfirmasi/detail/<?php echo $b->id_jeniskegiatan; ?>/2"><?php echo $b->nama_kegiatan;?></a></td>
						<td align="center"><?php echo $b->jumlah_dikonfirm; ?></td>
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
        <div class="tab-pane" id="sos"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
					
						<th width="10%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="27%">Nama Kegiatan</th>
						<th width="25%">Jumlah Yang Harus Dikonfirmasi</th>

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
						<td align="center"><?php echo $no;?></td>
						<td align="center" ><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/konfirmasi/detail/<?php echo $b->id_jeniskegiatan; ?>/3"><?php echo $b->nama_kegiatan;?></a></td>
						<td align="center"><?php echo $b->jumlah_dikonfirm; ?></td>
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
        <div class="tab-pane" id="prod"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="27%">Nama Kegiatan</th>
						<th width="25%">Jumlah Yang Harus Dikonfirmasi</th>
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
						<td align="center"><?php echo $no;?></td>
						<td align="center" ><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/konfirmasi/detail/<?php echo $b->id_jeniskegiatan; ?>/4"><?php echo $b->nama_kegiatan;?></a></td>
						<td align="center"><?php echo $b->jumlah_dikonfirm; ?></td>
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
		<div class="tab-pane" id="dist"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="27%">Nama Kegiatan</th>
						<th width="25%">Jumlah Yang Harus Dikonfirmasi</th>
					</tr>
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
						<td align="center"><?php echo $no;?></td>
						<td align="center" ><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/konfirmasi/detail/<?php echo $b->id_jeniskegiatan; ?>/5"><?php echo $b->nama_kegiatan;?></a></td>
						<td align="center"><?php echo $b->jumlah_dikonfirm; ?></td>
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
		<div class="tab-pane" id="ner"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="27%">Nama Kegiatan</th>
						<th width="25%">Jumlah Yang Harus Dikonfirmasi</th>
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
						<td align="center"><?php echo $no;?></td>
						<td align="center" ><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/konfirmasi/detail/<?php echo $b->id_jeniskegiatan; ?>/6"><?php echo $b->nama_kegiatan;?></a></td>
						<td align="center"><?php echo $b->jumlah_dikonfirm; ?></td>
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
		<div class="tab-pane" id="ipds"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="10%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="27%">Nama Kegiatan</th>
						<th width="25%">Jumlah Yang Harus Dikonfirmasi</th>
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
						<td align="center"><?php echo $no;?></td>
						<td align="center" ><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/konfirmasi/detail/<?php echo $b->id_jeniskegiatan; ?>/7"><?php echo $b->nama_kegiatan;?></a></td>
						<td align="center"><?php echo $b->jumlah_dikonfirm; ?></td>
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
	   </div>
	</div>
    </div><!-- /.blog-main -->
	</div>
	</div><!-- /.container -->
  
  
	
	</div>
  </div>
</div>


	
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



