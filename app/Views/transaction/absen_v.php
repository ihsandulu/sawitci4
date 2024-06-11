<?php echo $this->include("template/header_v"); ?>
<style>
    .modal-content {
        background-color: transparent;
        /* Membuat latar belakang modal menjadi transparan */
        border: none;
    }

    .modal-body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        /* Mengatur tinggi modal menjadi 80% tinggi layar */
    }

    .modal-body .gambar {
        max-height: 100%;
        /* Membuat gambar tidak melebihi tinggi modal */
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
                                        <input type="hidden" name="absen_id" />
                                    </h1>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update Absensi";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah Absensi";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_type">Type:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control select" id="absen_type" name="absen_type">
                                            <option value="" <?= ($absen_type == "") ? "selected" : ""; ?>>Pilih Type</option>
                                            <option value="Masuk" <?= ($absen_type == "Masuk") ? "selected" : ""; ?>>Masuk</option>
                                            <option value="Keluar" <?= ($absen_type == "Keluar") ? "selected" : ""; ?>>Keluar</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_datetime">Date Time:</label>
                                    <div class="col-sm-10">
                                        <input onchange="rdate()" required type="datetime-local" autofocus class="form-control" id="absen_datetime" name="absen_datetime" placeholder="" value="<?= $absen_datetime; ?>">

                                        <input type="hidden" id="absen_date" name="absen_date" value="<?= $absen_date; ?>" />
                                        <input type="hidden" id="absen_time" name="absen_time" value="<?= $absen_time; ?>" />
                                        <script>
                                            function rdate() {
                                                let datetime = $("#absen_datetime").val();
                                                // Memisahkan tanggal dan waktu
                                                var parts = datetime.split(" ");
                                                var tanggal = parts[0];
                                                var waktu = parts[1];
                                                $("#absen_date").val(tanggal);
                                                $("#absen_time").val(waktu);
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_geo">Geolocation:</label>
                                    <div class="col-sm-10">
                                        <input required type="text" autofocus class="form-control" id="absen_geo" name="absen_geo" placeholder="" value="<?= $absen_geo; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="absen_tp">Name:</label>
                                    <div class="col-sm-10">
                                        <?php
                                        $user = $this->db
                                            ->table("placement")
                                            ->join("t_user", "t_user.user_id=placement.user_id", "left")
                                            ->join("estate", "estate.estate_id=placement.estate_id", "left")
                                            ->join("divisi", "divisi.divisi_id=placement.divisi_id", "left")
                                            ->join("position", "position.position_id=placement.position_id", "left")
                                            // ->where("placement.position_id","4")
                                            ->like("position.position_name", "checker", "BOTH")
                                            ->orLike("position.position_name", "mandor", "BOTH")
                                            ->orLike("position.position_name", "tenaga panen", "BOTH")
                                            ->orderBy("t_user.nama", "ASC")
                                            ->get();
                                        //echo $this->db->getLastQuery();
                                        ?>
                                        <select onchange="tp()" required class="form-control select" id="absen_user" name="absen_user">
                                            <option value="" <?= ($absen_user == "") ? "selected" : ""; ?>>Pilih User</option>
                                            <?php
                                            foreach ($user->getResult() as $user) { ?>
                                                <option estate_id="<?= $user->estate_id; ?>" estate_name="<?= $user->estate_name; ?>" divisi_id="<?= $user->divisi_id; ?>" divisi_name="<?= $user->divisi_name; ?>" absen_username="<?= $user->nama; ?>" value="<?= $user->user_id; ?>" <?= ($absen_user == $user->user_id) ? "selected" : ""; ?>><?= $user->placement_name; ?> - <?= $user->nama; ?> (<?= $user->user_nik; ?>)</option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" id="estate_id" name="estate_id" value="<?= $estate_id; ?>" />
                                        <input type="hidden" id="estate_name" name="estate_name" value="<?= $estate_name; ?>" />
                                        <input type="hidden" id="divisi_id" name="divisi_id" value="<?= $divisi_id; ?>" />
                                        <input type="hidden" id="divisi_name" name="divisi_name" value="<?= $divisi_name; ?>" />
                                        <input type="hidden" id="absen_username" name="absen_username" value="<?= $absen_username; ?>" />
                                        <script>
                                            function tp() {
                                                let estate_id = $("#absen_user").find(':selected').attr('estate_id');
                                                $("#estate_id").val(estate_id);


                                                let estate_name = $("#absen_user").find(':selected').attr('estate_name');
                                                $("#estate_name").val(estate_name);


                                                let divisi_id = $("#absen_user").find(':selected').attr('divisi_id');
                                                $("#divisi_id").val(divisi_id);


                                                let divisi_name = $("#absen_user").find(':selected').attr('divisi_name');
                                                $("#divisi_name").val(divisi_name);


                                                let absen_username = $("#absen_user").find(':selected').attr('absen_username');
                                                $("#absen_username").val(absen_username);
                                            }
                                        </script>
                                    </div>
                                </div>

                                <input type="hidden" name="absen_id" value="<?= $absen_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("absen"); ?>">Back</a>
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
                        <div class="alert alert-dark">
                            <form>
                                <div class="row">
                                    <?php
                                    $dari = date("Y-m-d");
                                    $ke = date("Y-m-d");
                                    $estate = "";
                                    $divisi = "";
                                    if (isset($_GET["dari"])) {
                                        $dari = $_GET["dari"];
                                    }
                                    if (isset($_GET["ke"])) {
                                        $ke = $_GET["ke"];
                                    }
                                    if (isset($_GET["estate"])) {
                                        $estate = $_GET["estate"];
                                    }
                                    if (isset($_GET["divisi"])) {
                                        $divisi = $_GET["divisi"];
                                    }
                                    ?>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Estate</label>
                                        </div>
                                        <div class="col-9">
                                            <select onChange="divisid()" class="form-control" id="estate" name="estate">
                                                <option value="" <?= ($estate == "") ? "selected" : ""; ?>>
                                                    Semua Estate
                                                </option>
                                                <?php
                                                $estated = $this->db->table("estate")->get();
                                                foreach ($estated->getResult() as $estated) { ?>
                                                    <option value="<?= $estated->estate_id; ?>" <?= ($estated->estate_id == $estate) ? "selected" : ""; ?>>
                                                        <?= $estated->estate_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <script>
                                                function divisid() {
                                                    let estaten = $("#estate").val();
                                                    let divisin = '<?= $divisi; ?>';
                                                    $.get("<?= base_url("api/divisi"); ?>", {
                                                            estate_id: estaten,
                                                            divisi_id: divisin
                                                        })
                                                        .done(function(data) {
                                                            $("#divisi").html(data);
                                                        });
                                                }
                                                divisid();
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Divisi</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" id="divisi" name="divisi">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">

                                        </div>
                                        <div class="col-9">

                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Dari :</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark">Ke :</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4 row mb-2">
                                        <div class="col-3">
                                            <label class="text-dark"></label>
                                        </div>
                                        <div class="col-9">
                                            <button type="submit" class="btn btn-block btn-primary">Cari</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <?php if (!isset($_GET["report"])) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                        <!-- <th>No.</th> -->
                                        <th>Picture</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Type</th>
                                        <th>Note</th>
                                        <th>Estate</th>
                                        <th>Divisi</th>
                                        <th>Name</th>
                                        <th>Geolocation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $build = $this->db
                                        ->table("absen")
                                        ->select("estate_id,divisi_id,absen_type,absen_note,absen_date,absen_time,estate_name,divisi_name,absen_username,absen_geo,absen_id")
                                        ->where("absen_date >=", $dari)
                                        ->where("absen_date <=", $ke);
                                    if ($estate > 0) {
                                        $build->where("estate_id", $estate);
                                    }
                                    if ($divisi > 0) {
                                        $build->where("divisi_id", $divisi);
                                    }
                                    $usr = $build->orderBy("absen_date", "ASC")
                                        ->orderBy("absen_time", "ASC")
                                        ->orderBy("estate_name", "ASC")
                                        ->orderBy("divisi_name", "ASC")
                                        ->orderBy("absen_username", "ASC")
                                        ->orderBy("absen_geo", "ASC")
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
                                                            <input type="hidden" name="absen_id" value="<?= $usr->absen_id; ?>" />
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
                                                            isset(session()->get("halaman")['50']['act_delete'])
                                                            && session()->get("halaman")['50']['act_delete'] == "1"
                                                        )
                                                    ) { ?>
                                                        <form method="post" class="btn-action" style="">
                                                            <button class="btn btn-sm btn-danger delete" onclick="return confirm(' you want to delete?');" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="absen_id" value="<?= $usr->absen_id; ?>" />
                                                        </form>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                            <!-- <td><?= $no++; ?></td> -->
                                            <td><i class="fa fa-camera tunjuk" onclick="tampilgambar('<?= $usr->absen_id; ?>');"></i></td>
                                            <td><?= $usr->absen_date; ?></td>
                                            <td><?= $usr->absen_time; ?></td>
                                            <td><?= $usr->absen_type; ?></td>
                                            <td><?= $usr->absen_note; ?></td>
                                            <td><?= $usr->estate_name; ?></td>
                                            <td><?= $usr->divisi_name; ?></td>
                                            <td><?= $usr->absen_username; ?></td>
                                            <td><?= $usr->absen_geo; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <script>
                                function tampilgambar(id) {
                                    $.get("<?= base_url("api/gambarabsen"); ?>", {
                                            id: id
                                        })
                                        .done(function(data) {
                                            if (data != "") {
                                                $("#gambarabsen").hide();
                                                $("#exampleModal").modal("show");
                                                $("#gambarabsen").attr("src", data);
                                                $("#gambarabsen").fadeIn();
                                            } else {
                                                toast("Loading Gambar", "Maaf, tidak ada gambar!");
                                            }
                                        });
                                }
                            </script>
                            <!-- Picture -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img id="gambarabsen" src="<?= base_url("images/picture.png"); ?>" class="gambar" style="width:100%; height:auto;" />
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
        var title = "Absensi";
        $("title").text(title);
        $(".card-title").text(title);
        $("#page-title").text(title);
        $("#page-title-link").text(title);
    </script>

    <?php echo  $this->include("template/footer_v"); ?>