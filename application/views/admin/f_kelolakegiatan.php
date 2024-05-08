<?php
$mode		= $this->uri->segment(3);
$wilayah	= $this->db->query("select * from m_kab where id_kab <> '6500'")->result();
$db2        = $this->load->database('db2',TRUE);
$this->load->model('M_kelolakegiatan');


$id_jeniskegiatan		= $datpil->id_jeniskegiatan;
$act					= "act_edt/".$id_jeniskegiatan;
$tahun					= substr($id_jeniskegiatan,0,4);
$nama_kegiatan			= $datpil->nama_kegiatan;
$dasar_surat			= $datpil->dasar_surat;
$batas_waktu			= $datpil->batas_waktu;
$satuan					= $datpil->satuan;
$mulai                  = $datpil->mulai;
$ketua_tim              = $datpil->ketua_tim;

$query_satuan=$this->db->query("SELECT * from m_satuan where id_satuan='$satuan' LIMIT 1")->row();
$idsatuan_terpilih      = $query_satuan->id_satuan;
$satuan_terpilih        = $query_satuan->satuan;
	
	$query_namakegiatan = $this->db->query("SELECT m.*, subk.nama_kegiatan as nmkegiatan, k.id_kegiatan, k.kegiatan from m_jeniskegiatan m left join m_listkegiatan subk on m.nama_kegiatan=subk.id left join m_kegiatan k on subk.id_kegiatan = k.id_kegiatan where m.id_jeniskegiatan='$id_jeniskegiatan' LIMIT 1")->row();
	$id_kegiatanterpilih=$query_namakegiatan->id_jeniskegiatan;
	$nama_kegiatanterpilih=$query_namakegiatan->nama_kegiatan;
	$query_namappjprov = $this->db->query("SELECT * from m_jeniskegiatan where id_jeniskegiatan='$id_jeniskegiatan' LIMIT 1")->row();
	$id_kegiatanterpilih=$query_namakegiatan->id_jeniskegiatan;
	$nama_kegiatanterpilih=$query_namakegiatan->nama_kegiatan;
	

?>

<?php echo $this->session->flashdata("k");?>
<div class="row col-md-12" style="margin-top:80px">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>EDIT KEGIATAN</h4>
        </div>
        
        <div class="scroll" style="height: auto;">
            <form action="<?php echo base_URL()?>index.php/admin/kelolakegiatan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="row-fluid well" style="overflow: hidden">
                    <div class="row col-md-12">
                        <table width="100%" class="table-form">
                            <tr>
                                <td width="20%">Tahun Kegiatan</td>
                                <td>
                                    <b>
                                        <select name="tahun" id="tahun"  class="form-control" tabindex="1" style="width: 100px" required>
                                            <option selected value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Nama Kegiatan</td>
                                <td>
                                    <b>
                                        <?php
                                        if ($mode == "edt" || $mode == "act_edt") 
                                        {
                                        ?>
                                            <select name="kegiatan" id="kegiatan"  class="form-control" tabindex="2" style="width: 500px" >
                                                <option selected value="<?php echo $query_namakegiatan->id_kegiatan; ?>"><?php echo $query_namakegiatan->kegiatan; ?></option>
                                                <?php
                                                
                                                //mengambil nama-nama kegiatan yang ada di database
                                                if($this->session->userdata('admin_level')=='userprov' and $this->session->userdata('admin_nip') != '6500')
                                                {
                                                    $timku = $this->session->userdata('admin_nip');
                                                    $kegiatan = $this->db->query("select * from m_kegiatan where id_tim='$timku'")->result();
                                                }
                                                else
                                                {
                                                    $kegiatan = $this->db->query("select * from m_kegiatan")->result();
                                                }
                                                foreach($kegiatan as $p)
                                                {
                                                    echo "<option value='".$p->id_kegiatan."'>".$p->kegiatan."</option>\n";
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        }
                                        else
                                        {
                                        }
                                        ?>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Nama Sub Kegiatan</td>
                                <td>
                                    <b>
                                        <?php
                                        if ($mode == "edt" || $mode == "act_edt") 
                                        {
                                        ?>
                                            <select name="subkegiatan" id="subkegiatan"  class="form-control" tabindex="3" style="width: 500px" >
                                                <option selected value="<?php echo $nama_kegiatan; ?>"><?php echo $query_namakegiatan->nmkegiatan; ?></option>
                                                <?php
                                                
                                                //mengambil nama-nama sub kegiatan yang ada di database
                                                $kegiatan = $this->db->query("select * from m_listkegiatan where id_kegiatan='$query_namakegiatan->id_kegiatan'")->result();
                                                foreach($kegiatan as $p)
                                                {
                                                    echo "<option value='".$p->id."'>".$p->nama_kegiatan."</option>\n";
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        }
                                        else
                                        {
                                        }
                                        ?>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Satuan</td>
                                <td>
                                    <b>
                                        <select name="satuan" id="satuan" style="width: 500px" class="form-control" readonly>
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
                            
                            <tr>
                                <td width="20%">Nama Ketua Tim</td>
                                <td>
                                    <b>
                                    <?php
                                        if ($mode == "edt" || $mode == "act_edt")
                                        {
                                            $pegawaiterpilih = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang FROM master_pegawai WHERE niplama='$ketua_tim' LIMIT 1")->row();
                                            ?>
                                            <select name="ketua_tim_prov" id="ketua_tim_prov"  class="form-control" tabindex="4" style="width: 500px" >
                                            <?php
                                                if(empty($pegawaiterpilih)){
                                                ?>
                                                    <option selected value="Kosong">- Pilih Penanggung Jawab -</option>
                                                <?php
                                                }
                                                else{
                                                ?>
                                                    <option selected value="<?php echo $ketua_tim; ?>"><?php echo $pegawaiterpilih->gelar_depan." ".$pegawaiterpilih->nama." ".$pegawaiterpilih->gelar_belakang; ?></option>
                                                <?php
                                                }
                                                
                                                //mengambil nama-nama pegawai dari provinsi
                                                $kodeprov = "6500";
                                                $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodeprov' AND niplama<>'340000000' ORDER BY id_org ")->result();
                                                foreach($pegawai as $p){
                                                    echo "<option value='".$p->niplama."'>".$p->gelar_depan." ".$p->nama." ".$p->gelar_belakang."</option>\n";
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        }
                                        else
                                        {
                                        }
                                    ?>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%" >Mulai</td>
                                <?php
                                if($mulai == "0000-00-00")
                                {
                                ?>
                                    <td><b><input type="text" name="mulai" tabindex="5" required value="" id="mulai" style="width: 250px" class="form-control"></b></td>
                                    <?php
                                }else
                                {
                                ?>
                                    <td><b><input type="text" name="mulai" tabindex="5" required value="<?php echo $mulai; ?>" id="mulai" style="width: 250px" class="form-control"></b></td>
                                <?php
                                }
                                ?>
                            </tr>
                            
                            <tr>
                                <td width="20%">Batas Waktu</td>
                                <td><b><input type="text" name="batas_waktu" tabindex="6" required value="<?php echo $batas_waktu; ?>" id="batas_waktu" style="width: 250px" class="form-control"></b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Dasar Kegiatan</td>
                                <td><b><input type="text" tabindex="7" name="dasar_surat" required value="<?php echo $dasar_surat; ?>" id="dasar_surat" style="width: 500px" class="form-control"></td>
                            </tr>
                        
                        </table>
                    </div>
                    
                    <div class="row col-md-12">
                        <hr>
                        <table width = 100%>
                            <tr>
                                <th width="100%" style="text-align:center; font-size:16pt; padding-bottom:12px;"><b>Alokasi</b></th>
                            </tr>
                            
                            <table width="100%" class="table table-striped" id="targetTable">
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th width="7%" style="text-align:center">Kode Kab/Kota</th>
                                    <th width="8%" style="text-align:center">Kab/Kota</th>
                                    <th width="20%" style="text-align:center" id="jtabel">Penanggung Jawab</th>
                                    <?php
                                    $friday = $this->db->query("select batas_minggu from t_kegiatan where id_kab='6501' and id_jeniskegiatan='$id_jeniskegiatan' ORDER BY batas_minggu ASC")->result();
                                    if(!empty($friday)){
                                        for($i = 1; $i <= count($friday); $i++){
                                            echo "<th style='text-align:center' id='tgt'>Minggu ".$i."<br>(".tgl_jam_sql($friday[$i-1]->batas_minggu).")</th>";
                                        }
                                    };?>
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
                                        <td>
                                        <?php
                                            $querypj = $this->db->query("select * from t_kegiatan where id_kab='$row->id_kab' and id_jeniskegiatan='$id_jeniskegiatan' ORDER BY batas_minggu ASC")->row();
                                            if(!empty($querypj)){
                                                $ketua_tim_kab = $querypj->ketua_tim;
                                                $pegawaiterpilih = $db2->query("SELECT gelar_depan, nama, gelar_belakang FROM master_pegawai WHERE niplama='$ketua_tim_kab' LIMIT 1")->row();?>
                                                <select name="<?php echo 'pj_'.$row->id_kab; ?>" class="form-control" pjkab readonly>
                                                <?php
                                                    if(empty($pegawaiterpilih))
                                                    {
                                                    ?>
                                                        <option selected value=""></option>
                                                    <?php
                                                    }else{
                                                    ?>
                                                        <option selected value="<?php echo $pj_kab; ?>"><?php echo $pegawaiterpilih->gelar_depan." ".$pegawaiterpilih->nama." ".$pegawaiterpilih->gelar_belakang; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select><?php
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        $querytarget = $this->db->query("select * from t_kegiatan where id_kab='$row->id_kab' and id_jeniskegiatan='$id_jeniskegiatan' ORDER BY batas_minggu ASC")->result();
                                        if(!empty($querytarget))
                                        {
                                            foreach($querytarget as $data)
                                            {
                                            ?>
                                                <td id="tgt" ><input type="text" name="<?php echo '_'.$row->id_kab.'[]'; ?>" id="<?php echo '_'.$row->id_kab.'[]'; ?>" class="form-control" size='60px' value="<?php echo $data->target; ?>" targetkab></td>
                                                <?php
                                                $realisasi_kab = $data->realisasi;
                                            }
                                        }
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
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
    $(document).ready(function(){
        $('#kegiatan').change(function(){
            var kegiatan=$(this).val();
            $.ajax({
                type : "GET",
                url : "<?php echo base_url();?>index.php/Admin/getsubkegiatan/"+kegiatan,
                dataType : 'json',
                success: function(datasubkegiatan){
                    var html = '';
                    var i;
                    html = '<option value="">- Pilih Sub Kegiatan -</option>'
                    for(i=0; i<datasubkegiatan.length; i++){
                        html += '<option value="'+datasubkegiatan[i].id+'">'+datasubkegiatan[i].nama_kegiatan+'</option>';
                    }
                    $('#subkegiatan').html(html);
                }
            });
        });
    });
</script>

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

	$(document).ready(function(){
        $('#mulai, #batas_waktu').change(function(){
            var tmulai  = $('#mulai').val();
            var tbatas  = $('#batas_waktu').val();
            var col       = document.getElementById("targetTable").rows[0].cells.length;
            var w       = document.getElementById("targetTable").rows.length;
            var cek     = document.getElementById("_6501[]").value;
            if(tmulai != '' && tbatas != ''){
                $.ajax({
                    typ         : "GET",
                    url         : "<?php echo base_url();?>index.php/Admin/getjumat/"+tmulai+"/"+tbatas,
                    dataType    : 'json',
                    success     : function(data){
                        if(cek[0] != ''){
                            for(i = 4; i < col; i++){
                                var tr  = document.getElementById("targetTable").rows[0];
                                tr.removeChild(tr.lastElementChild);
                            }
                            if((col-4) > data.jfriday){
                                for(i = 1; i <= (col-4-data.jfriday); i++){
                                    for(j = 1; j < w; j++){
                                        var tr  = document.getElementById("targetTable").rows[j];
                                        tr.removeChild(tr.lastElementChild);
                                    }
                                }
                            }else{
                                for(i = col; i < (data.jfriday+4); i++){
                                    var kodekab     = ["", "6501", "6502", "6503", "6504", "6571"]
                                    for(j = 1; j < w; j++){
                                        var tr          = document.getElementById("targetTable").rows[j];
                                        var td      = document.createElement("td");
                                        var input   = document.createElement("input");
                                        td.setAttribute("id", "tgt");
                                        input.setAttribute("type", "text");
                                        input.setAttribute("name", "_"+kodekab[j]+"[]");
                                        input.setAttribute("class", "form-control");
                                        input.setAttribute("size", "60px");
                                        tr.appendChild(td);
                                        td.appendChild(input);
                                    }
                                }
                            }
                            for(i = 4; i < (data.jfriday+4); i++){
                                var tr  = document.getElementById("targetTable").rows[0];
                                var th      = document.createElement("th");
                                var text    = "Minggu "+ (i-3) + "<br>" + data.friday2[i-4];
                                th.setAttribute("style", "text-align:center");
                                th.setAttribute("id", "tgt");
                                tr.appendChild(th);
                                th.innerHTML    = text;
                            };
                        }else{
                            if(col > 4){
                                for(i = 4; i < col; i++){
                                    for (j = 0; j < w; j++){
                                        const element = document.getElementById("tgt");
                                        element.remove();
                                    }
                                }
                            };
                            for(i = 0; i < data.jfriday; i++){
                                var tr      = document.getElementById("targetTable").rows[0];
                                var th      = document.createElement("th");
                                var text    = "Minggu "+ (i+1) + "<br>" + data.friday2[i];
                                th.setAttribute("style", "text-align:center");
                                th.setAttribute("id", "tgt");
                                tr.appendChild(th);
                                th.innerHTML    = text;
                                var kodekab     = ["", "6501", "6502", "6503", "6504", "6571"]
                                for(j = 1; j < w; j++){
                                    tr          = document.getElementById("targetTable").rows[j];
                                    var td      = document.createElement("td");
                                    var input   = document.createElement("input");
                                    td.setAttribute("id", "tgt");
                                    input.setAttribute("type", "text");
                                    input.setAttribute("name", "_"+kodekab[j]+"[]");
                                    input.setAttribute("class", "form-control");
                                    input.setAttribute("size", "60px");
                                    tr.appendChild(td);
                                    td.appendChild(input);
                                }
                            }
                        }
                    }
                });
            }
            
        });
    });


</script>
