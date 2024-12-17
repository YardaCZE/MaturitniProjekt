<?php

namespace App\Http\Middleware;

use App\Models\Zavod;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckZavodStav
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $zavod = Zavod::find($request->route('id'));

        if ($zavod->stav == 2) {
            abort(403, 'Akce není povolena, závod není aktivní.');
        }
        return $next($request);
    }
}
