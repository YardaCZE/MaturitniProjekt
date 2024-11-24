<?php

namespace App\Http\Controllers;

use App\Models\Zavod;
use Illuminate\Http\Request;

class ZavodyController extends Controller
{
    public function index()
    {
        $verejneZavody = Zavod::where('soukromost', 0)->get();
        $uzivatelovoZavody = Zavod::where('id_zakladatele', auth()->id())->get();

        return view('zavody.index', compact('verejneZavody', 'uzivatelovoZavody'));
    }
}
