<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarUlovky extends Model
{
    use HasFactory;

    protected $table = 'komentare_ulovky';

    protected $fillable = ['ulovek_id', 'uzivatel_id', 'text', 'parent_id'];

    public function ulovek()
    {
        return $this->belongsTo(Ulovky::class, 'ulovek_id', 'id');
    }

    public function uzivatel()
    {
        return $this->belongsTo(User::class);
    }

    public function odpovedi()
    {
        return $this->hasMany(KomentarUlovky::class, 'parent_id');
    }


}
