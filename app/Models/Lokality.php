<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokality extends Model
{
    use HasFactory;
    protected $table = 'lokality';

    protected $fillable = [
        'nazev_lokality',
        'druh',
        'rozloha',
        'kraj',
        'souradnice',
        'id_zakladatele',
        'soukroma',
        'soukSkup',
        'soukOsob',
        'soukSkupID'


    ];

    public function obrazky()
    {
        return $this->hasMany(LokalityObrazky::class, 'lokalita_id');
    }

    public function zakladatel()
    {
        return $this->belongsTo(User::class, 'id_zakladatele');
    }
}
