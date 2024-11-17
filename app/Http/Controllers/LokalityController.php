<?php

namespace App\Http\Controllers;

use App\Models\DruhReviru;
use App\Models\Kraj;
use App\Models\LikeLokalita;
use App\Models\Lokality;
use App\Models\LokalityObrazky;
use App\Models\SaveLokalita;
use App\Models\Skupina;
use App\Models\Ulovky;
use Illuminate\Http\Request;

class LokalityController extends Controller
{
    public function index()
    {
        $verejneLokality = Lokality::where('soukroma', 0)
            ->orderBy('likes', 'desc')
            ->get();

        $uzivatelovolokality = Lokality::where('id_zakladatele', auth()->id())
            ->orderBy('likes', 'desc')
            ->get();

        return view('lokality.index', compact('verejneLokality', 'uzivatelovolokality'));
    }

    public function create()
    {
        $druhy = DruhReviru::all();
        $kraje = Kraj::all();
        $verejneSkupiny = Skupina::where('je_soukroma', false)->get();
        $uzivatelovySkupiny = auth()->user()->skupiny;
        $adminovySkupiny = Skupina::where('id_admin', auth()->id())->where('je_soukroma', true)->get();

        $skoroVsechnySkupiny = $uzivatelovySkupiny->merge($adminovySkupiny)->unique('id');
        $vsechnySkupiny = $skoroVsechnySkupiny->merge($verejneSkupiny)->unique('id');

        return view('lokality.vytvorit', compact('druhy', 'kraje', 'vsechnySkupiny'));
    }

    public function store(Request $request)
    {
        // Získání hodnoty checkboxů
        $soukroma = $request->get('soukroma') == "1";
        $soukSkup = $request->get('souk_skup') == "1";
        $soukOsob = $request->get('soukOsob') == "1";
       // dd($request->all());
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

    public function soukromeLokality($skupina_id)
    {

        $soukromeLokality = Lokality::where('soukSkup', 1)
            ->where('soukSkupID', $skupina_id)
            ->get();


        $skupina = Skupina::findOrFail($skupina_id);

        return view('lokality.skupinaLokality', compact('soukromeLokality', 'skupina'));
    }

    public function like($id)
    {
        $userId = auth()->id();
        $lokalita = Lokality::findOrFail($id);

        $existingLike = LikeLokalita::where('user_id', $userId)
            ->where('lokalita_id', $id)
            ->first();

        if ($existingLike) {
            // Pokud už existuje, smažu
            $existingLike->delete();
            $lokalita->decrement('likes');
        } else {

            LikeLokalita::create([
                'user_id' => $userId,
                'lokalita_id' => $id,
            ]);
            $lokalita->increment('likes');
        }

        return redirect()->back();
    }

    public function save($id)
    {
        $userId = auth()->id();

        $existingSave = SaveLokalita::where('user_id', $userId)
            ->where('lokalita_id', $id)
            ->first();

        if ($existingSave) {
            // Pokud už existuje, smažu
            $existingSave->delete();
        } else {

            SaveLokalita::create([
                'user_id' => $userId,
                'lokalita_id' => $id,
            ]);
        }

        return redirect()->back();
    }



    public function destroy(Lokality $lokalita)
    {
        $lokalita->delete();
        return redirect()->route('lokality.index')->with('success', 'Lokality byla úspěšně smazána.');
    }
}
