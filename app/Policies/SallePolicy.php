<?php

namespace App\Policies;

use App\Models\Salle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SallePolicy
{
    /**
     * Vérifie si l'utilisateur peut voir une salle.
     */
    public function view(User $user, Salle $salle)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire');
    }

    /**
     * Vérifie si l'utilisateur peut créer une salle.
     */
    public function create(User $user)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire');
    }

    /**
     * Vérifie si l'utilisateur peut mettre à jour une salle.
     */
    public function update(User $user, Salle $salle)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire');
    }

    /**
     * Vérifie si l'utilisateur peut supprimer une salle.
     */
    public function delete(User $user, Salle $salle)
    {
        return $user->hasRole('administrateur');
    }
}
