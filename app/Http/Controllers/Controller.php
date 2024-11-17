<?php

namespace App\Http\Controllers;

use App\Models\Lokality;

 class Controller
{
    public function ulozene()
    {

        $ulozeneLokality = Lokality::whereHas('saves', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();




        return view('ulozene', compact('ulozeneLokality'));
    }


}
