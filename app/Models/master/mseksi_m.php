<?php

namespace App\Models\master;

use App\Models\core_m;

class mseksi_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek seksi
        if ($this->request->getVar("seksi_id")) {
            $seksid["seksi_id"] = $this->request->getVar("seksi_id");
        } else {
            $seksid["seksi_id"] = -1;
        }
        $us = $this->db
            ->table("seksi")
            ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
            ->join("estate","estate.estate_id=divisi.estate_id","left")
            ->getWhere($seksid);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "seksi_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $seksi) {
                foreach ($this->db->getFieldNames('seksi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $seksi->$field;
                    }
                }
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $seksi->$field;
                    }
                }
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $seksi->$field;
                    }
                }
            }
        } else {
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
            $seksi_id=   $this->request->getPost("seksi_id");
            $cek=$this->db->table("blok")
            ->where("seksi_id", $seksi_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "seksi masih dipakai di data TPH!";
            } else{    
                $this->db
                ->table("seksi")
                ->delete(array("seksi_id" =>  $seksi_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'seksi_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('seksi');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $seksi_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'seksi_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('seksi')->update($input, array("seksi_id" => $this->request->getPost("seksi_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
