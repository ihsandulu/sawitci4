<?php

use PHPUnit\Framework\Constraint\IsNull;

 echo $this->include("template/header_v"); ?>
 <style>
 .merah{background-color: rgba(255, 0, 0, 0.1)!important;}
 .putih{background-color: rgba(255, 255, 255, 0.8)!important;}

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
                                    <th>Estate</th>
                                    <th>Divisi</th>
                                    <th>Seksi</th>
                                    <th>Blok</th>
                                    <th>TPH</th>
                                    <th>SPTBS CARD</th>
                                    <th>WT CARD</th>
                                    <th>TPH CARD</th>
                                    <th>TT</th>
                                    <th>TP</th>
                                    <th>Loading Ramp</th>
                                    <th>Mandor/Checker</th>
                                    <th>B/T</th>
                                    <th>Geolocation</th>
                                    <th>WT Driver</th>
                                    <th>Jml</th>
                                    <th>Bruto</th>
                                    <th>Grading</th>
                                    <th>Netto</th>
                                    <th>BJR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // dd(session()->get("position_id"));
                                $build = $this->db
                                    ->table("restand")
                                    ->select("
                                    restand.panen_date as panen_date,
                                    restand.estate_name as estate_name,
                                    restand.divisi_name as divisi_name,
                                    restand.seksi_name as seksi_name,
                                    restand.blok_name as blok_name,
                                    restand.tph_name as tph_name,
                                    panen.sptbs_card as sptbs_card,
                                    panen.wt_card as wt_card,
                                    restand.panen_card as panen_card,
                                    restand.tph_thntanam as tph_thntanam,
                                    restand.panen_tpname as panen_tpname,
                                    panen.lr_name as lr_name,
                                    restand.user_name as user_name,
                                    restand.panen_brondol as panen_brondol,
                                    restand.panen_geo as panen_geo,
                                    panen.wt_drivername as wt_drivername,
                                    restand.panen_jml as panen_jml,
                                    panen.panen_bruto as panen_bruto,
                                    panen.panen_grading as panen_grading,
                                    panen.panen_netto as panen_netto,
                                    panen.panen_bjr as panen_bjr,
                                    ")
                                    ->join('panen', 'panen.restand_id = restand.restand_id', 'left');

                                $panen = $build
                                    ->where("restand.panen_date >=", $dari)
                                    ->where("restand.panen_date <=", $ke)
                                    ->groupBy("restand.restand_id")
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                foreach ($panen->getResult() as $panen) {
                                    if(is_null($panen->sptbs_card) || $panen->sptbs_card === ''){
                                        $bck="merah";
                                    }else{
                                        $bck="putih";
                                    }
                                ?>
                                    <tr class="<?=$bck;?>">
                                        <td><?= $panen->panen_date; ?></td>
                                        <td><?= $panen->estate_name; ?></td>
                                        <td><?= $panen->divisi_name; ?></td>
                                        <td><?= $panen->seksi_name; ?></td>
                                        <td><?= $panen->blok_name; ?></td>
                                        <td><?= $panen->tph_name; ?></td>
                                        <td><?= $panen->sptbs_card; ?></td>
                                        <td><?= $panen->wt_card; ?></td>
                                        <td><?= $panen->panen_card; ?></td>
                                        <td><?= $panen->tph_thntanam; ?></td>
                                        <td><?= $panen->panen_tpname; ?></td>
                                        <td><?= $panen->lr_name; ?></td>
                                        <td><?= $panen->user_name; ?></td>
                                        <td>
                                            <?php
                                            if ($panen->panen_brondol == 1) {
                                                $bt = "B";
                                            } else {
                                                $bt = "T";
                                            }
                                            echo $bt;
                                            ?>
                                        </td>
                                        <td><?= $panen->panen_geo; ?></td>
                                        <td><?= $panen->wt_drivername; ?></td>
                                        <td><?= number_format($panen->panen_jml, 0, ",", "."); ?></td>
                                        <td><?= number_format($panen->panen_bruto, 0, ",", "."); ?></td>
                                        <td><?= number_format($panen->panen_grading, 0, ",", "."); ?></td>
                                        <td><?= number_format($panen->panen_netto, 0, ",", "."); ?></td>
                                        <td><?= number_format($panen->panen_bjr, 0, ",", "."); ?></td>
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
    var title = "Data Panen";
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
                    title: 'Data Panen',
                    filename: 'Data Panen ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Data Panen',
                    filename: 'Data Panen ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Data Panen Excel',
                    filename: 'Data Panen ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data Panen',
                    filename: 'Data Panen ',
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