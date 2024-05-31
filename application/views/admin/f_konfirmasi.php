<?php
	$id_jeniskegiatan		= $datpil->id_jeniskegiatan;
	$nama_kegiatan			= $datpil->nmkegiatan;
	$id_kab					= $datpil->id_kab;
	$nama_kab				= $datpil->nama_kab;
	$target					= $datpil->target;
	$realisasi				= $datpil->realisasi;
	$bukti					= $datpil->bukti;
	$link_pengiriman		= $datpil->link_pengiriman;
	$minggu_ke              = $datpil->minggu_ke;
	$batas_minggu           = $datpil->batas_minggu;

?>
<div class="modal-dialog" style="margin-top:80px">
    <div class="modal-content">

    	<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Data Yang Harus Dikonfirmasi</h4>
        </div>

        <div class="modal-body">
        	<form action="<?php echo base_URL()?>index.php/admin/konfirmasi/act_edt/<?php echo $minggu_ke.'/'.$batas_minggu.'/'; ?> name="modal_popup enctype="multipart/form-data" method="POST">
        		
                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Kegiatan Name">Kegiatan </label>
                    <input type="hidden" name="id_jeniskegiatan"  class="form-control" value="<?php echo $id_jeniskegiatan; ?>" />
     				<input type="text" name="nama_kegiatan"  class="form-control" value="<?php echo $nama_kegiatan ; ?>" disabled/>
                </div>

                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Kabupaten Name">Kabupaten/Kota </label>
                    <input type="hidden" name="id_kab"  class="form-control" value="<?php echo $id_kab; ?>" />
     				<input type="text" name="nama_kab"  class="form-control" value="<?php echo $nama_kab ; ?>" disabled/>
                </div>

                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Target">Target</label>  
     				<input type="text" name="target"  class="form-control" value="<?php echo $target; ?>" disabled/>
                </div>

				<div class="form-group" style="padding-bottom: 20px;">
                	<label for="Target">Realisasi</label>       
     				<input type="text" name="realisasi"  class="form-control" value="<?php echo $realisasi; ?>" disabled/>
                </div>
				
				<div class="form-group" style="padding-bottom: 20px;">
                	<label for="Target">Bukti Realisasi Kegiatan</label>       
     				<input type="text" name="bukti"  class="form-control" value="<?php echo $bukti; ?>" disabled/>
					<input type="text" name="link_pengiriman"  class="form-control" value="<?php echo $link_pengiriman; ?>" readonly/>
                </div>
                
                <div class="form-group" style="padding-bottom: 20px;">
                	<label for="Target">Catatan Persetujuan</label>       
					<input type="text" name="konfirm_ket"  class="form-control" style="height:150px" value="" />
                </div>

	            <div class="modal-footer">
	                <button class="btn btn-success" type="submit">
	                    Konfirmasi
	                </button>
					<!--<a href="javascript:history.back()" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>-->
	                <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">
	               		Cancel
	                </button>
	            </div>
	            
            	</form>
            </div>
        </div>
    </div>