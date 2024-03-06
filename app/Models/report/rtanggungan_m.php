<?php

namespace App\Models\report;

use App\Models\core_m;

class rtanggungan_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek tanggungan
        if ($this->request->getVar("tanggungan_id")) {
            $tanggungand["tanggungan_id"] = $this->request->getVar("tanggungan_id");
        } else {
            $tanggungand["tanggungan_id"] = -1;
        }
        $us = $this->db
            ->table("tanggungan")
            ->join("user","user.user_id=tanggungan.user_id","left")
            ->getWhere($tanggungand);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "tanggungan_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $tanggungan) {
                foreach ($this->db->getFieldNames('tanggungan') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tanggungan->$field;
                    }
                }
                foreach ($this->db->getFieldNames('user') as $field) {
                    $data[$field] = $tanggungan->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('tanggungan') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
        }

        
        //delete
        if ($this->request->getPost("delete") == "OK") {           
            $this->db
                ->table("tanggungan")
                ->delete(array("tanggungan_id" => $this->request->getPost("tanggungan_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'tanggungan_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["tanggungan_date"] = date("Y-m-d");
            $input["tanggungan_tahun"] = date("Y");
            $builder = $this->db->table('tanggungan');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $tanggungan_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'tanggungan_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('tanggungan')->update($input, array("tanggungan_id" => $this->request->getPost("tanggungan_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
