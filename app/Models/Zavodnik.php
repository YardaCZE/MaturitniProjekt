<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zavodnik extends Model
{
    use HasFactory;
    protected $table = 'cleni_zavodu';

    protected $fillable = [
        'id_zavodu',
        'jmeno',
        'prijmeni',
        'datum_narozeni',
    ];

    public function zavod()
    {
        return $this->belongsTo(Zavod::class, 'id_zavodu');
    }
}
