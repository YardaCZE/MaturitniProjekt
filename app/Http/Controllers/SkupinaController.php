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
            'je_soukroma' => 'required|boolean',
        ]);

        // Vytvoření nové skupiny
        Skupina::create([
            'nazev_skupiny' => $request->input('nazev_skupiny'),
            'je_soukroma' => $request->input('je_soukroma'),
            'id_admin' => auth()->user()->id, // Předpoklad, že uživatel je přihlášen
        ]);

        // Přesměrování zpět na seznam skupin
        return redirect()->route('skupiny.index');
    }




}


