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
                                    isset(session()->get("halaman")['47']['act_create']) 
                                    && session()->get("halaman")['47']['act_create'] == "1"
                                )
                            ) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="tph_id" />
                                </h1>
                            </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update RKH";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah RKH";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">     
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="estate_id">Estate:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $estate = $this->db->table("estate")
                                            ->orderBy("estate_name", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select onchange="divisi()" required class="form-control select" id="estate_id" >
                                            <option value="" <?= ($estate_id == "") ? "selected" : ""; ?>>Pilih Estate</option>
                                            <?php
                                            foreach ($estate->getResult() as $estate) { ?>
                                                <option value="<?= $estate->estate_id; ?>" <?= ($estate_id == $estate->estate_id) ? "selected" : ""; ?>><?= $estate->estate_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>                                                   
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="divisi_id">Divisi:</label>
                                    <div class="col-sm-10">
                                        <select onchange="seksi()" required class="form-control select" id="divisi_id">
                                            
                                        </select>
                                        <script>
                                            function divisi(){
                                                let estate_id = $("#estate_id").val();
                                                let divisi_id = "<?=$divisi_id;?>";
                                                $.get("<?=base_url("api/divisi");?>",{estate_id:estate_id,divisi_id:divisi_id})
                                                .done(function(data){
                                                    $("#divisi_id").html(data);
                                                    seksi();
                                                });
                                            }
                                            divisi();
                                        </script>
                                    </div>
                                </div>                                                        
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="seksi_id">Seksi:</label>
                                    <div class="col-sm-10">
                                        <select onchange="blok()" required class="form-control select" id="seksi_id">
                                            
                                        </select>
                                        <script>
                                            function seksi(){
                                                let divisi_id = $("#divisi_id").val();
                                                let seksi_id = "<?=$seksi_id;?>";
                                                $.get("<?=base_url("api/seksi");?>",{divisi_id:divisi_id,seksi_id:seksi_id})
                                                .done(function(data){
                                                    $("#seksi_id").html(data);
                                                    blok();
                                                });
                                            }
                                            seksi();
                                        </script>
                                    </div>
                                </div>                                              
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="blok_id">Blok:</label>
                                    <div class="col-sm-10">
                                        <select onchange="tph()" required class="form-control select" id="blok_id">
                                            
                                        </select>
                                        <script>
                                            function blok(){
                                                let seksi_id = $("#seksi_id").val();
                                                let blok_id = "<?=$blok_id;?>";
                                                $.get("<?=base_url("api/blok");?>",{seksi_id:seksi_id,blok_id:blok_id})
                                                .done(function(data){
                                                    $("#blok_id").html(data);
                                                    tph();
                                                });
                                            }
                                            blok();
                                        </script>
                                    </div>
                                </div>                                              
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="tph_id">TPH:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control select" id="tph_id" name="tph_id">
                                            
                                        </select>
                                        <script>
                                            function tph(){
                                                let blok_id = $("#blok_id").val();
                                                let tph_id = "<?=$tph_id;?>";
                                                $.get("<?=base_url("api/tph");?>",{blok_id:blok_id,tph_id:tph_id})
                                                .done(function(data){
                                                    $("#tph_id").html(data);
                                                });
                                            }
                                            tph();
                                        </script>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="rkh_job">Job:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control select" id="rkh_job" name="rkh_job" >
                                            <option value="" <?= ($rkh_job == "") ? "selected" : ""; ?>>Pilih Job</option>
                                            <option value="Panen" <?= ($rkh_job == "Panen") ? "selected" : ""; ?>>Panen</option>
                                            <option value="Pemberondol" <?= ($rkh_job == "Pemberondol") ? "selected" : ""; ?>>Pemberondol</option>
                                            <option value="Stocker" <?= ($rkh_job == "Stocker") ? "selected" : ""; ?>>Stocker</option>
                                            <option value="Driver" <?= ($rkh_job == "Driver") ? "selected" : ""; ?>>Driver</option>
                                            <option value="Operator Traktor" <?= ($rkh_job == "Operator Traktor") ? "selected" : ""; ?>>Operator Traktor</option>
                                        </select>
                                    </div>
                                </div>                                                  
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="rkh_rdate">Tanggal:</label>
                                    <div class="col-sm-10">
                                        <input required type="date"  class="form-control" id="rkh_rdate" name="rkh_rdate" placeholder="" value="<?= ($rkh_rdate)?$rkh_rdate:date("Y-m-d",strtotime("+1 days",strtotime(date("Y-m-d")))); ?>">
                                    </div>
                                </div>                                               
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="rkh_masuk">Masuk:</label>
                                    <div class="col-sm-10">
                                        <input type="number"  class="form-control" id="rkh_masuk" name="rkh_masuk" placeholder="" value="<?= $rkh_masuk; ?>">
                                    </div>
                                </div>                                               
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="rkh_tmasuk">Tidak Masuk:</label>
                                    <div class="col-sm-10">
                                        <input type="number"  class="form-control" id="rkh_tmasuk" name="rkh_tmasuk" placeholder="" value="<?= $rkh_tmasuk; ?>">
                                    </div>
                                </div>  

                                <input type="hidden" name="rkh_id" value="<?= $rkh_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("rkh"); ?>">Back</a>
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
                            <table id="example231" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Job</th>
                                        <th>Estate</th>
                                        <th>Divisi</th>
                                        <th>Seksi</th>
                                        <th>Blok</th>
                                        <th>Luas (Ha)</th>
                                        <th>TPH</th>
                                        <th>TK Masuk</th>
                                        <th>TK Tdk Masuk</th>
                                        <th>Created</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("rkh")
                                        ->join("t_user","t_user.user_id=rkh.user_id","left")
                                        ->join("tph","tph.tph_id=rkh.tph_id","left")
                                        ->join("blok","blok.blok_id=tph.blok_id","left")
                                        ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
                                        ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
                                        ->join("estate","estate.estate_id=divisi.estate_id","left")
                                        ->where("rkh_rdate >=",$dari)
                                        ->where("rkh_rdate <=",$ke)
                                        ->orderBy("rkh_rdate", "ASC")
                                        ->orderBy("estate_name", "ASC")
                                        ->orderBy("divisi_name", "ASC")
                                        ->orderBy("seksi_name", "ASC")
                                        ->orderBy("blok_name", "ASC")
                                        ->orderBy("tph_name", "ASC")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
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
                                                            isset(session()->get("halaman")['47']['act_update']) 
                                                            && session()->get("halaman")['47']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="rkh_id" value="<?= $usr->rkh_id; ?>" />
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
                                                            isset(session()->get("halaman")['47']['act_delete']) 
                                                            && session()->get("halaman")['47']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="rkh_id" value="<?= $usr->rkh_id; ?>" />
                                                    </form>
                                                    <?php }?>
                                                </td>
                                            <?php } ?>
                                            <td><?= $no++; ?></td>
                                            <td><?= $usr->rkh_rdate; ?></td>
                                            <td><?= $usr->rkh_job; ?></td>
                                            <td><?= $usr->estate_name; ?></td>
                                            <td><?= $usr->divisi_name; ?></td>
                                            <td><?= $usr->seksi_name; ?></td>
                                            <td><?= $usr->blok_name; ?></td>
                                            <td><?= $usr->blok_ha; ?></td>
                                            <td><?= $usr->tph_name; ?></td>
                                            <td><?= $usr->rkh_masuk; ?></td>
                                            <td><?= $usr->rkh_tmasuk; ?></td>
                                            <td><?= $usr->rkh_date; ?></td>
                                            <td><?= $usr->username; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "RKH";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>