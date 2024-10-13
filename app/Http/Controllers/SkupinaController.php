<?php

namespace App\Http\Controllers;

use App\Models\Skupina;
use Illuminate\Http\Request;

class SkupinaController extends Controller
{

    public function index()
    {
        $skupiny = Skupina::all();
        return view('skupiny.index', compact('skupiny'));
    }

    // Metoda pro zobrazení detailu skupiny
    public function show($id)
    {
        $skupina = Skupina::findOrFail($id); // Získání skupiny podle ID
        $prispevky = $skupina->prispevky; // Získání příspěvků pro tuto skupinu
        return view('skupiny.show', compact('skupina', 'prispevky')); // Předání dat do view
    }

    public function create()
    {
        return view('skupiny.create');
    }

    // Metoda pro uložení nové skupiny do databáze
    public function store(Request $request)
    {
        // Validace vstupu
        $request->validate([
            'nazev_skupiny' => 'required|string|max:255',
        ]);

        // Vytvoření nové skupiny
        Skupina::create([
            'nazev_skupiny' => $request->input('nazev_skupiny'),
            'je_soukroma' => $request->has('je_soukroma') ? 1 : 0, // Pokud je checkbox zaškrtnutý, nastaví 1, jinak 0
            'id_admin' => auth()->user()->id, // Předpoklad, že uživatel je přihlášen
        ]);

        // Přesměrování zpět na seznam skupin
        return redirect()->route('skupiny.index');
    }




}


