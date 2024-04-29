<?php echo $this->include("template/header_v"); ?>
<style>
.nl1{font-size:15px!important; padding:20px !important; border:rgba(0,0,0,0.2) solid 1px !important;}
.tab-pane{border:rgba(0,0,0,0.2) solid 1px !important; padding:20px !important; margin:0px!important;}
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

                            <li class="nav-item"><a class="nav-link nl1" data-toggle="tab" href="#t<?=$timbangan->timbangan_id;?>"><?=$timbangan->timbangan_name;?></a></li>
                            
                            <?php }?>
                        </ul>

                        <div class="tab-content p-0 mt-2">
                            <?php $timbangan = $this->db->table("timbangan")->get();
                            foreach($timbangan->getResult() as $timbangan){?>
                            <div id="t<?=$timbangan->timbangan_id;?>" class="tab-pane fade in">
                                
                                <?php 
                                $currentDateTime = date("Y-m-d H:i:s");
                                $fiveMinutesAgo = date("Y-m-d H:i:s", strtotime("-5 minutes", strtotime($currentDateTime)));
                                
                                $sptbs = $this->db->table("sptbs")
                                ->where("timbangan_name",$timbangan->timbangan_name)
                                // ->where("sptbs_date",date("Y-m-d"))
                                // ->where("sptbs_created >=", $fiveMinutesAgo)
                                // ->where("sptbs_created <=", $currentDateTime)
                                // ->limit(1)
                                ->get();
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
                                        ->select("SUM(panen_jml)As jmltandan,panen.*,blok.*")
                                        ->join("blok","blok.blok_id=panen.blok_id","left")
                                        ->where("sptbs_id", $sptbs->sptbs_id)
                                        ->groupBy("tph_thntanam")
                                        ->get();
                                        foreach($panen->getResult() as $panen){?>                                                                            
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
                                                    <?=$panen->blok_certificate;?>
                                                </div>
                                                <div class="col border text-center">
                                                    <?=$panen->blok_status;?>
                                                </div>
                                                <div class="col border text-center">
                                                    <?=$panen->jmltandan;?>
                                                </div>
                                                <div class="col border text-center">
                                                
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>

                                    <div class="row mt-3">  
                                        <div class="col-4 row">   
                                            <div class="col-12">
                                                <h5 class="text-center">INFORMASI TIMBANGAN</h5>
                                            </div>                                            
                                            <div class="col-5">
                                                Berat Brutto
                                            </div>
                                            <div class="col-7">
                                                : <?php 
                                                $brutto = $sptbs->sptbs_kgbruto;
                                                ?> Kg
                                            </div>
                                            <div class="col-5">
                                                Berat Tarra
                                            </div>
                                            <div class="col-7">
                                                : <?php 
                                                $tarra = $sptbs->sptbs_kgtruk;
                                                ?> Kg
                                            </div>
                                            <div class="col-5">
                                                Berat Netto
                                            </div>
                                            <div class="col-7">
                                                : <?php 
                                                $netto = $brutto-$tarra;
                                                ?> Kg
                                            </div>
                                            <div class="col-5">
                                                Jumlah Grading
                                            </div>
                                            <div class="col-7">
                                                : <span id="tgrading<?=$sptbs->sptbs_id;?>"></span> Kg
                                            </div>
                                            <div class="col-5">
                                                Netto Diterima
                                            </div>
                                            <div class="col-7">
                                                : <span id="lnetto<?=$sptbs->sptbs_id;?>"></span> Kg
                                            </div>
                                            <div class="col-5">
                                                Jumlah Tandan
                                            </div>
                                            <div class="col-7">
                                                : <?php 
                                                $netto = $brutto-$tarra;
                                                ?> Kg
                                            </div>
                                            <div class="col-5">
                                                BJR
                                            </div>
                                            <div class="col-7">
                                                : <?php 
                                                $netto = $brutto-$tarra;
                                                ?> Kg
                                            </div>
                                            <div class="col-5">
                                                % Grading
                                            </div>
                                            <div class="col-7">
                                                : <?php 
                                                $netto = $brutto-$tarra;
                                                ?> Kg
                                            </div>
                                        </div>
                                        <div class="col-8 row">                                             
                                            <div class="col-12">
                                                <h5 class="text-center">GRADING</h5>
                                            </div>
                                            <?php $grading = $this->db->table("grading")
                                            ->where("sptbsid",$sptbs->sptbsid)
                                            ->where("grading_date",$sptbs->sptbs_date)
                                            ->get();
                                            foreach($grading->getResult() as $grading){?>
                                            <div class="col-7">
                                                : <?=$sptbs->sptbs_id;?>
                                            </div>
                                            <div class="col-5">
                                                SPTBS Date
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">SPTBS Card</div>
                                        <div class="col-10"><?=$sptbs->sptbs_card;?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">Berat Bruto</div>
                                        <div class="col-10"><?=$sptbs->sptbs_kgbruto;?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">Berat Tarra</div>
                                        <div class="col-10"><?=$sptbs->sptbs_kgtruk;?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">Cheker</div>
                                        <div class="col-10"><?=$sptbs->sptbs_createdname;?></div>
                                    </div>

                                   

                                    <div class="row">
                                        <div class="col-2">Divisi</div>
                                        <div class="col-10"><?=$sptbs->estate_name;?> - <?=$sptbs->divisi_name;?></div>
                                    </div>

                                   

                                <?php }?>
                            </div>
                            <?php }?>
                        </div>
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
                                                </form>
                                                <?php }?>
                                            </td>
                                        <?php } ?>
                                        <td><?= $no++; ?></td>
                                        <td><?= $usr->sptbs_date; ?></td>
                                        <td>
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
                                            <?= $usr->no_polisi; ?><br/>
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