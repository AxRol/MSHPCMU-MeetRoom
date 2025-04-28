<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Salle;
use App\Models\Reservation;
use App\Models\Direction;
use App\Models\User;
use App\Policies\SallePolicy;
use App\Policies\ReservationPolicy;
use App\Policies\DirectionPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

    protected $policies = [
        Salle::class => SallePolicy::class,
        Reservation::class => ReservationPolicy::class,
        Direction::class => DirectionPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
