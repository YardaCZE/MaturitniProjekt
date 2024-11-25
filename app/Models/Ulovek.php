<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulovek extends Model
{
    use HasFactory;

    protected $table = 'ulovky_zavodu';

    protected $fillable = [
        'id_zavodu',
        'id_zavodnika',
        'id_merice',
        'druh_ryby',
        'delka',
        'vaha',
        'body',
    ];

    public function zavodnik()
    {
        return $this->belongsTo(Zavodnik::class, 'id_zavodnika');
    }

    public function meric()
    {
        return $this->belongsTo(User::class, 'id_merice');
    }
}
