<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pozorovatel extends Model
{
    use HasFactory;

    protected $table = 'pozorovatele';

    protected $fillable = [
        'id_zavodu',
        'id_uzivatele',
    ];

    public function zavod()
    {
        return $this->belongsTo(Zavod::class, 'id_zavodu');
    }

    public function uzivatel()
    {
        return $this->belongsTo(User::class, 'id_uzivatele');
    }
}
