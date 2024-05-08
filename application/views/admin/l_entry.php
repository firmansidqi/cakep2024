<?php
	if($this->uri->segment(3) == null )
	{
	$tab=1;
	}
	else if(null!==$this->uri->segment(3) && ( $this->uri->segment(3) != 'add' || $this->uri->segment(3) != 'edt') )
	{
		$tab = $this->uri->segment(3);
	}
		
?>


<div class="clearfix">
<div class="row">
  <div class="col-lg-12">
	<div class="navbar navbar-inverse">
	
		<div class="navbar-header">
			<span class="navbar-brand" href="#">Entry Progress Kegiatan</span>
		</div>
	</div><!-- /.navbar -->
  
  
	  
	<div class="container">
	<div class="row">
    <div class="col-sm-12 blog-main">
	
	<?php echo $this->session->flashdata("k");?>
	
	<div class="tabs">
        <!-- content blog anda isikan disini-->
		<ul class="nav nav-tabs" id="prodTabs">
			<li <?php echo $tab==1?"class='active'":"" ?> ><a href="#all" data-toggle="tab">All</a></li>
			<li <?php echo $tab==2?"class='active'":"" ?> ><a href="#tu" data-toggle="tab">Bagian Umum</a></li>
			<li <?php echo $tab==3?"class='active'":"" ?> ><a href="#sos" data-toggle="tab">Fungsi Statistik Sosial</a></li>
			<li <?php echo $tab==4?"class='active'":"" ?> ><a href="#prod" data-toggle="tab">Fungsi Statistik Produksi</a></li>
			<li <?php echo $tab==5?"class='active'":"" ?> ><a href="#dist" data-toggle="tab">Fungsi Statistik Distribusi</a></li>
			<li <?php echo $tab==6?"class='active'":"" ?> ><a href="#ner" data-toggle="tab">Fungsi Nerwilis</a></li>
			<li <?php echo $tab==7?"class='active'":"" ?> ><a href="#ipds" data-toggle="tab">Fungsi IPDS</a></li>
	  </ul>
      <!-- Tab panes content dari tab di atas -->
      <div class="tab-content">
      <div class="scroll tab-pane <?php echo $tab==1?"active":"" ?>" id="all"><br>
				<?php
				$tab=1;
				?>
	   		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="15%">Persentase</th>
						<th width="15%">Action</th>
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
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->persen.' %';?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry/edt/<?php echo $b->id_jeniskegiatan; ?>/1" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i>Realisasi</a>
							</div>	
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
        <div class="scroll tab-pane <?php echo $tab==2?"active":"" ?>" id="tu"><br>
				<?php
				$tab=2;
				?>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="15%">Persentase</th>
						<th width="15%">Action</th>
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
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->persen.' %';?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry/edt/<?php echo $b->id_jeniskegiatan; ?>/2" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Realisasi</a>
							</div>	
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
        <div class="scroll tab-pane <?php echo $tab==3?"active":"" ?>" id="sos"><br>
				<?php
				$tab=3;
				?>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="15%">Persentase</th>
						<th width="15%">Action</th>
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
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->persen.' %';?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry/edt/<?php echo $b->id_jeniskegiatan; ?>/3" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Realisasi</a>
							</div>	
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
        <div class="scroll tab-pane <?php echo $tab==4?"active":"" ?>" id="prod"><br>
				<?php
				$tab=4;
				?>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="15%">Persentase</th>
						<th width="15%">Action</th>
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
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->persen.' %';?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry/edt/<?php echo $b->id_jeniskegiatan; ?>/4" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Realisasi</a>
							</div>	
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
		<div class="scroll tab-pane <?php echo $tab==5?"active":"" ?>" id="dist"><br>
		<?php
				$tab=5;
				?>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="15%">Persentase</th>
						<th width="15%">Action</th>
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
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->persen.' %';?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry/edt/<?php echo $b->id_jeniskegiatan; ?>/5" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Realisasi</a>
							</div>	
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
		<div class="scroll tab-pane <?php echo $tab==6?"active":"" ?>" id="ner"><br>
		<?php
				$tab=6;
				?>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="15%">Persentase</th>
						<th width="15%">Action</th>
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
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->persen.' %';?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry/edt/<?php echo $b->id_jeniskegiatan; ?>/6" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Realisasi</a>
							</div>	
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
		<div class="scroll tab-pane <?php echo $tab==7?"active":"" ?>" id="ipds"><br>
		<?php
				$tab=7;
				?>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="15%">Persentase</th>
						<th width="15%">Action</th>
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
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->persen.' %';?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/entry/edt/<?php echo $b->id_jeniskegiatan; ?>/7" class="btn btn-success btn-sm" title="Edit Data"><i class="icon-edit icon-white"> </i> Realisasi</a>
							</div>	
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



