<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'fecha_inicio', 'fecha_fin', 'periodo_activo'];

    public function carpetaPeriodo(){
        return $this->hasMany(Carpeta::class);
    }
}
