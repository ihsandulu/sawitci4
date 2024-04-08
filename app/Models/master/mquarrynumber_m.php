<?php

namespace App\Models\master;

use App\Models\core_m;

class mquarrynumber_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek quarrynumber
        if ($this->request->getVar("quarrynumber_id")) {
            $quarrynumberd["quarrynumber_id"] = $this->request->getVar("quarrynumber_id");
        } else {
            $quarrynumberd["quarrynumber_id"] = -1;
        }
        $us = $this->db
            ->table("quarrynumber")
            ->getWhere($quarrynumberd);
        // echo $this->db->getLastquery(); die;
        $larang = array("log_id", "id", "action", "data", "quarrynumber_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $quarrynumber) {
                foreach ($this->db->getFieldNames('quarrynumber') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $quarrynumber->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('quarrynumber') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $quarrynumber_id = $this->request->getPost("quarrynumber_id");              
            $this->db
            ->table("quarrynumber")
            ->delete(array("quarrynumber_id" =>  $quarrynumber_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'quarrynumber_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $builder = $this->db->table('quarrynumber');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $quarrynumber_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'quarrynumber_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('quarrynumber')->update($input, array("quarrynumber_id" => $this->request->getPost("quarrynumber_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
