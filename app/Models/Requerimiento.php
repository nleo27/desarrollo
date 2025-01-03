<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto_requerimiento',
        'fecha_inicio',
        'fecha_fin',
        'id_carta',
        'dirigido',
    ];

    public function carta()
    {
        return $this->belongsTo(Carta::class, 'id_carta');
    }

    public function detalleRequerimientos()
    {
        return $this->hasMany(DetalleRequerimiento::class, 'id_requerimiento', 'id');
    }
}
