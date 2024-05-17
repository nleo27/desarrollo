<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoGrupo extends Model
{
    use HasFactory;

    protected $table = 'archivos_grupos';

    protected $fillable = [
        'nombre',
        'ruta_archivo',
        'grupo_area_id',
        'descripcion',
    ];

    public function grupoArea()
    {
        return $this->belongsTo(GrupoArea::class, 'grupo_area_id');
    }
}
