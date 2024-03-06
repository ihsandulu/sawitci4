<?php

namespace App\Models\master;

use App\Models\core_m;

class muser_m extends core_m
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
            ->table("t_user")
            ->getWhere($userd);
        //echo $this->db->getLastquery();
        //die;
        $larang = array("log_id", "id",  "action", "data", "user_id_dep", "trx_id", "trx_code", "contact_id_dep");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $user) {
                foreach ($this->db->getFieldNames('t_user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $user->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('t_user') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") {
            $user_id = $this->request->getPost("user_id");
            $cek=$this->db->table("placement")
            ->where("user_id", $user_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "User masih dipakai di data 'Placement'!";
            } else{    
                $this->db
                ->table("t_user")
                ->delete(array("user_id" =>  $user_id));
                $data["message"] = "Delete Success";
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
            // $inputu["password"] = password_hash($inputu["password"], PASSWORD_DEFAULT);
            // $inputu["password"] = $inputu["password"];
            $this->db->table('t_user')->insert($inputu);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if($e!='change'){
                    $inputu[$e] = $this->request->getPost($e);
                }
            }
            /* if($this->request->getPost("password")!=""){
                $pass = $this->request->getPost("password");
                $inputu["password"] = password_hash($pass, PASSWORD_DEFAULT);
            } */
            $this->db->table('t_user')
                ->where("user_id", $inputu["user_id"])
                ->update($inputu);
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
