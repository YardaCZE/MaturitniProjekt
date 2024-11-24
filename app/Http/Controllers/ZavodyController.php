<?php

namespace App\Http\Controllers;

use App\Models\Lokality;
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

    public function create()
    {
        $lokality = Lokality::all();
        return view('zavody.create', compact('lokality'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nazev' => 'required|string',
            'lokalita' => 'nullable|exists:lokality,id', // Povolit null pro žádnou lokalitu
            'soukromost' => 'boolean',
            'datum_zahajeni' => 'required|date',
            'datum_ukonceni' => 'required|date|after_or_equal:datum_zahajeni',
        ]);

        // Založení závodu
        $zavod = Zavod::create([
            'nazev' => $validated['nazev'],
            'id_zakladatele' => auth()->id(),
            'lokalita' => $validated['lokalita'] ?: null, // Pokud je hodnota 0, uložit null
            'soukromost' => $request->has('soukromost'), // Vrátí true/false podle checkboxu
            'stav' => 1, // Výchozí stav závodu
            'datum_zahajeni' => $validated['datum_zahajeni'],
            'datum_ukonceni' => $validated['datum_ukonceni'],
        ]);

        return redirect()->route('zavody.index')->with('success', 'Závod byl úspěšně přidán.');
    }

}
