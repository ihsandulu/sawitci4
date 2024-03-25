<?php

namespace App\Models\master;

use App\Models\core_m;

class mgrading_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek grading
        if ($this->request->getVar("grading_id")) {
            $gradingd["grading_id"] = $this->request->getVar("grading_id");
        } else {
            $gradingd["grading_id"] = -1;
        }
        $us = $this->db
            ->table("grading")
            ->getWhere($gradingd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "grading_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $grading) {
                foreach ($this->db->getFieldNames('grading') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $grading->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('grading') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $grading_id=$this->request->getPost("grading_id");
            $cek=$this->db->table("seksi")
            ->where("grading_id", $grading_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "grading masih dipakai di data blok!";
            } else{    
                $this->db
                ->table("grading")
                ->delete(array("grading_id" =>  $grading_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'grading_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('grading');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $grading_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'grading_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('grading')->update($input, array("grading_id" => $this->request->getPost("grading_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
