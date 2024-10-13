<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prispevek extends Model
{
    use HasFactory;

    protected $table = 'prispevky';

    protected $fillable = [
        'id_skupiny',
        'id_autora',
        'id_obrazku',
        'nadpis',
        'text',
    ];


    public function skupina()
    {
        return $this->belongsTo(Skupina::class, 'id_skupiny');
    }


    public function autor()
    {
        return $this->belongsTo(Uzivatel::class, 'id_autora');
    }
}
