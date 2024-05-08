<?php 
$uri4 = $this->uri->segment(4);
?>

<div class="row col-md-12">
  <div class="panel panel-info">
  	 <div class="panel-heading">
      <div class="btn-group">
						<a href="<?php echo base_URL()?>index.php/admin/tambah_kegiatan/" class="btn btn-success btn-sm"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan_bidang/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Semua Kegiatan</a>
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan_bidang/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Bidang/Bagian</a>
       </div>
    </div>
    <div class="panel-body">
        
        <!-- accordion -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        
				<div class="scroll">
					<form action="<?php echo base_URL()?>index.php/admin/kelolakegiatan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					
					<!--<input type="hidden" name="idp" value="<?php// echo $idp; ?>">-->
					
					<div class="row-fluid well" style="overflow: hidden">
					
					<div class="col-lg-6">
						<table width="100%" class="table-form">
						
						<tr><td width="20%">Asal Kegiatan</td>
						<td>
								<b>
								<?php
								$bidang=$tab-1;
								if ($mode == "edt" || $mode == "act_edt") 
								{
								?>
									<select name="unitkerja" id="unitkerja"  class="form-control" tabindex="5" style="width: 200px">
									<option selected value="<?php echo $idunitkerja_terpilih; ?>"><?php echo $unitkerja_terpilih; ?></option>
										<?php
										//mengambil nama-nama satuan yang ada di database
										if($bidang != 0)
										{
										$unitkerja = mysql_query("select * from m_unitkerja where substring(id_unitkerja,4,1)='$bidang'");
										}
										else
										{
										 $unitkerja = mysql_query("select * from m_unitkerja where id_unitkerja <> '33500'");
										}
										while($p=mysql_fetch_array($unitkerja)){
											if ($p[id_unitkerja] != $idunitkerja_terpilih) 
											{
											echo "<option value='".$p[id_unitkerja]."'>".$p[unitkerja]."</option>";
											}
										}
										?>
									</select>  
								<?php
								}
								else
								{
								?>
									<select name="unitkerja" id="unitkerja"  class="form-control" tabindex="6" style="width: 200px">
									<option selected value="Kosong">- Pilih Unit Kerja -</option>
										<?php
										//mengambil nama-nama unitkerja yang ada di database
									   if($bidang != 0)
										{
										$unitkerja = mysql_query("select * from m_unitkerja where substring(id_unitkerja,4,1)='$bidang'");
										}
										else
										{
										 $unitkerja = mysql_query("select * from m_unitkerja where id_unitkerja <> '33500'");
										}
										while($p=mysql_fetch_array($unitkerja)){
											echo "<option value='".$p[id_unitkerja]."'>".$p[unitkerja]."</option>\n";
										}
						
								}
								?>
								
									<!--<input type="text" tabindex="5" name="satuan" required value="<?php echo $satuan; ?>" id="satuan" style="width: 100px" class="form-control">-->
								</b>
							</td>
						</tr>
						<tr style="display:none">
							<td width="20%">Tab</td>
							<td><b><input type="text" tabindex="2" name="tab" required value="<?php echo $tab; ?>" id="tahun" style="width: 100px" class="form-control"></b>
							</td>
						</tr>
						<tr>
							<td width="20%">Tahun Kegiatan</td>
							<td><b><input type="text" tabindex="2" name="tahun" required value="<?php echo $tahun; ?>" id="tahun" style="width: 100px" class="form-control"></b>
							</td>
						</tr>
						<tr><td width="20%">Nama Kegiatan</td><td><b>
							<input type="text" tabindex="3" name="nama_kegiatan" required value="<?php echo $nama_kegiatan; ?>" id="nama_kegiatan" style="width: 400px" class="form-control">
						</td></tr>
						<tr>
							<td width="20%">Target</td>
							<td><b><input type="text" tabindex="4" name="targetprop" required value="<?php echo $targetprop; ?>" id="targetprop" style="width: 100px" class="form-control"></b>
							</td>
						</tr>
						<?php
						//if ($mode == "edt" || $mode == "act_edt") {
						?>
						<!--	<tr>
							<td width="20%">Realisasi</td>
							<td><b><input type="text" tabindex="5" name="realisasiprop" required value="<?php //echo $realisasiprop; ?>" id="targetprop" style="width: 100px" class="form-control"></b>
							</td>
						</tr>-->
						<?php
					//	}
						?>
						<tr>
							<td width="20%">Satuan</td>
							<td>
								<b>
								<?php
								if ($mode == "edt" || $mode == "act_edt") 
								{
								?>
									<select name="satuan" id="satuan"  class="form-control" tabindex="5" style="width: 200px">
									<option selected value="<?php echo $idsatuan_terpilih; ?>"><?php echo $satuan_terpilih; ?></option>
										<?php
										//mengambil nama-nama satuan yang ada di database
										$satuan = mysql_query("select * from m_satuan");
										while($p=mysql_fetch_array($satuan)){
											if ($p[id_satuan] != $idsatuan_terpilih) 
											{
											echo "<option value='".$p[id_satuan]."'>".$p[satuan]."</option>";
											}
										}
										?>
									</select>  
								<?php
								}
								else
								{
								?>
									<select name="satuan" id="satuan"  class="form-control" tabindex="6" style="width: 200px">
									<option selected value="Kosong">- Pilih Satuan -</option>
										<?php
										//mengambil nama-nama satuan yang ada di database
										$satuan = mysql_query("select * from m_satuan");
										while($p=mysql_fetch_array($satuan)){
											echo "<option value='".$p[id_satuan]."'>".$p[satuan]."</option>\n";
										}
							
							
								}
								?>
								
									<!--<input type="text" tabindex="5" name="satuan" required value="<?php echo $satuan; ?>" id="satuan" style="width: 100px" class="form-control">-->
								</b>
							</td>
						</tr>
						<tr>
							<td width="20%">Batas Waktu</td>
							<td><b><input type="text" name="batas_waktu" tabindex="7" required value="<?php echo $batas_waktu; ?>" id="batas_waktu" style="width: 200px" class="form-control"></b>
							</td>
						</tr>
						<tr><td width="20%">Dasar Kegiatan</td><td><b>
							<input type="text" tabindex="8" name="dasar_surat" required value="<?php echo $dasar_surat; ?>" id="dasar_surat" style="width: 400px" class="form-control">
						</td></tr>
						<tr><td colspan="2">
						<br><a href="javascript:history.back()" tabindex="10" class="btn btn-primary"><i class="icon icon-arrow-left icon-white"></i> Batal</a>
						<button type="submit" class="btn btn-success" tabindex="9" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>
						
						</td></tr>
						
						</table>
					</div>
					<div class="col-lg-6">
					<table width="100%" class="table-form">
						<tr>
							<td width="20%">Alokasi</td><td><b></b>
							</td>
						</tr>
						<tr>
							<td width="20%"></td>
							<td>
							<table class="table table-striped">
							<tr>
							<th>No</th>
							<th>Kode Kab/Kota</th>
							<th>Kab/Kota</th>
							<th>Target</th>
							<?php
							if ($mode == "edt" || $mode == "act_edt") {
							?>
							<th>Realisasi</th>
							<?php
							}?>
							</tr>
							
							<?php
								$no=1;
								foreach($wilayah as $row) 
								{
									$querytarget = mysql_query("select * from t_kegiatan where id_kab='$row->id_kab' and id_jeniskegiatan='$id_jeniskegiatan'");
									$datatarget = mysql_fetch_array($querytarget);
									$target_kab = $datatarget['target'];
									$realisasi_kab = $datatarget['realisasi'];
									
									echo "<tr>";
									echo "<td>".$no." </td>";
									echo "<td>".$row->id_kab." </td>";
									echo "<td>".$row->nama_kab." </td>";
									?>
									<td><input type="text" name="<?php echo '_'.$row->id_kab; ?>" class="form-control" size='60px' value="<?php echo $target_kab; ?>"></td>
									<?php
									
									if ($mode == "edt" || $mode == "act_edt") {
									?>
									<td><input type="text" name="<?php echo 'realisasi_'.$row->id_kab; ?>" class="form-control" size='60px' value="<?php echo $realisasi_kab; ?>"></td>
									<?php
									}
									echo "</tr>";
									$no++;
								}
							?>
							</table>
							</td>
						</tr>	
					</table>
					
					</div>
					
					</div>
					
					</form>
					</div>
      </div>
    </div>
  </div>
</div>