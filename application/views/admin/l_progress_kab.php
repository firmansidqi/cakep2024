<?php
$id_jeniskegiatan=$this->uri->segment(4);
$nama_kegiatan_ini=$this->db->query("SELECT nama_kegiatan FROM m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan' LIMIT 1")->row();

$tab=1;
if(null!==$this->uri->segment(5))
{
	$tab = $this->uri->segment(5);
}

?>

<div class="clearfix">
<div class="row">
  <div class="col-lg-12">
	<div class="navbar navbar-inverse">
	
		<div class="navbar-header">
			<span class="navbar-brand" href="#">Progress Kegiatan -- <?php echo $nama_kegiatan_ini->nama_kegiatan;?> --</span>
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
	   <div class="scroll">
	   		<table class="table table-bordered table-striped  table-hover">
				<thead>
					<tr>
						
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Persentase</th>
						<th width="10%">Tgl Update Terakhir</th>
						<?php
						if ($this->session->userdata('admin_user') == "6500")
						{
						?>
							<th width="10%">Konfirmasi Data</th>
						<?php
						}
						?>
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
						<?php
						if($b->flag_konfirm == '2' && $b->realisasi != 0)
						{?>
						<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Belum Dikonfirmasi" align="center"><font color="red"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else if($b->flag_konfirm != '2' && $b->realisasi != 0)
						{
						?>
						<td  data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Sudah Dikonfirmasi" align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else
						{?>
						<td align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						?>
						<?php
						if($b->persen >= '0' && $b->persen <= '50')
						{
						?>
						<td  align="center"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else if($b->persen > '50' && $b->persen <= '90')
						{
						?>
						<td  align="center"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else
						{
						?>
						<td  align="center"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						?>
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
						<?php
						if($this->session->userdata('admin_user') == "6500" && $b->realisasi != 0 && $b->flag_konfirm =='2')
						{
						$id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab.''.$tab;
						?>
						<td class="ctr">
							<div class="btn-group">
								<a href="#" class=" open_modal btn btn-info btn-sm"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> Konfirmasi</a>
							</div>	
						</td>
						<?php
						}
						?>
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
        <div class="scroll tab-pane <?php echo $tab==2?"active":"" ?>" id="tu"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Persentase</th>
						<th width="10%">Tgl Update Terakhir</th>
						<?php
						if ($this->session->userdata('admin_user') == "6500")
						{
						?>
							<th width="10%">Konfirmasi Data</th>
						<?php
						}
						?>
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
						<?php
						if($b->flag_konfirm == '2' && $b->realisasi != 0)
						{?>
						<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Belum Dikonfirmasi" align="center"><font color="red"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else if($b->flag_konfirm != '2' && $b->realisasi != 0)
						{
						?>
						<td  data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Sudah Dikonfirmasi" align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else
						{?>
						<td align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						?>
						<?php
						if($b->persen >= '0' && $b->persen <= '50')
						{
						?>
						<td  align="center"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else if($b->persen > '50' && $b->persen <= '90')
						{
						?>
						<td  align="center"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else
						{
						?>
						<td  align="center"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						?>
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
						<?php
						if($this->session->userdata('admin_user') == "6500" && $b->realisasi != 0 && $b->flag_konfirm =='2')
						{
						$id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab.''.$tab;
						?>
						<td class="ctr">
							<div class="btn-group">
								<a href="#" class=" open_modal btn btn-info btn-sm"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> Konfirmasi</a>
							</div>	
						</td>
						<?php
						}
						?>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
		
		</div>
        <div class="tab-pane <?php echo $tab==3?"active":"" ?>" id="sos"><br>
		<div class="scroll">
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Persentase</th>
						<th width="10%">Tgl Update Terakhir</th>
						<?php
						if ($this->session->userdata('admin_user') == "6500")
						{
						?>
							<th width="10%">Konfirmasi Data</th>
						<?php
						}
						?>
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
						<?php
						if($b->flag_konfirm == '2' && $b->realisasi != 0)
						{?>
						<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Belum Dikonfirmasi" align="center"><font color="red"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else if($b->flag_konfirm != '2' && $b->realisasi != 0)
						{
						?>
						<td  data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Sudah Dikonfirmasi" align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else
						{?>
						<td align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						?>
						<?php
						if($b->persen >= '0' && $b->persen <= '50')
						{
						?>
						<td  align="center"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else if($b->persen > '50' && $b->persen <= '90')
						{
						?>
						<td  align="center"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else
						{
						?>
						<td  align="center"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						?>
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
						<?php
						if($this->session->userdata('admin_user') == "6500" && $b->realisasi != 0 && $b->flag_konfirm =='2')
						{
						$id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab.''.$tab;
						?>
						<td class="ctr">
							<div class="btn-group">
								<a href="#" class=" open_modal btn btn-info btn-sm"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> Konfirmasi</a>
							</div>	
						</td>
						<?php
						}
						?>
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
        <div class="scroll tab-pane <?php echo $tab==4?"active":"" ?>" id="prod"><br>
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Persentase</th>
						<th width="10%">Tgl Update Terakhir</th>
						<?php
						if ($this->session->userdata('admin_user') == "6500")
						{
						?>
							<th width="10%">Konfirmasi Data</th>
						<?php
						}
						?>
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
						<?php
						if($b->flag_konfirm == '2' && $b->realisasi != 0)
						{?>
						<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Belum Dikonfirmasi" align="center"><font color="red"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else if($b->flag_konfirm != '2' && $b->realisasi != 0)
						{
						?>
						<td  data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Sudah Dikonfirmasi" align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else
						{?>
						<td align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						?>
						<?php
						if($b->persen >= '0' && $b->persen <= '50')
						{
						?>
						<td  align="center"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else if($b->persen > '50' && $b->persen <= '90')
						{
						?>
						<td  align="center"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else
						{
						?>
						<td  align="center"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						?>
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
						<?php
						if($this->session->userdata('admin_user') == "6500" && $b->realisasi != 0 && $b->flag_konfirm =='2')
						{
						$id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab.''.$tab;
						?>
						<td class="ctr">
							<div class="btn-group">
								<a href="#" class=" open_modal btn btn-info btn-sm"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> Konfirmasi</a>
							</div>	
						</td>
						<?php
						}
						?>
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
	
		<table class="table table-bordered table-hover">
			   
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Persentase</th>
						<th width="10%">Tgl Update Terakhir</th>
						<?php
						if ($this->session->userdata('admin_user') == "6500")
						{
						?>
							<th width="10%">Konfirmasi Data</th>
						<?php
						}
						?>
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
						<?php
						if($b->flag_konfirm == '2' && $b->realisasi != 0)
						{?>
						<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Belum Dikonfirmasi" align="center"><font color="red"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else if($b->flag_konfirm != '2' && $b->realisasi != 0)
						{
						?>
						<td  data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Sudah Dikonfirmasi" align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else
						{?>
						<td align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						?>
						<?php
						if($b->persen >= '0' && $b->persen <= '50')
						{
						?>
						<td  align="center"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else if($b->persen > '50' && $b->persen <= '90')
						{
						?>
						<td  align="center"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else
						{
						?>
						<td  align="center"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						?>
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
						<?php
						if($this->session->userdata('admin_user') == "6500" && $b->realisasi != 0 && $b->flag_konfirm =='2')
						{
						$id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab.''.$tab;
						?>
						<td class="ctr">
							<div class="btn-group">
								<a href="#" class=" open_modal btn btn-info btn-sm"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> Konfirmasi</a>
							</div>	
						</td>
						<?php
						}
						?>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
		

		</div>
		<div class="scroll tab-pane <?php echo $tab==6?"active":"" ?> " id="ner"><br>
		
		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Persentase</th>
						<th width="10%">Tgl Update Terakhir</th>
						<?php
						if ($this->session->userdata('admin_user') == "6500")
						{
						?>
							<th width="10%">Konfirmasi Data</th>
						<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($datanerwil)) {
						echo "<tr><td colspan='5' style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
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
						<?php
						if($b->flag_konfirm == '2' && $b->realisasi != 0)
						{?>
						<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Belum Dikonfirmasi" align="center"><font color="red"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else if($b->flag_konfirm != '2' && $b->realisasi != 0)
						{
						?>
						<td  data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Sudah Dikonfirmasi" align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else
						{?>
						<td align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						?>
						<?php
						if($b->persen >= '0' && $b->persen <= '50')
						{
						?>
						<td  align="center"><font style="background-color:red ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else if($b->persen > '50' && $b->persen <= '90')
						{
						?>
						<td  align="center"><font style="background-color:orange ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else
						{
						?>
						<td  align="center"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						?>
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
						<?php
						if($this->session->userdata('admin_user') == "6500" && $b->realisasi != 0 && $b->flag_konfirm =='2')
						{
						$id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab.''.$tab;
						?>
						<td class="ctr">
							<div class="btn-group">
								<a href="#" class=" open_modal btn btn-info btn-sm"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> Konfirmasi</a>
							</div>	
						</td>
						<?php
						}
						?>
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>

		
		</div>
		<div class="scroll tab-pane <?php echo $tab==7?"active":"" ?> " id="ipds"><br>

		<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="10%" style="display:none">ID Kegiatan</th>
						<th width="25%" style="display:none">Nama Kegiatan</th>
						<th width="25%">KabKota</th>
						<th width="10%">Target</th>
						<th width="10%">Realisasi</th>
						<th width="10%">Persentase</th>
						<th width="10%">Tgl Update Terakhir</th>
						<?php
						if ($this->session->userdata('admin_user') == "6500")
						{
						?>
							<th width="10%">Konfirmasi Data</th>
						<?php
						}
						?>
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
						<?php
						if($b->flag_konfirm == '2' && $b->realisasi != 0)
						{?>
						<td data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Belum Dikonfirmasi" align="center"><font color="red"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else if($b->flag_konfirm != '2' && $b->realisasi != 0)
						{
						?>
						<td  data-container="body" data-toggle="tooltip" data-placement="bottom" title="Data Sudah Dikonfirmasi" align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						else
						{?>
						<td align="center"><font color="black"><?php echo $b->realisasi;?></font></td>
						<?php
						}
						?>
						<?php
						if($b->persen >= '0' && $b->persen <= '50')
						{
						?>
						<td  align="center"><font style="background-color:red  ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else if($b->persen > '50' && $b->persen <= '90')
						{
						?>
						<td  align="center"><font style="background-color:orange  ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						else
						{
						?>
						<td  align="center"><font style="background-color:green ; color:white"><?php echo $b->persen.' %';?></font></td>
						<?php
						}
						?>
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
						<?php
						if($this->session->userdata('admin_user') == "6500" && $b->realisasi != 0 && $b->flag_konfirm =='2')
						{
						$id_konfirm=$b->id_jeniskegiatan.''.$b->id_kab.''.$tab;
						?>
						<td class="ctr">
							<div class="btn-group">
								<a href="#" class=" open_modal btn btn-info btn-sm"  id="<?php echo $id_konfirm;?>" title="Konfirmasi Data"><i class="icon-check icon-white"> </i> Konfirmasi</a>
							</div>	
						</td>
						<?php
						}
						?>
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



