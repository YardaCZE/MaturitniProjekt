<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skupina extends Model
{
    use HasFactory;

    protected $table = 'skupiny';

    protected $fillable = [
        'nazev_skupiny',
        'je_soukroma',
        'heslo',
        'id_admin',
    ];



    public function prispevky()
    {
        return $this->hasMany(Prispevek::class, 'id_skupiny');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function clenove()
    {
        return $this->hasMany(ClenSkupiny::class, 'id_skupiny');
    }
    public function jeClen($userId)
    {
        return $this->clenove()->where('id_uzivatele', $userId)->exists();
    }

    public function moderatori()
    {
        return $this->hasMany(Moderator::class, 'id_skupiny');
    }


}

