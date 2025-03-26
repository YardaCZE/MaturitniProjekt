<?php

namespace App\Http\Controllers;

use App\Models\Lokality;
use App\Models\Meric;
use App\Models\Pozorovatel;
use App\Models\Ulovek;
use App\Models\User;
use App\Models\Zavod;
use App\Models\Zavodnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ZavodyController extends Controller
{
    public function index()
    {
        $verejneZavody = Zavod::where('soukromost', 0)->get();
        $zavodyKdeZakladatel = Zavod::where('id_zakladatele', auth()->id())->get();
        $zavodyKdeMeric = Zavod::whereHas('merici', function ($query) {
            $query->where('id_uzivatele', auth()->id());
        })->get();

        $zavodyKdePozorovatel = Zavod::whereHas('pozorovatele', function ($query) {
            $query->where('id_uzivatele', auth()->id());
        })->get();
        $ZavodyKDeMericAPozorovatel = $zavodyKdePozorovatel->merge($zavodyKdeMeric)->unique('id');

        $uzivatelovoZavody = $zavodyKdeZakladatel->merge($ZavodyKDeMericAPozorovatel)->unique('id');
        return view('zavody.index', compact('verejneZavody', 'uzivatelovoZavody'));
    }

    public function create()
    {
        $lokality = Lokality::all();
        return view('zavody.create', compact('lokality'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nazev' => 'required|string',
            'lokalita' => 'nullable|exists:lokality,id',
            'soukromost' => 'boolean',
            'datum_zahajeni' => 'required|date',
            'datum_ukonceni' => 'required|date|after_or_equal:datum_zahajeni',
        ]);


        $zavod = Zavod::create([
            'nazev' => $validated['nazev'],
            'id_zakladatele' => auth()->id(),
            'lokalita' => $validated['lokalita'] ?: null,
            'soukromost' => $request->has('soukromost'),
            'stav' => 1, // Výchozí stav závodu
            'datum_zahajeni' => $validated['datum_zahajeni'],
            'datum_ukonceni' => $validated['datum_ukonceni'],
        ]);

        return redirect()->route('zavody.index')->with('success', 'Závod byl úspěšně přidán.');
    }

    public function detail($id)
    {
        $zavod = Zavod::findOrFail($id);

        $zavodnici = DB::table('cleni_zavodu')
            ->leftJoin('ulovky_zavodu', function ($join) use ($id) {
                $join->on('cleni_zavodu.id', '=', 'ulovky_zavodu.id_zavodnika')
                    ->where('ulovky_zavodu.id_zavodu', '=', $id);
            })
            ->select(
                'cleni_zavodu.id',
                'cleni_zavodu.jmeno',
                'cleni_zavodu.prijmeni',
                'cleni_zavodu.datum_narozeni',
                DB::raw('COALESCE(SUM(ulovky_zavodu.body), 0) as body_celkem'),
                DB::raw('RANK() OVER (ORDER BY COALESCE(SUM(ulovky_zavodu.body), 0) DESC) as umisteni')
            )
            ->whereExists(function ($query) use ($id) {
                $query->select(DB::raw(1))
                    ->from('zavody')
                    ->whereColumn('zavody.id', 'cleni_zavodu.id_zavodu')
                    ->where('zavody.id', $id);
            })
            ->groupBy(
                'cleni_zavodu.id',
                'cleni_zavodu.jmeno',
                'cleni_zavodu.prijmeni',
                'cleni_zavodu.datum_narozeni'
            )
            ->get();

        $jeMeric = DB::table('merici')
            ->where('id_zavodu', $id)
            ->where('id_uzivatele', auth()->id())
            ->exists();


        $nejdelsiRyba = DB::table('ulovky_zavodu')
            ->where('id_zavodu', $id)
            ->orderByDesc('delka')
            ->first();

        $nejbodovanesiRyba = DB::table('ulovky_zavodu')
            ->where('id_zavodu', $id)
            ->orderByDesc('body')
            ->first();

        $nejtezsiRyba = DB::table('ulovky_zavodu')
            ->where('id_zavodu', $id)
            ->orderByDesc('vaha')
            ->first();

        return view('zavody.detail', compact('zavod', 'zavodnici', 'jeMeric', 'nejdelsiRyba', 'nejtezsiRyba', 'nejbodovanesiRyba'));
    }

    public function zobrazUlovky($id_zavodnika, $id_zavodu)
    {
        $zavod = Zavod::findOrFail($id_zavodu);
        $ulovky = DB::table('ulovky_zavodu')
            ->where('id_zavodnika', $id_zavodnika)
            ->where('id_zavodu', $id_zavodu)
            ->get();

        return view('zavody.ulovky', compact('ulovky', 'zavod'));
    }

    public function pridatZavodnika($id)
    {
        $zavod = Zavod::findOrFail($id);
        return view('zavody.pridatZavodnika', compact('zavod'));
    }



    public function storeZavodnik(Request $request, $id)
    {
        $zavod = Zavod::findOrFail($id);


        if ($zavod->id_zakladatele !== auth()->id()) {
            return redirect()->route('zavody.index')->with('error', 'Nemáte oprávnění přidat závodníka do tohoto závodu.');
        }

        $validated = $request->validate([
            'jmeno' => 'required|string|max:255',
            'prijmeni' => 'required|string|max:255',
            'narozeni' => 'required|date',
        ]);

        Zavodnik::create([
            'id_zavodu' => $id,
            'jmeno' => $validated['jmeno'],
            'prijmeni' => $validated['prijmeni'],
            'datum_narozeni' => $validated['narozeni'],
        ]);

        return back()->with('success', 'Závodník byl úspěšně přidán.');
    }



    public function pridatMerice($id)
    {
        $zavod = Zavod::findOrFail($id);

        $users = User::whereDoesntHave('merici', function($query) use ($id) {
            $query->where('id_zavodu', $id);
        })->get();

        return view('zavody.pridatMerice', compact('zavod', 'users'));
    }

    public function storeMeric(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $zavod = Zavod::findOrFail($id);

        Meric::create([
            'id_zavodu' => $zavod->id,
            'id_uzivatele' => $request->user_id,
        ]);

        return redirect()->route('zavody.pridatMerice', $zavod->id)
            ->with('success', 'Měřič byl úspěšně přidán.');
    }

    public function PridatPozorovatele($id)
    {
        $zavod = Zavod::findOrFail($id);

        $users = User::whereDoesntHave('pozorovatele', function($query) use ($id) {
            $query->where('id_zavodu', $id);
        })->get();

        return view('zavody.pridatPozorovatele', compact('zavod', 'users'));
    }

    public function storePozorovatel(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $zavod = Zavod::findOrFail($id);

        Pozorovatel::create([
            'id_zavodu' => $zavod->id,
            'id_uzivatele' => $request->user_id,
        ]);

        return redirect()->route('zavody.pridatPozorovatele', $zavod->id)
            ->with('success', 'Pozorovatel byl úspěšně přidán.');
    }

    public function zapsatUlovek($id)
    {
        $zavodnici = Zavodnik::where('id_zavodu', $id)->get();
        return view('zavody.zapsatUlovek', compact('zavodnici', 'id'));
    }

    public function storeUlovek(Request $request, $id)
    {
        $isMeric = DB::table('merici')
            ->where('id_zavodu', $id)
            ->where('id_uzivatele', auth()->id())
            ->exists();

        if (!$isMeric) {
            return response()->json([
                'error' => 'Nemáte oprávnění zapsat úlovek pro tento závod.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'id_zavodnika' => 'required|exists:cleni_zavodu,id',
            'druh_ryby' => 'required|string|max:255',
            'delka' => 'nullable|numeric|min:0',
            'vaha' => 'nullable|numeric|min:0',
            'body' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Neplatná data',
                'messages' => $validator->errors()
            ], 422);
        }

        $id_merice = DB::table('merici')
            ->where('id_uzivatele', auth()->id())
            ->where('id_zavodu', $id)
            ->value('id');

        try {
            $ulovek = new Ulovek([
                'id_zavodu' => $id,
                'id_zavodnika' => $request->id_zavodnika,
                'id_merice' => $id_merice,
                'druh_ryby' => $request->druh_ryby,
                'delka' => $request->delka,
                'vaha' => $request->vaha,
                'body' => $request->body,
            ]);

            $ulovek->save();

            return response()->json([
                'message' => 'Úlovek byl úspěšně uložen',
                'ulovek' => $ulovek
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Chyba při ukládání úlovku',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function ukoncitZavod($id)
    {
        $zavod = Zavod::findOrFail($id);

        $zavod->update(['stav' => 2]);

        return redirect()->back()->with('success', 'Závod byl úspěšně ukončen.');
    }

    public function aktivovatZavod($id)
    {

        $zavod = Zavod::findOrFail($id);

        if (auth()->user()->isAdmin() || auth()->user()->id === $zavod->id_zakladatele) {
            //
            if ($zavod->stav == 2) {
                $zavod->stav = 1;
                $zavod->save();

                return redirect()->back()->with('success', 'Závod byl úspěšně aktivován.');
            } else {
                return redirect()->back()->with('error', 'Závod není ukončený, takže ho nelze aktivovat.');
            }
        } else {
            return redirect()->back()->with('error', 'Nemáte oprávnění k aktivaci tohoto závodu.');
        }
    }


    public function destroy(Zavod $zavod)
    {
        $zavod->delete();
        return redirect()->route('zavody.index')->with('succes', 'Zavod byl smazan');
    }

}
