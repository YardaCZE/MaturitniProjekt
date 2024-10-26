<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $table = 'komentare';

    protected $fillable = [
        'prispevek_id',
        'uzivatel_id',
        'text',
        'parent_id',
    ];

    public function prispevek()
    {
        return $this->belongsTo(Prispevek::class);
    }

    public function uzivatel()
    {
        return $this->belongsTo(User::class);
    }

    public function odpovedi()
    {
        return $this->hasMany(Komentar::class, 'parent_id');
    }
}
