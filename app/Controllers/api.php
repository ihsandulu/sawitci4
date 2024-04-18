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

    /* public function datablok(){
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
    } */

    public function datablok(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("blok")
        ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
        ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
        ->join("estate","estate.estate_id=divisi.estate_id","left")
        ->orderBy("blok_name", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "estate_id" => $usr->estate_id,
                "estate_name" => $usr->estate_name,
                "divisi_id" => $usr->divisi_id,
                "divisi_name" => $usr->divisi_name,
                "seksi_id" => $usr->seksi_id,
                "seksi_name" => $usr->seksi_name,
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

    public function driverdumptruck(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("t_user")
        ->join("position","position.position_id=t_user.position_id","left")
        ->where("t_user.position_id","7")
        ->orWhere("t_user.position_id","59")
        ->orderBy("t_user.nama", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "driverdumptruck_id" => $usr->user_id,
                "driverdumptruck_name" => $usr->nama,
                "driverdumptruck_position" => $usr->position_name
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function operatortractor(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("t_user")
        ->where("t_user.position_id","68")
        ->orderBy("t_user.nama", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "operatortractor_id" => $usr->user_id ,
                "operatortractor_name" => $usr->nama
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

    public function quarrynumber(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("quarrynumber")
        ->orderBy("quarrynumber.quarrynumber_card", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "quarrynumber_card" => $usr->quarrynumber_card
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datasptbsmentah(){
        $inpututama = request()->getGet("datanya");
        $bintang = explode("*", $inpututama);

        $whereu["sptbs_card"] = request()->getGet("sptbs_card");
        $usru = $this->db->table('sptbs')->getWhere($whereu);
        $rowCountu = $usru->countAll();
        if($rowCountu>0){
            $inputt["sptbs_kgtruk"] = request()->getGet("sptbs_timbangan");
            $wheret["sptbs_card"] = request()->getGet("sptbs_card");
            $buildert = $this->db->table('sptbs');
            $buildert->update($inputt, $wheret); 
            $jsonResponset = json_encode($inputt);

            // Mengembalikan respons JSON
            return $this->response->setContentType('application/json')->setBody($jsonResponset);
            // print_r($input);
        }else{
            
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
                if($panen_id>0){
                    $inputt["sptbs_kgbruto"] = request()->getGet("sptbs_timbangan");
                    $wheret["sptbs_card"] = request()->getGet("sptbs_card");
                    $buildert = $this->db->table('sptbs');
                    $buildert->update($inputt, $wheret); 
                    $jsonResponset = json_encode($inputt);

                    // Mengembalikan respons JSON
                    return $this->response->setContentType('application/json')->setBody($jsonResponset);
                    // print_r($input);
                }
            }
        }
        // echo "Insert Data Success";
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

    public function apitimbangan(){
        $input["sptbs_timbangan"] = request()->getGet("sptbs_timbangan");
        $where["sptbs_card"] = request()->getGet("sptbs_card");
        $usr = $this->db->table('sptbs')->getWhere($where);
        $rowCount = $query->countAllResults();
        if($rowCount>0){
            foreach($usr->getResult() as $usr){

            }
            $builder->update($input, $where);
        }else{
            $this->table("sptbs")->insert($input);
        }
        
         
        $jsonResponse = json_encode($input);

        // Mengembalikan respons JSON
        return $this->response->setContentType('application/json')->setBody($jsonResponse);
        // print_r($input);
    }

    public function apibrutto(){
        $input["sptbs_kgbruto"] = request()->getGet("sptbs_kgbruto");
        $where["sptbs_card"] = request()->getGet("sptbs_card");
        $builder = $this->db->table('sptbs');
        $builder->update($input, $where); 
        $jsonResponse = json_encode($input);

        // Mengembalikan respons JSON
        return $this->response->setContentType('application/json')->setBody($jsonResponse);
        // print_r($input);
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
        return $this->response->setContentType('application/json')->setBody($jsonResponse);
        // print_r($input);

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
   

    public function absen1()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
    
        helper(['form', 'url']);
    
        // Validate file upload
        $file = $this->request->getFile('absen_picture');
        if ($file && $file->isValid()) {
            // Pindahkan file gambar ke direktori writable/uploads
            $direktori = 'images/absen_picture';
            $file->move(ROOTPATH . $direktori);
    
            // Ambil data tambahan dari request
            $divisiId = $this->request->getPost('divisi_id');
            $estateId = $this->request->getPost('estate_id');
    
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

    public function absen(){
        foreach ($this->request->getPost() as $e => $f) {
            if ($e != 'create' ) {
                $inputu[$e] = $this->request->getPost($e);
            }
        }
        //cek
        $cek=$this->db->table('absen')
        ->where("absen_date",$inputu["absen_date"])
        ->where("absen_type",$inputu["absen_type"])
        ->where("absen_user",$inputu["absen_user"])
        ->get();
        if($cek->getNumRows()==0){
            $this->db->table('absen')->insert($inputu);
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Insert Data Success!";
        }else{
            $data["message"] = "Data sudah ada!";
        }

    }

    public function uploadtph(){
        foreach ($this->request->getPost() as $e => $f) {
            if ($e != 'create' ) {
                $inputu[$e] = $this->request->getPost($e);
            }
        }
        //cek
        $cek=$this->db->table('panen')
        ->where("panen_date",$inputu["panen_date"])
        ->where("tph_id",$inputu["tph_id"])
        ->where("panen_card",$inputu["panen_card"])
        ->get();
        if($cek->getNumRows()==0){
            $this->db->table('restand')->insert($inputu);
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Insert Data Success!";
        }else{
            foreach ($cek->getResult() as $cek) {
                $input["panen_picture"]=$this->request->getPost("panen_picture");
                $where["panen_id"]=$cek->panen_id;
                $this->db->table('panen')->update($input,$where);
                $data["message"] = "Update Gambar Success!";
            }
        }

    }

    public function gambarabsen(){
        $id = $this->request->getGet("id");
        $cek=$this->db->table('absen')
        ->where("absen_id",$id)
        ->get();
        // echo $this->db->getLastQuery(); die;
        foreach($cek->getResult() as $cek){
            echo $cek->absen_picture;
        }
    }

    public function wt(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("wt")
        ->orderBy("wt.wt_name", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "wt_id" => $usr->wt_id,
                "wt_name" => $usr->wt_name,
                "wt_vendor" => $usr->wt_vendor,
                "wt_jenis" => $usr->wt_jenis,
                "wt_sewa" => $usr->wt_sewa
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function quarrytype(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("quarrytype")
        ->orderBy("quarrytype.quarrytype_sumber", "ASC")
        ->orderBy("quarrytype.quarrytype_jenis", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "quarrytype_id" => $usr->quarrytype_id,
                "quarrytype_sumber" => $usr->quarrytype_sumber,
                "quarrytype_jenis" => $usr->quarrytype_jenis
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    

    public function uploadquarry(){
        foreach ($this->request->getPost() as $e => $f) {
            if ($e != 'create' ) {
                $inputu[$e] = $this->request->getPost($e);
            }
        }
        
        $this->db->table('quarry')->insert($inputu);
        //cek
        /* $cek=$this->db->table('quarry')
        ->where("quarry_date",$inputu["quarry_date"])
        ->where("quarry_card",$inputu["quarry_card"])
        ->get();
        if($cek->getNumRows()==0){
            $this->db->table('quarry')->insert($inputu);
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Insert Data Success!";
        }else{
            foreach ($cek->getResult() as $cek) {
                $where["quarry_id"]=$cek->quarry_id;
                $this->db->table('quarry')->update($input,$where);
                $data["message"] = "Data Diupdate!";
            }
        } */

    }
    public function insertquarry_jarak(){
        foreach ($this->request->getGet() as $e => $f) {
            if ($e != 'create' ) {
                $input[$e] = $this->request->getGet($e);
            }
        }
        $where["quarry_id"] = $this->request->getGet("quarry_id");
        $this->db->table('quarry')->update($input,$where);
    }
    
}
