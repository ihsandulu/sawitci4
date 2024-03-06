<?php

namespace App\Models\master;

use App\Models\core_m;

class mblok_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek blok
        if ($this->request->getVar("blok_id")) {
            $blokd["blok_id"] = $this->request->getVar("blok_id");
        } else {
            $blokd["blok_id"] = -1;
        }
        $us = $this->db
            ->table("blok")
            ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
            ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
            ->join("estate","estate.estate_id=divisi.estate_id","left")
            ->getWhere($blokd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "blok_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $blok) {
                foreach ($this->db->getFieldNames('blok') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $blok->$field;
                    }
                }
                foreach ($this->db->getFieldNames('seksi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $blok->$field;
                    }
                }
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $blok->$field;
                    }
                }
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $blok->$field;
                    }
                }
            }
        } else {
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
            $blok_id=   $this->request->getPost("blok_id");
            $cek=$this->db->table("tph")
            ->where("blok_id", $blok_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "Blok masih dipakai di data TPH!";
            } else{    
                $this->db
                ->table("blok")
                ->delete(array("blok_id" =>  $blok_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'blok_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('blok');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $blok_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'blok_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('blok')->update($input, array("blok_id" => $this->request->getPost("blok_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
