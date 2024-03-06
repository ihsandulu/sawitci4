<?php

namespace App\Controllers\master;


use App\Controllers\baseController;

class mseksi extends baseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\master\mseksi_m();
        $data = $data->data();
        return view('master/mseksi_v', $data);
    }
}
