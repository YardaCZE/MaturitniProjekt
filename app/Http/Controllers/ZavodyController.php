<?php

namespace App\Http\Controllers;

use App\Models\Lokality;
use App\Models\Meric;
use App\Models\Zavod;
use App\Models\Zavodnik;
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

    public function detail($id)
    {
        $zavod = Zavod::findOrFail($id);
        return view('zavody.detail', compact('zavod'));
    }

    public function pridatZavodnika($id)
    {
        $zavod = Zavod::findOrFail($id);
        return view('zavody.pridatZavodnika', compact('zavod'));
    }



    public function storeZavodnik(Request $request, $id)
    {
        $zavod = Zavod::findOrFail($id);

        // Zkontroluj, zda je uživatel autorem závodu
        if ($zavod->id_zakladatele !== auth()->id()) {
            return redirect()->route('zavody.index')->with('error', 'Nemáte oprávnění přidat závodníka do tohoto závodu.');
        }

        $validated = $request->validate([
            'jmeno' => 'required|string|max:255',
            'prijmeni' => 'required|string|max:255',
            'narozeni' => 'required|date',
        ]);

        Zavodnik::create([
            'id_zavodu' => $id,
            'jmeno' => $validated['jmeno'],
            'prijmeni' => $validated['prijmeni'],
            'datum_narozeni' => $validated['narozeni'],
        ]);

        return back()->with('success', 'Závodník byl úspěšně přidán.');
    }

}
