<?php 
$uri4 = $this->uri->segment(4);
?>

<script>
 function OnSelectionChange()
 {
  alert("OK IT WORKS");
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
					);
			
		echo form_dropdown("pilih_bulan", $options_bulan, $uri4, "id='pilih_bulan' class='form-control col-md-6' onchange='OnSelectionChange()'")."<br><br>";
		?>
		<!-- TATA USAHA -->
        <div class="col-lg-12">
		<div class="panel-heading"> BAGIAN TATA USAHA</div>
        <div class="col-md-6">
            <table class="table table-bordered">
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Nama Guru</td><td></td></tr>
              <tr><td width="30%">Nama Ujian</td><td width="70%"></td></tr>
              <tr><td>Waktu</td><td></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Tertinggi</td><td></td></tr>
              <tr><td>Terendah</td><td></td></tr>
              <tr><td>Rata-rata</td><td></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered" >
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Nama Guru</td><td></td></tr>
              <tr><td width="30%">Nama Ujian</td><td width="70%"></td></tr>
              <tr><td>Waktu</td><td></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Tertinggi</td><td></td></tr>
              <tr><td>Terendah</td><td></td></tr>
              <tr><td>Rata-rata</td><td></td></tr>
            </table>
        </div>
		</div>
		<!-- END TATA USAHA-->
		
		
		<!-- TATA USAHA -->
        <div class="col-lg-12>
		<div class="panel-heading"> BAGIAN TATA USAHA</div>
        <div class="col-md-6">
            <table class="table table-bordered">
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Nama Guru</td><td></td></tr>
              <tr><td width="30%">Nama Ujian</td><td width="70%"></td></tr>
              <tr><td>Waktu</td><td></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Tertinggi</td><td></td></tr>
              <tr><td>Terendah</td><td></td></tr>
              <tr><td>Rata-rata</td><td></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered" >
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Nama Guru</td><td></td></tr>
              <tr><td width="30%">Nama Ujian</td><td width="70%"></td></tr>
              <tr><td>Waktu</td><td></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
              <tr><td colspan="2">Subbagian Bina Program</td></tr>
              <tr><td>Tertinggi</td><td></td></tr>
              <tr><td>Terendah</td><td></td></tr>
              <tr><td>Rata-rata</td><td></td></tr>
            </table>
        </div>
		</div>
		<!-- END TATA USAHA--> 
		
      </div>
    </div>
  </div>
</div>