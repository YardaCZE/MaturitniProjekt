<?php

namespace App\Http\Controllers;

use App\Models\Lokality;
use App\Models\Meric;
use App\Models\Zavod;
use App\Models\Zavodnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'lokalita' => 'nullable|exists:lokality,id',
            'soukromost' => 'boolean',
            'datum_zahajeni' => 'required|date',
            'datum_ukonceni' => 'required|date|after_or_equal:datum_zahajeni',
        ]);


        $zavod = Zavod::create([
            'nazev' => $validated['nazev'],
            'id_zakladatele' => auth()->id(),
            'lokalita' => $validated['lokalita'] ?: null,
            'soukromost' => $request->has('soukromost'),
            'stav' => 1, // Výchozí stav závodu
            'datum_zahajeni' => $validated['datum_zahajeni'],
            'datum_ukonceni' => $validated['datum_ukonceni'],
        ]);

        return redirect()->route('zavody.index')->with('success', 'Závod byl úspěšně přidán.');
    }

    public function detail($id)
    {
        $zavod = Zavod::findOrFail($id);


        $zavodnici = DB::table('cleni_zavodu')
            ->leftJoin('ulovky_zavodu', function ($join) use ($id) {
                $join->on('cleni_zavodu.id', '=', 'ulovky_zavodu.id_zavodnika')
                    ->where('ulovky_zavodu.id_zavodu', '=', $id);
            })
            ->select(
                'cleni_zavodu.jmeno',
                'cleni_zavodu.prijmeni',
                'cleni_zavodu.datum_narozeni',
                DB::raw('COALESCE(SUM(ulovky_zavodu.body), 0) as body_celkem')
            )
            ->whereExists(function ($query) use ($id) {
                $query->select(DB::raw(1))
                    ->from('zavody')
                    ->whereColumn('zavody.id', 'cleni_zavodu.id_zavodu')
                    ->where('zavody.id', $id);
            })
            ->groupBy('cleni_zavodu.id')
            ->get();

        return view('zavody.detail', compact('zavod', 'zavodnici'));
    }


    public function pridatZavodnika($id)
    {
        $zavod = Zavod::findOrFail($id);
        return view('zavody.pridatZavodnika', compact('zavod'));
    }



    public function storeZavodnik(Request $request, $id)
    {
        $zavod = Zavod::findOrFail($id);


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
