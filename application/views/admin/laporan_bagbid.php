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
	  <div class="panel-heading"> LAPORAN REKAP KEGIATAN BERDASARKAN BAGIAN/FUNGSI
      <div class="btn-group pull-right">
	          		<a href="<?php echo base_URL()?>index.php/admin/laporan_kab/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kabupaten</a>
					<a href="<?php echo base_URL()?>index.php/admin/laporan_bagbid/" class="btn btn-success btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Bagian/Fungsi</a>
					<a href="<?php echo base_URL()?>index.php/admin/laporan_pengguna/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Pengguna</a>
       </div>
	   </div>
	   
	   <br>
	   
	   <div class="row">
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
                            <li><a href="#tab2primary" data-toggle="tab">Grafik</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
							<table class="table table-hover">
							<thead class="" style="background-color: #003366; color: white;">
								<tr>
									<th style="align: center;">No.</th>
									<th style="display: none;">ID Bagian/Fungsi</th>
									<th style="text-align: center;">Nama Bagian/Fungsi</th>
									<!--<th style="text-align: center;">Jumlah Kegiatan</th>
									<th style="text-align: center;">Target (Volume) </th>-->
									<th style="text-align: center;">Rata-rata nilai (volume dan deadline)</th>
								</tr>
							</thead>
							<?php
							$i=0;
							foreach ($hasillaporanbagbid as $d) {
							?>
							<tbody>
								<tr>
									<td style="align: center;"><?php echo $i+1; ?></td>
									<td style="display: none;"><?php echo $d->id_bidang; ?></td>
									<?php
									if($d->id_bidang=='921')
									{
										$nama_bagbid="Bagian Umum";
									}
									else if($d->id_bidang=='922')
									{
										$nama_bagbid="Fungsi Statistik Sosial";
									}
									else if($d->id_bidang=='923')
									{
										$nama_bagbid="Fungsi Statistik Produksi";
									}
									else if($d->id_bidang=='924')
									{
										$nama_bagbid="Fungsi Statistik Distribusi";
									}
									else if($d->id_bidang=='925')
									{
										$nama_bagbid="Fungsi Nerwilis";
									}
									else if($d->id_bidang=='926')
									{
										$nama_bagbid="Fungsi IPDS";
									}
									?>
									<td><?php echo $nama_bagbid;; ?></td>
									<!--<td style="text-align: center;"><?php echo $d->jmlh; ?></td>
									<td style="text-align: center;"><?php echo $d->target; ?></td>-->
									<td style="text-align: center;"><?php $angka = $d->rata2nilai; $tabel_format = number_format($angka, 2); echo $tabel_format; ?></td>
								</tr>
							</tbody>
							<?php 
								$i++;
								} 
								/*if (count($hasil) == 0) {
								echo "<-- DATA TIDAK DITEMUKAN -->";
								}*/
							?>
							</table>
						</div>
                        <div class="tab-pane fade" id="tab2primary">
							<?php 
							//print_r($report);
							$nama_bidang=[];
							$nilai = [];
							$color =[];
								foreach ($reportlaporanbagbid as $result) {
									$id_bidang[] = $result->id_bidang;
									
									if($result->id_bidang=='921')
									{
											$nama_bidang_toadd='Bagian Umum';
									}
									else if($result->id_bidang=='922')
									{
											$nama_bidang_toadd='Fungsi Statistik Sosial';
									}
									else if($result->id_bidang=='923')
									{
											$nama_bidang_toadd='Fungsi Statistik Produksi';
									}
									else if($result->id_bidang=='924')
									{
											$nama_bidang_toadd='Fungsi Statistik Distribusi';
									}
									else if($result->id_bidang=='925')
									{
											$nama_bidang_toadd='Fungsi Nerwilis';
									}
									else if($result->id_bidang=='926')
									{
											$nama_bidang_toadd='Fungsi IPDS';
									}
									array_push($nama_bidang,$nama_bidang_toadd);
									
									$nilai[] = (float) $result -> rata2nilai;
								}
							?>

									<div id="grafikbagbid"></div>
									<script>
										//var chart=null;
										//$(document).ready(function(){
										//$('#report').highcharts({
										Highcharts.chart('grafikbagbid', {
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
													text:  '<?php echo 'Rata-rata Nilai Kegiatan Berdasarkan Bagian/Fungsi';?>' ,
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
														depth: 25,
														color:'green',
													}
													
												},
												credits : {
													enabled: false
												},
												xAxis: {
													categories: <?php echo json_encode($nama_bidang); ?>
												},
												exporting: {
													enabled: false
												},
												yAxis: {
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
													data: <?php echo json_encode($nilai); ?>,
													shadow: true,
													dataLabels: {
														enabled: true,
														color: '#045396',
														align: 'center',
														formatter: function() {
															return Highcharts.numberFormat(this.y, 1);
														},
													y: 0,
													style: {
														fontSize: '12px',
														fontFamily: 'Verdana, sans-serif'
													}
													}
												}]
											});
										//});
									</script>
						</div>
                    </div>
                </div>
            </div>
        </div>
		</div>
  </div>
</div>
</html>