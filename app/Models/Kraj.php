<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kraj extends Model
{
    use HasFactory;
    protected $table = 'kraje';

    protected $fillable = ['kraj'];

    public $timestamps = true;
}
