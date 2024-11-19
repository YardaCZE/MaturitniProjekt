<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClenSkupiny extends Model
{
    use HasFactory;

    protected $table = 'clenove_skupiny';

    protected $fillable = [
        'id_skupiny',
        'id_uzivatele',
    ];

    public static function jeClen($idSkupiny, $idUzivatele)
    {
        return self::where('id_skupiny', $idSkupiny)
            ->where('id_uzivatele', $idUzivatele)
            ->exists();
    }

    public function uzivatel()
    {
        return $this->belongsTo(User::class, 'id_uzivatele');
    }
}
