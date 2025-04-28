@extends('master')

@section('content')

<main id="main" class="main">
    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .fc-toolbar {
                flex-direction: column;
                align-items: center;
            }

            .fc-toolbar .fc-left,
            .fc-toolbar .fc-center,
            .fc-toolbar .fc-right {
                margin-bottom: 10px;
            }
        }

        /* Style pour la liste des salles disponibles */
        .salle-disponible {
            background-color: #e8f5e9;
            border-left: 4px solid #2e7d32;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }
        .salle-indisponible {
            background-color: #ffebee;
            border-left: 4px solid #c62828;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }
    </style>

    <!-- En-tête -->
    <div class="pagetitle">
        <h1>Tableau de bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>
    </div><!-- Fin de l'en-tête -->

    <!-- Section principale -->
    <section class="section dashboard">
        <div class="row">
            <!-- Réservations en cours -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            @if(Auth::check() && Auth::user()->getRoleNames()->first() === 'utilisateur')
                                Mes réservations
                            @else
                                Réservations
                            @endif
                            <span>| En cours</span>
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar4-week"></i>
                            </div>
                            <div class="ps-3">
                                <h6>
                                    @if(Auth::check() && Auth::user()->getRoleNames()->first() === 'utilisateur')
                                        {{ $currentReservationsUser }}
                                    @else
                                        {{ $currentReservations }}
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Réservations du jour -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            @if(Auth::check() && Auth::user()->getRoleNames()->first() === 'utilisateur')
                                Mes réservations
                            @else
                                Réservations
                            @endif
                            <span>| Du jour</span>
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar4-week"></i>
                            </div>
                            <div class="ps-3">
                                <h6>
                                    @if(Auth::check() && Auth::user()->getRoleNames()->first() === 'utilisateur')
                                        {{ $totalReservationsDuJourUser }}
                                    @else
                                        {{ $totalReservationsDuJour }}
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total des réservations -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            @if(Auth::check() && Auth::user()->getRoleNames()->first() === 'utilisateur')
                                Mes réservations
                            @else
                                Réservations
                            @endif
                            <span>| Total</span>
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar4-week"></i>
                            </div>
                            <div class="ps-3">
                                <h6>
                                    @if(Auth::check() && Auth::user()->getRoleNames()->first() === 'utilisateur')
                                        {{ $totalReservationsUser }}
                                    @else
                                        {{ $totalReservations }}
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::check() && in_array(Auth::user()->getRoleNames()->first(), ['admin', 'gestionnaire']))
            <!-- Statistiques secondaires (uniquement pour admin et gestionnaire) -->
            <div class="row">
                <!-- Réservations en attente -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Réservations <span>| En attente</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-hourglass-split" style="color: orange;"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $reservationsEnAttente }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Réservations validées -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Réservations <span>| Validées</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check-circle" style="color: #2eca6a;"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $reservationsValidees }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Réservations annulées -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Réservations <span>| Annulées</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-x-circle" style="color: red;"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $reservationsAnnulees }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques et données supplémentaires (uniquement pour admin et gestionnaire) -->
            <div class="row">
                <!-- Graphique : Taux d'occupation des salles -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Taux d'occupation des salles</h5>
                            <div id="reservationpieChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques : Répartition des réservations par salle -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Répartition des réservations par salle</h5>
                            <canvas id="reservationsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Agenda des réservations (visible pour tous) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Agenda des réservations</h5>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

         @if (Auth::check() && in_array(Auth::user()->getRoleNames()->first(), ['admin', 'gestionnaire']))
            <!-- Répartition par direction (visible pour admin, gestionnaire et utilisateur) -->
            <div class="row mt-3">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Répartition des réservations par direction</h5>
                            <div class="activity">
                                @foreach ($topDirections as $direction)
                                    <div class="activity-item d-flex">
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <div class="activity-content">
                                            <a class="fw-bold text-dark">{{ $direction->direction }}</a> - {{ $direction->total }} réservations
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Nouvelle section : Salles disponibles du jour -->
                <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Disponibilité des salles aujourd'hui ({{ now()->format('d/m/Y') }})</h5>
                                    <div class="table-responsive">
                                        <table id="salles-disponibilite-table" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Statut</th>
                                                    <th>Salle</th>
                                                    <th>Disponibilité</th>
                                                    <th>Créneau horaire</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($salles as $salle)
                                                    @php
                                                        $reservationEnCours = $salle->reservations->first();
                                                        $estDisponible = is_null($reservationEnCours);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <i class='bi bi-circle-fill {{ $estDisponible ? 'text-success' : 'text-danger' }}'></i>
                                                        </td>
                                                        <td class="fw-bold">{{ $salle->nom }}</td>
                                                        <td>
                                                            @if($estDisponible)
                                                                <span class="badge bg-success">Disponible</span>
                                                            @else
                                                                <span class="badge bg-danger">Réservée</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!$estDisponible)
                                                                <small class="text-muted">
                                                                    De {{ \Carbon\Carbon::parse($reservationEnCours->start_time)->format('H:i') }}
                                                                    à {{ \Carbon\Carbon::parse($reservationEnCours->end_time)->format('H:i') }}
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($estDisponible)
                                                                <a href="{{ route('reservations.create', ['salle_id' => $salle->id]) }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                    <i class="bi bi-calendar-plus"></i> Réserver
                                                                </a>
                                                            @else
                                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                                    <i class="bi bi-lock"></i> Occupée
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @push('scripts')
                            <script>
                                $(document).ready(function() {
                                    $('#salles-disponibilite-table').DataTable({
                                        responsive: true,
                                        columnDefs: [
                                            { orderable: false, targets: [0, 4] }, // Désactiver le tri sur les colonnes Statut et Actions
                                            { searchable: false, targets: [0, 4] } // Désactiver la recherche sur ces colonnes
                                        ],
                                        language: {
                                            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json' // Localisation française
                                        }
                                    });
                                });
                            </script>
                            @endpush
                </div>

            </div>
        @endif
    </section>
</main>

<!-- Script pour le rafraîchissement automatique -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rafraîchir toutes les 30 secondes
    setInterval(function() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.table-responsive').innerHTML;
                document.querySelector('.table-responsive').innerHTML = newContent;
            });
    }, 30000);
});
</script>

<!-- Scripts pour les graphiques et le calendrier -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (Auth::check() && in_array(Auth::user()->getRoleNames()->first(), ['admin', 'gestionnaire']))
            // Graphique en camembert (uniquement pour admin et gestionnaire)
            new ApexCharts(document.querySelector("#reservationpieChart"), {
                series: @json($data_pourcentage_salle),
                chart: { type: 'pie', height: 350 },
                labels: @json($labels_reserv_salle)
            }).render();

            // Graphique en barres (uniquement pour admin et gestionnaire)
            const ctx = document.getElementById('reservationsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($labels_reserv_salle),
                    datasets: [{
                        label: 'Nombre de réservations',
                        data: @json($data_reserv_salle),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } },
                    plugins: { legend: { position: 'top' } }
                }
            });
        @endif

        // Calendrier (visible pour tous)
        const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            events: @json($reservationsForCalendar),
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventClick: function(info) {
                // window.location.href = "{{ route('reservations.edit', '') }}".replace('/edit', `${info.event.id}/edit`);
                window.location.href = "{{ route('reservations.show', '') }}/" + info.event.id;
            }
        });
        calendar.render();
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Rafraîchir toutes les 30 secondes
    setInterval(function() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.getElementById('salles-disponibilite').innerHTML;
                document.getElementById('salles-disponibilite').innerHTML = newContent;
            });
    }, 30000); // 30 secondes
});
</script>

@endsection
