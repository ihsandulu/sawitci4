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
                    </div>
                    <div class="">                            
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
                    </div>
                    <?php if ($message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><?= $message; ?></strong>
                        </div>
                    <?php } ?>

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
                                    <th>Estate</th>
                                    <th>Divisi</th>
                                    <th>Card</th>
                                    <th>Vendor</th>
                                    <th>Material</th>
                                    <th>Kecamatan</th>
                                    <th>No. Plat</th>
                                    <th>Driver</th>
                                    <th>List Panen Card</th>
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
                                    ->orderBy("sptbs_id", "ASC")
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
                                                        isset(session()->get("halaman")['55']['act_update']) 
                                                        && session()->get("halaman")['55']['act_update'] == "1"
                                                    )
                                                ) { ?>
                                                <form method="post" class="btn-action" style="">
                                                    <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                    <input type="hidden" name="sptbs_id" value="<?= $usr->sptbs_id; ?>" />
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
                                        <td><?= $usr->estate_name; ?></td>
                                        <td><?= $usr->divisi_name; ?></td>
                                        <td><?= $usr->sptbs_card; ?></td>
                                        <td><?= $usr->nama_vendor; ?></td>
                                        <td><?= $usr->nama_material; ?></td>
                                        <td><?= $usr->kecamatan; ?></td>
                                        <td><?= $usr->no_polisi; ?></td>
                                        <td><?= $usr->nama_driver; ?></td>
                                        <td><?= $usr->sptbs_listcard; ?></td>
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