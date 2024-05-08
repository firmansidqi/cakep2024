<?php
$mode           = $this->uri->segment(3);
$idkab          = $this->session->userdata('admin_nip');
?>

<div class="modal-dialog" style="margin-top:80px">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Notifikasi</h4>
        </div>
        
        <div class="modal-body">
            <div class="notif-modal">
                <div class="notif-header">
                    <table class="notif-table">
                        <thead>
                            <tr class="tr-header">
                                <th width=10px class="notif-th"></th>
                                <th width=15% class="notif-th">Tanggal</th>
                                <th width=20% class="notif-th">Judul</th>
                                <th width=60% class="notif-th">Pesan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="notif-body">
                    <table class="notif-table">
                        <tbody>
                            <?php
                            if (empty($data)){
                               ?>
                               <tr style="height:150px; ">
                                   <td class="no-data">
                                       <i class="bi bi-folder-x" style="font-size: 30pt; "></i>
                                       <p>No Data Found!</p>
                                   </td>
                               </tr>
                               <?php
                            }else{
                                foreach($data as $dat){
                                    ?>
                                    <tr style="height:50px; " class="tr-body">
                                        <?php
                                        if ($dat->status == 1){
                                            ?>
                                            <td align="center" width=5% class="notif-th">
                                                <i class="bi bi-envelope bi-bold"></i>
                                            </td>
                                            <td width=15% class="notif-th">
                                                <b><?php echo $dat->created_on?></b>
                                            </td>
                                            <td width=20% class="notif-th">
                                                <b><?php echo $dat->jenis_notif?></b>
                                            </td>
                                            <td width=60% class="notif-th">
                                                <b>
                                                    <a href="<?php echo base_url(); ?>index.php/admin/notifikasi/view/<?php echo $dat->id;?>">
                                                        <?php
                                                        if($dat->id_notif == '1'){
                                                            echo "Terdapat realisasi baru pada kegiatan";
                                                        } else if($dat->id_notif == '2'){
                                                            echo "Terdapat perubahan realisasi kegiatan";
                                                        } else if($dat->id_notif == '3'){
                                                            echo "Realisasi kegiatan disetujui oleh Provinsi";
                                                        } else if($dat->id_notif == '4'){
                                                            echo "Terdapat target kegiatan baru dari Provinsi";
                                                        } else if($dat->id_notif == '5'){
                                                            echo "Terdapat perubahan target kegiatan dari Provinsi";
                                                        } else if($dat->id_notif == '6'){
                                                            echo "Terdapat pengajuan perubahan target kegiatan dari Kabupaten/Kota";
                                                        } else if($dat->id_notif == '7'){
                                                            echo "Pengajuan perubahan target disetujui oleh Provinsi";
                                                        } else if($dat->id_notif == '8'){
                                                            echo "Pengajuan perubahan target ditolak oleh Provinsi";
                                                        }
                                                        ?>
                                                    </a>
                                                </b>
                                            </td>
                                            <?php
                                        }elseif ($dat->status == 2){
                                            ?>
                                            <td align="center" width=5% class="notif-th">
                                                <i class="bi bi-envelope-open"></i>
                                            </td>
                                            <td width=15% class="notif-th">
                                                <?php echo $dat->created_on?>
                                            </td>
                                            <td width=20% class="notif-th">
                                                <?php echo $dat->jenis_notif?>
                                            </td>
                                            <td width=65% class="notif-th">
                                                <a href="<?php echo base_url(); ?>index.php/admin/notifikasi/view/<?php echo $dat->id;?>">
                                                    <?php
                                                    if($dat->id_notif == '1'){
                                                        echo "Terdapat realisasi baru pada kegiatan";
                                                    } else if($dat->id_notif == '2'){
                                                        echo "Terdapat perubahan realisasi kegiatan";
                                                    } else if($dat->id_notif == '3'){
                                                        echo "Realisasi kegiatan disetujui oleh Provinsi";
                                                    } else if($dat->id_notif == '4'){
                                                        echo "Terdapat target kegiatan baru dari Provinsi";
                                                    } else if($dat->id_notif == '5'){
                                                        echo "Terdapat perubahan target kegiatan dari Provinsi";
                                                    } else if($dat->id_notif == '6'){
                                                        echo "Terdapat pengajuan perubahan target kegiatan dari Kabupaten/Kota";
                                                    } else if($dat->id_notif == '7'){
                                                        echo "Pengajuan perubahan target disetujui oleh Provinsi";
                                                    } else if($dat->id_notif == '8'){
                                                        echo "Pengajuan perubahan target ditolak oleh Provinsi";
                                                    }
                                                    ?>
                                                </a>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </div>
                <div class="notif-footer">
                    
                </div>
            </div>
        </div>
    </div>
</div>