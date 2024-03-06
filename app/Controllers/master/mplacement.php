<?php

namespace App\Controllers\master;


use App\Controllers\baseController;

class mplacement extends baseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\master\mplacement_m();
        $data = $data->data();
        // dd($data);
        return view('master/mplacement_v', $data);
    }
}
