<?php

namespace App\Http\Controllers;

use App\Models\KomentarUlovky;
use App\Models\Lokality;
use App\Models\ObrazkyUlovky;
use App\Models\TypLovu;
use App\Models\Ulovky;
use Illuminate\Http\Request;
use App\Models\DruhReviru;

class UlovkyController extends Controller
{
    public function index(Request $request)
    {
        $query = Ulovky::query();


        $query->with(['lokalita', 'TypLovu']);


        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('druh_ryby', 'LIKE', '%' . $search . '%')
                ->orWhere('delka', 'LIKE', '%' . $search . '%')
                ->orWhere('vaha', 'LIKE', '%' . $search . '%')
                ->orWhereHas('lokalita', function($q) use ($search) {
                    $q->where('nazev_lokality', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('typLovu', function($q) use ($search) {
                    $q->where('druh', 'LIKE', '%' . $search . '%');
                });
        }


        if ($request->has('sort') && in_array($request->sort, ['delka', 'vaha'])) {
            $query->orderBy($request->sort, 'desc');
        }


        $ulovky = $query->paginate(10);

        return view('ulovky.index', compact('ulovky'));
    }

    public function detail($id)
    {
        $ulovek = Ulovky::with(['obrazky', 'komentare'])->findOrFail($id);
        return view('ulovky.detail', compact('ulovek'));
    }

    public function ulozitKomentar(Request $request, $ulovek_id)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:komentare_ulovky,id',
        ]);

        KomentarUlovky::create([
            'ulovek_id' => $ulovek_id,
            'uzivatel_id' => auth()->id(),
            'text' => $request->text,
            'parent_id' => $request->input('parent_id'),
        ]);

        return redirect()->route('ulovky.detail', $ulovek_id)->with('status', 'Komentář byl přidán.');
    }



    public function create()
    {
        $typyLovu = TypLovu::all();
        $lokality = Lokality::all();
        $druhyReviru = DruhReviru::all();
        return view('ulovky.create', compact('typyLovu', 'lokality', 'druhyReviru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'druh_ryby' => 'required|string',
            'delka' => 'required|numeric',
            'vaha' => 'required|numeric',
            'id_typu_lovu' => 'required|exists:typ_lovu,id',
            'id_lokality' => 'required|exists:lokality,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Načíst lokalitu a získat hodnotu sloupce 'druh'
        $lokalita = Lokality::findOrFail($request->id_lokality);
        $druh_reviru = $lokalita->druh; // Získání hodnoty sloupce 'druh'

        // Vytvoření záznamu úlovku s vyplněným druhem revíru
        $ulovek = Ulovky::create(array_merge(
            $request->only('druh_ryby', 'delka', 'vaha', 'id_typu_lovu', 'id_lokality'),
            [
                'id_druhu_reviru' => $druh_reviru, // Používá hodnotu z lokality
                'id_uzivatele' => auth()->id()
            ]
        ));

        // Uložení obrázků, pokud existují
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('obrazky', 'public');
                ObrazkyUlovky::create([
                    'id_ulovku' => $ulovek->id,
                    'cesta_k_obrazku' => $path,
                ]);
            }
        }

        return redirect()->route('ulovky.index')->with('success', 'Úlovek byl úspěšně přidán.');
    }





    public function destroy($id)
    {
        $ulovek = Ulovky::findOrFail($id);
        $ulovek->delete();
        return redirect()->route('ulovky.index')->with('success', 'Úlovek byl úspěšně smazán.');
    }
}
