<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zavod extends Model
{
    use HasFactory;
    protected $table = 'zavody';


    protected $fillable = [
        'nazev',
        'id_zakladatele',
        'lokalita',
        'soukromost',
        'stav',
        'datum_zahajeni',
        'datum_ukonceni',
    ];


    public function isZakladatel(User $user)
    {
        return $this->id_zakladatele === $user->id;
    }

    public function merici()
    {
        return $this->hasMany(Meric::class, 'id_zavodu');
    }

    public function pozorovatele()
    {
        return $this->hasMany(Pozorovatel::class, 'id_zavodu');
    }

    public function lokalita()
    {
        return $this->belongsTo(Lokality::class, 'lokalita');
    }
}
