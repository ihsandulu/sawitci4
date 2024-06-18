<?php echo $this->include("template/header_v"); ?>
<style>
.modal-content {
    background-color: transparent; /* Membuat latar belakang modal menjadi transparan */
    border: none;
}

.modal-body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh; /* Mengatur tinggi modal menjadi 80% tinggi layar */
}

.modal-body .gambar {
    max-height: 100%; /* Membuat gambar tidak melebihi tinggi modal */
    width: auto;
    height: auto;
}

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
                                    isset(session()->get("halaman")['50']['act_create']) 
                                    && session()->get("halaman")['50']['act_create'] == "1"
                                )
                            ) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="quarry_id" />
                                </h1>
                            </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Quarry";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Quarry";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_date">Date:</label>
                                    <div class="col-sm-12">
                                        <input required type="date" autofocus class="form-control" id="quarry_date" name="quarry_date" placeholder="" value="<?= $quarry_date; ?>">
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_card">Kartu:</label>
                                    <div class="col-sm-12">
                                        <input required type="text" class="form-control" id="quarry_card" name="quarry_card" placeholder="" value="<?= $quarry_card; ?>">
                                    </div>
                                </div>           
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_kubikasi">Kubikasi:</label>
                                    <div class="col-sm-12">
                                        <input required type="number" class="form-control" id="quarry_kubikasi" name="quarry_kubikasi" placeholder="" value="<?= $quarry_kubikasi; ?>">
                                    </div>
                                </div>          
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_jarak">Jarak:</label>
                                    <div class="col-sm-12">
                                        <input required type="text" class="form-control" id="quarry_jarak" name="quarry_jarak" placeholder="" value="<?= $quarry_jarak; ?>">
                                    </div>
                                </div>       
                                <h3>Pengirim</h3> 
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_checkerpengirim">Pengirim:</label>
                                    <div class="col-sm-12">                                        
                                        <select required class="form-control select" id="quarry_checkerpengirim" name="quarry_checkerpengirim">
                                            <option value="" <?= ($quarry_checkerpengirim == "") ? "selected" : ""; ?>>Pilih Checker</option>
                                            <?php
                                            $usr = $this->db->table("t_user")
                                            // ->select('t_user.*, CASE WHEN (SELECT COUNT(*) FROM placement WHERE placement.user_id = t_user.user_id) > 0 THEN GROUP_CONCAT(placement.divisi_id SEPARATOR ",") ELSE NULL END AS divisiid')
                                            ->select("*, t_user.user_id as user_id, placement.estate_id as estate_id, placement.divisi_id as divisi_id, placement.seksi_id as seksi_id, placement.blok_id as blok_id, placement.tph_id as tph_id, t_user.position_id as position_id, position.position_name as position_name")
                                            ->join('placement', 'placement.user_id = t_user.user_id', 'left')
                                            ->join('estate', 'estate.estate_id = placement.estate_id', 'left')
                                            ->join('divisi', 'divisi.divisi_id = placement.divisi_id', 'left')
                                            ->join('seksi', 'seksi.seksi_id = placement.seksi_id', 'left')
                                            ->join('blok', 'blok.blok_id = placement.blok_id', 'left')
                                            ->join('tph', 'tph.tph_id = placement.tph_id', 'left')
                                            ->join('position', 'position.position_id = t_user.position_id', 'left')
                                            ->orderBy("t_user.username", "ASC")
                                            ->groupBy('t_user.user_id')
                                            ->get();
                                            foreach($usr->getResult() as $usr){?>
                                            <option value="<?=$usr->user_id;?>" <?= ($quarry_checkerpengirim == $usr->user_id) ? "selected" : ""; ?>><?=$usr->nama;?> (<?=$usr->position_name;?> - <?=$usr->estate_name;?> - <?=$usr->divisi_name;?>)</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_geo1">Geolocation Pengirim:</label>
                                    <div class="col-sm-12">
                                        <input required type="text" class="form-control" id="quarry_geo1" name="quarry_geo1" placeholder="" value="<?= $quarry_geo1; ?>">
                                    </div>
                                </div>         
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_jampergi">Jam Pergi:</label>
                                    <div class="col-sm-12">
                                        <input onkeyup="kirimjam()" required type="datetime-local" autofocus class="form-control" id="quarry_jampergi" placeholder="" value="<?= $quarry_date; ?> <?= $quarry_jampergi; ?>">
                                        <input type="hidden" id="quarry_jampergi" name="quarry_jampergi" value="<?= $quarry_jampergi; ?>" />
                                        <script>
                                            function kirimjam(){            
                                                let datetime = $("#quarry_jampergi"). val();
                                                // Memisahkan tanggal dan waktu
                                                var parts = datetime.split(" ");
                                                var tanggal = parts[0];
                                                var waktu = parts[1];
                                                $("#quarry_jampergi").val(waktu);
                                            }
                                        </script>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="wt_id">Vehicle:</label>
                                    <div class="col-sm-12">                                        
                                        <select required class="form-control select" id="wt_id" name="wt_id">
                                            <option value="" <?= ($wt_id == "") ? "selected" : ""; ?>>Pilih Kendaraan</option>
                                            <?php
                                            $usr = $this->db
                                            ->table("wt")
                                            ->get();
                                            $vendor = array("","PAM","VF","Sewa"); 
                                            $sewa = array("","Wong Ganteng","VF","Putri Tunggal","Surya Gemilang");   
                                            foreach($usr->getResult() as $usr){?>
                                            <option value="<?=$usr->wt_id;?>" <?= ($wt_id == $usr->wt_id) ? "selected" : ""; ?>><?=$usr->wt_name;?> (<?=$usr->wt_jenis;?> <?=$vendor[$usr->wt_vendor];?> <?=$sewa[$usr->wt_sewa];?>)</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarrytype_id">Jenis:</label>
                                    <div class="col-sm-12">                                        
                                        <select required class="form-control select" id="quarrytype_id" name="quarrytype_id">
                                            <option value="" <?= ($quarrytype_id == "") ? "selected" : ""; ?>>Pilih Jenis</option>
                                            <?php
                                            $usr = $this->db
                                            ->table("quarrytype")
                                            ->get();
                                            foreach($usr->getResult() as $usr){?>
                                            <option value="<?=$usr->quarrytype_id;?>" <?= ($quarrytype_id == $usr->quarrytype_id) ? "selected" : ""; ?>><?=$usr->quarrytype_sumber;?> (<?=$usr->quarrytype_jenis;?>)</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_driver">Driver:</label>
                                    <div class="col-sm-12">                                        
                                        <select onchange="drivername()" required class="form-control select" id="quarry_driver" name="quarry_driver">
                                            <option value="" <?= ($quarry_driver == "") ? "selected" : ""; ?>>Pilih Jenis</option>
                                            <?php
                                            $usr = $this->db
                                            ->table("t_user")
                                            ->join("position","position.position_id=t_user.position_id","left")
                                            ->where("t_user.position_id","7")
                                            ->orWhere("t_user.position_id","59")
                                            ->orderBy("t_user.nama", "ASC")
                                            ->get();
                                            foreach($usr->getResult() as $usr){?>
                                            <option value="<?=$usr->user_id;?>" <?= ($quarry_driver == $usr->user_id) ? "selected" : ""; ?>><?=$usr->nama;?> (<?=$usr->position_name;?>)</option>
                                            <?php }?>
                                        </select>
                                        <script>
                                            function drivername(){
                                                let drivername = $("#quarry_driver :selected").attr("driver_name");
                                                if (typeof drivername !== "undefined") {
                                                    $("#quarry_drivername").val(drivername);
                                                } else {
                                                    $("#quarry_drivername").val("");
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_blok1">Blok Pengirim:</label>
                                    <div class="col-sm-12">                                        
                                        <select onchange="blokname1()" required class="form-control select" id="quarry_blok1" name="quarry_blok1">
                                            <option value="" <?= ($quarry_blok1 == "") ? "selected" : ""; ?>>Pilih Blok</option>
                                            <?php
                                            $usr = $this->db
                                            ->table("blok")
                                            ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
                                            ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
                                            ->join("estate","estate.estate_id=divisi.estate_id","left")
                                            ->orderBy("blok_name", "ASC")
                                            ->get();
                                            foreach($usr->getResult() as $usr){?>
                                            <option blok_name="<?=$usr->blok_name;?>" estate_id="<?=$usr->estate_id;?>" estate_name="<?=$usr->estate_name;?>" divisi_id="<?=$usr->divisi_id;?>" divisi_name="<?=$usr->divisi_name;?>"  value="<?=$usr->blok_id;?>" <?= ($quarry_blok1 == $usr->blok_id) ? "selected" : ""; ?>><?=$usr->blok_name;?> (<?=$usr->estate_name;?> - <?=$usr->divisi_name;?>)</option>
                                            <?php }?>
                                        </select>
                                        
                                        <input type="hidden" name="quarry_blok1name" value="<?= $quarry_blok1name; ?>" />
                                        <input type="hidden" name="quarry_estate1" value="<?= $quarry_estate1; ?>" />
                                        <input type="hidden" name="quarry_estate1name" value="<?= $quarry_estate1name; ?>" />
                                        <input type="hidden" name="quarry_divisi1" value="<?= $quarry_divisi1; ?>" />
                                        <input type="hidden" name="quarry_divisi1name" value="<?= $quarry_divisi1name; ?>" />

                                        <script>
                                            function blokname1(){
                                                let blok_name = $("#quarry_blok1 :selected").attr("blok_name");
                                                let estate_id = $("#quarry_blok1 :selected").attr("estate_id");
                                                let estate_name = $("#quarry_blok1 :selected").attr("estate_name");
                                                let divisi_id = $("#quarry_blok1 :selected").attr("divisi_id");
                                                let divisi_name = $("#quarry_blok1 :selected").attr("divisi_name");
                                                if (typeof blok_name !== "undefined") {
                                                    $("#quarry_blok1name").val(blok_name);
                                                    $("#quarry_estate1").val(estate_id);
                                                    $("#quarry_estate1name").val(estate_name);
                                                    $("#quarry_divisi1").val(divisi_id);
                                                    $("#quarry_divisi1name").val(divisi_name);
                                                } else {
                                                    // Atau, jika quarry_blok1name undefined, atur nilai input ke string kosong atau sesuai kebutuhan
                                                    $("#quarry_blok1name").val("");
                                                    $("#quarry_estate1").val("");
                                                    $("#quarry_estate1name").val("");
                                                    $("#quarry_divisi1").val("");
                                                    $("#quarry_divisi1name").val("");
                                                }
                                                // alert(quarry_blok1name);
                                            }
                                        </script>
                                    </div>
                                </div>    
                                <h3>Penerima</h3> 
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_checkerpenerima">Penerima:</label>
                                    <div class="col-sm-12">                                        
                                        <select required class="form-control select" id="quarry_checkerpenerima" name="quarry_checkerpenerima">
                                            <option value="" <?= ($quarry_checkerpenerima == "") ? "selected" : ""; ?>>Pilih Checker</option>
                                            <?php
                                            $usr = $this->db->table("t_user")
                                            // ->select('t_user.*, CASE WHEN (SELECT COUNT(*) FROM placement WHERE placement.user_id = t_user.user_id) > 0 THEN GROUP_CONCAT(placement.divisi_id SEPARATOR ",") ELSE NULL END AS divisiid')
                                            ->select("*, t_user.user_id as user_id, placement.estate_id as estate_id, placement.divisi_id as divisi_id, placement.seksi_id as seksi_id, placement.blok_id as blok_id, placement.tph_id as tph_id, t_user.position_id as position_id, position.position_name as position_name")
                                            ->join('placement', 'placement.user_id = t_user.user_id', 'left')
                                            ->join('estate', 'estate.estate_id = placement.estate_id', 'left')
                                            ->join('divisi', 'divisi.divisi_id = placement.divisi_id', 'left')
                                            ->join('seksi', 'seksi.seksi_id = placement.seksi_id', 'left')
                                            ->join('blok', 'blok.blok_id = placement.blok_id', 'left')
                                            ->join('tph', 'tph.tph_id = placement.tph_id', 'left')
                                            ->join('position', 'position.position_id = t_user.position_id', 'left')
                                            ->orderBy("t_user.username", "ASC")
                                            ->groupBy('t_user.user_id')
                                            ->get();
                                            foreach($usr->getResult() as $usr){?>
                                            <option value="<?=$usr->user_id;?>" <?= ($quarry_checkerpenerima == $usr->user_id) ? "selected" : ""; ?>><?=$usr->nama;?> (<?=$usr->position_name;?> - <?=$usr->estate_name;?> - <?=$usr->divisi_name;?>)</option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>                                      
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_geo2">Geolocation Penerima:</label>
                                    <div class="col-sm-12">
                                        <input required type="text" class="form-control" id="quarry_geo2" name="quarry_geo2" placeholder="" value="<?= $quarry_geo2; ?>">
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_jamtiba">Jam Datang:</label>
                                    <div class="col-sm-12">
                                        <input onkeyup="tibajam()" required type="datetime-local" autofocus class="form-control" id="quarry_jamtiba" placeholder="" value="<?= $quarry_date; ?> <?= $quarry_jamtiba; ?>">
                                        <input type="hidden" id="quarry_jamtiba" name="quarry_jamtiba" value="<?= $quarry_jamtiba; ?>" />
                                        <script>
                                            function tibajam(){            
                                                let datetime = $("#quarry_jamtiba"). val();
                                                // Memisahkan tanggal dan waktu
                                                var parts = datetime.split(" ");
                                                var tanggal = parts[0];
                                                var waktu = parts[1];
                                                $("#quarry_jamtiba").val(waktu);
                                            }
                                        </script>
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="quarry_blok2">Blok Penerima:</label>
                                    <div class="col-sm-12">                                        
                                        <select onchange="blokname2()" required class="form-control select" id="quarry_blok2" name="quarry_blok2">
                                            <option value="" <?= ($quarry_blok2 == "") ? "selected" : ""; ?>>Pilih Blok</option>
                                            <?php
                                            $usr = $this->db
                                            ->table("blok")
                                            ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
                                            ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
                                            ->join("estate","estate.estate_id=divisi.estate_id","left")
                                            ->orderBy("blok_name", "ASC")
                                            ->get();
                                            foreach($usr->getResult() as $usr){?>
                                            <option blok_name="<?=$usr->blok_name;?>" estate_id="<?=$usr->estate_id;?>" estate_name="<?=$usr->estate_name;?>" divisi_id="<?=$usr->divisi_id;?>" divisi_name="<?=$usr->divisi_name;?>"  value="<?=$usr->blok_id;?>" <?= ($quarry_blok2 == $usr->blok_id) ? "selected" : ""; ?>><?=$usr->blok_name;?> (<?=$usr->estate_name;?> - <?=$usr->divisi_name;?>)</option>
                                            <?php }?>
                                        </select>
                                        
                                        <input type="hidden" name="quarry_blok2name" value="<?= $quarry_blok2name; ?>" />
                                        <input type="hidden" name="quarry_estate2" value="<?= $quarry_estate2; ?>" />
                                        <input type="hidden" name="quarry_estate2name" value="<?= $quarry_estate2name; ?>" />
                                        <input type="hidden" name="quarry_divisi2" value="<?= $quarry_divisi2; ?>" />
                                        <input type="hidden" name="quarry_divisi2name" value="<?= $quarry_divisi2name; ?>" />

                                        <script>
                                            function blokname2(){
                                                let blok_name = $("#quarry_blok2 :selected").attr("blok_name");
                                                let estate_id = $("#quarry_blok2 :selected").attr("estate_id");
                                                let estate_name = $("#quarry_blok2 :selected").attr("estate_name");
                                                let divisi_id = $("#quarry_blok2 :selected").attr("divisi_id");
                                                let divisi_name = $("#quarry_blok2 :selected").attr("divisi_name");
                                                if (typeof blok_name !== "undefined") {
                                                    $("#quarry_blok2name").val(blok_name);
                                                    $("#quarry_estate2").val(estate_id);
                                                    $("#quarry_estate2name").val(estate_name);
                                                    $("#quarry_divisi2").val(divisi_id);
                                                    $("#quarry_divisi2name").val(divisi_name);
                                                } else {
                                                    // Atau, jika quarry_blok2name undefined, atur nilai input ke string kosong atau sesuai kebutuhan
                                                    $("#quarry_blok2name").val("");
                                                    $("#quarry_estate2").val("");
                                                    $("#quarry_estate2name").val("");
                                                    $("#quarry_divisi2").val("");
                                                    $("#quarry_divisi2name").val("");
                                                }
                                                // alert(quarry_blok2name);
                                            }
                                        </script>
                                    </div>
                                </div>                                                  
                                 

                                <input type="hidden" name="quarry_id" value="<?= $quarry_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("quarry"); ?>">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
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
                                    <?php if(isset($_GET["report"])){?>
                                        <input type="hidden" name="report" value="OK"/>
                                    <?php }?>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive m-t-40">
                            
                            <?php if (!isset($_GET["report"])) { ?>
                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                    <thead class="">
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <th>Action</th>
                                            <?php } ?>
                                            <!-- <th>No.</th> -->
                                            <th>Date</th>
                                            <th>Jarak</th>
                                            <th>Detail</th>
                                            <th>Jenis</th>
                                            <th>Pengirim</th>
                                            <th>Penerima</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php                                    
                                        $usr = $this->db
                                            ->table("quarry")
                                            ->join("(SELECT user_id as driverid, nama as drivername FROM t_user)AS driver","driver.driverid=quarry.quarry_driver","left")
                                            ->join("(SELECT user_id as pengirimid, nama as pengirimname FROM t_user)AS pengirim","pengirim.pengirimid=quarry.quarry_checkerpengirim","left")
                                            ->join("(SELECT user_id as penerimaid, nama as penerimaname FROM t_user)AS penerima","penerima.penerimaid=quarry.quarry_checkerpenerima","left")
                                            ->join("wt","wt.wt_id=quarry.wt_id","left")
                                            ->join("quarrytype","quarrytype.quarrytype_id=quarry.quarrytype_id","left")

                                            ->join("(SELECT blok_id as blok1id, blok_name as blok1name FROM blok)AS blok1","blok1.blok1id=quarry.quarry_blok1","left")
                                            ->join("(SELECT blok_id as blok2id, blok_name as blok2name FROM blok)AS blok2","blok2.blok2id=quarry.quarry_blok2","left")

                                            ->join("(SELECT estate_id as estate1id, estate_name as estate1name FROM estate)AS estate1","estate1.estate1id=quarry.quarry_estate1","left")
                                            ->join("(SELECT estate_id as estate2id, estate_name as estate2name FROM estate)AS estate2","estate2.estate2id=quarry.quarry_estate2","left")

                                            ->join("(SELECT divisi_id as divisi1id, divisi_name as divisi1name FROM divisi)AS divisi1","divisi1.divisi1id=quarry.quarry_divisi1","left")
                                            ->join("(SELECT divisi_id as divisi2id, divisi_name as divisi2name FROM divisi)AS divisi2","divisi2.divisi2id=quarry.quarry_divisi2","left")

                                            ->where("quarry_date >=",$dari)
                                            ->where("quarry_date <=",$ke)
                                            ->orderBy("quarry_date", "ASC")
                                            ->orderBy("quarry_card", "ASC")
                                            ->get();
                                        // echo $this->db->getLastquery();
                                        $no = 1;
                                        $vendor = array("","PAM","VF","Sewa"); 
                                        $sewa = array("","Wong Ganteng","VF","Putri Tunggal","Surya Gemilang"); 
                                        foreach ($usr->getResult() as $usr) { ?>
                                            <tr>
                                                <?php if (!isset($_GET["report"])) { ?>
                                                    <td style="padding-left:0px; padding-right:0px;">
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
                                                                isset(session()->get("halaman")['50']['act_update']) 
                                                                && session()->get("halaman")['50']['act_update'] == "1"
                                                            )
                                                        ) { ?>
                                                            <form method="post" class="btn-action" style="">
                                                                <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                <input type="hidden" name="quarry_id" value="<?= $usr->quarry_id; ?>" />
                                                            </form>
                                                        <?php }?>
                                                        
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
                                                                isset(session()->get("halaman")['50']['act_delete']) 
                                                                && session()->get("halaman")['50']['act_delete'] == "1"
                                                            )
                                                        ) { ?>
                                                            <form method="post" class="btn-action" style="">
                                                                <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                <input type="hidden" name="quarry_id" value="<?= $usr->quarry_id; ?>" />
                                                            </form>
                                                        <?php }?>
                                                    </td>
                                                <?php } ?>
                                                <!-- <td><?= $no++; ?></td> -->
                                                <td><?= $usr->quarry_date; ?></td>
                                                <td class="text-left">
                                                    Jarak
                                                    <div class="input-group mt-2 mb-2">
                                                        <input type="text" id="quarry_jarak<?= $usr->quarry_id ; ?>" name="quarry_jarak" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2" value="<?= $usr->quarry_jarak; ?>">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button"><i onclick="jarak(<?= $usr->quarry_id ; ?>)" class="fa fa-check"></i></button>
                                                        </div>
                                                    </div>                                                    
                                                </td>
                                                <td class="text-left">
                                                    <?= $usr->quarry_card; ?><br/>
                                                    <?= $usr->quarry_kubikasi; ?> Kubik<br/>
                                                    <?=$usr->quarrytype_sumber;?> (<?=$usr->quarrytype_jenis;?>)
                                                </td>
                                                <td class="text-left">
                                                    <?= $usr->drivername; ?><br/>
                                                    <?= $usr->wt_name; ?> (<?= $usr->wt_jenis; ?> <?= ($usr->wt_vendor!="")?$vendor[$usr->wt_vendor]:""; ?> <?= ($usr->wt_sewa!="")?$sewa[$usr->wt_sewa]:""; ?>)
                                                </td>
                                                <td class="text-left">
                                                    <?= $usr->pengirimname; ?><br/>
                                                    <?= $usr->quarry_jampergi; ?><br/>
                                                    <?= $usr->estate1name; ?> <?= $usr->divisi1name; ?> <?= $usr->blok1name; ?><br/>
                                                    <?= $usr->quarry_geo1; ?>
                                                </td>
                                                <td class="text-left"><?= $usr->penerimaname; ?><br/>
                                                    <?= $usr->quarry_jamtiba; ?><br/>
                                                    <?= $usr->estate2name; ?> <?= $usr->divisi2name; ?> <?= $usr->blok2name; ?><br/>
                                                    <?= $usr->quarry_geo2; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php }else{?>
                                <table id="example2310" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action....</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <th>Date</th>
                                        <th>Card</th>
                                        <th>Jarak (Km)</th>
                                        <th>Kubik</th>
                                        <th>JenisQuarry</th>
                                        <th>Driver</th>
                                        <th>Vehicle</th>
                                        <th>Pengirim</th>
                                        <th>JamKirim</th>
                                        <th>EstateAsal</th>
                                        <th>DivisiAsal</th>
                                        <th>BlokAsal</th>
                                        <th>LokasiKirim</th>
                                        <th>Penerima</th>
                                        <th>JamTiba</th>
                                        <th>EstateTujuan</th>
                                        <th>DivisiTujuan</th>
                                        <th>BlokTujuan</th>
                                        <th>LokasiTujuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                    
                                    $usr = $this->db
                                        ->table("quarry")
                                        ->join("(SELECT user_id as driverid, nama as drivername FROM t_user)AS driver","driver.driverid=quarry.quarry_driver","left")
                                        ->join("(SELECT user_id as pengirimid, nama as pengirimname FROM t_user)AS pengirim","pengirim.pengirimid=quarry.quarry_checkerpengirim","left")
                                        ->join("(SELECT user_id as penerimaid, nama as penerimaname FROM t_user)AS penerima","penerima.penerimaid=quarry.quarry_checkerpenerima","left")
                                        ->join("wt","wt.wt_id=quarry.wt_id","left")
                                        ->join("quarrytype","quarrytype.quarrytype_id=quarry.quarrytype_id","left")

                                        ->join("(SELECT blok_id as blok1id, blok_name as blok1name FROM blok)AS blok1","blok1.blok1id=quarry.quarry_blok1","left")
                                        ->join("(SELECT blok_id as blok2id, blok_name as blok2name FROM blok)AS blok2","blok2.blok2id=quarry.quarry_blok2","left")

                                        ->join("(SELECT estate_id as estate1id, estate_name as estate1name FROM estate)AS estate1","estate1.estate1id=quarry.quarry_estate1","left")
                                        ->join("(SELECT estate_id as estate2id, estate_name as estate2name FROM estate)AS estate2","estate2.estate2id=quarry.quarry_estate2","left")

                                        ->join("(SELECT divisi_id as divisi1id, divisi_name as divisi1name FROM divisi)AS divisi1","divisi1.divisi1id=quarry.quarry_divisi1","left")
                                        ->join("(SELECT divisi_id as divisi2id, divisi_name as divisi2name FROM divisi)AS divisi2","divisi2.divisi2id=quarry.quarry_divisi2","left")

                                        ->where("quarry_date >=",$dari)
                                        ->where("quarry_date <=",$ke)
                                        ->orderBy("quarry_date", "ASC")
                                        ->orderBy("quarry_card", "ASC")
                                        ->get();
                                    // echo $this->db->getLastquery();
                                    $no = 1;
                                    $vendor = array("","PAM","VF","Sewa"); 
                                    $sewa = array("","Wong Ganteng","VF","Putri Tunggal","Surya Gemilang"); 
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">
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
                                                            isset(session()->get("halaman")['50']['act_update']) 
                                                            && session()->get("halaman")['50']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="quarry_id" value="<?= $usr->quarry_id; ?>" />
                                                        </form>
                                                    <?php }?>
                                                    
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
                                                            isset(session()->get("halaman")['50']['act_delete']) 
                                                            && session()->get("halaman")['50']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="quarry_id" value="<?= $usr->quarry_id; ?>" />
                                                        </form>
                                                    <?php }?>
                                                    <div class="input-group mt-2 mb-2">
                                                        <input type="text" id="quarry_jarak<?= $usr->quarry_id ; ?>" name="quarry_jarak" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2" value="<?= $usr->quarry_jarak; ?>">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button"><i onclick="jarak(<?= $usr->quarry_id ; ?>)" class="fa fa-check"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td><?= $usr->quarry_date; ?></td>
                                            <td><?= $usr->quarry_card; ?></td>
                                            <td class="text-left"><?= $usr->quarry_jarak; ?></td>
                                            <td><?= $usr->quarry_kubikasi; ?> Kubik</td>
                                            <td>
                                                <?=$usr->quarrytype_sumber;?> (<?=$usr->quarrytype_jenis;?>)
                                            </td>
                                            <td class="text-left"><?= $usr->drivername; ?></td>
                                            <td>
                                                <?= $usr->wt_name; ?> (<?= $usr->wt_jenis; ?> <?= ($usr->wt_vendor!="")?$vendor[$usr->wt_vendor]:""; ?> <?= ($usr->wt_sewa!="")?$sewa[$usr->wt_sewa]:""; ?>)
                                            </td>
                                            <td><?= $usr->pengirimname; ?></td>
                                            <td><?= $usr->quarry_jampergi; ?></td>
                                            <td><?= $usr->estate1name; ?></td>
                                            <td><?= $usr->divisi1name; ?></td>
                                            <td><?= $usr->blok1name; ?></td>
                                            <td><?= $usr->quarry_geo1; ?></td>
                                            <td><?= $usr->penerimaname; ?></td>
                                            <td><?= $usr->quarry_jamtiba; ?></td>
                                            <td><?= $usr->estate2name; ?></td>
                                            <td><?= $usr->divisi2name; ?></td>
                                            <td><?= $usr->blok2name; ?></td>
                                            <td><?= $usr->quarry_geo2; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php }?>
                            
                            <script>                                
                                function jarak(id){
                                    let quarry_id = id;
                                    let quarry_jarak = $("#quarry_jarak"+id).val();
                                    $.get("<?=base_url("api/insertquarry_jarak");?>",{quarry_id:quarry_id,quarry_jarak:quarry_jarak})
                                    .done(function(data){
                                        // showmessage("Update jarak berhasil!");
                                        toast("Info", "Update jarak berhasil!")
                                    });
                                }
                            </script>
                            <!-- Picture -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-body">
                                       <img id="gambarquarry" src="<?=base_url("images/picture.png");?>" class="gambar"/>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "Quarry";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#example2310').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>)',
                    filename: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>) ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>)',
                    filename: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>) ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>) Excel',
                    filename: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>) ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>)',
                    filename: 'Requirement Reports  (<?=$dari;?> to <?=$ke;?>) ',
                    text: 'Export to PDF',
                    customize: function (doc) {
                        doc.content[1].table.headerRows = 1;
                        doc.content[1].table.body[0].forEach(function (h) {
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