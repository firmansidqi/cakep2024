<?php
	$id_jeniskegiatan		= $datpil->id_jeniskegiatan;
	$nama_kegiatan			= $datpil->nmkegiatan;
	$target					= $datpil->target;
	$realisasi				= $datpil->realisasi;
?>
<div class="modal-dialog" style="margin-top:80px">
    <div class="modal-content">

    	<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Data Yang Akan Dihapus</h4>
        </div>

        <div class="modal-body">
        	<form action="<?php echo base_URL()?>index.php/admin/kelolakegiatan/act_del/" name="modal_popup" enctype="multipart/form-data" method="POST">
        		
                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Kegiatan Name">Kegiatan </label>
                    <input type="hidden" name="id_jeniskegiatan"  class="form-control" value="<?php echo $id_jeniskegiatan; ?>" />
     				<input type="text" name="nama_kegiatan"  class="form-control" value="<?php echo $nama_kegiatan ; ?>"/>
                </div>

                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Target">Target</label>
								
     				<input type="text" name="target"  class="form-control" value="<?php echo $target; ?>" disabled/>
                </div>

				<div class="form-group" style="padding-bottom: 20px;">
                	<label for="Target">Realisasi</label>       
     				<input type="text" name="realisasi"  class="form-control" value="<?php echo $realisasi; ?>" disabled/>
                </div>
				
	            <div class="modal-footer">
	                <button class="btn btn-success" type="submit">
	                    Delete
	                </button>
	                <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">
	               		Cancel
	                </button>
	            </div>
            	</form>
            </div>
        </div>
    </div>