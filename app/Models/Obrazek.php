<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Obrazek extends Model
{
    use HasFactory;

    protected $table = 'obrazky';

    protected $fillable = [
        'ID_prispevku',
        'cesta_k_obrazku',
    ];

    public function prispevek()
    {
        return $this->belongsTo(Prispevek::class, 'ID_prispevku');
    }
}
