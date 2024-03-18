<?php

namespace App\Models\master;

use App\Models\core_m;

class mtphnumber_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek tphnumber
        if ($this->request->getVar("tphnumber_id")) {
            $tphnumberd["tphnumber_id"] = $this->request->getVar("tphnumber_id");
        } else {
            $tphnumberd["tphnumber_id"] = -1;
        }
        $us = $this->db
            ->table("tphnumber")
            ->getWhere($tphnumberd);
        // echo $this->db->getLastquery(); die;
        $larang = array("log_id",  "action", "data");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $tphnumber) {
                foreach ($this->db->getFieldNames('tphnumber') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tphnumber->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('tphnumber') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $tphnumber_id = $this->request->getPost("tphnumber_id");              
            $this->db
            ->table("tphnumber")
            ->delete(array("tphnumber_id" =>  $tphnumber_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'tphnumber_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $builder = $this->db->table('tphnumber');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $tphnumber_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'tphnumber_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('tphnumber')->update($input, array("tphnumber_id" => $this->request->getPost("tphnumber_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
