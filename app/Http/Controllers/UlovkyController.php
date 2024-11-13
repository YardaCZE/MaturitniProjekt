<?php

namespace App\Http\Controllers;

use App\Models\KomentarUlovky;
use App\Models\Lokality;
use App\Models\ObrazkyUlovky;
use App\Models\Skupina;
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

        $verejneSkupiny = Skupina::where('je_soukroma', false)->get();
        $uzivatelovySkupiny = auth()->user()->skupiny;
        $adminovySkupiny = Skupina::where('id_admin', auth()->id())->where('je_soukroma', true)->get();

        $skoroVsechnySkupiny = $uzivatelovySkupiny->merge($adminovySkupiny)->unique('id');
        $vsechnySkupiny = $skoroVsechnySkupiny->merge($verejneSkupiny)->unique('id');
        return view('ulovky.create', compact('typyLovu', 'lokality', 'druhyReviru', 'vsechnySkupiny'));
    }

    public function store(Request $request)
    {

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


      $validated =  $request->validate([
            'druh_ryby' => 'required|string',
            'delka' => 'required|numeric',
            'vaha' => 'required|numeric',
            'id_typu_lovu' => 'required|exists:typ_lovu,id',
            'id_lokality' => 'required|exists:lokality,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'souk_skup' => 'nullable|boolean',
            'soukOsob' => 'nullable|boolean',
            'soukSkupID' => 'nullable|exists:skupiny,id',

        ]);

        // Načíst lokalitu a získat hodnotu sloupce 'druh'
        $lokalita = Lokality::findOrFail($request->id_lokality);
        $druh_reviru = $lokalita->druh;





        $ulovek =Ulovky::create([
            'druh_ryby' => $validated['druh_ryby'],
            'delka' => $validated['delka'],
            'vaha' => $validated['vaha'],
            'id_typu_lovu' => $validated['id_typu_lovu'],
            'id_lokality' => $validated['id_lokality'],
            'id_uzivatele' => auth()->id(),
            'id_druhu_reviru' => $druh_reviru,
            'soukroma' => $soukroma,
            'soukSkup' => $soukSkup,
            'soukOsob' => $soukOsob,
            'soukSkupID' => $request->input('soukSkupID'),
        ]);

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
