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
        'nadpis',
        'text',
    ];


    public function skupina()
    {
        return $this->belongsTo(Skupina::class, 'id_skupiny');
    }


    public function autor()
    {
        return $this->belongsTo(User::class, 'id_autora');
    }




    public function obrazky()
    {
        return $this->hasMany(Obrazek::class, 'ID_prispevku');
    }


}
