<?php
$mode		    = $this->uri->segment(3);
$id_kegiatan    = $data[0]->id_jeniskegiatan;
$id_kab         = $data[0]->id_kab;
$approval       = $data[0]->flag_approval;
?>

<?php echo $this->session->flashdata("k");?>
<div class="row col-md-12" style="margin-top:80px">
    <div class="panel panel-info">
        <div class="panel-heading"> PERSETUJUAN PENGAJUAN UBAH TARGET MINGGUAN
        </div>
        
        <div class="scroll" style="height: auto;">
            <form action="<?php echo base_URL()?>index.php/admin/approval/act_approv" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="row-fluid well" style="overflow: hidden">
                    <div class="row col-md-12">
                        <table width="100%" class="table-form">
                            <tr>
                                <td width="20%">Nama Kegiatan</td>
                                <td>
                                    <b>
                                        <input type="hidden" name="idpengajuan" tabindex="1" id="idpengajuan" style="width: 500px" class="form-control" value="<?php echo $data[0]->id_pengajuan; ?>">
                                        <input type="hidden" name="idkegiatan" tabindex="1" id="idkegiatan" style="width: 500px" class="form-control" value="<?php echo $data[0]->id_jeniskegiatan; ?>">
                                        <input type="text" name="kegiatan" tabindex="1" id="kegiatan" style="width: 500px" class="form-control" value="<?php echo $data[0]->nama_kegiatan; ?>" readonly>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Kabupaten/Kota</td>
                                <td>
                                    <b>
                                        <input type="text" name="idkab" tabindex="1" id="idkab" style="width: 500px" class="form-control" value="<?php echo $data[0]->id_kab; ?>" readonly>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Alasan Pengajuan</td>
                                <td>
                                    <b>
                                        <input type="text" name="alasan" tabindex="2" id="alasan" style="width: 500px" class="form-control" value="<?php echo $data[0]->alasan; ?>" readonly>
                                    </b>
                                </td>
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
                                    <th style="text-align:center" width=5%>No.</th>
                                    <th style="text-align:center" width=10%>Jenis Target</th>
                                    <?php
                                    $friday = $this->db->query("select batas_minggu from t_kegiatan where id_kab='6501' and id_jeniskegiatan=$id_kegiatan ORDER BY minggu_ke")->result();
                                    if(!empty($friday)){
                                        for($i = 1; $i <= count($friday); $i++){
                                            echo "<th style='text-align:center' id='tgt'>Minggu ".$i."<br>(".tgl_jam_sql($friday[$i-1]->batas_minggu).")</th>";
                                        }
                                    };?>
                                </tr>
                                <?php
                                    echo "<tr>";?>
                                        <td style="text-align:center">1</td>
                                        <td >Target Lama</td>
                                        <?php
                                        if(!empty($data))
                                        {
                                            foreach($data as $dat)
                                            {
                                            ?>
                                                <td id="tgt" ><input type="text" name="<?php echo '_'.$id_kab.'[]'; ?>" id="<?php echo '_'.$id_kab.'[]'; ?>" class="form-control" size='60px' value="<?php echo $dat->target_lama; ?>" targetkabnew readonly></td>
                                                <?php
                                            }
                                        }
                                    echo "</tr>";
                                ?>
                                <tr>
                                    <td style="text-align:center">2</td>
                                    <td >Target Baru</td>
                                    <?php
                                        if(!empty($data))
                                        {
                                            foreach($data as $dat)
                                            {
                                            ?>
                                                <td id="tgt" ><input type="text" name="<?php echo '_'.$id_kab.'new[]'; ?>" id="<?php echo '_'.$id_kab.'new[]'; ?>" class="form-control" size='60px' value="<?php echo $dat->target_baru; ?>" targetkabnew readonly></td>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tr>
                            </table>
                        </table>
                        
                        
                    </div>
                    <div class="row col-md-12">
                        <?php
                        if($approval != 2){
                            
                        }
                        else
                        {
                            ?>
                            <table class="table-form">
                                <tr>
                                    <td width="20%">Persetujuan</td>
                                    <td width="20%">
                                        <select name="persetujuan" id="persetujuan" class="form-control" tabindex="1" required>
                							<option value="1" >
                								<?php echo "Disetujui"; ?>
                							</option>
                							<option value="3" >
                								<?php echo "Ditolak"; ?>
                							</option>
                						</select>
                                    </td>
                                </tr>
                                
                            </table>
                        <?php
                        }
                        ?>
                        
                        <br>
                        <?php
                        if($approval != 2)
                        {
                            ?>
                            <a href="<?php echo base_URL()?>index.php/admin/approval/" tabindex="10" class="btn btn-primary"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
                        <?php
                        }
                        else
                        {
                            ?>
                            <a href="javascript:history.back()" tabindex="10" class="btn btn-primary"><i class="icon icon-arrow-left icon-white"></i> Batal</a>
                            <button type="submit" class="btn btn-success" tabindex="9" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>
                            <?php
                        }
                        ?>
                        
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
	
	$("input[targetkabnew]").bind("paste", function(){
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
