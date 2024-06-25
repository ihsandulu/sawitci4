<?php echo $this->include("template/header_v"); ?>
<style>
.nl1{font-size:15px!important; padding:20px !important; border:rgba(0,0,0,0.2) solid 1px !important;}
.tab-pane{border:rgba(0,0,0,0.2) solid 1px !important; padding:20px !important; margin:0px!important;}
.text-bold{font-weight:bold;}
.t-10{font-size:12px;}
</style>
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
                    </div>
                    <!-- <div class="">                            
                        <div class="lead">
                            <h3>Letakkan Kartu pada Card Reader!</h3>
                        </div>
                        <form class="form-horizontal" method="post" enctype="multipart/form-data"> 
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sptbs_tmasuk">Data Kartu</label>
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control" id="datakartu" name="datakartu" >
                                </div>
                            </div>  

                            <input type="hidden" name="sptbs_id" value="<?= $sptbs_id; ?>" />
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" id="submit" class="btn btn-primary col-md-12" name="submit" value="OK">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div> -->
                    <div class="container mb-5">
                        <h2>Mesin Timbangan</h2>
                        <ul class="nav nav-tabs">
                            <?php $timbangan = $this->db->table("timbangan")->get();
                            foreach($timbangan->getResult() as $timbangan){?>

                            <li class="nav-item"><a onclick="muncultimbangan('<?=$timbangan->timbangan_name;?>')" class="nav-link nl1" data-toggle="tab" href="#t<?=$timbangan->timbangan_id;?>"><?=$timbangan->timbangan_name;?></a></li>
                            
                            <?php }?>
                        </ul>
                        <script>
                            function ambildatatimbangan(timbangan_name){
                                $.get("<?=base_url("api/printtimbangan");?>",{timbangan_name:timbangan_name})
                                .done(function(data){
                                    $("#isitabtimbangan").html(data);
                                });
                            }
                            var intervalID = null;
                            function muncultimbangan(timbangan_name){
                                ambildatatimbangan(timbangan_name);
                                
                                clearInterval(intervalID);
                                intervalID = setInterval(() => {
                                    ambildatatimbangan(timbangan_name);
                                }, 3000); 
                            }
                            
                        </script>
                        <div id="isitabtimbangan"></div>
                        <!-- <div class="tab-content p-0 mt-2">
                            <?php $timbangan = $this->db->table("timbangan")->get();
                            foreach($timbangan->getResult() as $timbangan){?>
                            <div id="t<?=$timbangan->timbangan_id;?>" class="tab-pane fade in">
                                
                                <?php 
                                $currentDateTime = date("Y-m-d H:i:s");
                                $fiveMinutesAgo = date("Y-m-d H:i:s", strtotime("-5 minutes", strtotime($currentDateTime)));
                                
                                $sptbs = $this->db->table("sptbs")
                                ->where("timbangan_name",$timbangan->timbangan_name)
                                ->where("sptbs_date",date("Y-m-d"))
                                ->where("sptbs_created >=", $fiveMinutesAgo)
                                ->where("sptbs_created <=", $currentDateTime)
                                ->orderBy("sptbs_id","DESC")
                                ->limit(1)
                                ->get();
                                // echo $this->db->getLastquery();
                                foreach($sptbs->getResult() as $sptbs){?>
                                    <div class="row">                                     
                                        <div class="col-12">
                                            <h3><?=$this->session->get("identity_company");?></h3>
                                        </div>
                                        <div class="col-6 row">   
                                            <div class="col-12">
                                                CPO Mill Office
                                            </div>
                                            <div class="col-12">
                                                <?=$this->session->get("identity_address");?>
                                            </div>
                                            <div class="col-5">
                                                NO POLISI
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_plat;?>
                                            </div>
                                            <div class="col-5">
                                                SUPIR
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_drivername;?>
                                            </div>
                                        </div>
                                        <div class="col-1"></div> 
                                        <div class="col-5 row">
                                            <div class="col-5">
                                                NO TICKET
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_id;?>
                                            </div>
                                            <div class="col-5">
                                                SPTBS Date
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_date;?>
                                            </div>
                                            <div class="col-5">
                                                Created Date
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_created;?>
                                            </div>
                                            <div class="col-5">
                                                Timbangan
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->timbangan_name;?>
                                            </div>
                                            <div class="col-5">
                                                Masuk
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_timbanganmasuk;?>
                                            </div>
                                            <div class="col-5">
                                                Keluar
                                            </div>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_timbangankeluar;?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">                                     
                                        <div class="col-12 row">
                                            <div class="col border text-center">
                                                Divisi
                                            </div>
                                            <div class="col border text-center">
                                                Blok
                                            </div>
                                            <div class="col border text-center">
                                                Thn Tanam
                                            </div>
                                            <div class="col border text-center">
                                                Sertifikasi
                                            </div>
                                            <div class="col border text-center">
                                                Status Kebun
                                            </div>
                                            <div class="col border text-center">
                                                Jml tandan
                                            </div>
                                            <div class="col border text-center">
                                                Loading Ramp
                                            </div>
                                        </div>
                                        <?php 
                                        $panen = $this->db->table("panen")
                                        ->select("SUM(panen_jml)As jmltandan,panen.*,tph.tph_status,tph.tph_certificate")
                                        ->join("tph","tph.tph_id=panen.tph_id","left")
                                        ->where("sptbs_id", $sptbs->sptbs_id)
                                        ->groupBy("tph_thntanam")
                                        ->get();
                                        $jmltandan=0;
                                        foreach($panen->getResult() as $panen){
                                            $jmltandan+=$panen->jmltandan;
                                            ?>      
                                            <div class="col-12 row">
                                                <div class="col border text-center">
                                                    <?=$panen->divisi_name;?>
                                                </div>
                                                <div class="col border text-center">
                                                    <?=$panen->blok_name;?>
                                                </div>
                                                <div class="col border text-center">
                                                    <?=$panen->tph_thntanam;?>
                                                </div>
                                                <div class="col border text-center">
                                                    <?=$panen->tph_certificate;?>
                                                </div>
                                                <div class="col border text-center">
                                                    <?=$panen->tph_status;?>
                                                </div>
                                                <div class="col border text-center">
                                                    <?=$panen->jmltandan;?>
                                                </div>
                                                <div class="col border text-center">
                                                
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>

                                    <div class="row mt-3 mb-5">  
                                        <?php                                        
                                        $brutto = $sptbs->sptbs_kgbruto;
                                        $tarra = $sptbs->sptbs_kgtruk;
                                        $netto = $brutto-$tarra;
                                        ?>
                                        <div class="col-6 row">                                             
                                            <div class="col-12">
                                                <h5 class="text-center">GRADING</h5>
                                            </div>
                                            <?php 
                                            $grading = $this->db->table("grading")
                                            ->join("gradingtype","gradingtype.gradingtype_id=grading.gradingtype_id","left")
                                            ->where("sptbsid",$sptbs->sptbsid)
                                            ->where("grading_date",$sptbs->sptbs_date)
                                            ->get();
                                            $tkg=0;
                                            foreach($grading->getResult() as $grading){
                                                /* 
                                                1 Fraksi 00
                                                2 Fraksi 0 
                                                3 Fraksi 5 
                                                4 Tangkai Panjang 
                                                5 Tandan Kosong 
                                                6 Tandan <3kg 
                                                7 Sampah 
                                                8 Brondolan Lepas 
                                                9 Fraksi 6 
                                                */ 
                                                $a = $grading->gradingtype_id;
                                                $knetto = array(6,7,8);
                                                if (in_array($a, $knetto)) {
                                                    $persen=$grading->grading_qty/$netto*100;
                                                }else{
                                                    $persen=$grading->grading_qty/$jmltandan*100;
                                                }
                                                
                                                $p50 = array(1,2);
                                                $p25 = array(3,9);
                                                $p100 = array(5);
                                                $p1 = array(4);
                                                $p30 = array(8);
                                                $k2 = array(7);
                                                $p70 = array(6);
                                                if (in_array($a, $p50)) {
                                                    $nilai = 50 * $persen / 100 * $netto;
                                                    $kg = round($nilai);
                                                }else  if (in_array($a, $p25)) {
                                                    if ($persen > 5) {
                                                        $nilai = 25/100 * ($persen/100 - 5/100) * $netto;
                                                        $kg = round($nilai);
                                                    } else {
                                                        $kg = 0;
                                                    }
                                                }else  if (in_array($a, $p100)) {
                                                    $nilai = (100/100) * ($persen/100) * $netto;
                                                    $kg = round($nilai);
                                                }else  if (in_array($a, $p1)) {
                                                    $nilai = (1/100) * ($persen/100) * $netto;
                                                    $kg = round($nilai);
                                                }else  if (in_array($a, $p30)) {
                                                    if ($persen <= 0) {
                                                        $kg = 0;
                                                    } else {
                                                        $nilai = 30/100 * (12.5/100 - $persen/100) * $netto;
                                                        if ($nilai < 0) {
                                                            $kg = 0;
                                                        } else {
                                                            $kg = round($nilai);
                                                        }
                                                    }                                                    
                                                }else if (in_array($a, $k2)) {
                                                    $nilai_J18 = $grading->grading_qty; 
                                                    $kg = round($nilai_J18*2);
                                                }else if (in_array($a, $p70)) {
                                                    $kg=$grading->grading_qty/$netto*100;
                                                    $nilai_J19 = $grading->grading_qty;
                                                    $kg = round($nilai_J19 * 1 * 0.70);
                                                }
                                                $tkg+=$kg;
                                                ?>
                                                <div class="col-3 text-bold t-10">
                                                    <?=$grading->gradingtype_name;?>
                                                </div>
                                                <div class="col-3  t-10">
                                                    = <?=$grading->grading_qty;?> <?=$grading->gradingtype_unit;?>
                                                </div>
                                                <div class="col-3  t-10">
                                                    = <?php
                                                    echo number_format($persen,2,",",".");
                                                    ?> %
                                                </div>
                                                <div class="col-3  t-10">
                                                    = <?=number_format($kg,0,",",".");?> Kg
                                                </div>
                                            <?php }?>
                                        </div>
                                        <?php
                                            $tgrading = $tkg;
                                            
                                            //netto diterima
                                            if (is_numeric($netto) && is_numeric($tgrading)) {
                                                $nettoditerima = $netto - $tgrading;
                                            } else {
                                                $nettoditerima = 0;
                                            }

                                            //bjr
                                            if (is_numeric($jmltandan) && $jmltandan != 0) {
                                                $bjr = $netto / $jmltandan;
                                            } else {
                                                $bjr = 0;
                                            }

                                            //% grading
                                            if ($netto != 0) {
                                                $pgrading = ($tgrading / $netto) * 100;
                                            } else {
                                                $pgrading = 0;
                                            }
                                        ?>
                                        <div class="col-1">&nbsp;</div>  
                                        <div class="col-5 row">   
                                            <div class="col-12 mb-2">
                                                <h5 class="text-center">INFORMASI TIMBANGAN</h5>
                                            </div>                                            
                                            <div class="col-6 t-10 text-bold">
                                                Berat Brutto
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?php 
                                                echo number_format($brutto,0,",",".");
                                                ?> Kg
                                            </div>
                                            <div class="col-6 t-10 text-bold">
                                                Berat Tarra
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?php 
                                                echo number_format($tarra,0,",",".");
                                                ?> Kg
                                            </div>
                                            <div class="col-6 t-10 text-bold">
                                                Berat Netto
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?php 
                                                echo number_format($netto,0,",",".");
                                                ?> Kg
                                            </div>
                                            <div class="col-6 t-10 mb-2 text-bold">
                                                Jumlah Grading
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?=number_format($tgrading,0,",",".");?> Kg
                                            </div>
                                            <div class="col-6 t-10 text-bold">
                                                Netto Diterima
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?=number_format($nettoditerima,0,",",".");?> Kg
                                            </div>
                                            <div class="col-6 t-10 text-bold">
                                                Jumlah Tandan
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?php 
                                                echo number_format($jmltandan,0,",",".");
                                                ?> Tdn
                                            </div>
                                            <div class="col-6 t-10 text-bold">
                                                BJR
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?php 
                                                echo number_format($bjr,0,",",".");
                                                ?> Kg
                                            </div>
                                            <div class="col-6 t-10 text-bold">
                                                % Grading
                                            </div>
                                            <div class="col-6 t-10">
                                                : <?php 
                                                echo number_format($pgrading,0,",",".");
                                                ?> %
                                            </div>
                                        </div>
                                        
                                    </div>

                                   

                                    

                                    <div class="row mt-5 pt-5">
                                        <div class="col-4 row">
                                            <div class="col-12 text-center text-bold"><?=session()->get("nama");?></div>
                                            <div class="col-12 pl-4 pr-4"><div class="border-top text-center">Opt.Timbangan</div></div>
                                        </div>
                                        <div class="col-4 row">
                                            <div class="col-12 text-center text-bold"><?=$sptbs->sptbs_drivername;?></div>
                                            <div class="col-12 pl-4 pr-4"><div class="border-top text-center">DRIVER/SUPIR</div></div>
                                        </div>
                                        <div class="col-4 row">
                                            <div class="col-12 text-center text-bold">SUYANTI</div>
                                            <div class="col-12 pl-4 pr-4"><div class="border-top text-center">KTU MILL</div></div>
                                        </div>
                                    </div>

                                   

                                <?php }?>
                            </div>
                            <?php }?>
                        </div> -->
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
                                    $dari=date("Y-m-d");
                                    $ke=date("Y-m-d");
                                    if(isset($_GET["dari"])){
                                        $dari=$_GET["dari"];
                                    }
                                    if(isset($_GET["ke"])){
                                        $ke=$_GET["ke"];
                                    }
                                    ?>
                                    <div class="col row">
                                        <div class="col-2">
                                            <label class="text-white">Dari :</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?=$dari;?>">
                                        </div>
                                    </div>
                                    <div class="col row">
                                        <div class="col-2">
                                            <label class="text-white">Ke :</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?=$ke;?>">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Detail Tiket Panen : <span id="title_panen" class="text-danger"></span></h4>
                                    </div>
                                    <div class="modal-body" id="modal-body">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <?php if (!isset($_GET["report"])) { ?>
                                        <th>Action</th>
                                    <?php } ?>
                                    <th>No.</th>
                                    <th>Date</th>
                                    <th>Tiket Panen</th>
                                    <th>Estate</th>
                                    <th>Divisi</th>
                                    <th>SPTBS Card</th>
                                    <th>Buah Dalam</th>
                                    <th>Buah Luar</th>
                                    <!-- <th>Card</th>
                                    <th>Vendor</th>
                                    <th>Material</th>
                                    <th>Kecamatan</th>
                                    <th>No. Plat</th>
                                    <th>Driver</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $usr = $this->db
                                    ->table("sptbs")
                                    ->join("t_user","t_user.user_id=sptbs.sptbs_createdby","left")
                                    ->join("t_vendor","t_vendor.ID_vendor=sptbs.sptbs_vendor","left")
                                    ->join("t_material","t_material.ID_material=sptbs.sptbs_material","left")
                                    ->join("t_asal","t_asal.id_asal=sptbs.sptbs_kecamatan","left")
                                    ->join("t_trukpenerimaan","t_trukpenerimaan.no_polisi=sptbs.sptbs_plat","left")
                                    ->join("t_driver","t_driver.ID_driver=sptbs.sptbs_driver","left")
                                    ->join("estate","estate.estate_id=sptbs.estate_id","left")
                                    ->join("divisi","divisi.divisi_id=sptbs.divisi_id","left")
                                    ->where("sptbs_date >=",$dari)
                                    ->where("sptbs_date <=",$ke)
                                    ->orderBy("sptbs_id", "ASC")
                                    ->get();
                                //echo $this->db->getLastquery();
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <td style="padding-left:0px; padding-right:0px;">
                                                <a target="_blank" href="<?=base_url("api/printtimbangan?print=OK&timbangan_name=".$usr->timbangan_name."&sptbs_id=".$usr->sptbs_id);?>" class="btn btn-sm btn-warning"><i class="fa fa-print"></i></a>
                                                <!-- <?php 
                                                if (
                                                    (
                                                        isset(session()->get("position_administrator")[0][0]) 
                                                        && (
                                                            session()->get("position_administrator") == "1" 
                                                            || session()->get("position_administrator") == "2"
                                                        )
                                                    ) ||
                                                    (
                                                        isset(session()->get("halaman")['55']['act_update']) 
                                                        && session()->get("halaman")['55']['act_update'] == "1"
                                                    )
                                                ) { ?>
                                                <form method="post" class="btn-action" style="">
                                                    <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                    <input type="hidden" name="sptbs_id" value="<?= $usr->sptbs_id; ?>" />
                                                </form>
                                                <?php }?> -->
                                                
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
                                                        isset(session()->get("halaman")['55']['act_delete']) 
                                                        && session()->get("halaman")['55']['act_delete'] == "1"
                                                    )
                                                ) { ?>
                                                <form method="post" class="btn-action" style="">
                                                    <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                    <input type="hidden" name="sptbs_id" value="<?= $usr->sptbs_id; ?>" />
                                                    <input type="hidden" name="sptbs_card" value="<?= $usr->sptbs_card; ?>" />
                                                    <input type="hidden" name="sptbs_date" value="<?= $usr->sptbs_date; ?>" />
                                                    <input type="hidden" name="sptbsid" value="<?= $usr->sptbsid; ?>" />
                                                </form>
                                                <?php }?>
                                            </td>
                                        <?php } ?>
                                        <td><?= $no++; ?></td>
                                        <td><?= $usr->sptbs_date; ?></td>
                                        <td>(<span class="text-danger"><?= $usr->sptbs_code; ?></span>)
                                            <?php
                                            $sptbs_id=$usr->sptbs_id; 
                                            $listcard=$usr->sptbs_listcard; 
                                            $lcard=explode("|",$listcard);
                                            foreach($lcard as $card){?>
                                                <button type="button" class="btn btn-xs btn-info" onclick="panen('<?=$card;?>','<?=$sptbs_id;?>')"><?=$card;?></button>
                                            <?php }
                                            ?>
                                        </td>
                                        <td><?= $usr->estate_name; ?></td>
                                        <td><?= $usr->divisi_name; ?></td>
                                        <td><?= $usr->sptbs_card; ?></td>
                                        <td>
                                            <?= $usr->wt_name; ?><br/>
                                            <?= $usr->nama_driver; ?><br/>
                                        </td>
                                        <td>
                                            <?= $usr->nama_vendor; ?><br/>
                                            <?= $usr->nama_material; ?><br/>
                                            <?= $usr->kecamatan; ?><br/>
                                        </td>
                                        <!-- <td><?= $usr->nama_vendor; ?></td>
                                        <td><?= $usr->nama_material; ?></td>
                                        <td><?= $usr->kecamatan; ?></td>
                                        <td><?= $usr->no_polisi; ?></td>
                                        <td><?= $usr->nama_driver; ?></td> -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <script>
                            function panen(panen_card,sptbs_id){
                                $("#title_panen").html(panen_card);
                                $.get("<?=base_url("api/apisync");?>",{panen_card:panen_card,sptbs_id:sptbs_id})
                                .done(function(data){
                                    $("#modal-body").html(data);
                                });
                                $("#myModal").modal("show");
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "Synchronization";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    $("#datakartu").focus();
    setInterval(() => {
        $("#datakartu").focus();
    }, 10000);
</script>

<?php echo  $this->include("template/footer_v"); ?>