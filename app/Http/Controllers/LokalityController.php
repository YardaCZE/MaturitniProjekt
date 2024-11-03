<?php

namespace App\Http\Controllers;

use App\Models\Lokality;
use App\Models\LokalityObrazky;
use Illuminate\Http\Request;

class LokalityController extends Controller
{
    public function index()
    {
        $lokality = Lokality::all();
        return view('lokality.index', compact('lokality'));
    }

    public function create()
    {
        return view('lokality.vytvorit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nazev_lokality' => 'required|string',
            'druh' => 'required|string',
            'rozloha' => 'required|numeric',
            'kraj' => 'required|string',
            'souradnice' => 'required|string',

        ]);

        $lokalita = Lokality::create([
            'nazev_lokality' => $validated['nazev_lokality'],
            'druh' => $validated['druh'],
            'rozloha' => $validated['rozloha'],
            'kraj' => $validated['kraj'],
            'souradnice' => $validated['souradnice'],
            'id_zakladatele' => auth()->id(),
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
