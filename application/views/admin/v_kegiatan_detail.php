<?php
$uri4 = $this->uri->segment(4);
$this->load->model('M_kelolakegiatan');
$j_minggu = count($datprogress) / 5;
//date("W", strtotime($datview->batas_waktu))
?>

<div class="row col-md-12" style="margin-top:80px">
    <div class="panel panel-info" >
        <div class="panel-heading">
            <!-- <a href="javascript:history.back()" class="btn btn-sm"><i class="icon icon-arrow-left"></i></a> -->
            <h4>DETAIL KEGIATAN</h4>
        </div>

        <div class="panel-body">

            <div class="col-lg-12 alert alert-warning" style="margin-bottom: 20px">
                <div class="col-md-12">
                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <tr>
                            <td>Nama Sub Kegiatan</td>
                            <td>
                                <?php echo $datview->nmkegiatan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%">Satuan</td>
                            <td width="70%">
                                <?php echo $datview->nama_satuan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Ketua Tim</td>
                            <td width="70%">
                                <?php echo $this->M_kelolakegiatan->getPgwTerpilih($datview->ketua_tim); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Target</td>
                            <td>
                                <?php echo $datview->target; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Rentang Waktu</td>
                            <td>
                                <?php echo tgl_jam_sql($datview->mulai) . " - " . tgl_jam_sql($datview->batas_waktu); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <div class="btn-group ">
                                    <a href="<?php echo base_URL() ?>index.php/admin/kelolakegiatan/edt/<?php echo $datview->id_jeniskegiatan; ?>/1" class="btn btn-success btn-xs" title="Edit Data">
                                        <i class="icon-edit icon-white"> </i></a>
                                    <?php
                                    $id_delete = $datview->id_jeniskegiatan;
                                    ?>
                                    <a href="#" class="open_modal btn btn-danger btn-xs"
                                        id="<?php echo $id_delete; ?>"><i class="icon-trash icon-white"></i></a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>



            <!-- -----------Kodingan Baru (29/01/2024)--------- -->


            <?php
            foreach ($wilayah as $wil) {
                $targetKum[$wil->id_kab] = 0;
                $realKum[$wil->id_kab] = 0;
            }
            ;
            $friday = $this->db->query("select batas_minggu from t_kegiatan where id_kab='6501' and id_jeniskegiatan='$datview->id_jeniskegiatan' ORDER BY batas_minggu")->result();
            if (!empty($friday)) {
                for ($i = 1; $i <= count($friday); $i++) {
                    ?>
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <?php echo 'Minggu ' . $i . ' (' . tgl_jam_sql($friday[$i - 1]->batas_minggu) . ')' ?>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                         <th>No.</th>
                                        <th>Kabupaten/Kota</th>
                                        <th width="14%">Target</th>
                                        <th width="14%">Target Kumulatif</th>
                                        <th width="14%">Realisasi</th>
                                        <th>Realisasi Kumulatif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($wilayah as $key => $wil) {
                                        $data = $this->M_kelolakegiatan->getProgresWil($uri4, $wil->id_kab, $i);
                                        if (!empty($data)) {
                                            ?>
                                            <tr>
                                                <td align="center">
                                                    <?php echo $key + 1; ?>
                                                </td>
                                                <td>
                                                    <?php echo $wil->nama_kab; ?>
                                                </td>
                                                <td align="center">
                                                    <?php echo $data[0]->target; ?>
                                                </td>
                                                <td align="center">
                                                    <?php
                                                    $targetKum[$wil->id_kab] += $data[0]->target;
                                                    echo $targetKum[$wil->id_kab];
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <?php echo $data[0]->realisasi; ?>
                                                </td>
                                                <td align="center">
                                                    <?php
                                                    $realKum[$wil->id_kab] += $data[0]->realisasi;
                                                    echo $realKum[$wil->id_kab];
                                                    $persen = 0.00;
                                                    if ($targetKum[$wil->id_kab] == 0) {
                                                        if ($realKum[$wil->id_kab] == 0) {
                                                        } else {
                                                            $persen = 100.00;
                                                        }
                                                    } else {
                                                        $persen = round(($realKum[$wil->id_kab] / $targetKum[$wil->id_kab]) * 100.00, 2);
                                                        if ($persen > 100) {
                                                            $persen = 100.00;
                                                        }
                                                    }
                                                    if ($persen >= 0 && $persen < 50) {
                                                        ?>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-danger" role="progressbar"
                                                                aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100"
                                                                style="<?php echo 'width: ' . $persen . "%"; ?>">
                                                                <?php echo $persen . " %"; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } elseif ($persen >= 50 && $persen < 90) {
                                                        ?>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100"
                                                                style="<?php echo 'width: ' . $persen . "%"; ?>">
                                                                <?php echo $persen . " %"; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } else {

                                                        ?>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar"
                                                                aria-valuenow="<?php echo $persen; ?>" aria-valuemin="0" aria-valuemax="100"
                                                                style="<?php echo 'width: ' . $persen . "%"; ?>">
                                                                <?php echo $persen . " %"; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                }
            }
            ;
            ?>


            <a href="<?php echo base_URL() ?>index.php/admin/kegiatan/" tabindex="10" class="btn btn-danger"><i
                    class="icon icon-arrow-left icon-white"></i> Kembali</a>


            <!-- ---Kodingan Lama--- -->

            <!--  <table class="table table-bordered">
                <thead>
                    <?php
                    ?>
                    <tr>
                        <th width="4%" rowspan="2">No</th>
                        <th width="9%" rowspan="2">Kabupaten/ Kota</th>
                        <th width="17%" rowspan="2">Penanggung Jawab</th>
                        <?php
                        $friday = $this->db->query("select batas_minggu from t_kegiatan where id_kab='6501' and id_jeniskegiatan='$datview->id_jeniskegiatan' ORDER BY minggu_ke")->result();
                        if (!empty($friday)) {
                            for ($i = 1; $i <= count($friday); $i++) {
                                echo "<th width='10%' colspan='3'>Minggu " . $i . "<br>(" . $friday[$i - 1]->batas_minggu . ")</th>";
                            }
                        }
                        ;
                        ?>
                        <th width="10%" colspan="2">Total</th>
                        <th width="10%" rowspan="2">Persentase</th>
                        <th width="10%" rowspan="2">Tanggal Update</th>
                    </tr>
                    <tr>
                        <?php
                        for ($i = 1; $i <= $j_minggu; $i++) {
                            echo "<th width='4%'>T</th>";
                            echo "<th width='8%'colspan='2'>R</th>";
                        }
                        ;
                        echo "<th width='4%'>T</th>";
                        echo "<th width='4%'>R</th>";
                        ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    foreach ($wilayah as $wil) {
                        $data = $this->M_kelolakegiatan->getProgresWil($uri4, $wil->id_kab);
                        if (!empty($data)) {
                            ?>
                            <tr>
                                <td class="ctr">
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <?php echo $wil->nama_kab; ?>
                                </td>
                                <td>
                                    <?php //echo $this->M_kelolakegiatan->getPgwTerpilih($data[0]->pj_kab); ?>
                                </td>
                                <?php
                                $target = 0;
                                $realisasi = 0;
                                $update = $data[0]->tgl_entri;
                                foreach ($data as $d) {
                                    echo "<td class=\"ctr\">" . $d->target . "</td>";
                                    echo "<td class=\"ctr\" width='4%'>" . $d->realisasi . "</td>";
                                    if ($this->session->userdata('admin_level') == 'userprov' && $d->realisasi != 0 && $d->flag_konfirm == '2') {
                                        $id_konfirm = $d->id_jeniskegiatan . '' . $d->id_kab . '' . $d->minggu_ke;
                                        ?>
                                        <td width='4%' class="ctr">
                                            <div class="btn-group">
                                                <a href="#<?= $no; ?>" class="open_modal_konfirm btn btn-success btn-xs"
                                                    id="<?php echo $id_konfirm; ?>" title="Konfirmasi Data"><i
                                                        class="icon-check icon-white"> </i> </a>
                                            </div>
                                        </td>
                                        <?php
                                    } else {
                                        echo "<td></td>";
                                    }
                                    ;
                                    $target += $d->target;
                                    $realisasi += $d->realisasi;
                                    if ($d->realisasi <> 0) {
                                        $update = $d->tgl_entri;
                                    }
                                }
                                ;
                                ?>
                                <td class="ctr">
                                    <?php echo $target; ?>
                                </td>
                                <td class="ctr">
                                    <?php echo $realisasi; ?>
                                </td>
                                <!-- td class = "ctr"><?php //echo round($realisasi / $target * 100, 2); ?></td -->
                    <!-- Agustus 2023 -->
                    <td class="ctr">
                        <?php
                        if ($realisasi == 0) {
                            echo "0";
                        } else {
                            echo round($realisasi / $target * 100, 2);
                        }
                        ?>
                    </td>
                    <!-- end -->
                    <td class="ctr">
                        <?php echo $update; ?>
                    </td>
                    </tr>
                    <?php
                    $no++;
                        }
                    }
                    ?>
                </tbody>
            </table> -->

        </div>
    </div>
</div>
</div>


<!-- Modal Popup untuk Delete-->
<div id="ModalDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Javascript untuk popup modal Delete-->
<script type="text/javascript">
    $(document).ready(function () {
        $(".open_modal").click(function (e) {
            var m = $(this).attr("id");
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/admin/kelolakegiatan/del/",
                type: "GET",
                data: { delete_id: m, },
                success: function (ajaxData) {
                    $("#ModalDelete").html(ajaxData);
                    $("#ModalDelete").modal('show', { backdrop: 'true' });
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
        $(".open_modal_konfirm").click(function (e) {
            //       e.preventDefault();
            var m = $(this).attr("id");
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/admin/konfirmasi/edt/",
                type: "GET",
                data: { konfirmasi_id: m, },
                success: function (ajaxData) {
                    $("#ModalEdit").html(ajaxData);
                    $("#ModalEdit").modal('show', { backdrop: 'true' });
                }
            });
        });
        //        return;
    });
</script>