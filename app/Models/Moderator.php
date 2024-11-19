<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Moderator extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_skupiny',
        'id_uzivatele',
    ];

    protected $table = 'moderatori';


}
