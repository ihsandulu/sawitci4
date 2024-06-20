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
                                    <th>Tgl</th>
                                    <?php

                                    $arrcolor = array();
                                    $arrdivisi = array();
                                    $divisi = $this->db->table("divisi")
                                        ->where("estate_id<", "7")
                                        ->orderBy("divisi_id", "ASC")->get();
                                    foreach ($divisi->getResult() as $divisi) {
                                        $arrdivisi[] = $divisi->divisi_id;

                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        $a = 0.1;
                                        $arrcolor[$divisi->divisi_id] = "rgba($r, $g, $b, $a)";
                                    ?>
                                        <th style="background-color:<?= $arrcolor[$divisi->divisi_id]; ?>">Bruto <?= $divisi->divisi_name; ?></th>
                                        <th style="background-color:<?= $arrcolor[$divisi->divisi_id]; ?>">Netto <?= $divisi->divisi_name; ?></th>
                                    <?php } ?>
                                    <th>Total Bruto</th>
                                    <th>Total Netto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $build = $this->db
                                    ->table("panen")
                                    ->select("panen.divisi_id, panen.divisi_name, panen.panen_date, panen.panen_jml, panen.panen_bruto, panen.panen_netto");

                                foreach ($arrdivisi as $adivisi) {
                                    $build->select("SUM(IF(panen.divisi_id=$adivisi,panen.panen_bruto,0))AS brutto$adivisi");
                                    $build->select("SUM(IF(panen.divisi_id=$adivisi,panen.panen_netto,0))AS netto$adivisi");
                                }

                                $panen = $build
                                    ->where("panen_date >=", $dari)
                                    ->where("panen_date <=", $ke)
                                    ->groupBy("panen_date")
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                $tbruto = 0;
                                $tnetto = 0;
                                foreach ($panen->getResult() as $panen) {
                                ?>
                                    <tr>
                                        <td><?= date("Y-m-d", strtotime($panen->panen_date)); ?></td>
                                        <?php foreach ($arrdivisi as $adivisi) {
                                            $panen_bruto = "brutto" . $adivisi;
                                            $panen_netto = "netto" . $adivisi;
                                            $pbruto = $panen->$panen_bruto;
                                            $pnetto = $panen->$panen_netto;

                                            $tbruto += $pbruto;
                                            $tnetto += $pnetto;
                                        ?>
                                            <td style="background-color:<?= $arrcolor[$adivisi]; ?>"><?= number_format($pbruto, 0, ",", "."); ?></td>
                                            <td style="background-color:<?= $arrcolor[$adivisi]; ?>"><?= number_format($pnetto, 0, ",", "."); ?></td>
                                        <?php } ?>
                                            <td><?= number_format($tbruto, 0, ",", "."); ?></td>
                                            <td><?= number_format($tnetto, 0, ",", "."); ?></td>
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
    var title = "Monitoring Pertanggal Pengiriman TBS";
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
                    title: 'Monitoring Pertanggal Pengiriman TBS',
                    filename: 'Monitoring Pertanggal Pengiriman TBS ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Monitoring Pertanggal Pengiriman TBS',
                    filename: 'Monitoring Pertanggal Pengiriman TBS ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Monitoring Pertanggal Pengiriman TBS Excel',
                    filename: 'Monitoring Pertanggal Pengiriman TBS ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Monitoring Pertanggal Pengiriman TBS',
                    filename: 'Monitoring Pertanggal Pengiriman TBS ',
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