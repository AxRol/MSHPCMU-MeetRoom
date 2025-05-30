<?php

namespace App\Policies;

use App\Models\Direction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DirectionPolicy
{
    /**
     * Vérifie si l'utilisateur peut voir une direction.
     */
    public function view(User $user, Direction $direction)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire');
    }

    /**
     * Vérifie si l'utilisateur peut créer une direction.
     */
    public function create(User $user)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire');
    }

    /**
     * Vérifie si l'utilisateur peut mettre à jour une direction.
     */
    public function update(User $user, Direction $direction)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire');
    }

    /**
     * Vérifie si l'utilisateur peut supprimer une direction.
     */
    public function delete(User $user, Direction $direction)
    {
        return $user->hasRole('administrateur');
    }
}
