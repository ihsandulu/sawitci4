<?php echo $this->include("template/header_v"); ?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div class="card">
                <div class="card-body">


                    <div class="row">
                        <?php if (!isset($_GET['user_id']) && !isset($_POST['new']) && !isset($_POST['edit'])) {
                            $coltitle = "col-md-10";
                        } else {
                            $coltitle = "col-md-8";
                        } ?>
                        <div class="<?= $coltitle; ?>">
                            <h4 class="card-title"></h4>
                            <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                        </div>
                        <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
                            <?php if (isset($_GET["user_id"])) { ?>
                                <form action="<?= base_url("user"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>
                            <?php
                            if (
                                (
                                    isset(session()->get("position_administrator")[0][0])
                                    && (
                                        session()->get("position_administrator") == "1"
                                        || session()->get("position_administrator") == "2"
                                    )
                                ) ||
                                (
                                    isset(session()->get("halaman")['3']['act_create'])
                                    && session()->get("halaman")['3']['act_create'] == "1"
                                )
                            ) { ?>
                                <!-- <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="panen_id" />
                                </h1>
                            </form> -->
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if ($message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><?= $message; ?></strong>
                        </div>
                    <?php } ?>
                    <div class="alert alert-success">
                        <form>
                            <div class="row">
                                <?php
                                $thn = date("Y");
                                if (isset($_GET["thn"])) {
                                    $thn = $_GET["thn"];
                                }
                                ?>
                                <div class="col row">
                                    <div class="col-2">
                                        <label class="text-white">Tahun :</label>
                                    </div>
                                    <div class="col-10">
                                        <select class="form-control" name="thn">
                                            <?php
                                            for ($y = 2010; $y <= date("Y"); $y++) { ?>
                                                <option value="<?= $y; ?>" <?= ($thn == $y) ? "selected" : ""; ?>><?= $y; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if (isset($_GET["report"])) { ?>
                                    <input type="hidden" name="report" value="OK" />
                                <?php } ?>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="example2310" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <th>Estate</th>
                                    <th>Divisi</th>
                                    <th>Thn Tnm</th>
                                    <th>Hektar</th>
                                    <th>Pokok</th>
                                    <th>SPH</th>
                                    <?php
                                    $pastelColors = [
                                        "",
                                        "rgba(255, 182, 193, 0.5)", // Pastel Red
                                        "rgba(255, 160, 122, 0.5)", // Pastel Orange
                                        "rgba(255, 255, 224, 0.5)", // Pastel Yellow
                                        "rgba(144, 238, 144, 0.5)", // Pastel Green
                                        "rgba(173, 216, 230, 0.5)", // Pastel Blue
                                        "rgba(221, 160, 221, 0.5)", // Pastel Purple
                                        "rgba(255, 182, 193, 0.5)", // Pastel Pink
                                        "rgba(222, 184, 135, 0.5)", // Pastel Brown
                                        "rgba(211, 211, 211, 0.5)", // Pastel Gray
                                        "rgba(175, 238, 238, 0.5)", // Pastel Turquoise
                                        "rgba(230, 230, 250, 0.5)", // Pastel Lavender
                                        "rgba(152, 251, 152, 0.5)"  // Pastel Mint
                                    ];
                                    $pColors = [
                                        "",
                                        "black", // Pastel Red
                                        "black", // Pastel Orange
                                        "black", // Pastel Yellow
                                        "black", // Pastel Green
                                        "black", // Pastel Blue
                                        "black", // Pastel Purple
                                        "black", // Pastel Pink
                                        "black", // Pastel Brown
                                        "black", // Pastel Gray
                                        "black", // Pastel Turquoise
                                        "black", // Pastel Lavender
                                        "black" // Pastel Mint
                                    ];
                                    for ($x = 1; $x <= 12; $x++) { ?>
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>; color:<?= $pColors[$x]; ?>;">Jml JJG <?= date("F", strtotime($thn . "-" . $x)); ?></th>

                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">JJG KG Bruto <?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">Brondol Bruto <?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">Total Bruto <?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">BJR Bruto <?= date("F", strtotime($thn . "-" . $x)); ?></th>

                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">JJG KG Netto <?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">Brondol Netto <?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">Total Netto <?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>">BJR Netto <?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                    <?php } ?>

                                    <th>Total JJG</th>
                                    <th>Total JJG KG Bruto</th>
                                    <th>Total Brondol Bruto</th>
                                    <th>Total Bruto</th>
                                    <th>Total BJR Bruto</th>

                                    <th>Total JJG KG Netto</th>
                                    <th>Total Brondol Netto</th>
                                    <th>Total Netto</th>
                                    <th>Total BJR Netto</th>
                                    
                                    <th>JJG/PKK</th>
                                    <th>Bruto TON/HA</th>
                                    <th>Netto TON/HA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $panen = $this->db
                                    ->table("panen")
                                    ->select("
                                    SUBSTRING(panen.panen_date,1,7) as bln, 
                                    panen.estate_name, 
                                    panen.divisi_name, 
                                    panen.tph_thntanam, 
                                    blok.blok_ha, 
                                    blok.blok_populasi, 
                                    (blok.blok_populasi/blok.blok_ha) as sph, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_jml, 0)) as jjg1,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_bruto, 0)) as brutojjg1, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_bruto, 0)) as brutobrndl1, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_bruto, 0)) as tbruto1,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_netto, 0)) as nettojjg1, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_netto, 0)) as nettobrndl1, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_netto, 0)) as tnetto1, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_jml, 0)) as jjg2,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_bruto, 0)) as brutojjg2, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_bruto, 0)) as brutobrndl2, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_bruto, 0)) as tbruto2,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_netto, 0)) as nettojjg2, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_netto, 0)) as nettobrndl2, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_netto, 0)) as tnetto2, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_jml, 0)) as jjg3,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_bruto, 0)) as brutojjg3, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_bruto, 0)) as brutobrndl3, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_bruto, 0)) as tbruto3,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_netto, 0)) as nettojjg3, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_netto, 0)) as nettobrndl3, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_netto, 0)) as tnetto3, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_jml, 0)) as jjg4,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_bruto, 0)) as brutojjg4, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_bruto, 0)) as brutobrndl4, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_bruto, 0)) as tbruto4,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_netto, 0)) as nettojjg4, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_netto, 0)) as nettobrndl4, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_netto, 0)) as tnetto4, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_jml, 0)) as jjg5,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_bruto, 0)) as brutojjg5, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_bruto, 0)) as brutobrndl5, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_bruto, 0)) as tbruto5,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_netto, 0)) as nettojjg5, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_netto, 0)) as nettobrndl5, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_netto, 0)) as tnetto5, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_jml, 0)) as jjg6,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_bruto, 0)) as brutojjg6, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_bruto, 0)) as brutobrndl6, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_bruto, 0)) as tbruto6,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_netto, 0)) as nettojjg6, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_netto, 0)) as nettobrndl6, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_netto, 0)) as tnetto6, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_jml, 0)) as jjg7,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_bruto, 0)) as brutojjg7, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_bruto, 0)) as brutobrndl7, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_bruto, 0)) as tbruto7,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_netto, 0)) as nettojjg7, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_netto, 0)) as nettobrndl7, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_netto, 0)) as tnetto7, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_jml, 0)) as jjg8,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_bruto, 0)) as brutojjg8, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_bruto, 0)) as brutobrndl8, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_bruto, 0)) as tbruto8,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_netto, 0)) as nettojjg8, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_netto, 0)) as nettobrndl8, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_netto, 0)) as tnetto8, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_jml, 0)) as jjg9,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_bruto, 0)) as brutojjg9, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_bruto, 0)) as brutobrndl9, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_bruto, 0)) as tbruto9,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_netto, 0)) as nettojjg9, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_netto, 0)) as nettobrndl9, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_netto, 0)) as tnetto9, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_jml, 0)) as jjg10,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_bruto, 0)) as brutojjg10, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_bruto, 0)) as brutobrndl10, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_bruto, 0)) as tbruto10,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_netto, 0)) as nettojjg10, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_netto, 0)) as nettobrndl10, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_netto, 0)) as tnetto10, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_jml, 0)) as jjg11,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_bruto, 0)) as brutojjg11, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_bruto, 0)) as brutobrndl11, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_bruto, 0)) as tbruto11,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_netto, 0)) as nettojjg11, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_netto, 0)) as nettobrndl11, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_netto, 0)) as tnetto11, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_jml, 0)) as jjg12,  
                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_bruto, 0)) as brutojjg12, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_bruto, 0)) as brutobrndl12, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_bruto, 0)) as tbruto12,

                                    SUM(IF(panen.panen_brondol=0 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_netto, 0)) as nettojjg12, 
                                    SUM(IF(panen.panen_brondol=1 AND SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_netto, 0)) as nettobrndl12, 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_netto, 0)) as tnetto12,

                                    ")
                                    ->join("blok", "blok.blok_id=panen.blok_id", "left")
                                    ->where("SUBSTRING(panen_date,1,4)", $thn)
                                    ->groupBy("panen.divisi_id, panen.tph_thntanam")
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                $arpan = array();
                                foreach ($panen->getResult() as $panen) {
                                    // $arpan[][]

                                ?>
                                    <tr>
                                        <th><?= $panen->estate_name; ?></th>
                                        <th><?= $panen->divisi_name; ?></th>
                                        <th><?= $panen->tph_thntanam; ?></th>
                                        <th><?= $panen->blok_ha; ?></th>
                                        <th><?= $panen->blok_populasi; ?></th>
                                        <th><?= number_format($panen->sph,0,",","."); ?></th>
                                        <?php

                                        $totjjg = 0;
                                        $totbrutojjg = 0;
                                        $totbrutobrndl = 0;
                                        $tottbruto = 0;
                                        $tobjrbruto = 0;
                                        $totnettojjg = 0;
                                        $totnettobrndl = 0;
                                        $tottnetto = 0;
                                        $tobjrnetto = 0;
                                        for ($x = 1; $x <= 12; $x++) {
                                            $jjg = "jjg" . $x;
                                            $tjjg = 0;
                                            if (isset($panen->$jjg)) {
                                                $tjjg = $panen->$jjg;
                                                $totjjg +=$tjjg;
                                            }

                                            $brutojjg = "brutojjg" . $x;
                                            $tbrutojjg = 0;
                                            if (isset($panen->$brutojjg)) {
                                                $tbrutojjg = $panen->$brutojjg;
                                                $totbrutojjg +=$tbrutojjg;
                                            }

                                            $brutobrndl = "brutobrndl" . $x;
                                            $tbrutobrndl = 0;
                                            if (isset($panen->$brutobrndl)) {
                                                $tbrutobrndl = $panen->$brutobrndl;
                                                $totbrutobrndl +=$tbrutobrndl;
                                            }

                                            $tbruto = "tbruto" . $x;
                                            $ttbruto = 0;
                                            if (isset($panen->$tbruto)) {
                                                $ttbruto = $panen->$tbruto;
                                                $tottbruto +=$ttbruto;
                                            }

                                            $bjrbruto = 0;
                                            if ($tjjg > 0) {
                                                $bjrbruto = $ttbruto / $tjjg;
                                                $tobjrbruto +=$bjrbruto;
                                            }

                                            $nettojjg = "nettojjg" . $x;
                                            $tnettojjg = 0;
                                            if (isset($panen->$nettojjg)) {
                                                $tnettojjg = $panen->$nettojjg;
                                                $totnettojjg +=$tnettojjg;
                                            }

                                            $nettobrndl = "nettobrndl" . $x;
                                            $tnettobrndl = 0;
                                            if (isset($panen->$nettobrndl)) {
                                                $tnettobrndl = $panen->$nettobrndl;
                                                $totnettobrndl +=$tnettobrndl;
                                            }

                                            $tnetto = "tnetto" . $x;
                                            $ttnetto = 0;
                                            if (isset($panen->$tnetto)) {
                                                $ttnetto = $panen->$tnetto;
                                                $tottnetto +=$ttnetto;
                                            }

                                            $bjrnetto = 0;
                                            if ($tjjg > 0) {
                                                $bjrnetto = $ttnetto / $tjjg;
                                                $tobjrnetto +=$bjrnetto;
                                            }

                                            $jjgpkk = 0;
                                            if ($panen->blok_populasi > 0) {
                                                $jjgpkk = $totjjg/$panen->blok_populasi;
                                            }                                            
                                            $brutotonha = 0;
                                            if ($panen->blok_ha > 0) {
                                                $brutotonha = $tottbruto/$panen->blok_ha;
                                            }
                                            $nettotonha = 0;
                                            if ($panen->blok_ha > 0) {
                                                $nettotonha = $tottnetto/$panen->blok_ha;
                                            }
                                        ?>
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($tjjg, 0, ",", "."); ?></th>

                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($tbrutojjg, 0, ",", "."); ?></th>
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($tbrutobrndl, 0, ",", "."); ?></th>
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($ttbruto, 0, ",", "."); ?></th>
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($bjrbruto, 2, ",", "."); ?></th>

                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($tnettojjg, 0, ",", "."); ?></th>
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($tnettobrndl, 0, ",", "."); ?></th>
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($ttnetto, 0, ",", "."); ?></th>
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($bjrnetto, 2, ",", "."); ?></th>
                                        <?php } ?>
                                       
                                        <th><?= number_format($totjjg, 0, ",", "."); ?></th>
                                        <th><?= number_format($totbrutojjg, 0, ",", "."); ?></th>
                                        <th><?= number_format($totbrutobrndl, 0, ",", "."); ?></th>
                                        <th><?= number_format($tottbruto, 0, ",", "."); ?></th>
                                        <th><?= number_format($tobjrbruto, 2, ",", "."); ?></th>

                                        <th><?= number_format($totnettojjg, 0, ",", "."); ?></th>
                                        <th><?= number_format($totnettobrndl, 0, ",", "."); ?></th>
                                        <th><?= number_format($tottnetto, 0, ",", "."); ?></th>
                                        <th><?= number_format($tobjrnetto, 2, ",", "."); ?></th>
                                        
                                        <th><?= number_format($jjgpkk, 2, ",", "."); ?></th>
                                        <th><?= number_format($brutotonha, 2, ",", "."); ?></th>
                                        <th><?= number_format($nettotonha, 2, ",", "."); ?></th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "CROPS Statement";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo $this->include("template/footer_v"); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example2310').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copyHtml5',
                    title: 'CROPS Statement',
                    filename: 'CROPS Statement ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'CROPS Statement',
                    filename: 'CROPS Statement ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'CROPS Statement Excel',
                    filename: 'CROPS Statement ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'CROPS Statement',
                    filename: 'CROPS Statement ',
                    text: 'Export to PDF',
                    customize: function(doc) {
                        doc.content[1].table.headerRows = 1;
                        doc.content[1].table.body[0].forEach(function(h) {
                            h.text = h.text.toUpperCase();
                            h.fillColor = '#dddddd';
                        });
                    }
                },
                {
                    extend: 'print',
                    title: 'Judul Custom',
                    text: 'Print'
                }
            ]
        });
    });
</script>