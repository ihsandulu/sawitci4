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
                                                <option value="<?= $y; ?>" <?= ($thn == $y) ? "selected" : ""; ?>><?= $y; ?></option>
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
                                    <th>Estate</th>
                                    <th>Divisi</th>
                                    <th>Hektar</th>
                                    <th>Pokok</th>
                                    <th>Uraian</th>
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
                                        <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= date("F", strtotime($thn . "-" . $x)); ?></th>
                                    <?php } ?>

                                    <th>Total KG</th>
                                    <th>Total TON/HA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tmonth=array();
                                for ($x = 1; $x <= 12; $x++) { 
                                    $tmonth[$x]=0;
                                }
                                
                                
                                $target=$this->db->table("t_target")->where("tahun",$thn)->get();
                                $ttarget=0;
                                foreach($target->getResult() as $target){
                                    for ($x = 1; $x <= 12; $x++) { 
                                        $bulan=date("F", strtotime($thn . "-" . $x));
                                        $tmonth[$x]=$target->$bulan;
                                        $ttarget+=$target->$bulan;
                                    }
                                }
                                $panen = $this->db
                                    ->table("panen")
                                    ->select("
                                    SUBSTRING(panen.panen_date,1,7) as bln, 
                                    panen.estate_name, 
                                    panen.divisi_name, 
                                    panen.tph_thntanam, 
                                    blok.blok_ha, 
                                    blok.blok_populasi, 
                                    (blok.blok_populasi/blok.blok_ha) as sph, 

                                    
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-01', panen.panen_netto, 0)) as tnetto1, 

                                  
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-02', panen.panen_netto, 0)) as tnetto2, 

                                  
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-03', panen.panen_netto, 0)) as tnetto3, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-04', panen.panen_netto, 0)) as tnetto4, 
                                  
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-05', panen.panen_netto, 0)) as tnetto5, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-06', panen.panen_netto, 0)) as tnetto6, 
                                 
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-07', panen.panen_netto, 0)) as tnetto7, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-08', panen.panen_netto, 0)) as tnetto8, 

                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-09', panen.panen_netto, 0)) as tnetto9, 
            
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-10', panen.panen_netto, 0)) as tnetto10, 
                            
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-11', panen.panen_netto, 0)) as tnetto11, 
                               
                                    SUM(IF(SUBSTRING(panen.panen_date,1,7)='" . $thn . "-12', panen.panen_netto, 0)) as tnetto12

                                    ")
                                    ->join("blok", "blok.blok_id=panen.blok_id", "left")
                                    ->where("SUBSTRING(panen_date,1,4)", $thn)
                                    ->groupBy("panen.divisi_id, panen.tph_thntanam")
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                $arpan = array();                                
                                $realisasi=array();
                                foreach ($panen->getResult() as $panen) {
                                    // $arpan[][]

                                ?>
                                    <tr>
                                        <th><?= $panen->estate_name; ?></th>
                                        <th><?= $panen->divisi_name; ?></th>
                                        <th><?= $panen->blok_ha; ?></th>
                                        <th><?= $panen->blok_populasi; ?></th>
                                        <th>Rencana</th>
                                        <?php
                                        
                                        $tonharealisasi = $ttarget/$panen->blok_ha/1000;
                                        for ($x = 1; $x <= 12; $x++) {0;
                                        ?>                                            
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($tmonth[$x], 0, ",", "."); ?></th>
                                        <?php } ?>
                                       
                                        
                                        <th><?= number_format($ttarget, 0, ",", "."); ?></th>
                                        <th><?= number_format($tonharealisasi, 2, ",", "."); ?></th>
                                    </tr>
                                    <tr>
                                        <th><?= $panen->estate_name; ?></th>
                                        <th><?= $panen->divisi_name; ?></th>
                                        <th><?= $panen->blok_ha; ?></th>
                                        <th><?= $panen->blok_populasi; ?></th>
                                        <th>Realisasi</th>
                                        <?php
                                        $tottnetto = 0;
                                        $tonharencana = 0;
                                        for ($x = 1; $x <= 12; $x++) {
                                            $tnetto = "tnetto" . $x;
                                            $ttnetto = 0;
                                            if (isset($panen->$tnetto)) {
                                                $ttnetto = $panen->$tnetto;
                                                $realisasi[$x]=$ttnetto;
                                                $tottnetto +=$ttnetto;
                                            }
                                            $tonharencana = $tottnetto/$panen->blok_ha/1000;
                                        ?>                                            
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($ttnetto, 0, ",", "."); ?></th>
                                        <?php } ?>
                                       
                                        
                                        <th><?= number_format($tottnetto, 0, ",", "."); ?></th>
                                        <th><?= number_format($tonharencana, 2, ",", "."); ?></th>
                                    </tr>
                                    <tr>
                                        <th><?= $panen->estate_name; ?></th>
                                        <th><?= $panen->divisi_name; ?></th>
                                        <th><?= $panen->blok_ha; ?></th>
                                        <th><?= $panen->blok_populasi; ?></th>
                                        <th>%BI</th>
                                        <?php
                                        
                                        for ($x = 1; $x <= 12; $x++) {
                                            $bi=$realisasi[$x]/$tmonth[$x];
                                        ?>                                            
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($bi, 3, ",", "."); ?> %</th>
                                        <?php } ?>
                                       
                                        
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th><?= $panen->estate_name; ?></th>
                                        <th><?= $panen->divisi_name; ?></th>
                                        <th><?= $panen->blok_ha; ?></th>
                                        <th><?= $panen->blok_populasi; ?></th>
                                        <th>%SDBI</th>
                                        <?php
                                        
                                        for ($x = 1; $x <= 12; $x++) {
                                            $sdbi=$realisasi[$x]/$ttarget;
                                        ?>                                            
                                            <th style="background-color:<?= $pastelColors[$x]; ?>; color:<?= $pColors[$x]; ?>;>"><?= number_format($sdbi, 3, ",", "."); ?> %</th>
                                        <?php } ?>
                                       
                                        
                                        <th></th>
                                        <th></th>
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