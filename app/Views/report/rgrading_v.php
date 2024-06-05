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
                                        <input type="date" class="form-control" placeholder="Dari" name="dari"
                                            value="<?= $dari; ?>">
                                    </div>
                                </div>
                                <div class="col row">
                                    <div class="col-2">
                                        <label class="text-white">Ke :</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="date" class="form-control" placeholder="Ke" name="ke"
                                            value="<?= $ke; ?>">
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
                        <table id="example2310" class="display nowrap table table-hover table-striped table-bordered"
                            cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <th>No. Tiket</th>
                                    <th>ID</th>
                                    <th>Vendor Name</th>
                                    <th>Area</th>
                                    <th>Tanggal</th>
                                    <th>IN</th>
                                    <th>OUT</th>
                                    <th>Blok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // dd(session()->get("position_id"));
                                $build = $this->db
                                    ->table("grading")
                                    ->select("t_vendor.nama_vendor,t_vendor.ket,lr.lr_name,sptbs.sptbs_code as sptbscode, panen.blok_name")
                                    ->join("sptbs", "sptbs.sptbs_date=grading.grading_date AND sptbs.sptbs_card=grading.sptbs_card", "left")
                                    ->join("wt", "wt.wt_name=sptbs.wt_name", "left")
                                    ->join("lr", "lr.lr_name=sptbs.lr_name", "left")
                                    ->join("t_vendor", "t_vendor.ID_vendor=sptbs.sptbs_vendor", "left")
                                    ->join("panen", "panen.sptbs_id=sptbs.sptbs_id", "left");

                                $usr = $build
                                    ->where("grading_date >=",$dari)
                                    ->where("grading_date <=",$ke)
                                    // ->groupBy("panen.divisi_id,panen.seksi_id,panen.blok_id")
                                    // ->orderBy("panen.blok_name", "ASC")
                                    // ->orderBy("panen.tph_thntanam", "DESC")
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                foreach ($usr->getResult() as $usr) { ?>
                                    <tr>
                                        <td><?= $usr->sptbscode; ?></td>
                                        <td><?= (isset($usr->nama_vendor))?$usr->nama_vendor:$usr->divisi_name; ?></td>
                                        <td><?= (isset($usr->ket))?$usr->ket:$usr->estate_name." ".$usr->divisi_name; ?></td>
                                        <td><?= $usr->lr_name; ?></td>
                                        <td><?= $usr->sptbs_date; ?></td>
                                        <td><?= $usr->sptbs_timbanganmasuk; ?></td>
                                        <td><?= $usr->sptbs_timbangankeluar; ?></td>
                                        <td><?= $usr->blok_name; ?></td>
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
    var title = "Data Grading";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo $this->include("template/footer_v"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#example2310').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: 'Data Grading',
                    filename: 'Data Grading ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Data Grading',
                    filename: 'Data Grading ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Data Grading Excel',
                    filename: 'Data Grading ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data Grading',
                    filename: 'Data Grading ',
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