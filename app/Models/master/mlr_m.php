<?php

namespace App\Models\master;

use App\Models\core_m;

class mlr_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek lr
        if ($this->request->getVar("lr_id")) {
            $lrd["lr_id"] = $this->request->getVar("lr_id");
        } else {
            $lrd["lr_id"] = -1;
        }
        $us = $this->db
            ->table("lr")
            ->join("blok","blok.blok_id=lr.blok_id","left")
            ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
            ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
            ->join("estate","estate.estate_id=divisi.estate_id","left")
            ->getWhere($lrd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "lr_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $lr) {
                foreach ($this->db->getFieldNames('lr') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lr->$field;
                    }
                }
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lr->$field;
                    }
                }
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lr->$field;
                    }
                }
                foreach ($this->db->getFieldNames('seksi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lr->$field;
                    }
                }
                foreach ($this->db->getFieldNames('blok') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lr->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('lr') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('estate') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('divisi') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('seksi') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('blok') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $lr_id=   $this->request->getPost("lr_id");  
                $this->db
                ->table("lr")
                ->delete(array("lr_id" =>  $lr_id));
                $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'lr_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('lr');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $lr_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'lr_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('lr')->update($input, array("lr_id" => $this->request->getPost("lr_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
