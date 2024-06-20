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
                                    <th>Tanggal</th>
                                    <th>NIK</th>
                                    <th>Nama Pemanen</th>
                                    <th>No.Tiket</th>
                                    <th>Divisi</th>
                                    <th>Blok</th>
                                    <th>Thn Tanam</th>
                                    <th>JJG</th>
                                    <th>BRNDL</th>
                                    <th>JJG KG</th>
                                    <th>BRNDL KG</th>
                                    <th>Total KG</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                              

                                    /* $build = $this->db
                                    ->table("panen")
                                    ->select("panen.panen_date, panen.panen_tpname, panen.divisi_name, panen.blok_name, panen.tph_thntanam, SUM(IF(panen_brondol=0, panen_jml, 0))as jjg, SUM(IF(panen_brondol=1, panen_jml, 0))as brd,  sptbs.sptbs_code,  SUM(IF(panen_brondol=0, panen_netto, 0))as jjgkg, SUM(IF(panen_brondol=1, panen_netto, 0))as brdkg, (jjgkg+brdkg)as tkg, t_user.user_nik", "left")
                                    ->join("sptbs","sptbs.sptbs_id=panen.sptbs_id","left")
                                    ->join("t_user","t_user.user_id=panen.user_id","left");

                                $panen = $build
                                    ->where("sptbs_date >=",$dari)
                                    ->where("sptbs_date <=",$ke)
                                    ->group_by("sptbs_id,panen_tp")
                                    ->get(); */
                                    $kerja = $this->db
                                    ->table("hasil_kerja_panen")
                                    ->where("panen_date >=",$dari)
                                    ->where("panen_date <=",$ke)
                                    ->get();
                                // echo $this->db->getLastquery();die;
                                $no = 1;
                                foreach ($kerja->getResult() as $kerja) {
                                ?>
                                    <tr>
                                        <td><?= date("Y-m-d", strtotime($kerja->panen_date)); ?></td>
                                        <td><?= $kerja->user_nik; ?></td>
                                        <td><?= $kerja->panen_tpname; ?></td>
                                        <td><?= $kerja->sptbs_code; ?></td>
                                        <td><?= $kerja->divisi_name; ?></td>
                                        <td><?= $kerja->blok_name; ?></td>
                                        <td><?= $kerja->tph_thntanam; ?></td>
                                        <td><?= number_format($kerja->jjg, 0, ",", "."); ?></td>
                                        <td><?= number_format($kerja->brd, 0, ",", "."); ?></td>
                                        <td><?= number_format($kerja->jjgkg, 0, ",", "."); ?></td>
                                        <td><?= number_format($kerja->brdkg, 0, ",", "."); ?></td>
                                        <td><?= number_format($kerja->tkg, 0, ",", "."); ?></td>
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
    var title = "Daftar Hasil Kerja Pemanen";
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
                    title: 'Daftar Hasil Kerja Pemanen',
                    filename: 'Daftar Hasil Kerja Pemanen ',
                    text: 'Copy'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Daftar Hasil Kerja Pemanen',
                    filename: 'Daftar Hasil Kerja Pemanen ',
                    text: 'Export to CSV'
                },
                {
                    extend: 'excelHtml5',
                    title: 'Daftar Hasil Kerja Pemanen Excel',
                    filename: 'Daftar Hasil Kerja Pemanen ',
                    text: 'Export to Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Daftar Hasil Kerja Pemanen',
                    filename: 'Daftar Hasil Kerja Pemanen ',
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