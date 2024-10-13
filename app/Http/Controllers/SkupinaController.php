<?php

namespace App\Http\Controllers;

use App\Models\Skupina;
use Illuminate\Http\Request;

class SkupinaController extends Controller
{
    public function index()
    {
        $skupiny = Skupina::where('je_soukroma', 0)->get();
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
        // Debugging
        \Log::info('Before saving to DB:', [
            'je_soukroma' => $request->has('je_soukroma') ? 1 : 0,


        ]);


        \Log::info('Request data:', $request->all());

        $request->validate([
            'nazev_skupiny' => 'required|string|max:255',
            'je_soukroma' => 'boolean',
            'heslo' => 'required_if:je_soukroma,1',
        ]);


        // Vytvoření nové skupiny
        Skupina::create([
            'nazev_skupiny' => $request->input('nazev_skupiny'),
            'je_soukroma' => $request->input('je_soukroma') == '1' ? 1 : 0, // Zkontroluj, zda je hodnota opravdu '1'
            'heslo' => $request->input('heslo'),
            'id_admin' => auth()->user()->id,
        ]);

        // Přesměrování zpět na seznam skupin
        return redirect()->route('skupiny.index');
    }

}

