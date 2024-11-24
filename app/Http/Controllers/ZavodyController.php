<?php

namespace App\Http\Controllers;

use App\Models\Meric;
use App\Models\Zavod;
use Illuminate\Http\Request;

class ZavodyController extends Controller
{
    public function index()
    {
        $verejneZavody = Zavod::where('soukromost', 0)->get();
        $zavodyKdeZakladatel = Zavod::where('id_zakladatele', auth()->id())->get();
        $zavodyKdeMeric = Zavod::whereHas('merici', function ($query) {
            $query->where('id_uzivatele', auth()->id());
        })->get();

        $uzivatelovoZavody = $zavodyKdeZakladatel->merge($zavodyKdeMeric)->unique('id');
        return view('zavody.index', compact('verejneZavody', 'uzivatelovoZavody'));
    }
}
