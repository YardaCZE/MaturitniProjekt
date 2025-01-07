<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ulovky;
use App\Models\Lokality;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $nejvetsiUlovky = Ulovky::where('created_at', '>=', Carbon::now()->subDay())

            ->orderBy('delka', 'desc')
            ->take(3)
            ->get();

        $nejlajkovanejsiUlovky = Ulovky::where('created_at', '>=', Carbon::now()->subDay())
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(3)
            ->get();

        $nejnovejsiUlovky = Ulovky::latest()->take(3)->get();
        $nejdelsiUlovky = Ulovky::orderBy('delka', 'desc')->take(3)->get();

        return view('dashboard', compact(
            'nejvetsiUlovky',
            'nejlajkovanejsiUlovky',
            'nejnovejsiUlovky',
            'nejdelsiUlovky'
        ));

    }
}
