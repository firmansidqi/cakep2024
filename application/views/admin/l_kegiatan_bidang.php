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

<script>
 function OnSelectionChange()
 {
  var pilihbulan  = document.getElementById('pilih_bulan');
  var id_bulan = pilihbulan.value;
  var base_url='<?php echo base_url();?>';
  var loc = base_url+"index.php/admin/kegiatan_bidang/pilih_kegiatan/"+id_bulan ;
  location.assign(loc); 
 }
</script>

<div class="row col-md-12">
  <div class="panel panel-info">
  	  <div class="panel-heading"> DAFTAR KEGIATAN PER BAGIAN/FUNGSI
      <div class="btn-group pull-right">
	
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Semua Kegiatan</a>
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan_bidang/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Bagian/Fungsi</a>
						    <a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/add" class="btn btn-success btn-sm"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
       </div>
	   </div>
    <div class="panel-body">
        
        <!-- accordion -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        
        <?php 
       $options_bulan = array(
							'00'         => 'All',
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
			
		echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control col-md-6' onchange='OnSelectionChange()'")."<br><br>";

        ?>
		<br>
		<?php
		 if($this->session->userdata('admin_nip') == '6500'|| $this->session->userdata('admin_nip') == '921')
		 {
		?>
		<!-- UMUM-->
		<div class="panel panel-warning">
			<div class="panel-heading">BAGIAN UMUM
			</div>
		</div>
		<!-- FUNGSI BINA PROGRAM-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Bina Program" ; ?>
              </a>
            </div>
			
            <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92110)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92110 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI BINA PROGRAM -->
         	

		<!-- FUNGSI KEPEGAWAIAN-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Kepegawaian dan Hukum" ; ?>
              </a>
            </div>
			
            <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92120)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92120 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI KEPEGAWAIAN -->
		  
		<!-- FUNGSI KEUANGAN-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Keuangan" ; ?>
              </a>
            </div>
			
            <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92130)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92130 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI KEUANGAN --> 

		<!-- FUNGSI UMUM-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Umum" ; ?>
              </a>
            </div>
			
            <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92140)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92140 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI UMUM -->		
		 
		 <!-- PBJ-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Pengadaan Barang/Jasa" ; ?>
              </a>
            </div>
			
            <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92150)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92150 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END PBJ -->
		 <!-- END UMUM -->  
		 <?php
		 }
		 if($this->session->userdata('admin_nip') == '6500' || $this->session->userdata('admin_nip') == '922' )
		 {
		?> 
		<!-- SOSIAL-->
		<div class="panel panel-warning">
			<div class="panel-heading">FUNGSI STATISTIK SOSIAL
			</div>
		</div>
		<!-- FUNGSI STAT KEPENDUDUKAN-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Kependudukan" ; ?>
              </a>
            </div>
			
            <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92210)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92210 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI STAT KEPENDUDUKAN -->
         	

		<!-- FUNGSI STAT HANSOS-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Ketahanan Sosial" ; ?>
              </a>
            </div>
			
            <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92220)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92220 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI STAT HANSOS -->
		  
		<!-- FUNGSI STAT KESRA-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Kesejahteraan Rakyat" ; ?>
              </a>
            </div>
			
            <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92230)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92230 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END SEKSI KESRA --> 
		<!-- END SOSIAL -->   
		 <?php
		 }
		 if($this->session->userdata('admin_nip') == '6500' || $this->session->userdata('admin_nip') == '923' )
		 {
		?> 
		
		<!-- PRODUKSI-->
		<div class="panel panel-warning">
			<div class="panel-heading">FUNGSI STATISTIK PRODUKSI
			</div>
		</div>
		<!-- FUNGSI STAT PERTANIAN-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Pertanian" ; ?>
              </a>
            </div>
			
            <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92310)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92310 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI STAT PERTANIAN -->
         	

		<!-- FUNGSI STAT INDUSTRI-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Industri" ; ?>
              </a>
            </div>
			
            <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92320)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92320 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI STAT INDUSTRI -->
		  
		<!-- FUNGSI STAT PEK-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse11" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Pertambangan, Energi dan Konstruksi " ; ?>
              </a>
            </div>
			
            <div id="collapse11" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92330)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92330 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI STAT PEK --> 
		<!-- END PRODUKSI --> 		
		  
		<?php
		}
		 if($this->session->userdata('admin_nip') == '6500' || $this->session->userdata('admin_nip') == '924' )
		 {
		?>
		<!-- DISTRIBUSI-->
		<div class="panel panel-warning">
			<div class="panel-heading">FUNGSI STATISTIK DISTRIBUSI
			</div>
		</div>
		<!-- FUNGSI STAT HK HPB-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse12" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Harga Konsumen dan Harga Perdagangan Besar" ; ?>
              </a>
            </div>
			
            <div id="collapse12" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92410)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92410 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI HK HPB -->
         	

		<!-- FUNGSI STAT KEU dan HP-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse13" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Keuangan Dan Harga Produsen" ; ?>
              </a>
            </div>
			
            <div id="collapse13" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92420)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92420 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI KEU dan HP -->
		  
		<!-- FUNGSI STAT NIAGA JASA-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse14" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Statistik Niaga dan Jasa" ; ?>
              </a>
            </div>
			
            <div id="collapse14" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92430)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92430 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END STAT NIAGA JASA --> 
		<!-- END DISTRIBUSI --> 
		<?php
		}
		 if($this->session->userdata('admin_nip') == '6500' || $this->session->userdata('admin_nip') == '925' )
		 {
		?>

		<!-- NERWILIS-->
		<div class="panel panel-warning">
			<div class="panel-heading">FUNGSI NERACA WILAYAH DAN ANALISIS STATISTIK
			</div>
		</div>
		<!-- FUNGSI NERACA PROD -->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse15" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Neraca Produksi " ; ?>
              </a>
            </div>
			
            <div id="collapse15" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92510)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92510 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END NERACA PROD  -->
         	

		<!-- FUNGSI NERACA KONS-->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse16" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Neraca Konsumsi" ; ?>
              </a>
            </div>
			
            <div id="collapse16" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92520)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92520 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI NERACA KONSUMSI -->
		  
		<!-- FUNGSI ANALISIS STATISTIK LINTAS SEKTOR -->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse17" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Analisis Statistik Lintas Sektor" ; ?>
              </a>
            </div>
			
            <div id="collapse17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92530)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92530 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI ANALISIS STATISTIK LINTAS SEKTOR  --> 
		<!-- END NERWILIS --> 
		<?php
		}
		 if($this->session->userdata('admin_nip') == '6500' || $this->session->userdata('admin_nip') == '926' )
		 {
		?>
		
		<!-- IPDS-->
		<div class="panel panel-warning">
			<div class="panel-heading">FUNGSI INTEGRASI PENGOLAHAN DAN DISEMINASI STATISTIK
			</div>
		</div>
		<!-- FUNGSI IPD  -->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse18" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Integrasi Pengolahan Data  " ; ?>
              </a>
            </div>
			
            <div id="collapse18" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92610)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92610 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI IPD   -->
         	

		<!--  FUNGSI JRS -->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse19" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo " Fungsi Jaringan dan Rujukan Statistik " ; ?>
              </a>
            </div>
			
            <div id="collapse19" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92620)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92620 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI JRS  -->
		  
		<!-- FUNGSI DLS  -->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse20" aria-expanded="true" aria-controls="collapseOne">
                #<?php echo "Fungsi Diseminasi dan Layanan Statistik " ; ?>
              </a>
            </div>
			
            <div id="collapse20" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="7%">ID Kegiatan</th>
						<th width="30%">Nama Kegiatan</th>
						<th width="25%">Unit Kerja</th>
						<th width="6%">Target</th>
						<th width="6%">Realisasi</th>
						<th width="6%">Satuan</th>
						<th width="10%">Batas Waktu</th>
						<th width="7%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (empty($data92630)) {
						echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Kegiatan--</td></tr>";
					} else {
						$no 	= 1;
						foreach ($data92630 as $b) {
					?>
					<tr>
						<td  align="center"><?php echo $no;?></td>
						<td><?php echo $b->id_jeniskegiatan;?></td>
						<td><a href="<?php echo base_URL()?>index.php/admin/kegiatan/view/<?php echo $b->id_jeniskegiatan; ?>"><?php echo $b->nama_kegiatan;?></a></td>
						<td  align="left"><?php echo $b->unitkerja; ?></td>
						<td  align="center"><?php echo $b->target; ?></td>
						<td  align="center"><?php echo $b->realisasi;?></td>
						<td  align="center"><?php echo $b->nama_satuan;?></td>
						<td  align="center"><?php echo tgl_jam_sql($b->batas_waktu);?></td>
						<td class="ctr">
							<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $b->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$b->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
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
        <!-- END FUNGSI DLS --> 
		<!-- END IPDS -->
			<?php
		 }
		?>
      </div>
    </div>
  </div>
</div>