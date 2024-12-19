<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'dni', 'name', 'apellidos', 'telefono', 'area_id', 'email', 'rol', 'password', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function area()
    {
       return $this->belongsTo(Area::class, 'area_id');
    }

    public function rol()
    {
    if ($this->roles->isNotEmpty()) {
        return $this->roles->first()->name;
    }
    
    return 'Sin rol';

    
    }

    public function carpeta(){
        return $this->hasMany(Carpeta::class);
    }


    public function cartasRecibidas()
    {
        return $this->hasMany(Carta::class, 'dirigido'); // Relaciona con la columna `dirigido` de la tabla `cartas`
    }
}
