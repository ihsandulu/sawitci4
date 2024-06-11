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
                                    <th>No.Polisi</th>
                                    <th>Supir</th>
                                    <th>Bruto</th>
                                    <th>Tara</th>
                                    <th>Netto</th>
                                    <th>Jml</th>
                                    <th>%</th>
                                    <th>Kg</th>
                                    <th>Netto Terima</th>
                                    <?php
                                    $gradingtype=$this->db->table("gradingtype")->get();
                                    foreach($gradingtype->getResult() as $gradingtype){?>
                                    <th><?=$gradingtype->gradingtype_name;?></th>
                                    <?php }?>
                                    <th>BJR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // dd(session()->get("position_id"));
                                $build = $this->db
                                    ->table("sptbs")
                                    ->select("t_vendor.nama_vendor, t_vendor.ket, lr.lr_name, sptbs.sptbs_id, sptbs.sptbsid, sptbs.sptbs_code as sptbscode, sptbs.estate_name, sptbs.divisi_name,sptbs.sptbs_timbanganmasuk, sptbs.sptbs_timbangankeluar, sptbs.sptbs_date, sptbs.sptbs_drivername, sptbs.sptbs_kgbruto, sptbs.sptbs_kgtruk, sptbs.sptbs_kgnetto, sptbs.sptbs_jmltandan,  wt.wt_name")
                                    // ->join("sptbs", "sptbs.sptbs_date=grading.grading_date AND sptbs.sptbs_card=grading.sptbs_card", "left")
                                    ->join("wt", "wt.wt_name=sptbs.wt_name", "left")
                                    ->join("lr", "lr.lr_name=sptbs.lr_name", "left")
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
                                    $jmltandan=$sptbs->sptbs_jmltandan;
                                    if($jmltandan==0){
                                        $panen = $this->db->table("panen")
                                        ->select("SUM(panen_jml)As jmltandan")
                                        ->where("sptbs_id", $sptbs->sptbs_id)
                                        ->groupBy("tph_thntanam")
                                        ->get();
                                        // echo $this->db->getLastquery();
                                        $jmltandan=0;
                                        foreach($panen->getResult() as $panen){
                                            $jmltandan+=$panen->jmltandan;
                                        }
                                    }
                                    $grading = $this->db->table("grading")
                                    ->join("gradingtype","gradingtype.gradingtype_id=grading.gradingtype_id","left")
                                    ->where("sptbsid",$sptbs->sptbsid)
                                    ->where("grading_date",$sptbs->sptbs_date)
                                    ->get();
                                    $tkg=0;
                                    $gradingtype_name=array();
                                    foreach($grading->getResult() as $grading){
                                        /* 
                                        1 Fraksi 00
                                        2 Fraksi 0 
                                        3 Fraksi 5 
                                        4 Tangkai Panjang 
                                        5 Tandan Kosong 
                                        6 Tandan <3kg 
                                        7 Sampah 
                                        8 Brondolan Lepas 
                                        9 Fraksi 6 
                                        */ 
                                        $a = $grading->gradingtype_id;
                                        $gradingqty = $grading->grading_qty;
                                        $knetto = array(6,7,8);
                                        $persen = 0;
                                        if (in_array($a, $knetto)) {
                                            $persent=$gradingqty/$netto*100;
                                            if ($persent > 0) {
                                                $persen = $persent;
                                            }
                                        }else{
                                            if($jmltandan==0){
                                                $persen = 0;
                                            }else{
                                                $persent = $gradingqty / $jmltandan * 100;
                                                if ($persent > 0) {
                                                    $persen = $persent;
                                                }
                                            }                                            
                                        }
                                        
                                        $p50 = array(1,2);
                                        $p25 = array(3,9);
                                        $p100 = array(5);
                                        $p1 = array(4);
                                        $p30 = array(8);
                                        $k2 = array(7);
                                        $p70 = array(6);
                                        if (in_array($a, $p50)) {
                                            $nilai = 50/100 * $persen / 100 * $netto;
                                            $kg = round($nilai);
                                        }else  if (in_array($a, $p25)) {
                                            if ($persen > 5) {
                                                $nilai = 25/100 * ($persen/100 - 5/100) * $netto;
                                                $kg = round($nilai);
                                            } else {
                                                $kg = 0;
                                            }
                                        }else  if (in_array($a, $p100)) {
                                            $nilai = (100/100) * ($persen/100) * $netto;
                                            $kg = round($nilai);
                                        }else  if (in_array($a, $p1)) {
                                            $nilai = (1/100) * ($persen/100) * $netto;
                                            $kg = round($nilai);
                                        }else  if (in_array($a, $p30)) {
                                            if ($persen <= 0) {
                                                $kg = 0;
                                            } else {
                                                $nilai = 30/100 * (12.5/100 - $persen/100) * $netto;
                                                if ($nilai < 0) {
                                                    $kg = 0;
                                                } else {
                                                    $kg = round($nilai);
                                                }
                                            }                                                    
                                        }else if (in_array($a, $k2)) {
                                            $kg = round($gradingqty*2);
                                        }else if (in_array($a, $p70)) {
                                            $kg = round($gradingqty * 1 * 0.70);
                                        }
                                        $tkg+=$kg;

                                        $gradingtype_name[$grading->gradingtype_id]["qty"]=$gradingqty;
                                        $gradingtype_name[$grading->gradingtype_id]["persen"]=$persen;
                                        $gradingtype_name[$grading->gradingtype_id]["kg"]=$kg;
                                    }

                                    $tgrading = $tkg;
                            
                                    //netto diterima
                                    if (is_numeric($netto) && is_numeric($tgrading)) {
                                        $nettoditerima = $netto - $tgrading;
                                    } else {
                                        $nettoditerima = 0;
                                    }

                                    //bjr
                                    if (is_numeric($jmltandan) && $jmltandan != 0) {
                                        $bjr = $netto / $jmltandan;
                                    } else {
                                        $bjr = 0;
                                    }

                                    //% grading
                                    if ($netto != 0) {
                                        $pgrading = ($tgrading / $netto) * 100;
                                    } else {
                                        $pgrading = 0;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $sptbs->sptbscode; ?></td>
                                        <td><?= (isset($sptbs->nama_vendor))?$sptbs->nama_vendor:$sptbs->divisi_name; ?></td>
                                        <td><?= (isset($sptbs->ket))?$sptbs->ket:$sptbs->estate_name." ".$sptbs->divisi_name; ?></td>
                                        <td><?= $sptbs->lr_name; ?></td>
                                        <td><?= $sptbs->sptbs_date; ?></td>
                                        <td><?= $sptbs->sptbs_timbanganmasuk; ?></td>
                                        <td><?= $sptbs->sptbs_timbangankeluar; ?></td>
                                        <td><?= $sptbs->wt_name; ?></td>
                                        <td><?= $sptbs->sptbs_drivername; ?></td>
                                        <td><?= number_format($brutto,0,",","."); ?></td>
                                        <td><?= number_format($tarra,0,",","."); ?></td>
                                        <td><?= number_format($netto,0,",","."); ?></td>
                                        <td><?= number_format($jmltandan,0,",","."); ?></td>
                                        <td><?= number_format($pgrading,2,",","."); ?></td>
                                        <td><?= number_format($tgrading,0,",","."); ?></td>
                                        <td><?= number_format($nettoditerima,0,",","."); ?></td>                                        
                                        <?php
                                        $gradingtype=$this->db->table("gradingtype")->get();
                                        foreach($gradingtype->getResult() as $gradingtype){?>
                                        <td>
                                            <?php 
                                            if(isset($gradingtype_name[$gradingtype->gradingtype_id]["qty"])){
                                                echo $gradingtype_name[$gradingtype->gradingtype_id]["qty"];
                                            }
                                            ?>
                                        </td>
                                        <?php }?>
                                        <td><?= number_format($bjr,0,",","."); ?></td>
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