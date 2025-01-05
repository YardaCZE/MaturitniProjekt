<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokality extends Model
{
    use HasFactory;
    protected $table = 'lokality';

    protected $fillable = [
        'nazev_lokality',
        'druh',
        'rozloha',
        'kraj',
        'souradnice',
        'id_zakladatele',
        'soukroma',
        'soukSkup',
        'soukOsob',
        'soukSkupID',
        'likes',


    ];

    public function obrazky()
    {
        return $this->hasMany(LokalityObrazky::class, 'lokalita_id');
    }

    public function ulovky()
    {
        return $this->hasMany(Ulovky::class);
    }

    public function likes()
    {
        return $this->hasMany(LikeLokalita::class, 'lokalita_id');
    }

    public function saves()
    {
        return $this->hasMany(SaveLokalita::class, 'lokalita_id');
    }

    public function likeCount()
    {
        return $this->likes()->count();
    }
}
