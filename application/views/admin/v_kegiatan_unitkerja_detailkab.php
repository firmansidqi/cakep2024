<?php 
$uri4 = $this->uri->segment(4);
?>

<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">DETAIL KEGIATAN
     <div class="btn-group pull-right">
	
         <a href="<?php echo base_URL()?>index.php/admin/unitkerjaprovuntukkab/" class="btn btn-info btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Provinsi</a>
            <a href="<?php echo base_URL()?>index.php/admin/unitkerjakabkotadetail/"  class="btn btn-danger btn-sm"><i class="icon-list icon-white" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Kabupaten/Kota</a>
       </div>
    </div>
    <div class="panel-body">

      <div class="col-lg-12 alert alert-warning" style="margin-bottom: 20px">
        <div class="col-md-12">
            <table class="table table-bordered" style="margin-bottom: 0px">
              <tr><td>ID Kegiatan</td><td><?php echo $datview->id_jeniskegiatan; ?></td></tr>
              <tr><td>Nama Kegiatan</td><td><?php echo $datview->nama_kegiatan; ?></td></tr>
              <tr><td width="30%">Satuan</td><td width="70%"><?php echo $datview->nama_satuan; ?></td></tr>
              <tr><td>Target</td><td><?php echo $datview->target; ?> </td></tr>
			  <tr><td>Batas Waktu</td><td><?php echo tgl_jam_sql($datview->batas_waktu); ?> </td></tr>
			  <?php
			  if ($this->session->userdata('admin_level') != "userkabkota") 
				{?>
			  <tr><td colspan="2" align="right">
				<div class="btn-group">
								<a href="<?php echo base_URL()?>index.php/admin/kelolakegiatan/edt/<?php echo $datview->id_jeniskegiatan; ?>" class="btn btn-success btn-xs" title="Edit Data"><i class="icon-edit icon-white"> </i></a>
								<?php
								$id_delete =$datview->id_jeniskegiatan ;
								?>
								<a href="#" class="open_modal btn btn-danger btn-xs" id="<?php echo $id_delete ;?>"><i class="icon-trash icon-white"></i></a>		
				</div>
			  </td></tr>
			  <?php
				}
				?>
            </table>
        </div>
      </div>


      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="35%">Kabupaten/Kota</th>
            <th width="15%">Target</th>
            <th width="15%">Realisasi</th>
            <th width="15%">Persentase</th>
			<th width="15%">Tanggal Update</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($datprogress)) {
              $no = 1;
              foreach ($datprogress as $d) {
				  ?>
                <tr>
                      <td class="ctr"><?php echo $no ; ?></td>
                      <td><?php echo $d->nama_kab ; ?></td>
                      <td class="ctr"><?php echo $d->target ; ?></td>
                      <td class="ctr"><?php echo $d->realisasi ; ?></td>
                      <?php
									if($d->persen >= '0' && $d->persen <= '50')
									{
									?>
									<td  align="center" style="background-color:red"><font style="background-color:red ; color:white"><?php echo $d->persen.' %';?></font></td>
									<?php
									}
									else if($d->persen > '50' && $d->persen <= '90')
									{
									?>
									<td  align="center" style="background-color:orange"><font style="background-color:orange ; color:white"><?php echo $d->persen.' %';?></font></td>
									<?php
									}
									else
									{
									?>
									<td  align="center" style="background-color:green"><font style="background-color:green ; color:white"><?php echo $d->persen.' %';?></font></td>
									<?php
									}
									?>
					  <td class="ctr"><?php echo tgl_jam_sql($d->tgl_entri) ; ?></td>
                      </tr>
			 <?php
              $no++;
              }
            } else {
              echo '<tr><td colspan="5">Belum ada progress</td></tr>';
            }
          ?>
        </tbody>
      </table>
    
      </div>
    </div>
  </div>
</div>

  <!-- Modal Popup untuk Delete--> 
<div id="ModalDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Edit--> 
<script type="text/javascript">
   $(document).ready(function () {
   $(".open_modal").click(function(e) {
      var m = $(this).attr("id");
		   $.ajax({
    			   url: "<?php echo base_url(); ?>index.php/admin/kelolakegiatan/del/",
    			   type: "GET",
    			   data : {delete_id: m,},
    			   success: function (ajaxData){
      			   $("#ModalDelete").html(ajaxData);
      			   $("#ModalDelete").modal('show',{backdrop: 'true'});
      		   }
    		   });
        });
      });
</script>

<!-- Modal Popup untuk Edit--> 
<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Edit--> 
<script type="text/javascript">
   $(document).ready(function () {
   $(".open_modal_edit").click(function(e) {
      var m = $(this).attr("id");
		   $.ajax({
    			   url: "<?php echo base_url(); ?>index.php/admin/konfirmasi/edt/",
    			   type: "GET",
    			   data : {konfirmasi_id: m,},
    			   success: function (ajaxData){
      			   $("#ModalEdit").html(ajaxData);
      			   $("#ModalEdit").modal('show',{backdrop: 'true'});
      		   }
    		   });
        });
      });
</script>	