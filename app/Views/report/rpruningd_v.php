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
                                $dari = date("Y-m-d");
                                $ke = date("Y-m-d");
                                if (isset($_GET["dari"])) {
                                    $dari = $_GET["dari"];
                                }
                                if (isset($_GET["ke"])) {
                                    $ke = $_GET["ke"];
                                }
                                ?>
                                <div class="col row">
                                    <div class="col-2">
                                        <label class="text-white">Dari :</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" class="form-control" placeholder="Dari" name="dari" value="<?= $dari; ?>">
                                    </div>
                                </div>
                                <div class="col row">
                                    <div class="col-2">
                                        <label class="text-white">Ke :</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" class="form-control" placeholder="Ke" name="ke" value="<?= $ke; ?>">
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
                                    <th>Date</th>
                                    <th><i class="fa fa-camera"></i></th>
                                    <th>Blok</th>
                                    <th>T.Panen</th>
                                    <th>Thn Tanam</th>
                                    <th>Luas(Ha)</th>
                                    <th>SPH</th>
                                    <th>Category</th>
                                    <th>Jml</th>
                                    <th>Geolocation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // dd(session()->get("position_id"));
                                $build = $this->db
                                    ->table("pruning")
                                    // ->select("sptbs.sptbs_code as sptbscode, sptbs.*, panen.*, pruning.*")
                                    ->join("pruningc", "pruningc.pruningc_id=pruning.pruningc_id", "left");

                                $usr = $build
                                    ->where("pruning_date >=", $dari)
                                    ->where("pruning_date <=", $ke)
                                    // ->groupBy("panen.divisi_id,panen.seksi_id,panen.blok_id")
                                    // ->orderBy("panen.blok_name", "ASC")
                                    // ->orderBy("panen.tph_thntanam", "DESC")
                                    ->get();
                                // echo $this->db->getLastquery();
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <td><?= $usr->pruning_date; ?></td>
                                        <td><i class="fa fa-camera tunjuk" onclick="tampilgambar('<?= $usr->pruning_id; ?>');"></i></td>
                                        <td><?= $usr->blok_name; ?></td>
                                        <td><?= $usr->pruning_tpname; ?></td>
                                        <td><?= $usr->pruning_thntanam; ?></td>
                                        <td><?= $usr->pruning_luas; ?></td>
                                        <td><?= $usr->pruning_pokok; ?></td>
                                        <td><?= $usr->pruningc_name; ?></td>
                                        <td><?= $usr->pruning_jml; ?></td>
                                        <td><?= $usr->pruning_geo; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <script>
                            function tampilgambar(id) {
                                $.get("<?= base_url("api/gambarpruning"); ?>", {
                                        id: id
                                    })
                                    .done(function(data) {
                                        if (data != "") {
                                            $("#gambarpruning").hide();
                                            $("#exampleModal").modal("show");
                                            $("#gambarpruning").attr("src", data);
                                            $("#gambarpruning").fadeIn();
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
                                        <img id="gambarpruning" src="<?= base_url("images/picture.png"); ?>" class="gambar" style="width:100%; height:auto;" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.select').select2();
        var title = "Inspeksi Panen Detail";
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
                        title: 'Inspeksi Panen Detail',
                        filename: 'Inspeksi Panen Detail ',
                        text: 'Copy'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Inspeksi Panen Detail',
                        filename: 'Inspeksi Panen Detail ',
                        text: 'Export to CSV'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Inspeksi Panen Detail Excel',
                        filename: 'Inspeksi Panen Detail ',
                        text: 'Export to Excel'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Inspeksi Panen Detail',
                        filename: 'Inspeksi Panen Detail ',
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