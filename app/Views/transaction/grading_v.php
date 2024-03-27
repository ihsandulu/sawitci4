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
                                    isset(session()->get("halaman")['50']['act_create']) 
                                    && session()->get("halaman")['50']['act_create'] == "1"
                                )
                            ) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="grading_id" />
                                </h1>
                            </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Grading";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Grading";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">     
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="sptbs_card">SPTBS:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $sptbs = $this->db->table("sptbs")
                                            ->orderBy("sptbs_card", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select required class="form-control select" id="sptbs_card" name="sptbs_card">
                                            <option value="" <?= ($sptbs_card == "") ? "selected" : ""; ?>>Pilih SPTBS</option>
                                            <?php
                                            foreach ($sptbs->getResult() as $sptbs) { ?>
                                                <option value="<?= $sptbs->sptbs_card; ?>" <?= ($sptbs_card == $sptbs->sptbs_card) ? "selected" : ""; ?>><?= $sptbs->sptbs_card; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>                                                    
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="grading_tp">Tenaga Panen:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $user = $this->db->table("t_user")
                                            ->orderBy("nama", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select onchange="tp()" required class="form-control select" id="grading_tp" name="grading_tp">
                                            <option value="" <?= ($grading_tp == "") ? "selected" : ""; ?>>Pilih Tenaga Panen</option>
                                            <?php
                                            foreach ($user->getResult() as $user) { ?>
                                                <option grading_tpname="<?= $user->nama; ?>" value="<?= $user->user_id; ?>" <?= ($grading_tp == $user->user_id) ? "selected" : ""; ?>><?= $user->username; ?></option>
                                            <?php } ?>
                                        </select>                                        
                                        <input type="hidden" id="grading_tpname" name="grading_tpname" value="<?= $grading_tpname; ?>" />
                                        <script>
                                            function tp(){            
                                                let grading_tpname = $("#grading_tp").find(':selected').attr('grading_tpname');
                                                $("#grading_tpname").val(grading_tpname);
                                            }
                                        </script>
                                    </div>
                                </div>                                                     
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="gradingtype_id">Grading Type:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $user = $this->db->table("gradingtype")
                                            ->orderBy("gradingtype_name", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select onchange="gtype()" required class="form-control select" id="gradingtype_id" name="gradingtype_id">
                                            <option value="" <?= ($gradingtype_id == "") ? "selected" : ""; ?>>Pilih Grading Type</option>
                                            <?php
                                            foreach ($user->getResult() as $user) { ?>
                                                <option gradingtype_name="<?= $user->gradingtype_name; ?>" value="<?= $user->gradingtype_id; ?>" <?= ($gradingtype_id == $user->gradingtype_id) ? "selected" : ""; ?>><?= $user->gradingtype_name; ?></option>
                                            <?php } ?>
                                        </select>                                        
                                        <input type="hidden" id="gradingtype_name" name="gradingtype_name" value="<?= $gradingtype_name; ?>" />
                                        <script>
                                            function gtype(){            
                                                let gradingtype_name = $("#gradingtype_id").find(':selected').attr('gradingtype_name');
                                                $("#gradingtype_name").val(gradingtype_name);
                                            }
                                        </script>
                                    </div>
                                </div>                                                
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="grading_qty">Jumlah:</label>
                                    <div class="col-sm-10">
                                        <input required type="number" autofocus class="form-control" id="grading_qty" name="grading_qty" placeholder="" value="<?= $grading_qty; ?>">
                                    </div>
                                </div>  

                                <input type="hidden" name="grading_id" value="<?= $grading_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("grading"); ?>">Back</a>
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

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <th>Date</th>
                                        <th>SPTBS</th>
                                        <th>Tenaga Panen</th>
                                        <th>Tipe Grading</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("grading")
                                        ->orderBy("grading_id", "DESC")
                                        ->get();
                                    // echo $this->db->getLastquery();
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
                                                            isset(session()->get("halaman")['50']['act_update']) 
                                                            && session()->get("halaman")['50']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="grading_id" value="<?= $usr->grading_id; ?>" />
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
                                                        <input type="hidden" name="grading_id" value="<?= $usr->grading_id; ?>" />
                                                    </form>
                                                    <?php }?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td><?= $usr->grading_date; ?></td>
                                            <td><?= $usr->sptbs_card; ?></td>
                                            <td><?= $usr->grading_tpname; ?></td>
                                            <td><?= $usr->gradingtype_name; ?></td>
                                            <td><?= $usr->grading_qty; ?></td>
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
    var title = "Master Grading";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>