<?php 
if($this->uri->segment(4)== NULL)
{
	$hariini=date("d-m-Y");
	$bulanini = substr($hariini,3,2);
	$bulandepan=$bulanini+1;
	$uri4=$bulanini;
}
else
{	
    $hariini=date("d-m-Y");
    $bulanini = substr($hariini,3,2);
	$uri4 = $this->uri->segment(4);
	$bulandepan=$bulanini+1;
}
?>

<script>
 function OnSelectionChange()
 {
  var pilihbulan  = document.getElementById('pilih_bulan');
  var id_bulan = pilihbulan.value;
  var base_url='<?php echo base_url();?>';
  var loc = base_url+"index.php/admin/duplikasikegiatan/pilih_kegiatanduplikasi/"+id_bulan;
  window.location.assign(loc); 
 }
</script>

<div class="row col-md-12">
  <div class="panel panel-info">
  	 <div class="panel-heading"> DAFTAR KEGIATAN BAGIAN/FUNGSI BULAN INI

	 </div>
	<br>
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

		echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'")."";
		?>
	
	
	
    <div class="panel-body">
        <!-- accordion -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
 		<form action="<?php echo base_URL()?>index.php/admin/duplikasikegiatan/duplikat" method="post">
       	   	<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Cek</th>

					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($datakegiatan)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($datakegiatan as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center">
							<input type="checkbox" name="duplikat[]" id="duplikat[]" value="<?php echo $b->id_jeniskegiatan; ?>">
						</td>
						
					</tr>
					<?php 
						$no++;
						}
					}
					?>
				</tbody>
			</table>
				<div class="form-group" style="padding-bottom: 20px;">
                	<label for="bulan_duplikasi_label">Duplikasi Ke Bulan</label>  
     				<select name="bulan_duplikasi" class="form-control" style="width: 200px" required tabindex="6" >
					<?php
					$l_opkodebulan	= array('01','02','03','04','05','06','07','08','09','10','11','12');
					$l_opnamabulan	= array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
					
					for ($i = 0; $i < sizeof($l_opkodebulan); $i++) {
    					if ($l_opkodebulan[$i] == $bulandepan) 
    					{
    						echo "<option selected value='".$l_opkodebulan[$i]."'>".$l_opnamabulan[$i]."</option>";
    					}
    					else
    					{
    						echo "<option value='".$l_opkodebulan[$i]."'>".$l_opnamabulan[$i]."</option>";
    					}	
					}	
					
					?>
					</select>
                </div>
			<button type="submit" class="btn btn-primary" tabindex="9" ><i class="icon icon-folder-save icon-white"></i> Lakukan Duplikasi</button>
		</form>
		 </div>
      </div>
    </div>
  </div>

  
