<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
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
        $prispevek = Prispevek::with(['obrazky', 'komentare.odpovedi'])->findOrFail($id);
        return view('prispevky.detail', compact('prispevek'));
    }

    public function ulozitKomentar(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:500',
        ]);

        Komentar::create([
            'prispevek_id' => $id,
            'uzivatel_id' => auth()->id(),
            'text' => $request->text,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('prispevky.detail', $id)->with('status', 'Komentář byl přidán.');
    }


    public function destroy($id)
    {
        $prispevek = Prispevek::findOrFail($id);
        $skupina_id = $prispevek->id_skupiny;
        $prispevek->delete();

        return redirect()->route('skupiny.show', $skupina_id)->with('success', 'Příspěvek byl úspěšně smazán.');
    }

}
