<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pozvanka extends Model
{
    use HasFactory;
    protected $table = 'pozvanky';
    protected $fillable = [
        'id_skupiny',
        'kod_pozvanky',
        'pocet_pouziti',
        'max_pocet_pouziti',
        'expirace',
    ];
}
