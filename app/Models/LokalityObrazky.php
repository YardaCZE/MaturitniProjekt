<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokalityObrazky extends Model
{
    use HasFactory;

    protected $table = 'lokality_obrazky';

    protected $fillable = ['lokalita_id', 'cesta_k_obrazku'];


    public function lokalita()
    {
        return $this->belongsTo(Lokality::class, 'lokalita_id');
    }
}
