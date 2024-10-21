<?php

namespace App\Http\Controllers;

use App\Models\Obrazek;
use App\Models\Prispevek;
use Illuminate\Http\Request;

class PrispevekController extends Controller
{
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nadpis' => 'required|string|max:255',
        'text' => 'required',
        'obrazky.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $prispevek = Prispevek::create([
        'nadpis' => $validatedData['nadpis'],
        'text' => $validatedData['text'],
        'id_skupiny' => $request->skupina_id,
        'id_autora' => auth()->user()->id,
    ]);

    if ($request->hasFile('obrazky')) {
        foreach ($request->file('obrazky') as $obrazek) {
            $cesta_k_obrazku = $obrazek->store('obrazky', 'public');
            Obrazek::create([
                'ID_prispevku' => $prispevek->id,
                'cesta_k_obrazku' => $cesta_k_obrazku,
            ]);
        }
    }

    return redirect()->route('skupiny.show', $request->skupina_id);
}

    public function create(Request $request)
    {
        $skupina_id = $request->skupina_id;
        return view('prispevky.create', compact('skupina_id'));
    }
    public function detail($id)
    {
        $prispevek = Prispevek::findOrFail($id);
        return view('prispevky.detail', compact('prispevek'));
    }

    public function destroy($id)
    {
        $prispevek = Prispevek::findOrFail($id);
        $prispevek->delete();

        return redirect()->route('skupiny.show', $skupina->id)->with('success', 'Příspěvěk byla úspěšně smazán.');
    }

}
