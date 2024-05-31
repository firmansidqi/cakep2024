<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <head>
        <title>.:: CAKEP (Capaian Kegiatan Pegawai) by BPS Provinsi Kalimantan Utara ::.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style type="text/css">
            @font-face {
                font-family: 'Cabin';
                font-style: normal;
                font-weight: 400;
                src: local('Cabin Regular'), local('Cabin-Regular'), url(<?php echo base_url(); ?>aset/font/satu.woff) format('woff');
            }
            @font-face {
                font-family: 'Cabin';
                font-style: normal;
                font-weight: 700;
                src: local('Cabin Bold'), local('Cabin-Bold'), url(<?php echo base_url(); ?>aset/font/dua.woff) format('woff');
            }
            @font-face {
                font-family: 'Lobster';
                font-style: normal;
                font-weight: 400;
                src: local('Lobster'), url(<?php echo base_url(); ?>aset/font/tiga.woff) format('woff');
            }

            .marquee-container {
    width: 100%; /* Sesuaikan lebar sesuai kebutuhan */
    overflow: hidden; /* Teks di dalam div tidak akan keluar dari div */
}

.marquee {
    white-space: nowrap;
    overflow: hidden;
    padding: 0 100%; /* Padding di sekitar teks */
    animation: marquee 15s linear infinite; /* Durasi animasi */
    font-size: 16px; /* Ukuran font */
    animation-delay: -15s; /* Mengatur delay menjadi negatif */
}

@keyframes marquee {
    0%   { transform: translateX(100%); } /* Mulai dari sisi kanan */
    100% { transform: translateX(-100%); } /* Bergerak sampai sisi kiri */
}




            /*@keyframes marquee {
                0% { transform: translateX(100%); }
                100% { transform: translateX(-100%); }
            }

            .marquee-container {
                overflow: hidden;
                white-space: nowrap;
                box-sizing: border-box;
                width: 100%;
                padding: 10px 0; /* Tambahkan padding atas dan bawah */
                /*position: relative;*/
            /*}*/

            /*.marquee {
                display: inline-block;
                animation: marquee 40s linear infinite;
                font-size: 1em;
                color: #333;
            }
            .marquee:nth-child(2) {
                animation-delay: 0s; /* Adjust to half of the animation duration */
            /*}*/
        }

        </style>

        <link rel="stylesheet" href="<?php echo base_url(); ?>aset/css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.css" />
        <link href="<?php echo base_url(); ?>aset/css/datatables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>aset/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="<?php echo base_url('aset/img/bps.ico');?>" type="image/ico">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <script src="<?php echo base_url(); ?>aset/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>aset/js/jquery.sortElements.js"></script>
        <script src="<?php echo base_url(); ?>aset/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>aset/js/bootswatch.js"></script>
        <script src="<?php echo base_url(); ?>aset/js/jquery/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>aset/js/datatables.min.js"></script>
        <script src="<?php echo base_url(); ?>aset/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>aset/js/app.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(function() {
                    $( "#mulai" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });

                $(function() {
                    $( "#batas_waktu" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });

                $(function() {
                    $( "#tgl_entri" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd'
                    });
                });
            });

            window.onscroll = function() {scrollFunction()};

            function scrollFunction() {
                var pathArray = window.location.pathname.split( '/' );
                if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                    const element = document.getElementById("navbar");
                    element.classList.add("navbar-scrolled");  // Add newone class
                } else if (pathArray.length <= 3) {
                    const element = document.getElementById("navbar");
                    element.classList.remove("navbar-scrolled"); 
                };
            };
        </script>


        <header>
        <?php
            $segmen = $this->uri->segment(2);
            if($segmen == ''){
            ?>
                <div id="navbar" class="navbar navbar-inverse navbar-fixed-top navbar">
            <?php
            }else{
            ?>
                <div id="navbar" class="navbar navbar-inverse navbar-fixed-top navbar navbar-scrolled">
            <?php
            }
            ?>
                <div class="container">
                    <div class="navbar-header">
                        <img src="<?php echo base_url(); ?>upload/logo2.jpg" class="thumbnail span3" style="display: inline; float: left; margin-right: 10px; width:60px; height: 50px">
                        <span class="navbar-brand"><strong style="font-family: verdana; vertical-align: baseline;">BPS KALTARA</strong></span>
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar-main">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo base_url(); ?>index.php/admin"><i class="icon-home icon-white"> </i> Beranda</a></li>
                            <?php
                            if ($this->session->userdata('admin_level') == "Super Admin" || $this->session->userdata('admin_level') == "userprov" || $this->session->userdata('admin_level') == "pemantau") 
                            {
                            ?>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/kegiatan/"><i class="icon-th icon-white"> </i> Kegiatan </a></li>
                            <?php 
                            } elseif ($this->session->userdata('admin_level') == "Super Admin" || $this->session->userdata('admin_level') == "userkabkota"){
                            ?>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/alokasikegiatan/"><i class="icon-th icon-white"> </i> Alokasi Kegiatan </a></li>
                            <?php
                            } 
                            if ($this->session->userdata('admin_level') == "userkabkota") 
                            {
                            ?>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/unitkerjakabkotadetail/"><i class="icon-film icon-white"> </i> Progress </a></li>
                            <?php
                            } else
                            {
                            ?>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/unitkerjaprov/"><i class="icon-film icon-white"> </i> Progress </a></li>  
                            <?php
                            }
                            ?>
                            <!--li><a href="<?php echo base_url(); ?>index.php/admin/laporan_kab/"><i class="icon-file icon-white"> </i> Laporan </a></li-->
                            <?php
                            if ($this->session->userdata('admin_level') == "Super Admin") 
                            {
                            ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-th-list icon-white"> </i> Master <span class="caret"></span></a>
                                    <ul class="dropdown-menu" aria-labelledby="themes">
                                        <li><a href="<?php echo base_url(); ?>index.php/admin/master_kegiatan/">Kegiatan</a></li>
                                        <li><a href="<?php echo base_url(); ?>index.php/admin/listkegiatan/">List Kegiatan</a></li>
                                        <li><a href="<?php echo base_url(); ?>index.php/admin/satuan/">Satuan</a></li>
                                        <!--li><a href="<?php echo base_url(); ?>index.php/admin/duplikasikegiatan/">Duplikasi Kegiatan</a></li-->
                                    </ul>
                                </li>
                                <!--<li><a href="<?php echo base_url(); ?>index.php/admin/konfirmasi"><i class="icon-retweet icon-white"> </i> Konfirmasi Realisasi Kegiatan</a></li>-->
                            <?php 
                            }
                            if ($this->session->userdata('admin_user') == "admin" || $this->session->userdata('admin_user') == "6500" ) 
                            {
                            ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="icon-wrench icon-white"> </i> Pengaturan<span class="caret"></span></a>
                                    <ul class="dropdown-menu" aria-labelledby="themes">
                                        <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/admin/pengguna">Instansi Pengguna</a></li>
                                        <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/admin/manage_admin">Manajemen Admin</a></li>
                                    </ul>
                                </li>
                            <?php
                            }
                            ?>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">
                                    <i class="icon-user icon-white"></i>
                                    <?php 
                                    echo $this->session->userdata('admin_nama');
                                    $nip    = $this->session->userdata('admin_nip');
                                    $notif  = $this->db->query("SELECT COUNT(id) as sum FROM t_notifikasi WHERE tujuan = '$nip' AND status = '1'")->row();
                                    if ($notif->sum != 0){
                                        echo "<span class='notif-icon'>".$notif->sum."</span>";
                                    }
                                    ?>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="themes">
                                    <li><a tabindex="-1" href="https://bpskaltara.id">Kembali ke SiApik</a></li>
                                    <!--li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/admin/set_tahun/2021">Tahun 2021</a></li-->
                                    <li>
                                        <a tabindex="-1" href="#" class="open_modal_notif">
                                            Notifikasi
                                            <?php
                                            if ($notif->sum != 0){
                                                echo "<span class='notif-badge'>".$notif->sum."</span>";
                                            }?>
                                        </a>
                                    </li>
                                    <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/admin/passwod">Ubah Password</a></li>
                                    <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/admin/logout">Logout Cakep</a></li>
                                    <?php 
                                    if($this->session->userdata('logout_url')) { 
                                    ?>
                                        <li><a tabindex="-1" href="<?php echo $this->session->userdata('logout_url'); ?>">Logout SSO</a></li>
                                    <?php 
                                    }?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php 
                $q_instansi = $this->db->query("SELECT * FROM tr_instansi LIMIT 1")->row();
                //echo $this->session->userdata('admin_level');
                ?>
            </div>
        </header>
    </head>

    <body>
        <?php
        $segmen = $this->uri->segment(2);
        if($segmen == ''){
        ?>
            <div class="row">
                <?php $this->load->view('admin/'.$page); ?>
            </div>
        <?php
        }else{
        ?>
            <div class="container">
                <div class="row">
                    <?php $this->load->view('admin/'.$page); ?>
                </div>
            </div>
        <?php
        }?>
    </body>

    <br>
    <footer class="main-footer" >
        <div class="span12 well well-sm" style=" bottom: 0px; text-align:center; width: 100%; position: fixed; margin-bottom: 0px;">
            <h5 style="font-weight: bold; align:center; ">CAKEP (Capaian Kegiatan Pegawai) @ BPS Provinsi Kalimantan Utara</h5>
            <!--<h6>&copy;  2017. Waktu Eksekusi : {elapsed_time}, Penggunaan Memori : {memory_usage}</h6>-->
        </div>
    </footer>

    <!-- Modal Popup Alokasi Ketua Tim--> 
    <div id="ModalKetua" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

    <!-- Javascript untuk popup modal Alokasi Ketua Tim-->
    <script type="text/javascript">
        $(document).ready(function () {
            $(".open_modal_notif").click(function(e) {
                var m = $(this).attr("id");
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/admin/notifikasi/",
                    type: "GET",
                    success: function (ajaxData){
                        $("#ModalKetua").html(ajaxData);
                        $("#ModalKetua").modal('show',{backdrop: 'true'});
                    }
                });
            });
        });
    </script>
</html>