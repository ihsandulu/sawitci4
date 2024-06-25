<?php

namespace App\Models\transaction;

use App\Models\core_m;

class synchron_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek sptbs
        if ($this->request->getVar("sptbs_id")) {
            $sptbsd["sptbs_id"] = $this->request->getVar("sptbs_id");
        } else {
            $sptbsd["sptbs_id"] = -1;
        }
        $us = $this->db
            ->table("sptbs")
            ->join("t_user","t_user.user_id=sptbs.sptbs_createdby","left")
            ->join("t_vendor","t_vendor.ID_vendor=sptbs.sptbs_vendor","left")
            ->join("t_material","t_material.ID_material=sptbs.sptbs_material","left")
            ->join("t_asal","t_asal.id_asal=sptbs.sptbs_kecamatan","left")
            ->join("t_trukpenerimaan","t_trukpenerimaan.no_polisi=sptbs.sptbs_plat","left")
            ->join("t_driver","t_driver.ID_driver=sptbs.sptbs_driver","left")
            ->join("estate","estate.estate_id=sptbs.estate_id","left")
            ->join("divisi","divisi.divisi_id=sptbs.divisi_id","left")
            ->getWhere($sptbsd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "sptbs_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $sptbs) {
                foreach ($this->db->getFieldNames('sptbs') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('t_user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('t_vendor') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('t_material') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('t_asal') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('t_trukpenerimaan') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('t_driver') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('estate') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
                foreach ($this->db->getFieldNames('divisi') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $sptbs->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('sptbs') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('t_user') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('t_vendor') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('t_material') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('t_asal') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('t_trukpenerimaan') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('t_driver') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('estate') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('divisi') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $sptbs_id = $this->request->getPost("sptbs_id"); 
            $sptbs_card = $this->request->getPost("sptbs_card"); 
            $grading_date = $this->request->getPost("sptbs_date"); 
            $sptbsid = $this->request->getPost("sptbsid");            

            $wgrading["sptbs_card"]=$sptbs_card;
            $wgrading["grading_date"]=$grading_date;
            $wgrading["sptbsid"]=$sptbsid;
            $this->db
            ->table("grading")
            ->delete($wgrading);

            $this->db
            ->table("panen")
            ->delete(array("sptbs_id" =>  $sptbs_id));

            $this->db
            ->table("sptbs")
            ->delete(array("sptbs_id" =>  $sptbs_id));
            $data["message"] = "Delete Success";
        }

         //submit
         if ($this->request->getPost("submit") == "OK") {
            $inpututama = $this->request->getPost("datakartu");
            $bintang = explode("*", $inpututama);

            //sptbs
            $pisah = $bintang[0];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $input[$data[0]] = $data[1];
            }
            $builder = $this->db->table('sptbs');
            $builder->insert($input);            
            /* echo $this->db->getLastQuery();
            die; */
            $sptbs_id = $this->db->insertID();

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
                if ($e != 'create' && $e != 'sptbs_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["sptbs_date"] = date("Y-m-d");
            $input["user_id"] = session()->get("user_id");
            $builder = $this->db->table('sptbs');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $sptbs_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'sptbs_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('sptbs')->update($input, array("sptbs_id" => $this->request->getPost("sptbs_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
