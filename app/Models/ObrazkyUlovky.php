<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObrazkyUlovky extends Model
{
    use HasFactory;
    protected $table = 'obrazky_ulovky';

    protected $fillable = [
        'id_ulovku',
        'cesta_k_obrazku',
    ];

    public function ulovky()
    {
        return $this->belongsTo(Ulovky::class, 'id_ulovku', 'id');
    }
}
