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
                                $thn = date("Y");
                                if (isset($_GET["thn"])) {
                                    $thn = $_GET["thn"];
                                }
                                ?>
                                <div class="col row">
                                    <div class="col-2">
                                        <label class="text-white">Tahun :</label>
                                    </div>
                                    <div class="col-10">
                                        <select class="form-control" name="thn">
                                            <?php
                                            for ($y = 2010; $y <= date("Y"); $y++) { ?>
                                                <option value="<?= $y; ?>" <?=($thn==$y)?"selected":"";?>><?= $y; ?></option>
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
                    <div class="table-responsive m-t-40">
                        <table id="example2310" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                            <thead class="">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Estate</th>
                                    <th>Divisi</th>
                                    <th>Thn Tnm</th>
                                    <th>Hektar</th>
                                    <th>Pokok</th>
                                    <th>SPH</th>
                                    <?php 
                                    $pastelColors = [
                                        "",
                                        "rgba(255, 182, 193, 0.5)", // Pastel Red
                                        "rgba(255, 160, 122, 0.5)", // Pastel Orange
                                        "rgba(255, 255, 224, 0.5)", // Pastel Yellow
                                        "rgba(144, 238, 144, 0.5)", // Pastel Green
                                        "rgba(173, 216, 230, 0.5)", // Pastel Blue
                                        "rgba(221, 160, 221, 0.5)", // Pastel Purple
                                        "rgba(255, 182, 193, 0.5)", // Pastel Pink
                                        "rgba(222, 184, 135, 0.5)", // Pastel Brown
                                        "rgba(211, 211, 211, 0.5)", // Pastel Gray
                                        "rgba(175, 238, 238, 0.5)", // Pastel Turquoise
                                        "rgba(230, 230, 250, 0.5)", // Pastel Lavender
                                        "rgba(152, 251, 152, 0.5)"  // Pastel Mint
                                    ];
                                    $pColors = [
                                        "",
                                        "black", // Pastel Red
                                        "black", // Pastel Orange
                                        "black", // Pastel Yellow
                                        "black", // Pastel Green
                                        "black", // Pastel Blue
                                        "black", // Pastel Purple
                                        "black", // Pastel Pink
                                        "black", // Pastel Brown
                                        "black", // Pastel Gray
                                        "black", // Pastel Turquoise
                                        "black", // Pastel Lavender
                                        "black" // Pastel Mint
                                    ];
                                    for ($x = 1; $x <= 12; $x++) { ?>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>; color:<?=$pColors[$x];?>;">JJG Bruto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">JJG KG Bruto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Brondol Bruto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Total Bruto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">BJR Bruto <?= date("N"); ?></th>

                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">JJG Netto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">JJG KG Netto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Brondol Netto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Total Netto <?= date("N"); ?></th>
                                        <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">BJR Netto <?= date("N"); ?></th>
                                    <?php } ?>

                                    <th>Total JJG Bruto</th>
                                    <th>Total JJG KG Bruto</th>
                                    <th>Total Brondol Bruto</th>
                                    <th>Total Bruto</th>
                                    <th>Total BJR Bruto</th>

                                    <th>Total JJG Netto</th>
                                    <th>Total JJG KG Netto</th>
                                    <th>Total Brondol Netto</th>
                                    <th>Total Netto</th>
                                    <th>Total BJR Netto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $kerja = $this->db
                                    ->table("panen")
                                    ->where("SUBSTRING(panen_date,1,4)", $thn)
                                    ->groupBy("panen.divisi_id, panen.tph_thntanam")
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                foreach ($kerja->getResult() as $kerja) {
                                ?>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Estate</th>
                                        <th>Divisi</th>
                                        <th>Thn Tnm</th>
                                        <th>Hektar</th>
                                        <th>Pokok</th>
                                        <th>SPH</th>
                                        <?php 
                                        for ($x = 1; $x <= 12; $x++) { ?>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">JJG Bruto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">JJG KG Bruto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Brondol Bruto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Total Bruto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">BJR Bruto <?= date("N"); ?></th>
    
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">JJG Netto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">JJG KG Netto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Brondol Netto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">Total Netto <?= date("N"); ?></th>
                                            <th style="background-color:<?=$pastelColors[$x];?>; color:<?=$pColors[$x];?>;>">BJR Netto <?= date("N"); ?></th>
                                        <?php } ?>

                                        <th>Total JJG Bruto</th>
                                        <th>Total JJG KG Bruto</th>
                                        <th>Total Brondol Bruto</th>
                                        <th>Total Bruto</th>
                                        <th>Total BJR Bruto</th>

                                        <th>Total JJG Netto</th>
                                        <th>Total JJG KG Netto</th>
                                        <th>Total Brondol Netto</th>
                                        <th>Total Netto</th>
                                        <th>Total BJR Netto</th>
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
    var title = "CROPS Statement";
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
                    title: 'CROPS Statement',
                    filename: 'CROPS Statement ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'CROPS Statement',
                    filename: 'CROPS Statement ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'CROPS Statement Excel',
                    filename: 'CROPS Statement ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'CROPS Statement',
                    filename: 'CROPS Statement ',
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