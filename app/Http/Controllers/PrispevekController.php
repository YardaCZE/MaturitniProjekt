<?php

namespace App\Http\Controllers;

use App\Models\Prispevek;
use Illuminate\Http\Request;

class PrispevekController extends Controller
{
    public function index()
    {
        $prispevky = Prispevek::all();
        return view('skupiny.show', compact('prispevky'));
    }
}
