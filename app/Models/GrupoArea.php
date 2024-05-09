<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoArea extends Model
{
    protected $table = 'grupo_area';

    protected $fillable = [
        'grupo_id',
        'area_id',
    ];
}
