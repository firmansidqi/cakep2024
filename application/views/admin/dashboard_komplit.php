<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    
    <style type="text/css">
        html {
            scroll-behavior: smooth;
        }
        
        @keyframes progress-enter {
            0%{
                width: 1px;
                transform-origin: left;
            }
        }
        
        
        
        .dash-progres.bar {
            animation: progress-enter 2s 1;
        }
        
        .dash-progres-icon{
            animation: move-icon 2s 1;
        }
        
        .capaian{
            position: relative;
            display: flex;
        }
        
        .capaian-box{
            width: 20%;
            height: 150px;
            text-align: center;
            margin: 15px 5px;
        }
        
        .with-nav-tabs.panel-primary .nav-tabs > li > a,
        .with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
        .with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
            color: #fff;
        }
        
        .with-nav-tabs.panel-primary .nav-tabs > .open > a,
        .with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
        .with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
        .with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
        .with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
            color: #fff;
            background-color: #003366;
            border-color: transparent;
        }
        
        .with-nav-tabs.panel-primary .nav-tabs > li.active > a,
        .with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
        .with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
            color: #003366;
            background-color: #fff;
            border-color: #003366;
            border-bottom-color: transparent;
        }
        
        .reveal{
            position: relative;
            transform: translateY(150px);
            opacity: 0;
            transition: 2s all ease;
        }
        
        .reveal.active{
            transform: translateY(0);
            opacity: 1;
        }

        
        


    </style>
    
    <?php
    $hariini=date("d-m-Y");
    $bulanini = substr($hariini,3,2);
    $tahunini =  $this->session->userdata('admin_ta');
    
    //isian tabel baru
    $query_nilai_volume=$this->db->query("SELECT *,round((sum(realisasi)/sum(target)*100),2) as persen FROM m_jeniskegiatan WHERE substring(batas_waktu,6,2) = '$bulanini' LIMIT 1")->row();
    
    //nilai volume dan nilai waktu
    $nilai_volume=$query_nilai_volume->persen;
    
    if($bulanini == '01')
    {
        $bulannama='Januari';
    }
    else if($bulanini == '02')
    {
        $bulannama='Februari';
    }
    else if($bulanini == '03')
    {
        $bulannama='Maret';
    }
    else if($bulanini == '04')
    {
        $bulannama='April';
    }
    else if($bulanini == '05')
    {
        $bulannama='Mei';
    }
    else if($bulanini == '06')
    {
        $bulannama='Juni';
    }
    else if($bulanini == '07')
    {
        $bulannama='Juli';
    }
    else if($bulanini == '08')
    {
        $bulannama='Agustus';
    }
    else if($bulanini == '09')
    {
        $bulannama='September';
    }
    else if($bulanini == '10')
    {
        $bulannama='Oktober';
    }
    else if($bulanini == '11')
    {
        $bulannama='November';
    }
    else if($bulanini == '12')
    {
        $bulannama='Desember';
    }
    ?>
    
    <script type="text/javascript">
        /*const startAnimation = (entries, observer) => {
            entries.forEach(entry => {
                entry.target.classList.toggle("bar", entry.isIntersecting);
            });
        };
        
        const observer = new IntersectionObserver(startAnimation);
        const options = { root: null, rootMargin: '0px', threshold: 1 }; 
        
        const elements = document.querySelectorAll('.dash-progres');
        elements.forEach(el => {
            observer.observe(el, options);
        });*/
        
        function ShowHideCapaian() {
            var bulanini    = document.getElementById("spiderbulanini");
            var sampaibulanini = document.getElementById("spiderkumulatifbulan");
            var sel_value   = document.getElementById("sel_jeniscapaian");
            if(sel_value.value == 1)
            {
                bulanini.style.display='block';
                sampaibulanini.style.display = 'none';
            }
            else
            {
                bulanini.style.display='none';
                sampaibulanini.style.display = 'block';
            }
        }
    </script>
    
    
    <body>
        <?php
        $wilayah    = $this->db->query("select * from m_kab where id_kab <> '6500'")->result();
        ?>
        <div class="landing">
            <div class="container">
                <div class="landing-box">
                    <div style="position:relative; left:-10px; top: 40px">
                        <h1><b style="font-family: 'Poppins'; font-size: 57px; font-weight:600; line-height: 85px;">SELAMAT DATANG</b><br>
                        <b style="font-family: 'Poppins'; font-size: 80px; font-weight:800; line-height: 100px; color:#D2973B">CAPAIAN KEGIATAN<br>PEGAWAI</b><br>
                        <a href="#dashboard1" style="font-family: 'Poppins'; font-size: 40px; font-weight:600; line-height: 85px;"><button class="landing-btn">Get Started!</button></a>
                        </h1>
                    </div>
                    <div><img src="<?php echo base_url(); ?>aset/img/icon.png" style="height: 610px; alight:right; position:relative; right:-30px" class="landing-icon"></div>
                </div>
            </div>
        </div>
        <div class="container reveal active"  id="dashboard1">
            <div class="row">
                <div class="dashboard">
                    <div class="dashboard-box col-lg-11" style="width:83%; ">
                        <a class="title">Progres Kegiatan Kabupaten/Kota <?php echo $bulannama.' '.date('Y'); ?></a><br>
                        <table class="dashgrap">
                            <?php
                            foreach ($wilayah as $kab){
                            ?>
                                <tr style="height:50pt">
                                <?php
                                $idkab      = $kab->id_kab;
                                $nminggu    = getMinggu($bulanini)[0];
                                $batasawal  = getMinggu($bulanini)[1][0];
                                $batasakhir = getMinggu($bulanini)[1][($nminggu-1)];
                                $data       = $this->db->query("SELECT t.* FROM t_kegiatan t WHERE t.id_kab =$idkab AND t.batas_minggu>='$batasawal' AND t.batas_minggu<='$batasakhir' ORDER BY t.batas_minggu ASC")->result();
                                $targetkum  = 0;
                                $realkum    = 0;
                                $persen     = 0.00;
                                foreach($data as $dat){
                                    $targetkum  = $targetkum + $dat->target;
                                    $realkum    = $realkum + $dat->realisasi;
                                }
                                if($targetkum == 0){
                                    if($realkum == 0){
                                    }else{
                                        $persen = 100.00;
                                    }
                                }else{
                                    $persen = round($realkum/$targetkum*100.00,2);
                                }
                                ?>
                                <td style='text-align:right; width:13%'><?php echo $kab->nama_kab;?> </td>
                                
                                <?php
                                if($persen >= 0 && $persen < 50){
                                ?>
                                    <td colspan=4 style='padding:7px 10px 0px 10px;'>
                                        <div class='dash-progres' style="<?php echo 'width: '.$persen.'%'; ?>; background:#dd4814; max-width:100%; ">
                                            <?php echo $persen.'%'; ?>
                                        </div>
                                        <div class='dash-progres-icon' style="<?php echo 'margin-left: '.($persen-1).'%'; ?>">
                                        </div>
                                    </td><?php
                                }elseif($persen >= 50 && $persen < 90){
                                ?>
                                    <td colspan=4 style='padding:7px 10px 0px 10px;'>
                                        <div class='dash-progres' style="<?php echo 'width: '.$persen.'%'; ?>; background:#efb73e; max-width:100%; ">
                                            <?php echo $persen.'%'; ?>
                                        </div>
                                        <div class='dash-progres-icon' style="<?php echo 'margin-left: '.($persen-1).'%'; ?>">
                                        </div>
                                    </td><?php
                                }else{
                                ?>
                                    <td colspan=4 style='padding:7px 10px 0px 10px;'>
                                        <div class='dash-progres' style="<?php echo 'width: '.$persen.'%'; ?>; background:#468847; max-width:100%; ">
                                            <?php echo $persen.'%'; ?>
                                        </div>
                                        <?php
                                        $position       = $persen-1;
                                        if($persen > 99){
                                            $position   = 99;
                                        }
                                        ?>
                                        <div class='dash-progres-icon' style="<?php echo 'margin-left: '.($position-1).'%'; ?>">
                                        </div>
                                    </td><?php
                                }
                                echo "</tr>";
                            }
                            ?>
                            
                            <tr style="text-align: right;">
                                <td style="width:12%;"><span style="display: flex; flex-direction: row-reverse; margin: -5px -18px 0px 0px;">0</span></td>
                                <td style="width:22%;"><span style="display: flex; flex-direction: row-reverse; margin: -5px -10px 0px 0px;">25</span></td>
                                <td style="width:22%;"><span style="display: flex; flex-direction: row-reverse; margin: -5px -10px 0px 0px;">50</span></td>
                                <td style="width:22%;"><span style="display: flex; flex-direction: row-reverse; margin: -5px -10px 0px 0px;">75</span></td>
                                <td style="width:22%;"><span style="display: flex; flex-direction: row-reverse; margin: -5px 2px 0px 0px;">100</span></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="dashboard-box col-lg-1" style="width:15%; height: 450px">
                        <a class="title">Nilai</a><br>
                        <table class="dashgrap">
                            <?php
                            foreach ($wilayah as $kab){
                                $idkab      = $kab->id_kab;
                                $data       = $this->db->query("SELECT t.* FROM t_kegiatan t WHERE t.id_kab =$idkab AND t.batas_minggu>='$batasawal' AND t.batas_minggu<='$batasakhir' ORDER BY t.batas_minggu ASC")->result();
                                $nilaikum   = 0;
                                foreach($data as $dat){
                                    $nilaikum  = $nilaikum + $dat->nilai_total;
                                }
                                if($nilaikum == 0){
                                    $nilaiakhir = 0.00;
                                }else{
                                    $nilaiakhir = round($nilaikum/count($data),2);
                                }
                                ?>
                                <tr style="height:50pt">
                                    <td style="font-size: 20pt; text-align: center;"><b><?php echo $nilaiakhir; ?></b></td>
                                </tr>
                            <?php
                            } 
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            
            <?php
            if ($this->session->userdata('admin_level') == "Super Admin" || $this->session->userdata('admin_level') == "userprov" || $this->session->userdata('admin_level') == "pemantau"){
            ?>
                <div class="row">
                    <div class="dashboard">
                        <div class="dashboard-box" style="width:100%; ">
                            <a class="title">Capaian Kinerja Kabupaten/Kota <?php echo $bulannama.' '.date('Y'); ?></a><br>
                            <div class="capaian">
                                <?php
                                foreach ($wilayah as $kab){
                                    $idkab      = $kab->id_kab;
                                    $data       = $this->db->query("SELECT t.* FROM t_kegiatan t WHERE t.id_kab =$idkab AND t.batas_minggu>='$batasawal' AND t.batas_minggu<='$batasakhir' ORDER BY t.batas_minggu ASC")->result();
                                    $nilaikum   = 0;
                                    foreach($data as $dat){
                                        $nilaikum  = $nilaikum + $dat->nilai_total;
                                    }
                                    $nilaiakhir = floor($nilaikum/count($data));
                                    if ($nilaiakhir <= 98){
                                        $nilaiakhir = 98;
                                    }
                                    ?>
                                    <div class="capaian-box col-lg-2 col-md-6 col-sm-12">
                                        <h4><?php echo $kab->nama_kab?></h4>
                                        <b><h1 style="font-size:50pt"><?php echo $nilaiakhir; ?></h1></b>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            
            <div class="container">
                <div class="row" style="height:100px">
                    <p id="demo"></p>
                </div>
            </div>
        </div>
        
        
    </body>
    
    
    <script type="text/javascript">
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            var progres = document.querySelectorAll(".dash-progres");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    for (var i = 0; i < progres.length; i++){
                        progres[i].classList.add("bar");
                    }
                } else {
                    for (var i = 0; i < progres.length; i++){
                        progres[i].classList.remove("bar");
                    }
                }
            }
        };
        
        window.addEventListener("scroll", reveal);
        
        //To check the scroll position on page load
        reveal();
        
    </script>
</html>