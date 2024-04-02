<?php

namespace App\Controllers;

use phpDocumentor\Reflection\Types\Null_;
use CodeIgniter\API\ResponseTrait;

class api extends baseController
{
    use ResponseTrait;

    protected $sesi_user;
    protected $db;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        echo "Page Not Found!";
    }

    public function active()
    {        
        $input["store_active"] = $this->request->getGET("store_active");
        $this->db->table('store')->update($input, array("store_id" => $this->request->getGET("store_id")));
        echo $this->db->getLastQuery();
    }

    public function createstore()
    {       
        //input store 
        $input["store_name"] = $this->request->getGET("store_name");
        $input["store_address"] = $this->request->getGET("store_address");
        $input["store_phone"] = $this->request->getGET("store_phone");
        $input["store_wa"] = $this->request->getGET("store_wa");
        $input["store_owner"] = $this->request->getGET("store_owner");
        $input["store_active"] = $this->request->getGET("store_active");
        $this->db->table('store')->insert($input);
        // echo $this->db->getLastQuery();
        $userid=$this->db->insertID();

        //input position
        $inputposition1["store_id"] = $userid;
        $inputposition1["position_name"] = "Admin";
        $inputposition2["position_administrator"] = 2;
        $this->db->table('position')->insert($inputposition1);
        $positionid1=$this->db->insertID();
        //input position
        $inputposition2["store_id"] = $userid;
        $inputposition2["position_administrator"] = 1;
        $inputposition2["position_name"] = "Administrator";
        $this->db->table('position')->insert($inputposition2);
        $positionid2=$this->db->insertID();

        //input user
        $inputuser1["store_id"] = $userid;
        $inputuser1["user_name"] = $this->request->getGET("user_name");
        $inputuser1["user_email "] = $this->request->getGET("user_email ");
        $inputuser1["user_password"] = password_hash($this->request->getGET("user_password"), PASSWORD_DEFAULT);
        $inputuser1["position_id"] = $positionid1;
        $this->db->table('user')->insert($inputuser1);

        //input user administrator
        $inputuser2["store_id"] = $userid;
        $inputuser2["user_name"] = "Administrator";
        $inputuser2["user_email "] = "ihsan.dulu@gmail.com";
        $inputuser2["user_password"] = "$2y$10$GjtRux7LHXpXN5JotL/J0uE1KyV5LQ.OQrapMZqbhHt84oB7WDoEa";
        $inputuser2["position_id"] = $positionid2;
        $this->db->table('user')->insert($inputuser2);
        echo $this->db->getLastQuery();

    }

    public function iswritable()
    {
        $dir = $_GET["path"];
        if (is_dir($dir)) {
            if (is_writable($dir)) {
                echo "true";
            } else {
                echo "false";
            }
        } else if (file_exists($dir)) {
            return (is_writable($dir));
        }
    }

    public function updateakun()
    {
        $input["akun_id"] = $this->request->getGET("akun_id");
        if ($input["akun_id"] == 0) {
            $input["akun_id"] = null;
        }
        $this->db->table('lpj1')->update($input, array("lpj1_id" => $this->request->getGET("lpj1_id")));
        // echo $this->db->getLastQuery();
        $akun = $this->db->table("akun")
            ->where("akun.akun_id", $input["akun_id"])
            ->get();
        foreach ($akun->getResult() as $akun) {
            if ($input["akun_id"] > 0) {
                $isi = $akun->akun_name . " (" . $akun->akun_no . ")";
            } else {
                $isi = "";
            }
            echo $isi;
        }
    }

    public function akunkosong()
    {
        $akunkosong = $this->db->table("lpj1")
            ->where("lpj0_id", $this->request->getGET("lpj0_id"))
            ->groupStart()
            ->where("akun_id", null)
            ->orWhere("akun_id", "0")
            ->groupEnd()
            ->get()
            ->getNumRows();
        // echo $this->db->getLastQuery();
        if ($akunkosong == 0) {
            echo "OK";
        }
    }

    public function hakakses()
    {
        $crud = $this->request->getGET("crud");
        $val = $this->request->getGET("val");
        $val = json_decode($val);
        $position_id = $this->request->getGET("position_id");
        $pages_id = $this->request->getGET("pages_id");
        $where["position_id"]=$this->request->getGET("position_id");
        $where["pages_id"]=$this->request->getGET("pages_id");
        $cek=$this->db->table('positionpages')->where($where)->get()->getNumRows();
        if($cek>0){
            $input1[$crud] = $val;
            $this->db->table('positionpages')->update($input1, $where);
            echo $this->db->getLastQuery();
        }else{
            $input2["position_id"] = $position_id;
            $input2["pages_id"] = $pages_id;
            $input2[$crud] = $val;
            $this->db->table('positionpages')->insert($input2);
            echo $this->db->getLastQuery();
        }        
    }

    public function cekcost_approver()
    {

        $build = $this->db->table("cost_approver");
        if (isset($_GET["branch_id"])) {
            $build->where("branch_id", $this->request->getGet("branch_id"));
        }
        $usr = $build->get();
        echo $usr->getNumRows();
    }

    public function request0buttons()
    {
        $request0 = $this->db->table("request0")
            ->select("request0.request0_id, request0.request0_no, SUM(request1.request1_proposed_nom)AS nominal")
            ->join("request1", "request1.request0_id=request0.request0_id", "left")
            ->join("advance0", "advance0.request0_id=request0.request0_id", "left")
            ->whereIn("request0.branch_id", session()->branchrule, true)
            ->groupStart()
            ->where("advance0.request0_id IS NULL")
            ->orWhere("advance0.request0_id", $this->request->getGet("request0_id"))
            ->groupEnd()
            ->where("request0.request0_status", "Validated")
            ->groupBy("request1.request0_id")
            ->groupBy("request0.request0_id")
            ->get();
        //echo $this->db->getLastQuery();
        foreach ($request0->getResult() as $request0) { ?>
            <div class="col-md-2 p-2">
                <button id="b<?= $request0->request0_id; ?>" type="button" onclick="buka('<?= $request0->request0_id; ?>')" class="btn btn-warning pilihb">
                    <?= $request0->request0_no; ?> (Rp. <?= number_format($request0->nominal, 0, ",", "."); ?>)
                    <button onclick="batal()" id="bc<?= $request0->request0_id; ?>" type="button" class="btn btn-xs btn-danger fa fa-close btnclose" style="position: absolute; top:-3px; right:-5px;"></button>
                </button>
            </div>
        <?php }
    }

    public function request0detail()
    {
        ?>
        <div class="tabale-responsive m-t-40">
            <table id="example231" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                <!-- 
                                            <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                <thead class="">
                    <tr style="background-color:peachpuff;">
                        <th>Date of Filing</th>
                        <th>No.Req</th>
                        <th>Branch</th>
                        <th>Applicant</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $builder = $this->db
                        ->table("request0");

                    $builder->where("request0_id", $this->request->getGet("request0_id"));
                    $usr = $builder
                        ->join("user", "user.user_id=request0.user_id_created", "left")
                        ->join("branch", "branch.branch_id=request0.branch_id", "left")
                        ->orderBy("request0_id", "desc")
                        ->get();
                    //echo $this->db->getLastquery();
                    $no = 1;
                    foreach ($usr->getResult() as $usr) {
                    ?>
                        <tr id="d<?= $usr->request0_id; ?>">
                            <td><?= $usr->request0_date; ?></td>
                            <td><?= $usr->request0_no; ?></td>
                            <td><?= $usr->branch_name; ?></td>
                            <td><?= $usr->username; ?></td>
                            <td><?= $usr->request0_desc; ?></td>
                            <td><?= $usr->request0_status; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="table-responsive m-t-40">
            <table id="example231" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <!-- 
                                            <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                <thead class="">
                    <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Cost</th>
                        <th>Proposed</th>
                        <th>Approved</th>
                        <th>Approved By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usr = $this->db
                        ->table("request1")
                        ->join("cost", "cost.cost_id=request1.cost_id", "left")
                        ->where("request0_id", $this->request->getVar("request0_id"))
                        ->orderBy("request1_id", "desc")
                        ->get();
                    //echo $this->db->getLastquery();
                    $no = 1;
                    foreach ($usr->getResult() as $usr) {
                        $usr1 = $this->db
                            ->table("user")
                            ->join("contact", "contact.contact_id=user.contact_id", "left")
                            ->where("user_id", $usr->user_id_approved)
                            ->get();
                        /* echo $this->db->getLastquery();
                                        die; */
                        $user_name = "";
                        if ($usr1->getNumRows() > 0) {
                            $usr1 = $usr1->getRow();
                            $user_name = $usr1->contact_first_name;
                        }

                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $usr->created; ?></td>
                            <td><?= $usr->cost_name; ?></td>
                            <td><?= number_format($usr->request1_proposed_nom, 0, ",", "."); ?></td>
                            <td><?= number_format($usr->request1_approved_nom, 0, ",", "."); ?></td>
                            <td><?= ($user_name == "") ? "" : $user_name . " (" . $usr->approved . ")"; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
    }

    public function advance0detail()
    {
    ?>
        <div class="tabale-responsive m-t-40">
            <table id="example231" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                <!-- 
                                            <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                <thead class="">
                    <tr style="background-color:peachpuff;">
                        <th>Action</th>
                        <th>Date of Filing</th>
                        <th>No.Advance</th>
                        <th>No.LPJ</th>
                        <th>Branch</th>
                        <th>Applicant</th>
                        <th>Total Nominal</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $builder = $this->db
                        ->table("advance0");
                    $builder->where("advance0.advance0_id", $this->request->getGet("advance0_id"));
                    $usr = $builder
                        ->select("*, advance0.advance0_id AS advance0_id, advance0.user_id_approved AS user_id_approved, advance0.approved AS approved")
                        ->join("(SELECT advance0_id AS advance0d_id, SUM(advance1_nom)AS dnom FROM advance1 GROUP BY advance0_id)advance1", "advance1.advance0d_id=advance0.advance0_id", "left")
                        ->join("user", "user.user_id=advance0.user_id_created", "left")
                        ->join("request0", "request0.request0_id=advance0.request0_id", "left")
                        ->join("(SELECT request0_id AS request0d_id,SUM(request1_proposed_nom)AS proposenom, SUM(request1_approved_nom)AS approvenom FROM request1 GROUP BY request0_id)request1", "request1.request0d_id=request0.request0_id", "left")
                        ->join("branch", "branch.branch_id=request0.branch_id", "left")
                        ->join("lpj0", "lpj0.advance0_id=advance0.advance0_id", "left")
                        ->orderBy("advance0.advance0_id", "desc")
                        ->get();
                    //echo $this->db->getLastquery();
                    $no = 1;
                    foreach ($usr->getResult() as $usr) {
                    ?>
                        <tr id="d<?= $usr->advance0_id; ?>">
                            <td style="padding-left:0px; padding-right:0px;">
                                <form method="post" class="btn-action" style="">
                                    <a href="#" onclick="tampilrow(this,'d<?= $usr->advance0_id; ?>','9', ['Advance Approved Date','Request Number','Request Proposed', 'Request Approved'], ['<?= $usr->approved; ?>', '<?= $usr->request0_no; ?>', '<?= number_format($usr->proposenom, 0, ",", "."); ?>', '<?= number_format($usr->approvenom, 0, ",", "."); ?>'])" class="btn btn-sm btn-success tampilrow">
                                        <span class="fa fa-plus" style="color:white;"></span>
                                    </a>
                                </form>
                            </td>
                            <td><?= $usr->advance0_date; ?></td>
                            <td><?= $usr->advance0_no; ?></td>
                            <td><?= $usr->lpj0_no; ?></td>
                            <td><?= $usr->branch_name; ?></td>
                            <td><?= $usr->username; ?></td>
                            <td><?= number_format($usr->advance0_nom, 0, ",", "."); ?></td>
                            <td><?= $usr->advance0_desc; ?></td>
                            <td><?= $usr->advance0_status; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="table-responsive m-t-40">
            <table id="example231" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <!-- 
                                            <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                <thead class="">
                    <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Cash</th>
                        <th>Nominal</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usr = $this->db
                        ->table("advance1")
                        ->join("cash", "cash.cash_id=advance1.cash_id", "left")
                        ->where("advance0_id", $this->request->getVar("advance0_id"))
                        ->orderBy("advance1_id", "desc")
                        ->get();
                    //echo $this->db->getLastquery();
                    $no = 1;
                    foreach ($usr->getResult() as $usr) {
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date("Y-m-d", strtotime($usr->created)); ?></td>
                            <td><?= $usr->cash_name; ?></td>
                            <td><?= number_format($usr->advance1_nom, 0, ",", "."); ?></td>
                            <td><?= $usr->advance1_bukti; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
<?php
    }

    public function listprepaid_prepaidpayment(){
        $prepaid_id=$this->request->getGET("prepaid_id");        
        $prepaid = $this->db->table("prepaid")
        ->where("branch_id", $this->request->getGET("branch_id"))
        ->get(); 
        // echo $this->db->getLastQuery();
        ?>
        <option value="0" <?= ($prepaid_id == "0") ? "selected" : ""; ?>>Select Prepaid</option>                                            
       <?php
        foreach ($prepaid->getResult() as $prepaid) { ?>
            <option value="<?= $prepaid->prepaid_id; ?>" <?= ($prepaid_id == $prepaid->prepaid_id) ? "selected" : ""; ?>><?= $prepaid->prepaid_name; ?></option>
        <?php } ?>
    <?php }

    public function listcash_prepaidpayment(){
        $cash_id=$this->request->getGET("cash_id");        
        $cash = $this->db->table("cash")
        ->where("branch_id", $this->request->getGET("branch_id"))
        ->get(); 
        echo $this->db->getLastQuery();
        ?>
        <option value="0" <?= ($cash_id == "0") ? "selected" : ""; ?>>Select Cash</option>                                            
       <?php
        foreach ($cash->getResult() as $cash) { ?>
            <option value="<?= $cash->cash_id; ?>" <?= ($cash_id == $cash->cash_id) ? "selected" : ""; ?>><?= $cash->cash_name; ?></option>
        <?php } ?>        
    <?php }


    public function user(){
        $users = $this->db->table("user")
        ->select("user_id, user_name", "user_rt", "user_rw")
        ->like("user_name", $this->request->getGet("search"), "both")
        ->where("position_id","4s")
        ->get()->getResult();

        $result = [];
        foreach ($users as $user) {
            $result[] = [
                'id' => $user->user_id,
                'text' => $user->user_name
            ];
        }

        return $this->response->setJSON($result);  
    }

    public function divisi(){
        $divisi = $this->db->table("divisi")
            ->where("estate_id",$this->request->getGET("estate_id"))
            ->orderBy("divisi_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $divisi_id = $this->request->getGET("divisi_id");
        ?>
        <option value="" <?= ($divisi_id == "") ? "selected" : ""; ?>>Pilih Divisi</option>
        <?php
        foreach ($divisi->getResult() as $divisi) { ?>
            <option value="<?= $divisi->divisi_id; ?>" <?= ($divisi_id == $divisi->divisi_id) ? "selected" : ""; ?>><?= $divisi->divisi_name; ?></option>
        <?php } ?>
        <?php
    }

    public function seksi(){
        $seksi = $this->db->table("seksi")
            ->where("divisi_id",$this->request->getGET("divisi_id"))
            ->orderBy("seksi_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $seksi_id = $this->request->getGET("seksi_id");
        ?>
        <option value="" <?= ($seksi_id == "") ? "selected" : ""; ?>>Pilih Seksi</option>
        <?php
        foreach ($seksi->getResult() as $seksi) { ?>
            <option value="<?= $seksi->seksi_id; ?>" <?= ($seksi_id == $seksi->seksi_id) ? "selected" : ""; ?>><?= $seksi->seksi_name; ?></option>
        <?php } ?>
        <?php
    }

    public function blok(){
        $blok = $this->db->table("blok")
            ->where("seksi_id",$this->request->getGET("seksi_id"))
            ->orderBy("blok_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $blok_id = $this->request->getGET("blok_id");
        ?>
        <option value="" <?= ($blok_id == "") ? "selected" : ""; ?>>Pilih Blok</option>
        <?php
        foreach ($blok->getResult() as $blok) { ?>
            <option value="<?= $blok->blok_id; ?>" <?= ($blok_id == $blok->blok_id) ? "selected" : ""; ?>><?= $blok->blok_name; ?></option>
        <?php } ?>
        <?php
    }

    public function tph(){
        $tph = $this->db->table("tph")
            ->where("blok_id",$this->request->getGET("blok_id"))
            ->orderBy("tph_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $tph_id = $this->request->getGET("tph_id");
        ?>
        <option value="" <?= ($tph_id == "") ? "selected" : ""; ?>>Pilih TPH</option>
        <?php
        foreach ($tph->getResult() as $tph) { ?>
            <option value="<?= $tph->tph_id; ?>" <?= ($tph_id == $tph->tph_id) ? "selected" : ""; ?>><?= $tph->tph_name; ?></option>
        <?php } ?>
        <?php
    }

    public function userposition(){
        $user = $this->db->table("t_user")
            ->where("position_id",$this->request->getGET("position_id"))
            ->orderBy("username", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $user_id = $this->request->getGET("user_id");
        ?>
        <option value="" <?= ($user_id == "") ? "selected" : ""; ?>>Pilih User</option>
        <?php
        foreach ($user->getResult() as $user) { ?>
            <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_nik; ?> - <?= $user->nama; ?></option>
        <?php } ?>
        <?php
    }

    public function alluser(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        

        $user = $this->db->table("t_user")
        // ->select('t_user.*, CASE WHEN (SELECT COUNT(*) FROM placement WHERE placement.user_id = t_user.user_id) > 0 THEN GROUP_CONCAT(placement.divisi_id SEPARATOR ",") ELSE NULL END AS divisiid')
        ->select("*, t_user.user_id as user_id, placement.estate_id as estate_id, placement.divisi_id as divisi_id, placement.seksi_id as seksi_id, placement.blok_id as blok_id, placement.tph_id as tph_id, t_user.position_id as position_id, position.position_name as position_name")
        ->join('placement', 'placement.user_id = t_user.user_id', 'left')
        ->join('estate', 'estate.estate_id = placement.estate_id', 'left')
        ->join('divisi', 'divisi.divisi_id = placement.divisi_id', 'left')
        ->join('seksi', 'seksi.seksi_id = placement.seksi_id', 'left')
        ->join('blok', 'blok.blok_id = placement.blok_id', 'left')
        ->join('tph', 'tph.tph_id = placement.tph_id', 'left')
        ->join('position', 'position.position_id = t_user.position_id', 'left')
        ->orderBy("t_user.username", "ASC")
        ->groupBy('t_user.user_id')
        ->get();

        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($user->getResult() as $user) {
            $userData = array(
                "user_id" => $user->user_id,
                "user_name" => ucwords($user->username),
                "user_password" => $user->password,
                "user_nik" => $user->user_nik,
                "position_id" => $user->position_id,
                "position_name" => $user->position_name,
                "estate_id" => $user->estate_id,
                "estate_name" => $user->estate_name,
                "divisi_id" => $user->divisi_id,
                "divisi_name" => $user->divisi_name,
                "seksi_id" => $user->seksi_id,
                "seksi_name" => $user->seksi_name,
                "blok_id" => $user->blok_id,
                "blok_name" => $user->blok_name,
                "tph_id" => $user->tph_id,
                "tph_name" => $user->tph_name
            );
    
            $data[] = $userData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function rkhnow(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("rkh")
        ->join("t_user","t_user.user_id=rkh.user_id","left")
        ->join("tph","tph.tph_id=rkh.tph_id","left")
        ->join("blok","blok.blok_id=tph.blok_id","left")
        ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
        ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
        ->join("estate","estate.estate_id=divisi.estate_id","left")
        ->orderBy("estate_name", "ASC")
        ->orderBy("divisi_name", "ASC")
        ->orderBy("seksi_name", "ASC")
        ->orderBy("blok_name", "ASC")
        ->orderBy("tph_name", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "rkh_id" => $usr->rkh_id,
                "rkh_rdate" => ucwords($usr->rkh_rdate),
                "rkh_job" => $usr->rkh_job,
                "estate_id" => $usr->estate_id,
                "estate_name" => $usr->estate_name,
                "divisi_id" => $usr->divisi_id,
                "divisi_name" => $usr->divisi_name,
                "seksi_id" => $usr->seksi_id,
                "seksi_name" => $usr->seksi_name,
                "blok_id" => $usr->blok_id,
                "blok_name" => $usr->blok_name,
                "blok_ha" => $usr->blok_ha,
                "tph_id" => $usr->tph_id,
                "tph_name" => $usr->tph_name,
                "rkh_masuk" => $usr->rkh_masuk,
                "rkh_tmasuk" => $usr->rkh_tmasuk,
                "rkh_date" => $usr->rkh_date,
                "username" => ucwords($usr->username)
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function cc(){
        $data=array();      
        $userData = array(
            "user_name" => "ihsan",
            "position_id" => "1"
        );
        $data[] = $userData; 
        $userData = array(
            "user_name" => "dadi",
            "position_id" => "1"
        );
        $data[] = $userData;
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datablok(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("blok")
        ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
        ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
        ->orderBy("blok_name", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "divisi_id" => $usr->divisi_id,
                "seksi_id" => $usr->seksi_id,
                "blok_id" => $usr->blok_id,
                "blok_name" => $usr->blok_name
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datatph(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("tph")
        ->orderBy("tph_name", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "blok_id" => $usr->blok_id,
                "tph_id" => $usr->tph_id,
                "tph_name" => $usr->tph_name,
                "tph_thntanam" => $usr->tph_thntanam
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datavendor(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("t_vendor")
        ->orderBy("nama_vendor", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "vendor_id" => $usr->ID_vendor,
                "vendor_name" => $usr->nama_vendor
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datamaterial(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("t_material")
        ->orderBy("nama_material", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "material_id" => $usr->ID_material,
                "material_name" => $usr->nama_material
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datakecamatan(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("t_asal")
        ->orderBy("kecamatan", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "kecamatan_id" => $usr->id_asal,
                "kecamatan_name" => $usr->kecamatan
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datadriver(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("t_driver")
        ->orderBy("nama_driver", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "driver_id" => $usr->ID_driver,
                "driver_name" => $usr->nama_driver
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datatrukpenerimaan(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("t_trukpenerimaan")
        ->where("status","Aktif")
        ->orderBy("no_polisi ", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "no_polisi" => $usr->no_polisi
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function tp(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("placement")
        ->join("t_user","t_user.user_id=placement.user_id","left")
        ->join("position","position.position_id=placement.position_id","left")
        // ->where("placement.position_id","4")
        ->like("position.position_name","checker","BOTH")
        ->orLike("position.position_name","mandor","BOTH")
        ->orLike("position.position_name","tenaga panen","BOTH")
        ->orderBy("t_user.nama", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "panen_tp" => $usr->user_id,
                "position_id" => $usr->position_id,
                "panen_tpname" => $usr->nama,
                "panen_tpnik" => $usr->user_nik,
                "divisi_id" => $usr->divisi_id,
                "panen_placement" => $usr->placement_name
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function tphnumber(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("tphnumber")
        ->orderBy("tphnumber.tphnumber_card", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "tphnumber_card" => $usr->tphnumber_card
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function sptbsnumber(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("sptbsnumber")
        ->orderBy("sptbsnumber.sptbsnumber_card", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "sptbsnumber_card" => $usr->sptbsnumber_card
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datasptbsmentah(){
        $inpututama = request()->getGet("datanya");
        $bintang = explode("*", $inpututama);

        //sptbs
        $pisah = $bintang[0];
        $koma = explode(",", $pisah);
        foreach ($koma as $isikoma) {
            $data = explode("=", $isikoma);
            $input[$data[0]] = $data[1];
        }
        $builder = $this->db->table('sptbs');
        $builder->insert($input);            
        /* echo $this->db->getLastQuery();
        die; */
        $sptbs_id = $this->db->insertID();

        //panen
        $panjangBintang = count($bintang);
        for ($i = 1; $i < $panjangBintang; $i++) {
            $pisah = $bintang[$i];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $inputpanen[$data[0]] = $data[1];
            }
            $builder = $this->db->table('panen');
            $builder->insert($inputpanen);            
            /* echo $this->db->getLastQuery();
            die; */
            $panen_id = $this->db->insertID();
        }
        echo "Insert Data Success";
    }

    public function datagradingmentah(){
        $inpututama = request()->getGet("datanya");
        $bintang = explode("*", $inpututama);
        $panjangBintang = count($bintang);
        for ($i = 0; $i < $panjangBintang; $i++) {
            $pisah = $bintang[$i];
            $koma = explode(",", $pisah);
            // dd($koma);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $input[$data[0]] = $data[1];
                if($data[0]=="grading_tp"){                    
                    $where[$data[0]] = $data[1];
                }
                if($data[0]=="gradingtype_id"){                    
                    $where[$data[0]] = $data[1];
                }
            }
            // dd($input);
            $this->db->table('grading')->delete($where); 

            $this->db->table('grading')->insert($input);            
            /* echo $this->db->getLastQuery();
            die; */
            $panen_id = $this->db->insertID();
        }
        echo "Insert Data Success";
    }

    public function apibrutto(){
        $input["sptbs_kgbruto"] = request()->getGet("sptbs_kgbruto");
        $where["sptbs_card"] = request()->getGet("sptbs_card");
        $builder = $this->db->table('sptbs');
        $builder->update($input, $where); 
        $jsonResponse = json_encode($input);

        // Mengembalikan respons JSON
        return $this->response->setContentType('application/json')
        ->setBody($jsonResponse);
    }

    public function apinetto(){
        $input["sptbs_kgtruk"] = request()->getGet("sptbs_kgtruk");
        $input["sptbs_kgsampah"] = request()->getGet("sptbs_kgsampah");
        $input["sptbs_kgnetto"] = request()->getGet("sptbs_kgnetto");
        $where["sptbs_card"] = request()->getGet("sptbs_card");
        $builder = $this->db->table('sptbs');
        $builder->update($input, $where); 
        $jsonResponse = json_encode($input);

        // Mengembalikan respons JSON
        return $this->response->setContentType('application/json')
        ->setBody($jsonResponse);
    }

    public function gradingtype(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("gradingtype")
        ->orderBy("gradingtype.gradingtype_id", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "gradingtype_id" => $usr->gradingtype_id,
                "gradingtype_name" => $usr->gradingtype_name
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function absen1(){
        header('Access-Control-Allow-Origin: *');
        //print_r(json_encode($_FILES));
        $new_image_name = urldecode($_FILES["file"]["name"]).".jpg";
        //Move your files into upload folder
        move_uploaded_file($_FILES["file"]["tmp_name"], "images/absen_picture/".$new_image_name);
    }

    public function absen(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        helper(['form', 'url']);

        // Validate file upload
        if ($this->request->getFile('absen_picture')->isValid()) {
            // Ambil file gambar dari request
            $file = $this->request->getFile('absen_picture');

            // Pindahkan file gambar ke direktori writable/uploads
            $direktori = 'images/absen_picture';
            $file->move(ROOTPATH . $direktori);

            // Ambil data tambahan dari request
            $divisiId = $this->request->getPost('divisi_id');
            // $estateId = $this->request->getPost('estate_id');

            // Proses data tambahan jika diperlukan
            // Misalnya: Simpan data tambahan ke database

            // Berikan respons sukses
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully'
            ]);
        } else {
            // Jika validasi gagal, berikan respons error
            return $this->failValidationError('File upload failed');
        }
    }
}
