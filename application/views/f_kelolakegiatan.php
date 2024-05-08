<?php
$mode		= $this->uri->segment(3);
$wilayah	= $this->db->query("select * from m_kab where id_kab <> '6500'")->result();
$db2        = $this->load->database('db2',TRUE);
$this->load->model('M_kelolakegiatan');


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
	// Perubahan April-Mei 2023
	$mulai                  = $datpil->mulai;
	$pj_prov                = $datpil->pj_prov;
	// End of Perubahan April-Mei 2023
	
	$query_satuan=$this->db->query("SELECT * from m_satuan where id_satuan='$satuan' LIMIT 1")->row();
	$idsatuan_terpilih =$query_satuan->id_satuan;
	$satuan_terpilih =$query_satuan->satuan;
	
	$query_unitkerja =$this->db->query("SELECT * from m_unitkerja where id_unitkerja='$idunitkerja' LIMIT 1")->row();
	$idunitkerja_terpilih =$query_unitkerja->id_unitkerja;
	$unitkerja_terpilih =$query_unitkerja->unitkerja;
	
	$query_namakegiatan = $this->db->query("SELECT * from m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan' LIMIT 1")->row();
	$id_kegiatanterpilih=$query_namakegiatan->id_jeniskegiatan;
	$nama_kegiatanterpilih=$query_namakegiatan->nama_kegiatan;
	//Perubahan April-Mei 2023
	$nama_pjprovterpilih=$query_namakegiatan->pj_prov;
	/*$_6501=$datpil->_6501;
	$_6502=$datpil->_6502;
	$_6503=$datpil->_6503;
	$_6504=$datpil->_6504;
	$_6571=$datpil->_6571;
	*/
	//Perubahan April-Mei 2023
	$query_namappjprov = $this->db->query("SELECT * from m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan' LIMIT 1")->row();
	$id_kegiatanterpilih=$query_namakegiatan->id_jeniskegiatan;
	$nama_kegiatanterpilih=$query_namakegiatan->nama_kegiatan;
	
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
	//Perubahan April-Mei 2023
	$mulai                  = "";
	$pj_prov                = "";
	$pj_6501="";
	$pj_6502="";
	$pj_6503="";
	$pj_6504="";
	$pj_6571="";
	//End of Perubahan April-Mei 2023
	
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
			 kabkota:kabkota,
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
			data: { kabkota:kabkota,
					jeniskegiatan:jeniskegiatan
			}
			}).done(function(data) {
			$("#target").val(data);
			});
		}
		}
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#nama_kegiatan').change(function(){
            var nama_kegiatan=$(this).val();
            $.ajax({
				type : "GET",
                url : "<?php echo base_url();?>index.php/Admin/getsatuan/"+nama_kegiatan,
                //data : {idgoal: idgoal},
               // async : false,
                dataType : 'json',
                success: function(datasatuan){
                    var html = '';
                    var i;
                    for(i=0; i<datasatuan.length; i++){
                        html += '<option value="'+datasatuan[i].id_satuan+'">'+datasatuan[i].satuan+'</option>';
                    }
                    $('#satuan').html(html);
                }
            });
        });
    });
</script>

<?php echo $this->session->flashdata("k");?>
<div class="row col-md-12">
  <div class="panel panel-info">
  
	 <div class="panel-heading"> TAMBAH KEGIATAN
      <div class="btn-group pull-right">
	
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Semua Kegiatan</a>
                          <a href="<?php echo base_URL()?>index.php/admin/kegiatan_bidang/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Bidang/Fungsi</a>
						  <a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/add" class="btn btn-success btn-sm"><i class="icon-plus-sign icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Tambah Kegiatan</a>
       </div>
    </div>
  
  
	
<div class="scroll" style="height: 800px;">
	<form action="<?php echo base_URL()?>index.php/admin/kelolakegiatan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	
	
	
	<div class="row-fluid well" style="overflow: hidden">
	
	<!-- Perubahan April-Mei 2023 -->
	<!--div class="col-lg-6"-->
	   <div class="row col-md-12">
		<table width="100%" class="table-form">
		
    		<tr><td width="20%">Asal Kegiatan</td>
    		<td>
    				<b>
    				<?php
    				if ($mode == "edt" || $mode == "act_edt") 
    				{
    				?>
    					<select name="unitkerja" id="unitkerja"  class="form-control" tabindex="5" style="width: 300px" required>
                        <option selected value="<?php echo $idunitkerja_terpilih; ?>"><?php echo $unitkerja_terpilih; ?></option>
                            <?php
    						//mengambil nama-nama satuan yang ada di database
    						if($this->session->userdata('admin_level')=='userprov' and $this->session->userdata('admin_nip') != '6500')
    						{
    						$bidangku = $this->session->userdata('admin_nip');
                            $unitkerja = $this->db->query("select * from m_unitkerja where substring(id_unitkerja,1,3)='$bidangku'")->result();
    						}
    						else
    						{
    						 $unitkerja = $this->db->query("select * from m_unitkerja where id_unitkerja <> '92000'")->result();
    						}
                            foreach($unitkerja as $p){
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
    					<select name="unitkerja" id="unitkerja"  class="form-control" tabindex="6" style="width: 300px" required>
                        <option selected value="Kosong">- Pilih Unit Kerja -</option>
                            <?php
    						//mengambil nama-nama unitkerja yang ada di database
                            if($this->session->userdata('admin_level') == 'userprov'  and  $this->session->userdata('admin_nip') != '6500')
    						{
    						$bidangku = $this->session->userdata('admin_nip');
                            $unitkerja = $this->db->query("select * from m_unitkerja where substring(id_unitkerja,1,3)='$bidangku'")->result();
    						}
    						else
    						{
    						 $unitkerja = $this->db->query("select * from m_unitkerja where id_unitkerja <> '92000'")->result();
    						}
                            foreach($unitkerja as $p){
    							echo "<option value='".$p->id_unitkerja."'>".$p->unitkerja."</option>\n";
    							//echo $this->session->userdata();
                            }
                         ?>
                        </select>  
    				<?php
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
    		<tr><td width="20%">Nama Kegiatan</td>
    		    <td><b>
        			<b>
        				<?php
        				if ($mode == "edt" || $mode == "act_edt") 
        				{
        				?>
        					<select name="nama_kegiatan" id="nama_kegiatan"  class="form-control" tabindex="5" style="width: 300px" >
                            <option selected value="<?php echo $nama_kegiatanterpilih; ?>"><?php echo $nama_kegiatanterpilih; ?></option>
                                <?php
        						//mengambil nama-nama satuan yang ada di database
        						if($this->session->userdata('admin_level')=='userprov' and $this->session->userdata('admin_nip') != '6500')
        						{
        						$bidangku = $this->session->userdata('admin_nip');
                                $unitkerja = $this->db->query("select * from m_listkegiatan where substring(id_unitkerja,1,3)='$bidangku' ORDER BY nama_kegiatan")->result();
        						}
        						else
        						{
        						 $unitkerja = $this->db->query("select * from m_listkegiatan ")->result();
        						}
                                foreach($unitkerja as $p){
        							//if ($p->id_unitkerja != $idunitkerja_terpilih) 
        							//{
        							echo "<option value='".$p->nama_kegiatan."'>".$p->nama_kegiatan."</option>";
        							//}
        						}
                                ?>
                            </select>  
        				<?php
        				}
        				else
        				{
        				?>
        					<select name="nama_kegiatan" id="nama_kegiatan"  class="form-control" tabindex="6" style="width: 300px" >
                            <option selected value="Kosong">- Pilih Nama Kegiatan -</option>
                                <?php
        						//mengambil nama-nama unitkerja yang ada di database
                                if($this->session->userdata('admin_level') == 'userprov'  and  $this->session->userdata('admin_nip') != '6500')
        						{
        						$bidangku = $this->session->userdata('admin_nip');
                                $unitkerja = $this->db->query("select * from m_listkegiatan where substring(id_unitkerja,1,3)='$bidangku'")->result();
        						}
        						else
        						{
        						 $unitkerja = $this->db->query("select * from m_listkegiatan")->result();
        						}
                                foreach($unitkerja as $p){
        							echo "<option value='".$p->nama_kegiatan."'>".$p->nama_kegiatan."</option>\n";
                                }
                                ?>
                            </select>
                        <?php
        				}
        				?>
        				
        					<!--<input type="text" tabindex="5" name="satuan" required value="<?php echo $satuan; ?>" id="satuan" style="width: 100px" class="form-control">-->
        				</b>
        	
        			<!--<input type="text" tabindex="3" name="nama_kegiatan" required value="<?php echo $nama_kegiatan; ?>" id="nama_kegiatan" style="width: 400px" class="form-control">-->
    		    </td>
            </tr>
    		<tr>
    			<td width="20%">Satuan</td>
    			<td>
        			<b>
        			<select name="satuan" id="satuan" style="width: 300px" class="form-control" readonly>
        			 <?php
        			 	if ($mode == "edt" || $mode == "act_edt") 
    				    {
    				    ?>
                        <option selected value="<?php echo $idsatuan_terpilih; ?>"><?php echo $satuan_terpilih; ?></option>
                        <?php
    					}
           				echo "<option> - Satuan - </option>";
        			?>
        			</select>
        			</b>
    			</td>
    		</tr>
    		
    		<!--<tr>
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
    							echo "<option value='".$p->id_satuan."'>".$p->satuan."</option>";
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
    				
    					<!--<input type="text" tabindex="5" name="satuan" required value="<?php echo $satuan; ?>" id="satuan" style="width: 100px" class="form-control">
    				</b>
    			</td>
    		</tr>-->
    		
    		<!-- Perubahan April-Mei 2023 -->
    		<tr>
    			<td width="20%">Penanggung Jawab</td>
    			<td><b>
        				<?php
        				if ($mode == "edt" || $mode == "act_edt")
        				{
        				    $pegawaiterpilih = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang FROM master_pegawai WHERE niplama='$nama_pjprovterpilih' LIMIT 1")->row();
        				?>
        					<select name="pj_prov" id="pj_prov"  class="form-control" tabindex="5" style="width: 300px" >
                            <option selected value="<?php echo $nama_pjprovterpilih; ?>"><?php echo $pegawaiterpilih->gelar_depan." ".$pegawaiterpilih->nama." ".$pegawaiterpilih->gelar_belakang; ?></option>
                                <?php
        						//mengambil nama-nama pegawai dari provinsi
                                if($this->session->userdata('admin_level') == 'userprov'  and  $this->session->userdata('admin_nip') != '6500')
        						{
            						$kodeprov = "6500";
                            	    $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodeprov' ORDER BY id_org ")->result();
        						}
        						else
        						{
        						    $kodeprov = "6500";
                            	    $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodeprov' ORDER BY id_org ")->result();
        						}
                                foreach($pegawai as $p){
        							echo "<option value='".$p->niplama."'>".$p->gelar_depan." ".$p->nama." ".$p->gelar_belakang."</option>\n";
                                }
                                ?>
                            </select>  
        				<?php
        				}
        				else
        				{
        				?>
        					<select name="pj_prov" id="pj_prov"  class="form-control" tabindex="6" style="width: 300px" >
                            <option selected value="Kosong">- Pilih Penanggung Jawab -</option>
                                <?php
        						//mengambil nama-nama pegawai dari provinsi
                                if($this->session->userdata('admin_level') == 'userprov'  and  $this->session->userdata('admin_nip') != '6500')
        						{
            						$kodeprov = "6500";
                            	    $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodeprov' ORDER BY id_org ")->result();
        						}
        						else
        						{
        						    $kodeprov = "6500";
                            	    $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodeprov' ORDER BY id_org ")->result();
        						}
                                foreach($pegawai as $p){
        							echo "<option value='".$p->niplama."'>".$p->gelar_depan." ".$p->nama." ".$p->gelar_belakang."</option>\n";
                                }
                                ?>
                            </select>
        				<?php
        				}
        				?>
        			</b>
    		    </td>
    		</tr>
    		<tr>
    			<td width="20%" >Mulai</td>
    			<td><b><input type="date" name="mulai" tabindex="7" required value="<?php echo $mulai; ?>" id="mulai" style="width: 200px" class="form-control"></b>
    			</td>
    		</tr>
    		
    		<!-- End of Perubahan April-Mei 2023 -->
    		
    		<tr>
    			<td width="20%">Batas Waktu</td>
    			<td><b><input type="text" name="batas_waktu" tabindex="7" required value="<?php echo $batas_waktu; ?>" id="batas_waktu" style="width: 200px" class="form-control"></b>
    			</td>
    		</tr>
    		<tr>
    		    <td width="20%">Dasar Kegiatan</td>
    		    <td><b><input type="text" tabindex="8" name="dasar_surat" required value="<?php echo $dasar_surat; ?>" id="dasar_surat" style="width: 300px" class="form-control"></td>
    		</tr>
    		<tr>
    		    <td><button type="button" class="btn btn-success" tabindex="9"><i class="icon-plus-sign icon-white"></i>Alokasi</button></td>
    		    <td><?php //echo getMingguKgt("2023-05-22","2023-05-02");?><p name="coba"></p></td>
    		</tr>
    		
		</table>
	</div>
	<div class="row col-md-12">
	    <table width = 100% class="table table-form">
	        <tr>
	            <td width="20%"><b>Alokasi</b></td>
	        </tr>
	        <tr><b></b></tr>
	        <table width="100%" class="table table-striped" id="targetTable">
        			<th width="5%" style="text-align:center">No</th>
        			<th width="7%" style="text-align:center">Kode Kab/Kota</th>
        			<th width="8%" style="text-align:center">Kab/Kota</th>
        			<!-- Perubahan April-Mei 2023 -->
        			<th width="20%" style="text-align:center" id="jtabel">Penanggung Jawab</th>
        			<!-- End of Perubahan April-Mei 2023 -->
        			<th style="text-align:center">Target
        			<!-- Perubahan April-Mei 2023 -->
        			<button type="button" class="btn btn-success" tabindex="9" onclick="tambah()" ><i class="icon-plus-sign icon-white" ></i></button></th>
        			<!-- End of Perubahan April-Mei 2023 -->
    			</tr>
    			<?php
    				$no=1;
    				foreach($wilayah as $row) 
    				{
    					
    					
    					echo "<tr>";
    					echo "<td>".$no." </td>";
    					echo "<td>".$row->id_kab."</td>";
    					echo "<td>".$row->nama_kab." </td>";
    					$i = 1;
    					?>
    					<!-- Perubahan April-Mei 2023 -->
    					<td>
    					<?php
    					    $querypj = $this->db->query("select * from t_kegiatan where id_kab='$row->id_kab' and id_jeniskegiatan='$id_jeniskegiatan'")->row();
    					    if(!empty($querypj)){
    					        $pj_kab = $querypj->pj_kab;
    					        $pegawaiterpilih = $db2->query("SELECT gelar_depan, nama, gelar_belakang FROM master_pegawai WHERE niplama='$pj_kab' LIMIT 1")->row();?>
    					        <select name="<?php echo 'pj_'.$row->id_kab; ?>" class="form-control" pjkab>
        					    <option selected value="<?php echo $pj_kab; ?>"><?php echo $pegawaiterpilih->gelar_depan." ".$pegawaiterpilih->nama." ".$pegawaiterpilih->gelar_belakang; ?></option>
        					    <?php
        					        //mengambil nama-nama pegawai dari kabkota
                                    if($this->session->userdata('admin_level') == 'userprov'  and  $this->session->userdata('admin_nip') != '6500')
            						{
                						$kodekab = "$row->id_kab";
                                	    $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodekab' ORDER BY id_org ")->result();
            						}
            						else
            						{
            						    $kodekab = "$row->id_kab";
                                	    $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodekab' ORDER BY id_org ")->result();
            						}
                                    foreach($pegawai as $p){
            							echo "<option value='".$p->niplama."'>".$p->gelar_depan." ".$p->nama." ".$p->gelar_belakang."</option>\n";
                                    }
                                ?>
                                </select><?php
    					    }else{?>
    					        <select name="<?php echo 'pj_'.$row->id_kab; ?>" class="form-control" pjkab>
    					        <option selected value="Kosong">- Pilih Penanggung Jawab -</option>
    					        <?php
    					            //mengambil nama-nama pegawai dari kabkota
                                    if($this->session->userdata('admin_level') == 'userprov'  and  $this->session->userdata('admin_nip') != '6500')
        						    {
            					    	$kodekab = "$row->id_kab";
                            	        $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodekab' ORDER BY id_org ")->result();
        						    }
        						    else
            						{
            						    $kodekab = "$row->id_kab";
                                	    $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodekab' ORDER BY id_org ")->result();
            						}
                                    foreach($pegawai as $p){
            							echo "<option value='".$p->niplama."'>".$p->gelar_depan." ".$p->nama." ".$p->gelar_belakang."</option>\n";
                                    }?>
                                </select>
    					    <?php
    					    }
    					?>
                        </td>
    					
    					<?php
    					$querytarget = $this->db->query("select * from t_kegiatan where id_kab='$row->id_kab' and id_jeniskegiatan='$id_jeniskegiatan'")->result();
    					if(!empty($querytarget))
    					{
    					    foreach($querytarget as $data){
    					    ?>
    					        <td><input type="text" name="<?php echo '_'.$row->id_kab.'[]'; ?>" class="form-control" size='60px' value="<?php echo $data->target; ?>" targetkab></td>
    					        <?php
    					        $realisasi_kab = $data->realisasi;
    					    }
    					}
    					else
    					{
    					    $target_kab = "";
    					    //$realisasi_kab = "";?>
    					    <td><input type="text" name="<?php echo '_'.$row->id_kab.'[]'; ?>" class="form-control" size='60px' value="<?php echo $target_kab; ?>" targetkab></td>
    					    <?php
    					}
    					?>
    					<!-- End of Perubahan April-Mei 2023 -->
    					<?php
    
    					echo "</tr>";
    					
    					$no++;
    				}
    			?>
    			</td>
    		</tr>	
    	</table>
	    </table>
    	   


	<a href="javascript:history.back()" tabindex="10" class="btn btn-primary"><i class="icon icon-arrow-left icon-white"></i> Batal</a>
	<button type="submit" class="btn btn-success" tabindex="9" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>

		

	</div>

	
	</div>
	
	</form>
	</div>
</div>
</div>
	
<script type="text/javascript">
	$("input[targetkab]").bind("paste", function(){
		var $this = $(this);
		setTimeout(function() {
			var columns = $this.val().split(/\s+/);
            var i;
            var input = $this;
            for (i = 0; i < columns.length; i++) {
                input.val(columns[i]);
                if( i % 3 !== 2){
                    input = input.parent().parent().next().find('input');
                } else{
                    input = input.parent().parent().next().find('input');
                }
            }
		}, 0);
	});
	//Perubahan April-Mei 2023
	$("input[pjkab]").bind("paste", function(){
		var $this = $(this);
		setTimeout(function() {
			var columns = $this.val().split(/\s+/);
            var i;
            var input = $this;
            for (i = 0; i < columns.length; i++) {
                input.val(columns[i]);
                if( i % 3 !== 2){
                    input = input.parent().parent().next().find('input');
                } else{
                    input = input.parent().parent().next().find('input');
                }
            }
		}, 0);
	});
	
	function tambah(){
	    var row     = document.getElementById("targetTable").rows[0];
	    var th      = document.createElement("th");
	    var btn     = document.createElement("button");
	    var i       = document.createElement("i");
	    var btnno   = row.cells.length;
	    th.setAttribute("style", "text-align:center");
	    th.setAttribute("id", "cell_"+btnno);
	    btn.setAttribute("class", "btn btn-primary");
	    btn.setAttribute("onclick", "hapus('cell_"+btnno+"')");
	    i.setAttribute("class", "icon-trash icon-white");
	    row.appendChild(th);
	    th.appendChild(btn);
	    btn.appendChild(i);
	    var kodekab = ["", "6501", "6502", "6503", "6504", "6571"]
	    for($i = 1; $i < document.getElementById("targetTable").rows.length; $i++){
	        row         = document.getElementById("targetTable").rows[$i];
	        var td      = document.createElement("td");
	        var input   = document.createElement("input");
	        td.setAttribute("id", "cell_"+btnno);
	        input.setAttribute("type", "text");
            input.setAttribute("name", "_"+kodekab[$i]+"[]");
            input.setAttribute("class", "form-control");
            input.setAttribute("size", "60px");
            row.appendChild(td);
            td.appendChild(input);
	    }
	}
	
	function hapus(cellno){
	    for($i = 0; $i < document.getElementById("targetTable").rows.length; $i++){
	        var row         = document.getElementById("targetTable").rows[$i];
	        var cellnum    = document.getElementById(cellno);
	        cellnum.remove();
	    }
	}
	
	$(document).ready(function(){
        $('#mulai, #batas_waktu').change(function(){
            var tmulai=$('#mulai').val();
            var tbatas=$('#batas_waktu').val();
            if(tmulai != '' && tbatas != ''){
                $.ajax({
    				typ         : "GET",
                    url         : "<?php echo base_url();?>index.php/Admin/getMingguKgt/"+tmulai+"/"+tbatas,
                    dataType    : 'json',
                    success     : function(data){
                        var text    = "Target "+data.friday
                        document.getElementById("jtabel").appendChild(text);
                        //$('#jtabel').innerText = "Target "+data.friday;
                    }
                });
            }
            
        });
    });


</script>
