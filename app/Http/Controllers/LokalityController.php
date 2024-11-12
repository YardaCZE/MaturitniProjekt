<?php

namespace App\Http\Controllers;

use App\Models\DruhReviru;
use App\Models\Kraj;
use App\Models\Lokality;
use App\Models\LokalityObrazky;
use App\Models\Skupina;
use App\Models\Ulovky;
use Illuminate\Http\Request;

class LokalityController extends Controller
{
    public function index()
    {
        $verejneLokality = Lokality::where('soukroma', 0)->get();
        $uzivatelovolokality = Lokality::where('id_zakladatele', auth()->id())->get();

        return view('lokality.index', compact('verejneLokality', 'uzivatelovolokality'));
    }

    public function create()
    {
        $druhy = DruhReviru::all();
        $kraje = Kraj::all();
        $uzivatelovySkupiny = auth()->user()->skupiny;
        $adminovySkupiny = Skupina::where('id_admin', auth()->id())->where('je_soukroma', true)->get();


        $vsechnySkupiny = $uzivatelovySkupiny->merge($adminovySkupiny)->unique('id');

        return view('lokality.vytvorit', compact('druhy', 'kraje', 'vsechnySkupiny'));
    }

    public function store(Request $request)
    {
        // Získání hodnoty checkboxů
        $soukroma = $request->get('soukroma') == "1";
        $soukSkup = $request->get('souk_skup') == "1";
        $soukOsob = $request->get('soukOsob') == "1";

        // Kontrola, že nemůže být zaškrtnuté obojí
        if ($soukSkup && $soukOsob) {
            return redirect()->back()->withErrors(['Nelze mít zárověň soukromou lokalitu pro osobu, i skupinu!".']);
        }

        // Kontrola, že pokud je zaškrtnuto soukOsob nebo soukSkup, musí být soukroma true
        if (($soukSkup || $soukOsob) && !$soukroma) {
            return redirect()->back()->withErrors(['být zaškrtnuto také soukromá.']);
        }

        // Kontrola, že pokud je zaškrtnuto soukSkup, musí být vyplněno soukSkupID
        if ($soukSkup && !$request->filled('soukSkupID')) {
            return redirect()->back()->withErrors(['Pokud je soukromé pro skupinu, je nutné vyplnit skupinu.']);
        }


        $validated = $request->validate([
            'nazev_lokality' => 'required|string',
            'druh' => 'required|string',
            'rozloha' => 'required|numeric',
            'kraj' => 'required|string',
            'souradnice' => 'required|string',
            'souk_skup' => 'nullable|boolean',
            'soukOsob' => 'nullable|boolean',
            'soukSkupID' => 'nullable|exists:skupiny,id',
        ]);

        // Uložení lokality do databáze
        $lokalita = Lokality::create([
            'nazev_lokality' => $validated['nazev_lokality'],
            'druh' => $validated['druh'],
            'rozloha' => $validated['rozloha'],
            'kraj' => $validated['kraj'],
            'souradnice' => $validated['souradnice'],
            'id_zakladatele' => auth()->id(),
            'soukroma' => $soukroma,
            'soukSkup' => $soukSkup,
            'soukOsob' => $soukOsob,
            'soukSkupID' => $request->input('soukSkupID'),
        ]);


        return redirect()->route('lokality.index')->with('success', 'Lokalita byla vytvořena.');
    }









    public function detail($id)
    {
        $lokalita = Lokality::with('obrazky')->findOrFail($id);
        return view('lokality.detail', compact('lokalita'));
    }

    public function nahratObrazek(Request $request, $id)
    {
        $lokalita = Lokality::findOrFail($id);


        $request->validate([
            'obrazky.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('obrazky')) {
            foreach ($request->file('obrazky') as $obrazek) {

                $cesta = $obrazek->store('lokality', 'public');


                LokalityObrazky::create([
                    'lokalita_id' => $lokalita->id,
                    'cesta_k_obrazku' => $cesta,
                ]);
            }
        }

        return redirect()->route('lokality.detail', $lokalita->id)
            ->with('success', 'Obrázky byly úspěšně nahrány.');
    }



    public function destroy(Lokality $lokalita)
    {
        $lokalita->delete();
        return redirect()->route('lokality.index')->with('success', 'Lokality byla úspěšně smazána.');
    }
}
