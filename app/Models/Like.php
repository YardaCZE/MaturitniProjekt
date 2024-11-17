<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'likes';

    protected $fillable = ['user_id', 'ulovky_id'];

    public function ulovky()
    {
        return $this->belongsTo(Ulovky::class, 'ulovky_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
