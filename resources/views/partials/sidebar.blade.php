<aside id="sidebar" class="sidebar">

    @if (Route::has('login'))

        @auth
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Salles (masqué pour le rôle "utilisateur") -->
            @if (!auth()->user()->hasRole('utilisateur') && !auth()->user()->hasRole('gestionnaire'))
                <li class="nav-item {{ request()->routeIs('salles.*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('salles.*') ? '' : 'collapsed' }}" href="{{ route('salles.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>Salles</span>
                    </a>
                </li>
            @endif

            <!-- Réservations -->
            <li class="nav-item {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                <a class="nav-link {{ request()->routeIs('reservations.*') ? '' : 'collapsed' }}" href="{{ route('reservations.index') }}">
                    <i class="bi bi-calendar4-week"></i>
                    <span>Réservations</span>
                </a>
            </li>

            <!-- Directions (masqué pour le rôle "utilisateur") -->
            @if (!auth()->user()->hasRole('utilisateur') && !auth()->user()->hasRole('gestionnaire'))
                <li class="nav-item {{ request()->routeIs('directions.*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('directions.*') ? '' : 'collapsed' }}" href="{{ route('directions.index') }}">
                        <i class="bi bi-building"></i>
                        <span>Directions</span>
                    </a>
                </li>
            @endif

            <!-- Utilisateurs (masqué pour les rôles "utilisateur" et "gestionnaire") -->
            @if (!auth()->user()->hasRole('utilisateur') && !auth()->user()->hasRole('gestionnaire'))
                <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->routeIs('users.*') ? '' : 'collapsed' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-person"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
            @endif

        </ul>

        @else
        <!-- Si l'utilisateur n'est pas authentifié -->
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        @endauth

    @endif

</aside>
