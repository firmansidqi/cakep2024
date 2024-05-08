<?php 
if($this->uri->segment(4)== NULL)
{
	$hariini=date("d-m-Y");
	$bulanini = substr($hariini,3,2);
	$uri4=$bulanini;
}
else
{	
	$uri4 = $this->uri->segment(4);
}
?>

<div class="row col-md-12">
  <div class="panel panel-info">
  	 <div class="panel-heading"> DAFTAR KEGIATAN BAGIAN/FUNGSI BULAN INI</div>
     <div class="panel-body">

        <!-- accordion -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<?php        
if ('1'=='2' && ($this->session->userdata('admin_user') == "rizchi" || $this->session->userdata('admin_user') == "6500" )) { 
        $options_bidang = array(
                            ''           => '- Pilih Bagian/Fungsi -',
							'92100'         => 'Umum',
							'92200'         => 'Stat. Sosial',
							'92300'         => 'Stat. Produksi',
							'92400'         => 'Stat. Distribusi',
							'92500'         => 'Nerwilis',
							'92600'         => 'IPDS',
					);
		echo form_dropdown("pilih_bidang", $options_bidang, $this->uri->segment(3), "id='pilih_bidang' class='form-control' onchange='OnSelectionChange()'")."";

        $options_bulan = array(
							''           => '- Pilih Bulan -',
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

		echo form_dropdown("pilih_bulan", $options_bulan, $this->uri->segment(4), "id='pilih_bulan' class='form-control' onchange='OnSelectionChange()'")."";
?>
    <br>
    <script>
        function OnSelectionChange()
        {
          var pilihbidang  = document.getElementById('pilih_bidang');
          var id_bidang = pilihbidang.value;

          var pilihbulan  = document.getElementById('pilih_bulan');
          var id_bulan = pilihbulan.value;

          var base_url='https://cakep.bpskaltara.id/';
          var loc = base_url+"index.php/admin/duplikasikegiatan/"+id_bidang+'/'+id_bulan;
          window.location.assign(loc); 
        }
    </script>

<?php } ?>

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
			<button type="submit" class="btn btn-primary" tabindex="9" ><i class="icon icon-folder-save icon-white"></i>Lakukan Duplikasi</button>
		</form>
		 </div>
      </div>
    </div>
  </div>

  
