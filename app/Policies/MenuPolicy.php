<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;

class MenuPolicy
{
    use HandlesAuthorization;

    public function createPeriodo(User $user)
    {
        // Aquí puedes agregar lógica para determinar si el usuario puede crear un período.
        return true; // Ejemplo: siempre devuelve true para permitir crear un período.
    }

    public function manageUsuarios(User $user)
    {
        // Aquí puedes agregar lógica para determinar si el usuario puede gestionar usuarios.
        return Session::has('periodo_seleccionado');
    }

    public function manageAreas(User $user)
    {
        // Aquí puedes agregar lógica para determinar si el usuario puede gestionar áreas.
        return Session::has('periodo_seleccionado');
    }

    public function hasSelectedPeriod(User $user)
    {
        // Devuelve true si el usuario ha seleccionado un período
        return Session::has('periodo_seleccionado');
    }
}
