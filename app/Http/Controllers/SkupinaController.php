<?php

namespace App\Http\Controllers;

use App\Models\ClenSkupiny;
use App\Models\Moderator;
use App\Models\Skupina;
use App\Models\Pozvanka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SkupinaController extends Controller
{
    public function index()
    {

        $verejneSkupiny = Skupina::where('je_soukroma', 0)
            ->with('admin')
            ->get();


        $soukromeSkupiny = Skupina::where('je_soukroma', 1)
            ->leftJoin('clenove_skupiny', 'skupiny.id', '=', 'clenove_skupiny.id_skupiny')
            ->where(function ($query) {
                $query->where('clenove_skupiny.id_uzivatele', auth()->user()->id)
                    ->orWhere('skupiny.id_admin', auth()->user()->id);
            })
            ->select('skupiny.*')
            ->with('admin')
            ->get()->unique('id');


        return view('skupiny.index', compact('verejneSkupiny', 'soukromeSkupiny'));
    }




    public function show($id)
    {
        $skupina = Skupina::findOrFail($id);


        if ($skupina->je_soukroma) {
            $isMember = DB::table('clenove_skupiny')
                ->where('id_skupiny', $skupina->id)
                ->where('id_uzivatele', auth()->user()->id)
                ->exists();

            if (!$isMember && auth()->user()->id !== $skupina->id_admin) {
                abort(403, 'Nejsi členem skupiny!');
            }
        }

        $jeModerator = DB::table('moderatori')
                    ->where('id_skupiny', $id)
                    ->where('id_uzivatele', auth()->id())->exists();



        $prispevky = $skupina->prispevky()->orderBy('created_at', 'desc')->get();;

        return view('skupiny.show', compact('skupina', 'prispevky', 'jeModerator'));
    }





    public function pripojit($idSkupiny)
    {
        $uzivatel = auth()->user();

        if (ClenSkupiny::jeClen($idSkupiny, $uzivatel->id)) {
            return redirect()->back()->with('error', 'Jste již členem této skupiny.');
        }


        ClenSkupiny::create([
            'id_skupiny' => $idSkupiny,
            'id_uzivatele' => $uzivatel->id,
        ]);

        return redirect()->route('skupiny.show', $idSkupiny)->with('success', 'Byl(a) jste úspěšně připojen(a) do skupiny.');
    }

    public function opustit($idSkupiny)
    {
        $uzivatel = auth()->user();
        $zaznam = ClenSkupiny::where('id_skupiny', $idSkupiny)
            ->where('id_uzivatele', $uzivatel->id)
            ->first();

        if ($zaznam) {
            $zaznam->delete();
            return redirect()->back()->with('success', 'Úspěšně jste opustil(a) skupinu.');
        }

        return redirect()->back()->with('error', 'Nejste členem této skupiny.');
    }




    public function create()
    {
        return view('skupiny.create');
    }


    public function store(Request $request)
    {

        $existingSkupina = Skupina::where('nazev_skupiny', $request->input('nazev_skupiny'))->first();

        if ($existingSkupina) {
            return redirect()->back()->withErrors(['nazev_skupiny' => 'Skupina s tímto názvem již existuje.'])->withInput();
        }

        $request->validate([
            'nazev_skupiny' => 'required|string|max:255',
            'je_soukroma' => 'boolean',
            'heslo' => 'required_if:je_soukroma,1',
        ]);



        Skupina::create([
            'nazev_skupiny' => $request->input('nazev_skupiny'),
            'je_soukroma' => $request->input('je_soukroma') == '1' ? 1 : 0,
            'heslo' => $request->has('heslo') ? Hash::make($request->input('heslo')) : null,
            'id_admin' => auth()->user()->id,
        ]);



        return redirect()->route('skupiny.index');
    }


    public function prihlasit(Request $request)
    {
        $request->validate([
            'nazev_skupiny' => 'required|string|max:255',
            'heslo' => 'required|string',
        ]);

        $skupina = Skupina::where('nazev_skupiny', $request->nazev_skupiny)->first();

        if ($skupina && $skupina->je_soukroma && Hash::check($request->heslo, $skupina->heslo)) {

            $clen = DB::table('clenove_skupiny')
                ->where('id_skupiny', $skupina->id)
                ->where('id_uzivatele', auth()->user()->id)
                ->first();

            if (!$clen) {

                DB::table('clenove_skupiny')->insert([
                    'id_skupiny' => $skupina->id,
                    'id_uzivatele' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('skupiny')->where('id', $skupina->id)->increment('pocet_clenu');
            }


            return redirect()->route('skupiny.show', $skupina->id);
        }

        return back()->withErrors(['heslo' => 'Nesprávný název skupiny nebo heslo.']);
    }



    public function AdminPanel($id)
    {
        $skupina = Skupina::findOrFail($id);
        $pozvanka = Pozvanka::where('id_skupiny', $id)->first();


        $cleni = ClenSkupiny::with('uzivatel')->where('id_skupiny', $id)->get();


        if (auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin) {
            return view('skupiny.admin', compact('skupina', 'pozvanka', 'cleni'));
        }

        abort(403);
    }

    public function smazatClena($skupinaId, $clenId)
    {
        $skupina = Skupina::findOrFail($skupinaId);

        if (auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin) {
            ClenSkupiny::where('id_skupiny', $skupinaId)
                ->where('id', $clenId)
                ->delete();
            return redirect()->route('skupiny.admin', $skupinaId)->with('success', 'Člen byl úspěšně odebrán.');
        }

        abort(403);
    }







    public function vytvoritPozvanku(Request $request, $id)
    {
        $skupina = Skupina::findOrFail($id);

        if (auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin) {
            $validatedData = $request->validate([
                'max_pocet_pouziti' => 'nullable|integer|min:1',
                'expirace' => 'nullable|date',
            ]);


            $maxPocetPouziti = $validatedData['max_pocet_pouziti'] ?? 9999999999;


            do {
                $kodPozvanky = Str::random(10);
            } while (Pozvanka::where('kod_pozvanky', $kodPozvanky)->exists());

            Pozvanka::create([
                'id_skupiny' => $skupina->id,
                'kod_pozvanky' => $kodPozvanky,
                'max_pocet_pouziti' => $maxPocetPouziti,
                'expirace' => $validatedData['expirace'],
            ]);

            return redirect()->back()->with('success', 'Pozvánka byla úspěšně vytvořena!');
        }
        abort(403);
    }



    public function prihlasitPomociPozvanky(Request $request)
    {
        $request->validate([
            'kod_pozvanky' => 'required|string',
        ]);


        $pozvanka = DB::table('pozvanky')
            ->where('kod_pozvanky', $request->kod_pozvanky)
            ->where(function ($query) {
                $query->whereNull('expirace')->orWhere('expirace', '<', now());
            })
            ->first();

        if ($pozvanka) {
            $skupina = Skupina::findOrFail($pozvanka->id_skupiny);

            if ($pozvanka->pocet_pouziti < $pozvanka->max_pocet_pouziti || is_null($pozvanka->max_pocet_pouziti)) {

                DB::table('clenove_skupiny')->insert([
                    'id_skupiny' => $skupina->id,
                    'id_uzivatele' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);


                DB::table('pozvanky')->where('id', $pozvanka->id)->increment('pocet_pouziti');


                DB::table('skupiny')->where('id', $skupina->id)->increment('pocet_clenu');


                if ($pozvanka->pocet_pouziti + 1 >= $pozvanka->max_pocet_pouziti) {
                    DB::table('pozvanky')->where('id', $pozvanka->id)->delete();
                }

                return redirect()->route('skupiny.show', $skupina->id);
            }

            return back()->withErrors(['kod_pozvanky' => 'Pozvánka již byla plně využita.']);
        }

        return back()->withErrors(['kod_pozvanky' => 'Neplatná nebo vypršela platnost pozvánky.']);

    }

    public function smazatPozvanku($id)
    {
        $pozvanka = Pozvanka::findOrFail($id);
        $pozvanka->delete();

        return redirect()->back()->with('success', 'Pozvánka byla úspěšně smazána.');
    }

    public function pridatModeratora(Request $request, $idSkupiny, $idUzivatele)
    {
        $skupina = Skupina::findOrFail($idSkupiny);


        if (Moderator::where('id_skupiny', $idSkupiny)->where('id_uzivatele', $idUzivatele)->exists()) {
            return redirect()->back()->with('error', 'Uživatel už je moderátorem.');
        }


        Moderator::create([
            'id_skupiny' => $idSkupiny,
            'id_uzivatele' => $idUzivatele,
        ]);

        return redirect()->back()->with('success', 'Uživatel byl úspěšně přidán jako moderátor.');
    }

    public function odebratModeratora($idSkupiny, $idUzivatele)
    {
        $moderator = Moderator::where('id_skupiny', $idSkupiny)
            ->where('id_uzivatele', $idUzivatele)
            ->firstOrFail();

        $moderator->delete();

        return redirect()->back()->with('success', 'Moderátor byl úspěšně odebrán.');
    }



    public function destroy($id)
    {
        $skupina = Skupina::findOrFail($id);
        $skupina->delete();

        return redirect()->route('skupiny.index')->with('success', 'Skupina byla úspěšně smazána.');
    }




}

