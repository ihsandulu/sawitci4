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
                                <form action="<?= base_url("anggota"); ?>" method="get" class="col-md-2">
                                    <h1 class="page-header col-md-12">
                                        <button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
                                    </h1>
                                </form>
                            <?php } ?>
                            <form method="post" class="col-md-2">
                                <h1 class="page-header col-md-12">
                                    <button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
                                    <input type="hidden" name="user_id" />
                                </h1>
                            </form>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Anggota";
                                $ketpassword="Kosongkan jika tidak ingin merubah password!";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Anggota";
                                $ketpassword="Jangan dikosongkan!";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data"> 
                                <?php
                                if(
                                    isset(session()->get("position_administrator")[0][0]) 
                                    && (
                                        session()->get("position_administrator") == "1" 
                                        || session()->get("position_administrator") == "2"
                                    )
                                ){?>
                                <div class="form-group">
                                   <label class="control-label col-sm-2" for="user_status">Aktif:</label>
                                   <div class="col-sm-10">
                                       <select required class="form-control" id="user_status" name="user_status">
                                            <option value="0" <?=($user_status=="0")?"selected":"";?>>Non Aktif</option>
                                            <option value="1" <?=($user_status=="1")?"selected":"";?>>Aktif</option>
                                        </select>

                                   </div>
                               </div> 
                               <?php }?> 
                               
                               <div class="form-group">
                                   <label class="control-label col-sm-2" for="user_rt">RT:</label>
                                   <div class="col-sm-10">
                                       <input required type="number" autofocus class="form-control" id="user_rt" name="user_rt" placeholder="" value="<?= $user_rt; ?>">

                                   </div>
                               </div>                                                           
                               
                               <div class="form-group">
                                   <label class="control-label col-sm-2" for="user_rw">RW:</label>
                                   <div class="col-sm-10">
                                       <input required type="number" autofocus class="form-control" id="user_rw" name="user_rw" placeholder="" value="<?= $user_rw; ?>">

                                   </div>
                               </div>                             
                               
                               <div class="form-group">
                                   <label class="control-label col-sm-2" for="user_name">Username:</label>
                                   <div class="col-sm-10">
                                       <input required type="text" autofocus class="form-control" id="user_name" name="user_name" placeholder="" value="<?= $user_name; ?>">

                                   </div>
                               </div>


                               
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_password">Password:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="user_password" name="user_password" placeholder="<?=$ketpassword;?>" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_email">Email:</label>
                                    <div class="col-sm-10">
                                        <input required type="email" autofocus class="form-control" id="user_email" name="user_email" placeholder="" value="<?= $user_email; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_wa">Whatsapp:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="user_wa" name="user_wa" placeholder="" value="<?= $user_wa; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_npwp">NPWP:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="user_npwp" name="user_npwp" placeholder="" value="<?= $user_npwp; ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_address">Alamat:</label>
                                    <div class="col-sm-10">
                                        <input type="text" autofocus class="form-control" id="user_address" name="user_address" placeholder="" value="<?= $user_address; ?>">

                                    </div>
                                </div>


                                
                                <input type="hidden" name="position_id" value="4" />
                                <input type="hidden" name="user_id" value="<?= $user_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("manggota"); ?>">Back</a>
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
                                        <th>No.</th>
                                        <th>Posisi</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        <th>Name</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Whatsapp</th>
                                        <th>NPWP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $usr = $this->db
                                        ->table("user")
                                        ->join("tagihan", "tagihan.user_id = user.user_id", "left")
                                        ->join("position", "position.position_id = user.position_id", "left")
                                        ->where("position.position_id", "4")
                                        ->groupBy("user.user_id")
                                        ->select("user.*, tagihan.*, position.*, user.user_id AS user_id, MIN(tagihan.tagihan_date) AS first_payment_date")
                                        ->orderBy("user.user_id", "desc")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) { 
                                        $aktif=array("bg-danger","");
                                        ?>
                                        <tr class="<?=$aktif[$usr->user_status];?>">
                                            <?php if (!isset($_GET["report"])) { ?>
                                                <td style="padding-left:0px; padding-right:0px;">

                                                    <form method="get" class="btn-action" style="" action="<?= base_url("mtanggungan"); ?>">
                                                        <button class="btn btn-sm btn-primary "><span class="fa fa-users" style="color:white;"></span> </button>
                                                        <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    </form>

                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                        <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    </form>

                                                    <form method="post" class="btn-action" style="">
                                                        <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                        <input type="hidden" name="user_id" value="<?= $usr->user_id; ?>" />
                                                    </form>
                                                </td>
                                            <?php } ?>
                                            <td><?= $no++; ?></td>
                                            <td><?= $usr->position_name; ?></td>
                                            <td><?= $usr->user_rw; ?></td>
                                            <td><?= $usr->user_rt; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                            <td><?= $usr->user_address; ?></td>
                                            <td><?= $usr->user_email; ?></td>
                                            <td><?= $usr->user_wa; ?></td>
                                            <td><?= $usr->user_npwp; ?></td>
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
    var title = "Master Anggota";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>