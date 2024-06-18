<?php

namespace App\Controllers\report;


use App\Controllers\baseController;

class rhkp extends baseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data["message"]="";
        return view('report/rhkp_v', $data);
    }
}
