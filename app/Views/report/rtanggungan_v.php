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
                                    <input type="hidden" name="tanggungan_id" />
                                </h1>
                            </form> -->
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                        <div class="">
                            <?php if (isset($_POST['edit'])) {
                                $namabutton = 'name="change"';
                                $judul = "Update tanggungan";
                            } else {
                                $namabutton = 'name="create"';
                                $judul = "Tambah tanggungan";
                            } ?>
                            <div class="lead">
                                <h3><?= $judul; ?></h3>
                            </div>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="user_id">tanggungan:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control" id="user_id" name="user_id">
                                            <option value="<?=$user_id;?>" selected><?=$user_name;?></option>
                                        </select>
                                        <script>
                                            $(document).ready(function() {
                                                $('#user_id').select2({
                                                    ajax: {
                                                        url: '<?=base_url("api/user");?>',
                                                        data: function (params) {
                                                            var query = {
                                                                search: params.term,
                                                                type: 'public'
                                                            }
                                                            // var jsonString = JSON.stringify(query);
                                                            // alert(jsonString);
                                                            // Query parameters will be ?search=[term]&type=public
                                                            return query;
                                                        },
                                                        processResults: function (data) {                                                            
                                                            return {
                                                                results: data
                                                            };
                                                        }
                                                    }
                                                });
                                            });
                                        </script>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="tanggungan_bulan">Bulan:</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control" id="tanggungan_bulan" name="tanggungan_bulan">
                                            <option value="1" <?=($tanggungan_bulan=="1")?"selected":"";?>><?=date("F", strtotime(date("Y-1-1")));?></option>
                                            <option value="2" <?=($tanggungan_bulan=="2")?"selected":"";?>><?=date("F", strtotime(date("Y-2-1")));?></option>
                                            <option value="3" <?=($tanggungan_bulan=="3")?"selected":"";?>><?=date("F", strtotime(date("Y-3-1")));?></option>
                                            <option value="4" <?=($tanggungan_bulan=="4")?"selected":"";?>><?=date("F", strtotime(date("Y-4-1")));?></option>
                                            <option value="5" <?=($tanggungan_bulan=="5")?"selected":"";?>><?=date("F", strtotime(date("Y-5-1")));?></option>
                                            <option value="6" <?=($tanggungan_bulan=="6")?"selected":"";?>><?=date("F", strtotime(date("Y-6-1")));?></option>
                                            <option value="7" <?=($tanggungan_bulan=="7")?"selected":"";?>><?=date("F", strtotime(date("Y-7-1")));?></option>
                                            <option value="8" <?=($tanggungan_bulan=="8")?"selected":"";?>><?=date("F", strtotime(date("Y-8-1")));?></option>
                                            <option value="9" <?=($tanggungan_bulan=="9")?"selected":"";?>><?=date("F", strtotime(date("Y-9-1")));?></option>
                                            <option value="10" <?=($tanggungan_bulan=="10")?"selected":"";?>><?=date("F", strtotime(date("Y-10-1")));?></option>
                                            <option value="11" <?=($tanggungan_bulan=="11")?"selected":"";?>><?=date("F", strtotime(date("Y-11-1")));?></option>
                                            <option value="12" <?=($tanggungan_bulan=="12")?"selected":"";?>><?=date("F", strtotime(date("Y-12-1")));?></option>
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="tanggungan_id" value="<?= $tanggungan_id; ?>" />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                        <a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= base_url("tanggungan"); ?>">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } else { ?>
                        <?php if ($message != "") { ?>
                            <div class="alert alert-info alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?= $message; ?></strong>
                            </div>
                        <?php } ?>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                                <thead class="">
                                    <tr>
                                        <th>RW</th>
                                        <th>RT</th>
                                        <th>Penanggung</th>
                                        <th>Ditanggung</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // dd(session()->get("position_id"));
                                    $build = $this->db                                        
                                        ->table("tanggungan")
                                        ->join("user","user.user_id=tanggungan.user_id","left");
                                    if(session()->get("position_id") == "4"){
                                        $build->where("user.user_id",session()->get("user_id"));
                                    }

                                    $usr=$build
                                        ->orderBy("tanggungan_name", "ASC")
                                        ->orderBy("user_name", "ASC")
                                        ->get();
                                    //echo $this->db->getLastquery();
                                    $no = 1;
                                    foreach ($usr->getResult() as $usr) { ?>
                                        <tr>                                            
                                            <td><?= $usr->user_rw; ?></td>
                                            <td><?= $usr->user_rt; ?></td>
                                            <td><?= $usr->user_name; ?></td>
                                            <td><?= $usr->tanggungan_name; ?></td>
                                            <td><?= $usr->tanggungan_status; ?></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.select').select2();
    var title = "Tanggungan";
    $("title").text(title);
    $(".card-title").text(title);
    $("#page-title").text(title);
    $("#page-title-link").text(title);
</script>

<?php echo  $this->include("template/footer_v"); ?>