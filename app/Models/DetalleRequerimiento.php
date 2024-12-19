<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DetalleRequerimiento extends Model
{
    use HasFactory;

    protected $table = 'detalle_requerimiento';

    protected $fillable = [
        'id_requerimiento',
        'archivo',
        'observaciones',
    ];

    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class, 'id_requerimiento');
    }

    // Accesor para obtener la URL pública del archivo
    public function getArchivoUrlAttribute()
    {
        return $this->archivo ? Storage::url($this->archivo) : null;
    }
}
