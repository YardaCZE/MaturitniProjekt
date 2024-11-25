<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meric extends Model
{
    use HasFactory;

    protected $table = 'merici';

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
