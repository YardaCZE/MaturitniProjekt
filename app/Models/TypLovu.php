<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypLovu extends Model
{
    use HasFactory;

    protected $table = 'typ_lovu';

    protected $fillable = [
        'druh',
    ];
}
