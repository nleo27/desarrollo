<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function create()
    {
        return view('create-periodo');
    }
}
