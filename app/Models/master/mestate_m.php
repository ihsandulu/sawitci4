<?php

namespace App\Models\master;

use App\Models\core_m;

class mestate_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek estate
        if ($this->request->getVar("estate_id")) {
            $estated["estate_id"] = $this->request->getVar("estate_id");
        } else {
            $estated["estate_id"] = -1;
        }
        $us = $this->db
            ->table("estate")
            ->getWhere($estated);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "estate_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $estate) {
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $estate->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('estate') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $estate_id=   $this->request->getPost("estate_id");
            $cek=$this->db->table("divisi")
            ->where("estate_id", $estate_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "Estate masih dipakai di data Divisi!";
            } else{    
                $this->db
                ->table("estate")
                ->delete(array("estate_id" =>  $estate_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'estate_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('estate');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $estate_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'estate_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('estate')->update($input, array("estate_id" => $this->request->getPost("estate_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
