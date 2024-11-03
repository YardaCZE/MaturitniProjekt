<?php

namespace App\Http\Controllers;

use App\Models\Ulovky;
use Illuminate\Http\Request;

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
        $ulovek = Ulovky::findOrFail($id);
        return view('ulovky.detail', compact('ulovek'));
    }

    public function destroy($id)
    {
        $ulovek = Ulovky::findOrFail($id);
        $ulovek->delete();
        return redirect()->route('ulovky.index')->with('success', 'Úlovek byl úspěšně smazán.');
    }
}
