<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'area_id');
    }

    public function carpetaArea(){
        return $this->hasMany(Carpeta::class);
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_area', 'area_id', 'grupo_id');
    }
}
