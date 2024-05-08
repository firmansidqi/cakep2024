<html>
	<head>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">

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

</head>

<div class="row col-md-12">
  <div class="panel panel-info">
	  <div class="panel-heading"> LAPORAN PENGGUNA
      <div class="btn-group pull-right">
	          		<a href="<?php echo base_URL()?>index.php/admin/laporan_kab/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kegiatan</a>
					<a href="<?php echo base_URL()?>index.php/admin/laporan_bagbid/" class="btn btn-success btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Bagian/Fungsi</a>
					<a href="<?php echo base_URL()?>index.php/admin/laporan_pengguna/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Pengguna</a>
       
       </div>
	   </div>
	   
	   <br>
	   
	   <div class="row">
		<!--<div class="col-sm-4">
			<form action="" method="get">
				<span>Pilih Kab./Kota</span>
				<!-- Tes PHP select option by variable 
				<?php
				$kbs = array(
				'MALINAU',
				'BULUNGAN',
				'TANA TIDUNG',
				'NUNUKAN',
				'KOTA TARAKAN');
				
				
				?>
				<select name="pilih_kab" class="form-control" id="pilih_kab">
					<option value="">Pilih</option>
					<?php foreach($kbs as $nama_kabupaten): ?>
						<option value="<?php echo $nama_kabupaten;?>" <?php if($nama_kabupaten == $kab) echo "selected"?> ><?php echo $nama_kabupaten;?></option>
					<?php endforeach; ?>
				</select>

			</div>-->
			<form action="" method="get">
			<div class="col-sm-6">
				<select class="form-control" name="bln">
					<b><option value=""> -Pilih Bulan- </option></b>
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
			<!--<div class="col-sm-4">
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
			</div>-->
			<div class="col-sm-6">
					<input class="btn" type="submit" value="Get Data" name="submit" style="background-color:#003366; color: white;">
			</div>
		</form>
		</div>
		<br>
		<div>
		<div class="col-md-12">
            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Tabel</a></li>
                           <!-- <li><a href="#tab2primary" data-toggle="tab">Grafik</a></li>-->
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
							<table class="table table-hover">
							<thead class="" style="background-color: #003366; color: white;">
								<tr>
									<th style="align: center;">No.</th>
									<th>Username</th>
									<th style="text-align: center;">Nama</th>
									<th style="text-align: center;">Hits</th>
									<th style="text-align: center;">Akses Terakhir</th>
								</tr>
							</thead>
							<?php
								foreach ($hasiluser as $i=>$tabel) {
							?>
							<tbody>
								<tr>
									<td style="align: center;"><?php echo $i+1; ?></td>
									<td><?php echo $tabel['username']; ?></td>
									<td><?php echo $tabel['nama']; ?></td>
									<td style="text-align: center;"><?php echo $tabel['jmlhlogin']; ?></td>
									<td style="text-align: center;"><?php echo tgl_jam_sql($tabel['loginterakhir']); ?></td>
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
                        <!--<div class="tab-pane fade" id="tab2primary">
							<?php 
							//print_r($report);
							$nama_kab = [];
							$nilai = [];
							$color =[];
								foreach ($report as $result) {
									$nama_kab[] = $result->nama_kab;
									if($result -> rata2nilai >= 0 && $result -> rata2nilai <= 1)
									{
										$color = "'red'";
									}
									else if($result -> rata2nilai > 1 && $result -> rata2nilai <= 3)
									{
										$color = "'orange'";
									}
									else if($result -> rata2nilai > 3 && $result -> rata2nilai <= 4)
									{
										$color = "'green'";
									} 
								$nilai[] =  "{y :".(float) $result -> rata2nilai.",color:".$color."}";
								}
								$nilai_final = json_encode($nilai);
								$nilai_dipakai = str_replace('"','',$nilai_final);
							?>

									<div id="report"></div>
									<script>
										//var chart=null;
										//$(document).ready(function(){
										//$('#report').highcharts({
										Highcharts.chart('report', {
												chart: {
												type: 'column',
												margin: 75,
												//renderTo:'report',
													option3d:{
														enabled: false,
														alpha: 10,
														beta: 25,
														depth: 70
													}
												},
												title: {
													text: 'Nilai Kegiatan/Bulan',
													style: {
														fontSize: '18px',
														fontFamily: 'Verdana, sans-serif'
													}
												},
												subtitle: {
													text: ' ',
													style: {
														fontSize: '18px',
														fontfamily: 'Verdana, sans-serif'
													}
												},
												plotOptions: {
													column: {
														depth: 25
													}
												},
												credits : {
													enabled: false
												},
												xAxis: {
													categories: <?php echo json_encode($nama_kab); ?>
												},
												exporting: {
													enabled: false
												},
												yAxis: {
													max:4,
													title: {
														text: 'Nilai'
													},
												},
												tooltip: {
													formatter: function() {
														return 'Nilai <b>'+ this.x + '</b> adalah <b>' + Highcharts.numberFormat(this.y,1);
													}
												},
												series: [{
													name: 'Rata-rata Nilai',
													data: <?php echo $nilai_dipakai; ?>,
													shadow: true,
													dataLabels: {
														enabled: true,
														//color: '#045396',
														align: 'center',
														formatter: function() {
															return Highcharts.numberFormat(this.y, 1);
														},
													y: 0,
													style: {
														fontSize: '13px',
														fontFamily: 'Verdana, sans-serif'
													}
													}
												}]
											});
										//});
									</script>
						</div>-->
                    </div>
                </div>
            </div>
        </div>
		</div>
  </div>
</div>
</html>