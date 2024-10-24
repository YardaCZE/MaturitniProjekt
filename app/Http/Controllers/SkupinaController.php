<?php

namespace App\Http\Controllers;

use App\Models\Skupina;
use App\Models\Pozvanka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SkupinaController extends Controller
{
    public function index()
    {
        $skupiny = Skupina::where('je_soukroma', 0)->get();
        return view('skupiny.index', compact('skupiny'));
    }

    public function mojeSkupiny()
    {
        $skupiny = \DB::table('skupiny')
            ->join('clenove_skupiny', 'skupiny.id', '=', 'clenove_skupiny.id_skupiny')
            ->where('clenove_skupiny.id_uzivatele', auth()->user()->id)
            ->select('skupiny.*')
            ->get();

        return view('skupiny.mojeSkupiny', compact('skupiny'));
    }


    public function show($id)
    {
        $skupina = Skupina::findOrFail($id);
        $prispevky = $skupina->prispevky;
        return view('skupiny.show', compact('skupina', 'prispevky'));
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

        \Log::info('Before saving to DB:', [
            'je_soukroma' => $request->has('je_soukroma') ? 1 : 0,


        ]);


        \Log::info('Request data:', $request->all());

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

            $clen = \DB::table('clenove_skupiny')
                ->where('id_skupiny', $skupina->id)
                ->where('id_uzivatele', auth()->user()->id)
                ->first();

            if (!$clen) {

                \DB::table('clenove_skupiny')->insert([
                    'id_skupiny' => $skupina->id,
                    'id_uzivatele' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }


            return redirect()->route('skupiny.show', $skupina->id);
        }

        return back()->withErrors(['heslo' => 'Nesprávný název skupiny nebo heslo.']);
    }



    public function zobrazAdminPanel($id)
    {
        $skupina = Skupina::findOrFail($id);
        $pozvanka = Pozvanka::where('id_skupiny', $id)->first();

        if (auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin) {
            return view('skupiny.admin', compact('skupina', 'pozvanka')); // Předání obou proměnných
        }

        abort(403);
    }






    public function vytvoritPozvanku(Request $request, $id)
    {
        $skupina = Skupina::findOrFail($id);

        if (auth()->user()->isAdmin() || auth()->user()->id === $skupina->id_admin) {
            $kod_pozvanky = Str::random(6);


            $pozvanka = \DB::table('pozvanky')->insert([
                'id_skupiny' => $skupina->id,
                'kod_pozvanky' => $kod_pozvanky,
                'max_pocet_pouziti' => $request->input('max_pocet_pouziti'),
                'expirace' => $request->input('expirace'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Pozvánka byla úspěšně vygenerována.');
        }
        abort(403);
    }


    public function prihlasitPomociPozvanky(Request $request)
    {
        $request->validate([
            'kod_pozvanky' => 'required|string',
        ]);


        $pozvanka = \DB::table('pozvanky')
            ->where('kod_pozvanky', $request->kod_pozvanky)
            ->where(function($query) {
                $query->whereNull('expirace')->orWhere('expirace', '>', now());
            })
            ->first();

        if ($pozvanka) {
            $skupina = Skupina::findOrFail($pozvanka->id_skupiny);


            if ($pozvanka->pocet_pouziti < $pozvanka->max_pocet_pouziti || is_null($pozvanka->max_pocet_pouziti)) {

                \DB::table('clenove_skupiny')->insert([
                    'id_skupiny' => $skupina->id,
                    'id_uzivatele' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);


                \DB::table('pozvanky')->where('id', $pozvanka->id)->increment('pocet_pouziti');

                return redirect()->route('skupiny.show', $skupina->id);
            }

            return back()->withErrors(['kod_pozvanky' => 'Pozvánka již byla plně využita.']);
        }

        return back()->withErrors(['kod_pozvanky' => 'Neplatná nebo vypršela platnost pozvánky.']);
    }



    public function destroy($id)
    {
        $skupina = Skupina::findOrFail($id);
        $skupina->delete();

        return redirect()->route('skupiny.index')->with('success', 'Skupina byla úspěšně smazána.');
    }




}

