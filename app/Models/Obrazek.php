<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obrazek extends Model
{
    protected $table = 'obrazky';

    public function prispevek()
    {
        return $this->belongsTo(Prispevek::class, 'ID_prispevku');
    }
}
