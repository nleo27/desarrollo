<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar todos los canales de broadcast para tu
| aplicación. Usa la función Broadcast::channel para definir un canal
| que se pueda usar en el lado del cliente.
|
*/

Broadcast::channel('user.{userId}', function ($user, $userId) {
    // Esto verifica que el usuario autenticado sea el mismo que el ID del canal.
    // Si son iguales, el usuario puede escuchar ese canal.
    return (int) $user->id === (int) $userId;
});