<?php

namespace App\Models\master;

use App\Models\core_m;

class manggota_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek user
        if ($this->request->getVar("user_id")) {
            $userd["user_id"] = $this->request->getVar("user_id");
        } else {
            $userd["user_id"] = -1;
        }
        $us = $this->db
            ->table("user")
            ->getWhere($userd);
        //echo $this->db->getLastquery();
        //die;
        $larang = array("log_id", "id",  "action", "data", "user_id_dep", "trx_id", "trx_code", "contact_id_dep");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $user) {
                foreach ($this->db->getFieldNames('user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $user->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") {
            $user_id=   $this->request->getPost("user_id");
            $cektagihan=$this->db->table("tagihan")->where("user_id",$user_id)
            ->countAllResults();
            $cektanggungan=$this->db->table("tanggungan")->where("user_id",$user_id)
            ->countAllResults();
            if($cektagihan==0 && $cektanggungan==0){
                $this->db
                ->table("user")
                ->delete(array("user_id" => $this->request->getPost("user_id")));
                $data["message"] = "Delete Success";
                // $data["message"] = "Delete Success" . $this->request->getPost("contact_id") . "=" . $this->request->getPost("user_id");
            }else{
                $data["message"] = "Delete Failed! Data masih digunakan.";
            }
            
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' ) {
                    $inputu[$e] = $this->request->getPost($e);
                }
            }

            //user
            $inputu["user_password"] = password_hash($inputu["user_password"], PASSWORD_DEFAULT);
            $this->db->table('user')->insert($inputu);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if($e!='change'&&$e!='user_password'){
                    $inputu[$e] = $this->request->getPost($e);
                }
            }
            if($this->request->getPost("user_password")!=""){
                $pass = $this->request->getPost("user_password");
                $inputu["user_password"] = password_hash($pass, PASSWORD_DEFAULT);
            }
            $this->db->table('user')
                ->where("user_id", $inputu["user_id"])
                ->update($inputu);
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
