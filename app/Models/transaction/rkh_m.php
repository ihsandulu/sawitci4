<?php

namespace App\Models\transaction;

use App\Models\core_m;

class rkh_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek rkh
        if ($this->request->getVar("rkh_id")) {
            $rkhd["rkh_id"] = $this->request->getVar("rkh_id");
        } else {
            $rkhd["rkh_id"] = -1;
        }
        $us = $this->db
            ->table("rkh")
            ->join("tph","tph.tph_id=rkh.tph_id","left")
            ->join("blok","blok.blok_id=tph.blok_id","left")
            ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
            ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
            ->join("estate","estate.estate_id=divisi.estate_id","left")
            ->getWhere($rkhd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "rkh_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $rkh) {
                foreach ($this->db->getFieldNames('rkh') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $rkh->$field;
                    }
                }
                foreach ($this->db->getFieldNames('tph') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $rkh->$field;
                    }
                }
                foreach ($this->db->getFieldNames('blok') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $rkh->$field;
                    }
                }
                foreach ($this->db->getFieldNames('seksi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $rkh->$field;
                    }
                }
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $rkh->$field;
                    }
                }
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $rkh->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('rkh') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('tph') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('blok') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('seksi') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('divisi') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('estate') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $rkh_id = $this->request->getPost("rkh_id");              
            $this->db
            ->table("rkh")
            ->delete(array("rkh_id" =>  $rkh_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'rkh_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["rkh_date"] = date("Y-m-d");
            $input["user_id"] = session()->get("user_id");
            $builder = $this->db->table('rkh');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $rkh_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'rkh_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('rkh')->update($input, array("rkh_id" => $this->request->getPost("rkh_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
