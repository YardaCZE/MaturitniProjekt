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


    public function zakladatel()
    {
        return $this->belongsTo(User::class, 'id_zakladatele');
    }

    public function merici()
    {
        return $this->hasMany(Meric::class, 'id_zavodu');
    }

    public function lokalita()
    {
        return $this->belongsTo(Lokality::class, 'lokalita');
    }
}
