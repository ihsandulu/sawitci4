<?php

namespace App\Models\master;

use App\Models\core_m;

class mplacement_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek placement
        if ($this->request->getVar("placement_id")) {
            $placementd["placement_id"] = $this->request->getVar("placement_id");
        } else {
            $placementd["placement_id"] = -1;
        }
        $us = $this->db
            ->table("placement")
            ->select("*, placement.user_id as user_id")
            ->join("t_user","t_user.user_id=placement.user_id","left")
            ->join("position","position.position_id=t_user.position_id","left")
            ->join("tph","tph.tph_id=placement.tph_id","left")
            ->join("blok","blok.blok_id=placement.blok_id","left")
            ->join("seksi","seksi.seksi_id=placement.seksi_id","left")
            ->join("divisi","divisi.divisi_id=placement.divisi_id","left")
            ->join("estate","estate.estate_id=placement.estate_id","left")
            ->getWhere($placementd);
        // echo $this->db->getLastquery(); die;
        $larang = array("log_id", "id", "action", "data", "placement_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $placement) {
                foreach ($this->db->getFieldNames('placement') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
                foreach ($this->db->getFieldNames('tph') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
                foreach ($this->db->getFieldNames('blok') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
                foreach ($this->db->getFieldNames('seksi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
                foreach ($this->db->getFieldNames('t_user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
                foreach ($this->db->getFieldNames('position') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $placement->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('placement') as $field) {
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
            foreach ($this->db->getFieldNames('t_user') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('position') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $placement_id = $this->request->getPost("placement_id");              
            $this->db
            ->table("placement")
            ->delete(array("placement_id" =>  $placement_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'placement_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $builder = $this->db->table('placement');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $placement_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'placement_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('placement')->update($input, array("placement_id" => $this->request->getPost("placement_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
