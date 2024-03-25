<?php

namespace App\Models\master;

use App\Models\core_m;

class mgradingtype_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek gradingtype
        if ($this->request->getVar("gradingtype_id")) {
            $gradingtyped["gradingtype_id"] = $this->request->getVar("gradingtype_id");
        } else {
            $gradingtyped["gradingtype_id"] = -1;
        }
        $us = $this->db
            ->table("gradingtype")
            ->getWhere($gradingtyped);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "gradingtype_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $gradingtype) {
                foreach ($this->db->getFieldNames('gradingtype') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $gradingtype->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('gradingtype') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $gradingtype_id=$this->request->getPost("gradingtype_id");
            $cek=$this->db->table("seksi")
            ->where("gradingtype_id", $gradingtype_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "gradingtype masih dipakai di data blok!";
            } else{    
                $this->db
                ->table("gradingtype")
                ->delete(array("gradingtype_id" =>  $gradingtype_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'gradingtype_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('gradingtype');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $gradingtype_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'gradingtype_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('gradingtype')->update($input, array("gradingtype_id" => $this->request->getPost("gradingtype_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
