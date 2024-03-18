<?php

namespace App\Controllers\master;


use App\Controllers\baseController;

class mtphnumber extends baseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\master\mtphnumber_m();
        $data = $data->data();
        // dd($data);
        return view('master/mtphnumber_v', $data);
    }
}
