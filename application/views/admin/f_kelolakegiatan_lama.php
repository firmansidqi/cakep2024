<?php
$mode		= $this->uri->segment(3);
$wilayah	= $this->db->query("select * from m_kab where id_kab <> '6500'")->result();


if ($mode == "edt" || $mode == "act_edt") {
	
	$judul		= "Edit Kegiatan";
	//$id_jeniskegiatan		= $datpil->id_jeniskegiatan;
	$id_jeniskegiatan		= $this->uri->segment(4);
	$act					= "act_edt/".$id_jeniskegiatan;
	$idunitkerja			= substr($id_jeniskegiatan,0,5);
	$tahun					= substr($id_jeniskegiatan,5,4);
	$nama_kegiatan			= $datpil->nama_kegiatan;
	$dasar_surat			= $datpil->dasar_surat;
	$targetprop				= $datpil->targetprop;
	$realisasiprop			= $datpil->realisasiprop;
	$kabkota				= $datpil->id_kab.' '.$datpil->nama_kab ;
	$batas_waktu			= $datpil->batas_waktu;
	$satuan					= $datpil->satuan;
	
	$query_satuan=$this->db->query("SELECT * from m_satuan where id_satuan='$satuan' LIMIT 1")->row();
	$idsatuan_terpilih =$query_satuan->id_satuan;
	$satuan_terpilih =$query_satuan->satuan;
	
	$query_unitkerja =$this->db->query("SELECT * from m_unitkerja where id_unitkerja='$idunitkerja' LIMIT 1")->row();
	$idunitkerja_terpilih =$query_unitkerja->id_unitkerja;
	$unitkerja_terpilih =$query_unitkerja->unitkerja;
	/*$_6501=$datpil->_6501;
	$_6502=$datpil->_6502;
	$_6503=$datpil->_6503;
	$_6504=$datpil->_6504;
	$_6571=$datpil->_6571;
	
	*/
} else {
	$act		= "act_add";
	$judul		= "Entri Kegiatan Baru";
	$idp		= "";
	$unitkerja  = "";
	$tahun		= "";
	$id_jeniskegiatan		= "";
	$nama_kegiatan			= "";
	$dasar_surat			= "";
	$target					= "";
	$realisasi				= "";
	$targetprop				= "";
	$realisasiprop			= "";
	$kabkota				= "";
	$batas_waktu			= "";
	$satuan					= "";
	
	$_6501="";
	$_6502="";
	$_6503="";
	$_6504="";
	$_6571="";
	
}

?>
<script type="text/javascript">
	function selectkegiatan()
			{
			   var unitkerja=$('#unitkerja').val();
			 
			 $.post('<?php echo base_url();?>index.php/admin/get_kegiatan/',
			 {
			 unitkerja:unitkerja
			 
			 },
			 function(data) 
			 {
			 $('#jeniskegiatan').html(data);
			 }); 
			 
			}
</script>
<script type="text/javascript">			
	function selecttarget()
			{
			window.alert ('Halooo');
			 var kabkota=$('#kabkota').val();
			 var jeniskegiatan=$('#jeniskegiatan').val();
			 
			 $.post('<?php echo base_url();?>index.php/admin/get_target/',
			 {
			 kabkota:kabkota
			 jeniskegiatan:jeniskegiatan
			 },
			 function(data) 
			 {
				$('#target').html(data);
				$('#realisasi').html(data);
			 }); 
			 
			}
	
</script>

<script type="text/javascript">		
		function callTarget(){
			window.alert ('Halooo');
			var kabkota=$('#kabkota').val();
			var jeniskegiatan=$('#jeniskegiatan').val();
		if(kabkota&&jeniskegiatan){
			
			$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/admin/get_target/",
			data: { kabkota:kabkota
					jeniskegiatan:jeniskegiatan
			}
			}).done(function(data) {
			$("#target").val(data);
			});
		}
		}
</script>

<div class="row col-md-12">
  <div class="panel panel-info">
  
	 <div class="panel-heading"> TAMBAH KEGIATAN
      <div class="btn-group pull-right">
	
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Semua Kegiatan</a>
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan_bidang/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Bagian/Fungsi</a>
						  <a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/add" class="btn btn-success btn-sm"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
       </div>
    </div>
  
  
<?php echo $this->session->flashdata("k");?>	
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
				if ($mode == "edt" || $mode == "act_edt") 
				{
				?>
					<select name="unitkerja" id="unitkerja"  class="form-control" tabindex="5" style="width: 200px">
                    <option selected value="<?php echo $idunitkerja_terpilih; ?>"><?php echo $unitkerja_terpilih; ?></option>
                        <?php
						//mengambil nama-nama satuan yang ada di database
						if($this->session->userdata('admin_level')=='userprov' and $this->session->userdata('admin_user') != '6500')
						{
						$bidangku = $this->session->userdata('admin_user');
                        $unitkerja = $this->db->query("select * from m_unitkerja where substring(id_unitkerja,1,4)='$bidangku'")->result();
						}
						else
						{
						 $unitkerja = $this->db->query("select * from m_unitkerja where id_unitkerja <> '6500'")->result();
						}
                        foreach($$unitkerja as $p){
							if ($p->id_unitkerja != $idunitkerja_terpilih) 
							{
							echo "<option value='".$p->id_unitkerja."'>".$p->unitkerja."</option>";
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
                        if($this->session->userdata('admin_level') == 'userprov'  and  $this->session->userdata('admin_user') != '6500')
						{
						$bidangku = $this->session->userdata('admin_user');
                        $unitkerja = $this->db->query("select * from m_unitkerja where substring(id_unitkerja,1,4)='$bidangku'")->result();
						}
						else
						{
						 $unitkerja = $this->db->query("select * from m_unitkerja where id_unitkerja <> '6500'")->result();
						}
                        foreach($unitkerja as $p){
							echo "<option value='".$p->id_unitkerja."'>".$p->unitkerja."</option>\n";
                        }
				}
				?>
				
					<!--<input type="text" tabindex="5" name="satuan" required value="<?php echo $satuan; ?>" id="satuan" style="width: 100px" class="form-control">-->
				</b>
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
		<!--<tr>
			<td width="20%">Target</td>
			<td><b><input type="text" tabindex="4" name="targetprop" required value="<?php echo $targetprop; ?>" id="targetprop" style="width: 100px" class="form-control"></b>
			</td>
		</tr>
		<?php
		//if ($mode == "edt" || $mode == "act_edt") {
		?>
			<tr>
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
                        $satuan = $this->db->query("select * from m_satuan")->result();
                        foreach($satuan as $p){
							if ($p->id_satuan != $idsatuan_terpilih) 
							{
							echo "<option value='".$p->d_satuan."'>".$p->satuan."</option>";
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
                        $satuan = $this->db->query("select * from m_satuan")->result();
                        foreach($satuan as $p){
							echo "<option value='".$p->id_satuan."'>".$p->satuan."</option>\n";
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
					
					
					echo "<tr>";
					echo "<td>".$no." </td>";
					echo "<td>".$row->id_kab." </td>";
					echo "<td>".$row->nama_kab." </td>";
					$querytarget = $this->db->query("select * from t_kegiatan where id_kab='$row->id_kab' and id_jeniskegiatan='$id_jeniskegiatan'")->row();
					//$datatarget = mysqli_fetch_array($querytarget);
					if(!empty($querytarget))
					{
					$target_kab = $querytarget->target;
					$realisasi_kab = $querytarget->realisasi;	
					}
					else
					{
					$target_kab = "";
					$realisasi_kab = "";
					}
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
	
