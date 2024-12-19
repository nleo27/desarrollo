<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_anio',
        'nombre_carta',
        'fecha_carta',
        'dirigido',
        'cargo',
        'institucion',
        'asunto',
        'referencia',
        'id_usuario',
        'mensaje',
        'fecha_caduca',
    ];

    public function requerimientos()
    {
        return $this->hasMany(Requerimiento::class, 'id_carta');
    }

    public function user()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function destinatario()
{
    return $this->belongsTo(Usuario::class, 'dirigido'); // `dirigido` es la clave foránea que apunta a la tabla `users`
}
}
