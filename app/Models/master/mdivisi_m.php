<?php

namespace App\Models\master;

use App\Models\core_m;

class mdivisi_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek divisi
        if ($this->request->getVar("divisi_id")) {
            $divisid["divisi_id"] = $this->request->getVar("divisi_id");
        } else {
            $divisid["divisi_id"] = -1;
        }
        $us = $this->db
            ->table("divisi")
            ->getWhere($divisid);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "divisi_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $divisi) {
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $divisi->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('divisi') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $divisi_id=$this->request->getPost("divisi_id");
            $cek=$this->db->table("seksi")
            ->where("divisi_id", $divisi_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "Divisi masih dipakai di data blok!";
            } else{    
                $this->db
                ->table("divisi")
                ->delete(array("divisi_id" =>  $divisi_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'divisi_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('divisi');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $divisi_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'divisi_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('divisi')->update($input, array("divisi_id" => $this->request->getPost("divisi_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
