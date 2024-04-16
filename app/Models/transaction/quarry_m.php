<?php

namespace App\Models\transaction;

use App\Models\core_m;

class quarry_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek quarry
        if ($this->request->getVar("quarry_id")) {
            $quarryd["quarry_id"] = $this->request->getVar("quarry_id");
        } else {
            $quarryd["quarry_id"] = -1;
        }
        $us = $this->db
            ->table("quarry")
            ->getWhere($quarryd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("action", "data");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $quarry) {
                foreach ($this->db->getFieldNames('quarry') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $quarry->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('quarry') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $quarry_id = $this->request->getPost("quarry_id");              
            $this->db
            ->table("quarry")
            ->delete(array("quarry_id" =>  $quarry_id));
            $data["message"] = "Delete Success";
        }

         //submit
         if ($this->request->getPost("submit") == "OK") {
            $inpututama = $this->request->getPost("datakartu");
            $bintang = explode("*", $inpututama);

            //quarry
            $pisah = $bintang[0];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $input[$data[0]] = $data[1];
            }
            $builder = $this->db->table('quarry');
            $builder->insert($input);            
            /* echo $this->db->getLastQuery();
            die; */
            $quarry_id = $this->db->insertID();

            //panen
            $panjangBintang = count($bintang);
            for ($i = 1; $i < $panjangBintang; $i++) {
                $pisah = $bintang[$i];
                $koma = explode(",", $pisah);
                foreach ($koma as $isikoma) {
                    $data = explode("=", $isikoma);
                    $inputpanen[$data[0]] = $data[1];
                }
                $builder = $this->db->table('panen');
                $builder->insert($inputpanen);            
                /* echo $this->db->getLastQuery();
                die; */
                $panen_id = $this->db->insertID();
            }
            




            $data["message"] = "Insert Data Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'quarry_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $builder = $this->db->table('quarry');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $quarry_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'quarry_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('quarry')->update($input, array("quarry_id" => $this->request->getPost("quarry_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
