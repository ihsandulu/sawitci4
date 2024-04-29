<?php

namespace App\Models;



class login_m extends core_m
{
    public function index()
    {
        //require_once("meta_m.php");
        $data = array();
        $data["message"] = "";
        $data["hasil"] = "";
        $data['masuk'] = 0;


        $identity = $this->db->table("identity")->get()->getRow();
        // dd($identity->identity_twitter);

        if (isset($_POST["user_nik"]) && isset($_POST["password"])) {
            $builder = $this->db->table("t_user")
                ->join("position", "position.position_id=t_user.position_id", "left")
                ->where("user_nik", $this->request->getVar("user_nik"));
            $user1 = $builder
                ->get();

                
         
            // define('production',$this->db->database);
            // echo production;
            // $lastquery = $this->db->getLastQuery();
            // echo $lastquery;
            // die;
        //    $query = $this->db->query("SELECT * FROM `user`  WHERE `user_nik` = 'ihsan.dulu@gmail.com'");
        //     echo $query->getFieldCount();
            // die;

            $halaman = array();
            if ($user1->getNumRows() > 0) {
                foreach ($user1->getResult() as $user) {
                    $password = $user->password;
                    // if (password_verify($this->request->getVar("password"), $password)) {
                    if ($this->request->getVar("password") == $password) {

                        // echo $user->identity_id;die;
                        $this->session->set("position_administrator", $user->position_id);
                        $this->session->set("position_id", $user->position_id);
                        $this->session->set("position_name", $user->position_name);
                        $this->session->set("username", $user->username);
                        $this->session->set("user_nik", $user->user_nik);
                        $this->session->set("nama", $user->nama);
                        $this->session->set("user_id", $user->user_id);
                        $this->session->set("identity_id", $identity->identity_id);
                        $this->session->set("identity_name", $identity->identity_name);
                        $this->session->set("identity_logo", $identity->identity_logo);
                        $this->session->set("identity_phone", $identity->identity_phone);
                        $this->session->set("identity_address", $identity->identity_address);
                        $this->session->set("identity_company", $identity->identity_company);
                        $this->session->set("identity_about", $identity->identity_about);

                         //tambahkan modul di sini                         
                        $pages = $this->db->table("positionpages")
                        ->join("pages","pages.pages_id=positionpages.pages_id","left")
                        ->where("position_id", $user->position_id)
                        ->get();
                       foreach ($pages->getResult() as $pages) {
                            // $halaman = array(109, 110, 111, 112, 116, 117, 118, 119, 120, 121, 122, 123, 159, 173,187,188,189,190,192,196);
                            $halaman[$pages->pages_id]['act_read'] = $pages->positionpages_read;
                            $halaman[$pages->pages_id]['act_create'] = $pages->positionpages_create;
                            $halaman[$pages->pages_id]['act_update'] = $pages->positionpages_update;
                            $halaman[$pages->pages_id]['act_delete'] = $pages->positionpages_delete;
                            $halaman[$pages->pages_id]['act_approve'] = $pages->positionpages_approve;
                        }
                        $this->session->set("halaman", $halaman);
                       
                        $data["hasil"] = " Selamat Datang  " . $user->username;
                        $this->session->setFlashdata('hasil', $data["hasil"]);
                        $data['masuk'] = 1;
                    } else {
                        $data["hasil"] = " Password Salah !";
                        // $data["hasil"]=password_verify('123456', '123456').">>>".$this->request->getVar("password").">>>".$password;
                    }
                }
            } else {
                $data["hasil"] = " NIK Salah !";
            }
        }

        $this->session->setFlashdata('message', $data["hasil"]);
        return $data;
    }
}
