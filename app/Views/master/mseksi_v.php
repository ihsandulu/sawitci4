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
                                    isset(session()->get("halaman")['53']['act_create']) 
                                    && session()->get("halaman")['53']['act_create'] == "1"
                                )
                            ) { ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="seksi_id" />
                                </h1>
                            </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Seksi";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Seksi";
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
                                        <select required class="form-control select" id="divisi_id" name="divisi_id">
                                            
                                        </select>
                                        <script>
                                            function divisi(){
                                                let estate_id = $("#estate_id").val();
                                                let divisi_id = "<?=$divisi_id;?>";
                                                $.get("<?=base_url("api/divisi");?>",{estate_id:estate_id,divisi_id:divisi_id})
                                                .done(function(data){
                                                    $("#divisi_id").html(data);
                                                });
                                            }
                                            divisi();
                                        </script>
                                    </div>
                                </div>                                                
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="seksi_name">Nama Seksi:</label>
                                    <div class="col-sm-10">
                                        <input required type="text" autofocus class="form-control" id="seksi_name" name="seksi_name" placeholder="" value="<?= $seksi_name; ?>">
                                    </div>
                                </div>  

                                <input type="hidden" name="seksi_id" value="<?= $seksi_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("mseksi"); ?>">Back</a>
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
                            <table id="table1" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <th>ID</th>
                                        <th>Estate</th>
                                        <th>Divisi</th>
                                        <th>Seksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("seksi")
                                        ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
                                        ->join("estate","estate.estate_id=divisi.estate_id","left")
                                        // ->orderBy("estate_name", "ASC")
                                        // ->orderBy("divisi_name", "ASC")
                                        // ->orderBy("seksi_name", "ASC")
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
                                                            isset(session()->get("halaman")['53']['act_update']) 
                                                            && session()->get("halaman")['53']['act_update'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="seksi_id" value="<?= $usr->seksi_id; ?>" />
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
                                                            isset(session()->get("halaman")['53']['act_delete']) 
                                                            && session()->get("halaman")['53']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="seksi_id" value="<?= $usr->seksi_id; ?>" />
                                                    </form>
                                                    <?php }?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td><?= $usr->seksi_id; ?></td>
                                            <td><?= $usr->estate_name; ?></td>
                                            <td><?= $usr->divisi_name; ?></td>
                                            <td><?= $usr->seksi_name; ?></td>
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
    var title = "Master Seksi";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
    $(document).ready(function() {
        $('#table1').DataTable({
            "order": [
                [1, 'asc'], // Estate Name
                [2, 'asc'], // Divisi Name
                [3, 'asc', 'num']  // Seksi Name (numeric)
            ],
            "pageLength": 50 
        });
    });
</script>

<?php echo  $this->include("template/footer_v"); ?>