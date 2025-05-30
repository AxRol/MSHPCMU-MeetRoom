<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    /**
     * Vérifie si l'utilisateur peut voir la liste des réservations.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire') || $user->hasRole('utilisateur');
    }

    /**
     * Vérifie si l'utilisateur peut voir une réservation spécifique.
     */
    public function view(User $user, Reservation $reservation)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire') || $user->hasRole('utilisateur');
    }

    /**
     * Vérifie si l'utilisateur peut créer une réservation.
     */
    public function create(User $user)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire') || $user->hasRole('utilisateur');
    }

    /**
     * Vérifie si l'utilisateur peut mettre à jour une réservation.
     */
    public function update(User $user, Reservation $reservation)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire') || $user->hasRole('utilisateur');
    }

    /**
     * Vérifie si l'utilisateur peut supprimer une réservation.
     */
    public function delete(User $user, Reservation $reservation)
    {
        return $user->hasRole('administrateur');
    }

    /**
     * Vérifie si l'utilisateur peut valider une réservation.
     */
    public function validate(User $user, Reservation $reservation)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire'); //|| $user->hasRole('utilisateur');
    }

    /**
     * Vérifie si l'utilisateur peut annuler une réservation.
     */
    public function cancel(User $user, Reservation $reservation)
    {
        return $user->hasRole('administrateur') || $user->hasRole('gestionnaire');
    }
}
