<?php echo $this->include("template/header_v"); ?>
<style>
    .merah {
        background-color: rgba(255, 0, 0, 0.1);
    }

    .hijau {
        background-color: rgba(0, 255, 0, 0.1);
    }

    .putih {
        background-color: rgba(255, 255, 255, 0.1);
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
                                $bln = date("m");
                                if (isset($_GET["bln"])) {
                                    $bln = $_GET["bln"];
                                }
                                ?>
                                <div class="col row">
                                    <div class="col-2">
                                        <label class="text-white">Bulan :</label>
                                    </div>
                                    <div class="col-10">
                                        <select class="form-control" name="bln">
                                            <?php
                                            for ($y = 1; $y <= 12; $y++) { ?>
                                                <option value="<?= $y; ?>" <?= ($bln == $y) ? "selected" : ""; ?>><?= date("F", strtotime(date("Y-" . $y))); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if (isset($_GET["report"])) { ?>
                                    <input type="hidden" name="report" value="OK" />
                                <?php } ?>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                    <?php
                    $targetMonth = 6;
                    $targetYear = 2024;

                    $startDate = new DateTime("$targetYear-$targetMonth-01");
                    $startDate->modify('-1 month');

                    $endDate = new DateTime("$targetYear-$targetMonth-01");
                    $endDate->modify('last day of this month');

                    $interval = new DateInterval('P1D');
                    $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));
                    $arrtgl = array();
                    $arrrestand = array();
                    $arrpanen = array();
                    foreach ($dateRange as $date) {
                        $md = $date->format('m-d');
                        $arrtgl[$md] = 0;
                        $arrrestand[$md] = 0;
                        $arrpanen[$md] = 0;
                    }
                    ?>
                    <div class="table-responsive m-t-40">
                        <table id="example2310" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <th>Estate</th>
                                    <th>Divisi</th>
                                    <th>Seksi</th>
                                    <th>Blok</th>
                                    <th>TPH</th>
                                    <th>Hektar</th>
                                    <th>Pokok</th>
                                    <th>TT</th>
                                    <?php
                                    $ybulan = date("Y-m", strtotime(date("Y-" . $bln)));
                                    $date = new DateTime($ybulan . "-01");
                                    $dmonth = $date->format('t');
                                    for ($x = 1; $x <= $dmonth; $x++) {
                                    ?>
                                        <th><?= $x; ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $arrgabungan = [];
                                // Query untuk tabel restand
                                $restandQuery = $this->db
                                    ->table("restand")
                                    ->select("
                                        restand.panen_date,
                                        restand.estate_name, 
                                        restand.divisi_name, 
                                        restand.seksi_name, 
                                        restand.blok_name, 
                                        restand.tph_name, 
                                        restand.tph_id, 
                                        blok.blok_ha, 
                                        blok.blok_populasi, 
                                        restand.tph_thntanam
                                    ")
                                    ->join("blok", "blok.blok_id=restand.blok_id", "left")
                                    ->where("SUBSTRING(panen_date,1,7)",  $ybulan)
                                    ->get();
                                $arrrestand = [];
                                foreach ($restandQuery->getResult() as $row) {
                                    $arrrestand[$row->tph_id]["panen_date"] = $row->panen_date;
                                    $arrrestand[$row->tph_id]["tph_id"] = $row->tph_id;
                                    $arrrestand[$row->tph_id]["tph_name"] = $row->tph_name;
                                    $arrgabungan[$row->tph_id]["tph_id"] = $row->tph_id;
                                    $arrgabungan[$row->tph_id]["estate_name"] = $row->estate_name;
                                    $arrgabungan[$row->tph_id]["divisi_name"] = $row->divisi_name;
                                    $arrgabungan[$row->tph_id]["seksi_name"] = $row->seksi_name;
                                    $arrgabungan[$row->tph_id]["blok_name"] = $row->blok_name;
                                    $arrgabungan[$row->tph_id]["tph_name"] = $row->tph_name;
                                    $arrgabungan[$row->tph_id]["blok_ha"] = $row->blok_ha;
                                    $arrgabungan[$row->tph_id]["blok_populasi"] = $row->blok_populasi;
                                    $arrgabungan[$row->tph_id]["tph_thntanam"] = $row->tph_thntanam;
                                }
                                // Query untuk tabel panen
                                $panenQuery = $this->db
                                    ->table("panen")
                                    ->select("
                                        panen.panen_date,
                                        panen.estate_name, 
                                        panen.divisi_name, 
                                        panen.seksi_name, 
                                        panen.blok_name, 
                                        panen.tph_name, 
                                        panen.tph_id, 
                                        blok.blok_ha, 
                                        blok.blok_populasi, 
                                        panen.tph_thntanam
                                    ")
                                    ->join("blok", "blok.blok_id=panen.blok_id", "left")
                                    ->where("SUBSTRING(panen_date,1,7)",  $ybulan)
                                    ->get();
                                // echo $this->db->getLastQuery();
                                $arrpanen = [];
                                foreach ($panenQuery->getResult() as $row) {
                                    $arrpanen[$row->tph_id]["panen_date"] = $row->panen_date;
                                    $arrpanen[$row->tph_id]["tph_id"] = $row->tph_id;
                                    $arrpanen[$row->tph_id]["tph_name"] = $row->tph_name;
                                    $arrgabungan[$row->tph_id]["tph_id"] = $row->tph_id;
                                    $arrgabungan[$row->tph_id]["estate_name"] = $row->estate_name;
                                    $arrgabungan[$row->tph_id]["divisi_name"] = $row->divisi_name;
                                    $arrgabungan[$row->tph_id]["seksi_name"] = $row->seksi_name;
                                    $arrgabungan[$row->tph_id]["blok_name"] = $row->blok_name;
                                    $arrgabungan[$row->tph_id]["tph_name"] = $row->tph_name;
                                    $arrgabungan[$row->tph_id]["blok_ha"] = $row->blok_ha;
                                    $arrgabungan[$row->tph_id]["blok_populasi"] = $row->blok_populasi;
                                    $arrgabungan[$row->tph_id]["tph_thntanam"] = $row->tph_thntanam;
                                }

                                
                                foreach ($arrgabungan as $a => $b) {
                                    $mulai=0;
                                ?>
                                    <tr>
                                        <th><?= $b["estate_name"]; ?></th>
                                        <th><?= $b["divisi_name"]; ?></th>
                                        <th><?= $b["seksi_name"]; ?></th>
                                        <th><?= $b["blok_name"]; ?></th>
                                        <th><?= $b["tph_name"]; ?></th>
                                        <th><?= $b["blok_ha"]; ?></th>
                                        <th><?= $b["blok_populasi"]; ?></th>
                                        <th><?= $b["tph_thntanam"]; ?></th>
                                        <?php
                                        $date = new DateTime($ybulan . "-01");
                                        $dmonth = $date->format('t');
                                        $bpanen = false;
                                        $brestand = false;
                                        $angka = 0;
                                        $bwarna = "putih";
                                        for ($x = 1; $x <= $dmonth; $x++) {
                                            $cmd = date("Y-m-d", strtotime(date("Y-" . $bln . "-" . $x)));
                                            $tph_id = $b["tph_id"];


                                            if (isset($arrpanen[$tph_id]) && $arrpanen[$tph_id]["tph_id"] == $tph_id && $arrpanen[$tph_id]["panen_date"] == $cmd) {
                                                $bpanen = true;
                                                if($mulai==0){$mulai=$x;}
                                            } else {
                                                $bpanen = false;
                                            }

                                            if (isset($arrrestand[$tph_id]) && $arrrestand[$tph_id]["tph_id"] == $tph_id && $arrrestand[$tph_id]["panen_date"] == $cmd) {
                                                $brestand = true;
                                                if($mulai==0){$mulai=$x;}
                                            } else {
                                                $brestand = false;
                                            }

                                            
                                            if(date("Y-m-d")<$cmd){$bwarna = "putih";}
                                            if ($bpanen == true && $brestand == true) {
                                                $angka = 1;
                                                $bwarna = "hijau";
                                            } else  if ($bpanen == false && $brestand == true) {
                                                $angka = 1;
                                                $bwarna = "merah";
                                            } else  if ($bpanen == true && $brestand == false) {
                                                $angka++;
                                                $bwarna = "hijau";
                                            } else {
                                                if ($angka > 0) {
                                                    $angka++;
                                                }
                                                if ($bwarna == "hijau") {
                                                    $bwarna = "putih";
                                                }
                                            }


                                            // echo $bpanen . "==" . $brestand . "<br/>";
                                            // echo $angka . "==" . $bwarna;

                                            //echo $md . "=>" . $md1; 
                                        ?>
                                            <th class="<?= $bwarna; ?>">
                                                <?=($angka>0)?$angka:""; ?>
                                            </th>
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
    var title = "Rencana dan Realisasi Produksi";
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
                    title: 'Rencana dan Realisasi Produksi',
                    filename: 'Rencana dan Realisasi Produksi ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Rencana dan Realisasi Produksi',
                    filename: 'Rencana dan Realisasi Produksi ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Rencana dan Realisasi Produksi Excel',
                    filename: 'Rencana dan Realisasi Produksi ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Rencana dan Realisasi Produksi',
                    filename: 'Rencana dan Realisasi Produksi ',
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