<?php

namespace App\Models\master;

use App\Models\core_m;

class mquarrytype_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek quarrytype
        if ($this->request->getVar("quarrytype_id")) {
            $quarrytyped["quarrytype_id"] = $this->request->getVar("quarrytype_id");
        } else {
            $quarrytyped["quarrytype_id"] = -1;
        }
        $us = $this->db
            ->table("quarrytype")
            ->getWhere($quarrytyped);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "quarrytype_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $quarrytype) {
                foreach ($this->db->getFieldNames('quarrytype') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $quarrytype->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('quarrytype') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $quarrytype_id=   $this->request->getPost("quarrytype_id");  
                $this->db
                ->table("quarrytype")
                ->delete(array("quarrytype_id" =>  $quarrytype_id));
                $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'quarrytype_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('quarrytype');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $quarrytype_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'quarrytype_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('quarrytype')->update($input, array("quarrytype_id" => $this->request->getPost("quarrytype_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
