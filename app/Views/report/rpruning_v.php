<?php echo $this->include("template/header_v"); ?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 10px;
        text-align: center;
    }
    .vertical-text {
        position: relative;
        height: 200px; /* Sesuaikan sesuai kebutuhan */
        width: 30px; /* Sesuaikan sesuai kebutuhan */
        padding: 0;
        vertical-align: bottom;
    }
    .vertical-text span {
        transform: rotate(90deg);
        white-space: nowrap;
        position: absolute;
        top: 10px;
        left: 75%;
        transform-origin: left top;
        margin-left: 0;
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
                                    <th>Blok</th>
                                    <th>Thn Tanam</th>
                                    <th>Luas(Ha)</th>
                                    <th>SPH</th>
                                    <?php
                                    $pruningc = $this->db->table("pruningc")->orderBy("pruningc_id", "ASC")->get();
                                    foreach ($pruningc->getResult() as $pruningc) { ?>
                                        <th class="vertical-text"><span><?= $pruningc->pruningc_name; ?></span></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("pruning")
                                    ->select("pruning_date, blok_id, pruningc_id, SUM(pruning_jml) AS sjml")
                                    ->where("pruning_date >=", $dari)
                                    ->where("pruning_date <=", $ke)
                                    ->groupBy("pruning_date, blok_id, pruning.pruningc_id")
                                    ->get();
                                $array = [];
                                foreach ($build->getResult() as $row) {
                                    $array[$row->pruning_date][$row->blok_id][$row->pruningc_id] = $row->sjml;
                                }

                                $usr = $this->db
                                    ->table("pruning")
                                    ->select("SUM(pruning_pokok)AS jpokok, pruning.*")
                                    ->where("pruning_date >=", $dari)
                                    ->where("pruning_date <=", $ke)
                                    ->groupBy("pruning_date,blok_id")
                                    ->orderBy("pruning.pruning_date", "ASC")
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <td><?= $usr->pruning_date; ?></td>
                                        <td><?= $usr->blok_name; ?></td>
                                        <td><?= $usr->pruning_thntanam; ?></td>
                                        <td><?= $usr->pruning_luas; ?></td>
                                        <td><?= $usr->jpokok; ?></td>
                                        <?php
                                        $pruningc = $this->db->table("pruningc")->orderBy("pruningc_id", "ASC")->get();
                                        foreach ($pruningc->getResult() as $pruningc) { ?>
                                            <th><?php
                                                if (isset($array[$usr->pruning_date][$usr->blok_id][$pruningc->pruningc_id])) {
                                                    echo $array[$usr->pruning_date][$usr->blok_id][$pruningc->pruningc_id];
                                                } else {
                                                    echo '-'; // Atau nilai default jika tidak ada data
                                                }
                                                ?></th>
                                        <?php } ?>
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
    var title = "Inspeksi Panen";
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
                    title: 'Inspeksi Panen',
                    filename: 'Inspeksi Panen ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Inspeksi Panen',
                    filename: 'Inspeksi Panen ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Inspeksi Panen Excel',
                    filename: 'Inspeksi Panen ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Inspeksi Panen',
                    filename: 'Inspeksi Panen ',
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