<?php

namespace App\Models\master;

use App\Models\core_m;

class mtph_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek tph
        if ($this->request->getVar("tph_id")) {
            $tphd["tph_id"] = $this->request->getVar("tph_id");
        } else {
            $tphd["tph_id"] = -1;
        }
        $us = $this->db
            ->table("tph")
            ->join("blok","blok.blok_id=tph.blok_id","left")
            ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
            ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
            ->join("estate","estate.estate_id=divisi.estate_id","left")
            ->getWhere($tphd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "tph_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $tph) {
                foreach ($this->db->getFieldNames('tph') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tph->$field;
                    }
                }
                foreach ($this->db->getFieldNames('blok') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tph->$field;
                    }
                }
                foreach ($this->db->getFieldNames('seksi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tph->$field;
                    }
                }
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tph->$field;
                    }
                }
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tph->$field;
                    }
                }
            }
        } else {
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
            $tph_id = $this->request->getPost("tph_id");              
            $this->db
            ->table("tph")
            ->delete(array("tph_id" =>  $tph_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'tph_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('tph');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $tph_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'tph_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('tph')->update($input, array("tph_id" => $this->request->getPost("tph_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
