<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    public function area()
    {
        return $this->belongsToMany(Area::class, 'grupo_area', 'grupo_id', 'area_id');
    }
}
