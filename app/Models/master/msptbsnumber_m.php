<?php

namespace App\Models\master;

use App\Models\core_m;

class msptbsnumber_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek sptbsnumber
        if ($this->request->getVar("sptbsnumber_id")) {
            $sptbsnumberd["sptbsnumber_id"] = $this->request->getVar("sptbsnumber_id");
        } else {
            $sptbsnumberd["sptbsnumber_id"] = -1;
        }
        $us = $this->db
            ->table("sptbsnumber")
            ->getWhere($sptbsnumberd);
        // echo $this->db->getLastquery(); die;
        $larang = array("log_id", "id", "action", "data", "sptbsnumber_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $sptbsnumber) {
                foreach ($this->db->getFieldNames('sptbsnumber') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbsnumber->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('sptbsnumber') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $sptbsnumber_id = $this->request->getPost("sptbsnumber_id");              
            $this->db
            ->table("sptbsnumber")
            ->delete(array("sptbsnumber_id" =>  $sptbsnumber_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'sptbsnumber_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $builder = $this->db->table('sptbsnumber');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $sptbsnumber_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'sptbsnumber_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('sptbsnumber')->update($input, array("sptbsnumber_id" => $this->request->getPost("sptbsnumber_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
