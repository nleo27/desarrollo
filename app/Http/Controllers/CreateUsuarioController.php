<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\User;

class CreateUsuarioController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('create-usuario', compact('areas'));
    }
}
