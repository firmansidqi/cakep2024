<style type="text/css">
			.with-nav-tabs.panel-primary .nav-tabs > li > a,
			.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
			.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
				color: #fff;
			}
			.with-nav-tabs.panel-primary .nav-tabs > .open > a,
			.with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
			.with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
			.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
			.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
				color: #fff;
				background-color: #003366;
				border-color: transparent;
			}
			.with-nav-tabs.panel-primary .nav-tabs > li.active > a,
			.with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
			.with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
				color: #003366;
				background-color: #fff;
				border-color: #003366;
				border-bottom-color: transparent;
			}
</style>



<div class="row col-md-12">
  <div class="panel panel-info">
	  <div class="panel-heading"> LAPORAN KEGIATAN
      <div class="btn-group pull-right">
	          		<a href="<?php echo base_URL()?>index.php/admin/laporan_kab/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kabupaten/Kota</a>
					<a href="<?php echo base_URL()?>index.php/admin/laporan_prov/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Provinsi</a>
       </div>
	   </div>
	   
	   <br>
	   
	   <div class="row">
		<div class="col-sm-4">
			<form action="" method="get">
				<span>Pilih Bagian/Fungsi</span>
				<!-- Tes PHP select option by variable -->
				<?php
				$kbs = array(
				'92100 Bagian Umum',
				'92200 Fungsi Statistik Sosial',
				'92300 Fungsi Statistik Produksi',
				'92400 Fungsi Statistik Distribusi',
				'92500 Fungsi Neraca Wilayah dan Analisis Statistik',
				'92600 Fungsi Integrasi Pengolahan dan Diseminasi Statistik');
				?>
				<select name="pilih_kab" class="form-control" id="pilih_kab">
					<option value="">Pilih</option>
					<?php foreach($kbs as $nama_kabupaten): ?>
						<option value="<?php echo substr($nama_kabupaten,0,4);?>" <?php if(substr($nama_kabupaten,0,4) == $kab) echo "selected"?> ><?php echo $nama_kabupaten;?></option>
					<?php endforeach; ?>
				</select>

			</div>
			<div class="col-sm-4">
				<span> Bulan Kegiatan</span>
				<select class="form-control" name="bln">
					<option value="">Pilih Bulan</option>
					<?php
						$mounth=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
						$jlh_bln=count($mounth);
						for($c=0; $c<$jlh_bln; $c+=1){
							$d = $c+1;
							if ($d == $bulan) {
								echo"<option value='$d' selected> $mounth[$c] </option>";
							}else {
								echo"<option value='$d'> $mounth[$c] </option>";	
							}
						}
					?>
				</select>
			</div>
			<div class="col-sm-4">
				<span>Tahun Kegiatan</span>
				<?php
					$now=date('Y');
					echo "<select class='form-control' name='Tahun'>";
					echo "<option value=''>Pilih Tahun</option>";
					for ($a=2010;$a<=$now;$a++)
					{
						if ($a == $tahun) {
							echo"<option value='$a' selected> $a </option>";
						}else {
							echo"<option value='$a'> $a </option>";	
						}
					}
					echo "</select>";
				?>
			</div>
			<div class="col-sm-4">
					<input class="btn" type="submit" value="Get Data" name="submit" style="background-color:#003366; color: white;">
			</div>
		</form>
		</div>
		<br>
		<div>
		<div class="col-md-12">
                <div class="panel-body">

							<table class="table table-hover">
							<thead class="" style="background-color: #003366; color: white;">
								<tr>
									<th style="text-align: center";>Bulan</th>
									<th style="text-align: center;">Nama Kegiatan</th>
									<th style="text-align: center;">Batas Waktu</th>
									<th style="text-align: center;">Satuan</th>
									<th style="text-align: center;">Target</th>
									<th style="text-align: center;">Realisasi</th>
									<th style="text-align: center;">% Realisasi</th>
									
								</tr>
							</thead>
							<?php
								foreach ($hasil as $i=>$tabel) {
							?>
							<tbody>
								<tr>
									<?php 
									if($tabel['bulan'] == '1')
									{
										$bulannama='Januari';
									}
									else if($tabel['bulan'] == '2')
									{
										$bulannama='Februari';
									}
									else if($tabel['bulan'] == '3')
									{
										$bulannama='Maret';
									}
									else if($tabel['bulan'] == '4')
									{
										$bulannama='April';
									}
									else if($tabel['bulan'] == '5')
									{
										$bulannama='Mei';
									}
									else if($tabel['bulan'] == '6')
									{
										$bulannama='Juni';
									}
									else if($tabel['bulan'] == '7')
									{
										$bulannama='Juli';
									}
									else if($tabel['bulan'] == '8')
									{
										$bulannama='Agustus';
									}
									else if($tabel['bulan'] == '9')
									{
										$bulannama='September';
									}
									else if($tabel['bulan'] == '10')
									{
										$bulannama='Oktober';
									}
									else if($tabel['bulan'] == '11')
									{
										$bulannama='November';
									}
									else if($tabel['bulan'] == '12')
									{
										$bulannama='Desember';
									}?>
									<td style="align: center;"><?php echo $bulannama; ?></td>
									<td style="align: left;"><?php echo $tabel['nama_kegiatan']; ?></td>
									<td style="text-align: center;"><?php echo tgl_jam_sql($tabel['batas_waktu']); ?></td>
									<td style="text-align: center;"><?php echo $tabel['satuan']; ?></td>
									<td style="text-align: center;"><?php echo $tabel['target']; ?></td>
									<td style="text-align: center;"><?php echo $tabel['realisasi']; ?></td>
									<td style="text-align: center;"><?php echo round($tabel['realisasi']/$tabel['target']*100,2); echo ' %' ?></td>
								</tr>
							</tbody>
							<?php 
								} 
								/*if (count($hasil) == 0) {
								echo "<-- DATA TIDAK DITEMUKAN -->";
								}*/
							?>
							</table>

                </div>
    
        </div>
		</div>
	   
	   
	   
  </div>
</div>