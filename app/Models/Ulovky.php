<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulovky extends Model
{
    use HasFactory;
    protected $table = 'ulovky';

    protected $fillable = [
        'id_lokality',
        'id_uzivatele',
        'id_druhu_reviru',
        'delka',
        'vaha',
        'druh_ryby',
        'id_typu_lovu',
        'soukroma',
        'soukSkup',
        'soukOsob',
        'soukSkupID',

    ];

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'ulovky_id', 'user_id');
    }

    public function likeCount()
    {
        return $this->likes()->count();
    }

    public function lokalita()
    {
        return $this->belongsTo(Lokality::class, 'id_lokality');
    }

    public function uzivatel()
    {
        return $this->belongsTo(User::class, 'id_uzivatele');
    }

    public function druhReviru()
    {
        return $this->belongsTo(DruhReviru::class, 'id_druhu_reviru');
    }

    public function typLovu()
    {
        return $this->belongsTo(TypLovu::class, 'id_typu_lovu');
    }

    public function obrazky()
    {
        return $this->hasMany(ObrazkyUlovky::class, 'id_ulovku', 'id');
    }

    public function komentare()
    {
        return $this->hasMany(KomentarUlovky::class, 'ulovek_id', 'id');
    }

    public function saves()
    {
        return $this->hasMany(SaveUlovek::class, 'ulovky_id');
    }
}
