<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveLokalita extends Model
{
    protected $table = 'saves_lokality';

    protected $fillable = ['user_id', 'lokalita_id'];

    public function lokalita()
    {
        return $this->belongsTo(Lokality::class, 'lokalita_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
