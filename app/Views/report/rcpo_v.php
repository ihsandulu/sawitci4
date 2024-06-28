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
                                    <th>Bln</th>
                                    <th>Tgl Timbang</th>                             
                                    <th>No.Polisi</th>  
                                    <th>Supir</th>
                                    <th>No. Tiket</th>  
                                    <th>No. SPTBS</th>  
                                    <th>Total Kg</th>
                                    <th>Tara</th>
                                    <th>Bruto</th>
                                    <th>Grading</th>
                                    <th>Netto</th>
                                    <th>Divisi</th>
                                    <th>% Grading</th>
                                    <th>Blok</th>
                                    <th>Thn Tanam</th>
                                    <th>Jumlah</th>
                                    <th>Bruto TPH</th>
                                    <th>Grading TPH</th>
                                    <th>Netto TPH</th>
                                    <th>T/B</th>
                                    <th>BJR TPH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                $build = $this->db
                                    ->table("sptbs")
                                    ->select("t_vendor.nama_vendor, sptbs.sptbs_card, sptbs.sptbs_id,sptbs.sptbs_code as sptbscode, sptbs.divisi_name,  sptbs.sptbs_date, sptbs.sptbs_drivername, sptbs.sptbs_kgbruto, sptbs.sptbs_kgtruk, sptbs.sptbs_kgnetto, sptbs.sptbs_jmltandan,  sptbs.sptbs_kgsampah, sptbs.sptbs_kgnettostlgrading, sptbs.sptbs_pgrading, sptbs.sptbs_pgrading,  sptbs.wt_name, panen.blok_name, panen.tph_thntanam, panen.panen_jml, panen.panen_brondol, panen.panen_bjr, panen.panen_bruto, panen.panen_grading, panen.panen_netto")
                                    ->join("panen", "panen.sptbs_id=sptbs.sptbs_id", "left")
                                    ->join("t_vendor", "t_vendor.ID_vendor=sptbs.sptbs_vendor", "left");

                                $sptbs = $build
                                    ->where("sptbs_date >=",$dari)
                                    ->where("sptbs_date <=",$ke)
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                foreach ($sptbs->getResult() as $sptbs) { 
                                    $brutto = $sptbs->sptbs_kgbruto;
                                    $tarra = $sptbs->sptbs_kgtruk;
                                    $netto = $brutto-$tarra;      
                                    $panen_jml=$sptbs->panen_jml;
                                    $sptbscode=$sptbs->sptbscode;
                                    $sptbs_kgsampah=$sptbs->sptbs_kgsampah;
                                    $sptbs_kgnettostlgrading=$sptbs->sptbs_kgnettostlgrading;
                                    $sptbs_pgrading=$sptbs->sptbs_pgrading;
                                    $panen_bjr=$sptbs->panen_bjr; 
                                    $panen_bruto=$sptbs->panen_bruto;
                                    $panen_grading=$sptbs->panen_grading;
                                    $panen_netto=$sptbs->panen_netto;
                                    if($sptbs->panen_brondol==0){$tb="T";}else{$tb="B";}
                                    ?>
                                    <tr>
                                        <td><?= date("n",strtotime($sptbs->sptbs_date)); ?></td>
                                        <td><?= date("Y-m-d",strtotime($sptbs->sptbs_date)); ?></td>
                                        <td><?= $sptbs->wt_name; ?></td>
                                        <td><?= $sptbs->sptbs_drivername; ?></td>
                                        <td><?= $sptbs->sptbscode; ?></td>
                                        <td><?= $sptbs->sptbs_card; ?></td>
                                        <td><?= number_format($brutto,0,",","."); ?></td>
                                        <td><?= number_format($tarra,0,",","."); ?></td>
                                        <td><?= number_format($netto,0,",","."); ?></td>
                                        <td><?= number_format($sptbs_kgsampah,0,",","."); ?></td>
                                        <td><?= number_format($sptbs_kgnettostlgrading,0,",","."); ?></td>                                        
                                        <td><?= (isset($sptbs->nama_vendor))?$sptbs->nama_vendor:$sptbs->divisi_name; ?></td>
                                        <td><?= number_format($sptbs_pgrading,2,",","."); ?></td>
                                        <td><?= $sptbs->blok_name; ?></td>
                                        <td><?= $sptbs->tph_thntanam; ?></td>
                                        <td><?= number_format($panen_jml,0,",","."); ?></td>
                                        <td><?= number_format($panen_bruto,0,",","."); ?></td>
                                        <td><?= number_format($panen_grading,0,",","."); ?></td>
                                        <td><?= number_format($panen_netto,0,",","."); ?></td>
                                        <td><?= $tb; ?></td>
                                        <td><?= number_format($panen_bjr,0,",","."); ?></td>
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
    var title = "Monitoring Pengiriman TBS ke CPO MIll";
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
                    title: 'Monitoring Pengiriman TBS ke CPO MIll',
                    filename: 'Monitoring Pengiriman TBS ke CPO MIll ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Monitoring Pengiriman TBS ke CPO MIll',
                    filename: 'Monitoring Pengiriman TBS ke CPO MIll ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Monitoring Pengiriman TBS ke CPO MIll Excel',
                    filename: 'Monitoring Pengiriman TBS ke CPO MIll ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Monitoring Pengiriman TBS ke CPO MIll',
                    filename: 'Monitoring Pengiriman TBS ke CPO MIll ',
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