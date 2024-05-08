<?php
$mode               = $this->uri->segment(3);
$wilayah            = $this->db->query("select * from m_kab where id_kab <> '6500'")->result();
$db2                = $this->load->database('db2',TRUE);
$this->load->model('M_kelolakegiatan');

$act                = "act_add";
$judul              = "Entri Kegiatan Baru";
$idp                = "";
$unitkerja          = "";
$tahun              = "";
$id_jeniskegiatan   = "";
$subkegiatan        = "";
$dasar_surat        = "";
$target             = "";
$realisasi          = "";
$targetprop         = "";
$realisasiprop      = "";
$kabkota            = "";
$batas_waktu        = "";
$satuan             = "";
$mulai              = "";
$ketua_tim_prov     = "";
$_6501              = "";
$_6502              = "";
$_6503              = "";
$_6504              = "";
$_6571              = "";

?>

<?php echo $this->session->flashdata("k");?>
<div class="row col-md-12" style="margin-top:80px">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>TAMBAH KEGIATAN</h4>
        </div>
        
        <div class="scroll" style="height: auto;">
            <form action="<?php echo base_URL()?>index.php/admin/kelolakegiatan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="row-fluid well" style="overflow: hidden">

                    <!-- Perubahan April-Mei 2023 -->
                    <!--div class="col-lg-6"-->
                    <div class="row col-md-12">
                        <table width="100%" class="table-form">
                            <tr>
                                <td width="20%">Tahun Kegiatan</td>
                                <td>
                                    <b>
                                        <select name="tahun" id="tahun" required class="form-control" tabindex="1" style="width: 100px">
                                            <option selected value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Nama Kegiatan</td>
                                <td>
                                    <b>
                                        <select name="kegiatan" id="kegiatan" required class="form-control" tabindex="2" style="width: 500px">
                                            <option selected value="">- Pilih Kegiatan -</option>
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
                                    </b>
                                </td>
                            </tr>
                            
                            <tr><td width="20%">Nama Sub Kegiatan</td>
                                <td>
                                    <b>
                                        <select name="subkegiatan" id="subkegiatan"  class="form-control" tabindex="3" style="width: 500px" required>
                                            <option selected value="">- Pilih Sub Kegiatan -</option>
                                        </select>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Satuan</td>
                                <td>
                                    <b>
                                        <select name="satuan" id="satuan" style="width: 500px" class="form-control" readonly>
                                            <option> - Satuan - </option>
                                            
                                        </select>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Nama Ketua Tim</td>
                                <td>
                                    <b>
                                        <select name="ketua_tim_prov" id="ketua_tim_prov"  class="form-control" tabindex="4" style="width: 500px" required>
                                            <option selected value="">- Pilih Ketua Tim -</option>
                                            <?php
                                                //mengambil nama-nama pegawai dari provinsi
                                            $kodeprov = "6500";
                                            $pegawai = $db2->query("SELECT niplama, gelar_depan, nama, gelar_belakang, id_satker FROM master_pegawai WHERE id_satker='$kodeprov' AND niplama<>'340000000' ORDER BY id_org ")->result();
                                            foreach($pegawai as $p){
                                                echo "<option value='".$p->niplama."'>".$p->gelar_depan." ".$p->nama." ".$p->gelar_belakang."</option>\n";
                                            }
                                            ?>
                                        </select>
                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%" >Mulai</td>
                                <td><b><input type="text" name="mulai" tabindex="5" required value="<?php echo $mulai; ?>" id="mulai" style="width: 250px" class="form-control"></b>
                                </td>
                            </tr>

                            <tr>
                                <td width="20%">Batas Waktu</td>
                                <td><b><input type="text" name="batas_waktu" tabindex="6" required value="<?php echo $batas_waktu; ?>" id="batas_waktu" style="width: 250px" class="form-control"></b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="20%">Dasar Kegiatan</td>
                                <td><b><input type="text" tabindex="7" name="dasar_surat" required value="<?php echo $dasar_surat; ?>" id="dasar_surat" style="width: 500px" class="form-control">
                                </td>
                            </tr>

                        </table>

                        <div class="row col-md-12">
                            <hr>
                            <table width = 100%>
                                <tr>
                                    <th width="100%" style="text-align:center; font-size:16pt; padding-bottom:12px;"><b>Alokasi</b></th>
                                </tr>
                            </table>
                            <div style="overflow:auto">
                                <table width="100%" class="table table-striped" id="targetTable">
                                    <tr>
                                        <th width="5%" style="text-align:center">No</th>
                                        <th width="7%" style="text-align:center">Kode Kab/Kota</th>
                                        <th width="8%" style="text-align:center">Kab/Kota</th>
                                    </tr>
    
                                    <?php
                                    $no=1;
                                    foreach($wilayah as $row) 
                                    {
                                        echo "<tr>";
                                        echo "<td align='center'>".$no." </td>";
                                        echo "<td align='center'>".$row->id_kab."</td>";
                                        echo "<td>".$row->nama_kab." </td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                    ?>
    
                                </table>
                            </div>
                            
                            <hr>
                            <a href="javascript:history.back()" tabindex="10" class="btn btn-primary"><i class="icon icon-arrow-left icon-white"></i> Batal</a>
                            <button type="submit" class="btn btn-success" tabindex="9" ><i class="icon icon-folder-close icon-white"></i> Simpan</button>
                        </div>
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
    $(document).ready(function(){
        $('#subkegiatan').change(function(){
            var subkegiatan=$(this).val();
            $.ajax({
                type : "GET",
                url : "<?php echo base_url();?>index.php/Admin/getsatuan/"+subkegiatan,
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
    $(document).ready(function(){
        $('#mulai, #batas_waktu').change(function(){
            var tmulai  = $('#mulai').val();
            var tbatas  = $('#batas_waktu').val();
            var l       = document.getElementById("targetTable").rows[0].cells.length;
            var w       = document.getElementById("targetTable").rows.length;
            if(tmulai != '' && tbatas != ''){
                if(l > 3){
                    for(i = 3; i < l; i++){
                        for (j = 0; j < w; j++){
                            const element = document.getElementById("tgt");
                            element.remove();
                        }
                    }
                }
                $.ajax({
                    typ         : "GET",
                    url         : "<?php echo base_url();?>index.php/Admin/getjumat/"+tmulai+"/"+tbatas,
                    dataType    : 'json',
                    success     : function(data){
                        for(i = 0; i < data.jfriday; i++){
                            var tr      = document.getElementById("targetTable").rows[0];
                            var th      = document.createElement("th");
                            var text    = "Minggu "+ (i+1) + "<br>(" + data.friday2[i]+")";
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
                                input.setAttribute("required", "");
                                tr.appendChild(td);
                                td.appendChild(input);
                            }
                        }
                    }
                });
            }

        });
    });
</script>
