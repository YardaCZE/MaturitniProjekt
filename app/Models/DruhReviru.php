<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DruhReviru extends Model
{
    use HasFactory;
    protected $table = 'druhy_reviru';

    protected $fillable = ['druh'];

    public $timestamps = true;
}
