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
</style>

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Dashboarddddddddddddddd</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Card : Réservations du jour -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| Du jour</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservationsDuJour }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->

                    <!-- Card : Total des réservations -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservations }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->

                    <!-- Card : Réservations en cours -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| En cours</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $currentReservations }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->

                    <!-- Agenda des réservations -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| agenda</span></h5>
                                <!-- Conteneur du calendrier -->
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div><!-- End Agenda -->

                    <!-- Tableau : Réservations de la semaine -->
                    <!-- <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| Semaine en cours</span></h5>
                                <table id="lastedreservationsTable" class="table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Salle</th>
                                            <th scope="col">Direction</th>
                                            <th scope="col">Date début</th>
                                            <th scope="col">Date fin</th>
                                            <th scope="col">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestReservations as $reservation)
                                            <tr>
                                                <td>{{ $reservation->salle->nom }}</td>
                                                <td>{{ $reservation->direction->nom }}</td>
                                                <td>{{ $reservation->start_time }}</td>
                                                <td>{{ $reservation->end_time }}</td>
                                                <td>
                                                    @php
                                                        $now = \Carbon\Carbon::now();
                                                        $startTime = \Carbon\Carbon::parse($reservation->start_time);
                                                        $endTime = \Carbon\Carbon::parse($reservation->end_time);
                                                    @endphp

                                                    @if ($endTime < $now)
                                                        <span class="badge bg-success">Libre</span>
                                                    @elseif ($now->between($startTime, $endTime))
                                                        <span class="badge bg-warning">Occupé</span>
                                                    @else
                                                        <span class="badge bg-primary">Réservé</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Tableau -->

                    <!-- Graphique : Répartition des réservations par salle -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pourcentage () des réservations par salle</h5>
                                <div id="reservationpieChart"></div> <!-- Graphique en camembert -->
                            </div>
                        </div>
                    </div><!-- End Graphique -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Activité récente : Réservations par direction -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Réservations par direction</h5>
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
                </div><!-- End Activité récente -->

                <!-- Graphique : Réservations par salle -->
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Réservations par salle <span>| Total</span></h5>
                        <div style="min-height: 400px;" class="echart">
                            <canvas id="reservationsChart"></canvas> <!-- Graphique en barres -->
                        </div>
                    </div>
                </div><!-- End Graphique -->

            </div><!-- End Right side columns -->

        </div>
        <!-- Section : Statistiques globales -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistiques globales</h5>
                    <div class="row">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Utilisateurs <span>| Total</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalUsers }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Salles <span>| Total</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalSalles }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Taux d'occupation <span>| Global</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-percent"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $tauxOccupationGlobal }}%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section : Gestion des utilisateurs -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestion des utilisateurs</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Scripts pour les graphiques et le calendrier -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Graphique en camembert (répartition des réservations par salle)
        new ApexCharts(document.querySelector("#reservationpieChart"), {
            series: @json($data_pourcentage_salle),
            chart: {
                height: 350,
                type: 'pie',
                toolbar: {
                    show: true
                }
            },
            labels: @json($labels_reserv_salle)
        }).render();

        // Graphique en barres (réservations par salle)
        /* const ctx = document.getElementById('reservationsChart').getContext('2d');
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
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Réservations par salle'
                    }
                }
            }
        }); */
        const ctx = document.getElementById('reservationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels_reserv_salle), // Libellés des salles
                datasets: [{
                    label: 'Nombre de réservations',
                    data: @json($data_reserv_salle), // Données des réservations
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Couleur de fond des barres
                    borderColor: 'rgba(54, 162, 235, 1)', // Couleur de bordure des barres
                    borderWidth: 1 // Épaisseur de la bordure
                }]
            },
            options: {
                responsive: true, // Graphique réactif
                scales: {
                    y: {
                        beginAtZero: true, // Commencer l'axe Y à 0
                        ticks: {
                            stepSize: 1 // Pas de 1 sur l'axe Y
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top', // Position de la légende
                    },
                    title: {
                        display: true,
                        text: 'Réservations par salle' // Titre du graphique
                    }
                }
            }
        });

        // Initialisation de DataTable
        $('#lastedreservationsTable').DataTable({
            responsive: true,
            language: {
                "sEmptyTable": "Aucune donnée disponible dans le tableau",
                "sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "sInfoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                "sInfoFiltered": "(filtré à partir de _MAX_ entrées totales)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Afficher _MENU_ entrées",
                "sLoadingRecords": "Chargement...",
                "sProcessing": "Traitement...",
                "sSearch": "Rechercher :",
                "sZeroRecords": "Aucun enregistrement correspondant trouvé",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sLast": "Dernier",
                    "sNext": "Suivant",
                    "sPrevious": "Précédent"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                }
            }
        });
    });
</script>

<!-- Script pour FullCalendar -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Vue par défaut
            events: @json($reservationsForCalendar), // Données des réservations
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'fr', // Définir la locale en français
            buttonText: {
                today: 'Aujourd\'hui',
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour'
            },
            contentHeight: 'auto', // Ajuster la hauteur automatiquement
            handleWindowResize: true,
            eventClick: function(info) {
                /* const now = new Date();
                // Récupérer les dates de début et de fin de l'événement
                const startTime = new Date(info.event.start);
                const endTime = new Date(info.event.end);
                // Vérifier si la date actuelle est comprise entre la date de début et de fin
                if (now >= startTime && now <= endTime) {
                    // Appliquer un style (par exemple, une bordure verte)
                    info.el.style.border = '3px solid green';
                } */
            window.location.href = "{{ route('reservations.edit', '') }}".replace('/edit', `${info.event.id}/edit`);
            }
        });
        calendar.render();

        // Redimensionner le calendrier lorsque la fenêtre est redimensionnée
        window.addEventListener('resize', function() {
            calendar.updateSize();
        });
    });
</script>


@endsection
