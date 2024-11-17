<?php

namespace App\Http\Controllers;

use App\Models\Lokality;
use App\Models\Ulovky;

class Controller
{
    public function ulozene()
    {

        $ulozeneLokality = Lokality::whereHas('saves', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        $ulozeneUlovky = Ulovky::whereHAS('saves', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();




        return view('ulozene', compact('ulozeneLokality', 'ulozeneUlovky'));
    }


}
