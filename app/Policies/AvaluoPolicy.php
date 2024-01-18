<?php

namespace App\Policies;

use App\Models\Avaluo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AvaluoPolicy
{

    public function view(User $user, Avaluo $avaluo): bool
    {

        if($user->hasRole('Administrador'))
            return true;

        return $user->id === $avaluo->creado_por;

    }

    /**
     * Determine whether the user can create models.
     */
    public function update(User $user, Avaluo $avaluo): Response
    {

        return $user->id === $avaluo->creado_por
                ? Response::allow()
                : Response::deny('El avalúo pertenece a otro valuador no tienes permisos para editarlo.');

    }

    public function delete(User $user, Avaluo $avaluo): Response
    {

        return $user->id === $avaluo->creado_por
                ? Response::allow()
                : Response::deny('El avalúo pertenece a otro valuador no tienes permisos para borrarlo.');

    }

}
