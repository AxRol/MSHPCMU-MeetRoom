<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Vérifie si l'utilisateur peut voir un autre utilisateur.
     */
    public function view(User $user, User $model)
    {
        return $user->hasRole('admin');
    }

    /**
     * Vérifie si l'utilisateur peut créer un utilisateur.
     */
    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Vérifie si l'utilisateur peut mettre à jour un utilisateur.
     */
    public function update(User $user, User $model)
    {
        return $user->hasRole('admin');
    }

    /**
     * Vérifie si l'utilisateur peut supprimer un utilisateur.
     */
    public function delete(User $user, User $model)
    {
        return $user->hasRole('admin');
    }
}
