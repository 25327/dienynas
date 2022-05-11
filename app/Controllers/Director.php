<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Director extends BaseController
{

    public function __construct()
    {

    }

    public function index()
    {
        if($this->user['type'] != 'director'){
            dd('klaida');
        }

        return view('users/director');
    }
}
