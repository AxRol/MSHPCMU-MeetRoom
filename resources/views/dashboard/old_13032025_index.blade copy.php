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
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    @if (Auth::check() && Auth::user()->getRoleNames()->first() === 'admin' || Auth::check() && Auth::user()->getRoleNames()->first() === 'gestionnaire')
        <div class="row">
            <div class="col-lg-12">
                <!-- Card : Réservations en cours -->
                <div class="row">
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| En cours</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $currentReservations }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->
                    <!-- Card : Réservations du jour -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| Du jour</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservationsDuJour }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->
                    <!-- Card : Total des réservations -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservations }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->
                    <div class="col-xxl-2 col-md-6">
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
                    </div><!-- End Card -->

                    <!-- Card : Réservations validées -->
                    <div class="col-xxl-2 col-md-6">
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
                    </div><!-- End Card -->

                    <!-- Card : Réservations annulées -->
                    <div class="col-xxl-2 col-md-6">
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
                    </div><!-- End Card -->
                <!-- Card: Les salles et utlisateur -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Salles <span>| En utlisation </span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-grid"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $sallesEnCoursUtilisation }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Salles <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-grid"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalSalles }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Utilisateurs <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalUsers }}</h6>
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
                </div>
            </div>
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Graphique : Taux (%) d'occupation salles -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Taux (%) d'occupation des salles</h5>
                                <div id="reservationpieChart"></div> <!-- Graphique en camembert -->
                            </div>
                        </div>
                    </div><!-- End taux -->
                </div>
            </div>
            <!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <div class="row">
                    <!-- Graphique : Repartition des réservations par salle -->
                         <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Repartition des réservations par salle</h5>
                                <div style="min-height: 400px;" class="echart">
                                    <canvas id="reservationsChart"></canvas> <!-- Graphique en barres -->
                                </div>
                            </div>
                         </div>
                    <!-- End Repartition des réservations par direction -->

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Repartition des réservations par direction</h5>
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
                    <!-- End Repartition des réservations par direction -->
                </div>
            </div><!-- End right side columns -->

        </div>


    @elseif (Auth::check() && Auth::user()->getRoleNames()->first() === 'utilisateur')
        <div class="row">
            <div class="col-lg-12">
                <!-- Card : Réservations en cours -->
                <div class="row">
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Mes réservations <span>| En cours</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $currentReservationsUser }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->
                    <!-- Card : Réservations du jour -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Mes réservations <span>| Du jour</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservationsDuJourUser }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->
                    <!-- Card : Total des réservations -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Mes réservations <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservationsUser }}</h6>
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
                </div>
            </div>
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Graphique : Taux (%) d'occupation salles -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Taux (%) d'occupation des salles</h5>
                                <div id="reservationpieChart"></div> <!-- Graphique en camembert -->
                            </div>
                        </div>
                    </div><!-- End taux -->
                </div>
            </div><!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <div class="row">
                    <!-- Graphique : Repartition des réservations par salle -->
                         <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Repartition des réservations par salle</h5>
                                <div style="min-height: 400px;" class="echart">
                                    <canvas id="reservationsChart"></canvas> <!-- Graphique en barres -->
                                </div>
                            </div>
                         </div>
                    <!-- End Repartition des réservations par direction -->

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Repartition des réservations par direction</h5>
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
                    <!-- End Repartition des réservations par direction -->
                </div>
            </div><!-- End right side columns -->


        </div>


    @else
        <div class="row">
            <div class="col-lg-12">
                <!-- Card : Réservations en cours -->
                <div class="row">
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| En cours</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $currentReservations }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->
                    <!-- Card : Réservations du jour -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| Du jour</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservationsDuJour }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Card -->
                    <!-- Card : Total des réservations -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Réservations <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar4-week"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalReservations }}</h6>
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
                </div>
            </div>
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Graphique : Taux (%) d'occupation salles -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Taux (%) d'occupation des salles</h5>
                                <div id="reservationpieChart"></div> <!-- Graphique en camembert -->
                            </div>
                        </div>
                    </div><!-- End taux -->
                </div>
            </div><!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <div class="row">
                    <!-- Graphique : Repartition des réservations par salle -->
                         <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Repartition des réservations par salle</h5>
                                <div style="min-height: 400px;" class="echart">
                                    <canvas id="reservationsChart"></canvas> <!-- Graphique en barres -->
                                </div>
                            </div>
                         </div>
                    <!-- End Repartition des réservations par direction -->

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Repartition des réservations par direction</h5>
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
                    <!-- End Repartition des réservations par direction -->
                </div>
            </div><!-- End right side columns -->

        </div>
    @endif

    </section>

</main>


<script>
/*  **************************************Scripts pour les graphiques, dataTables et le calendrier**************************************  */
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
        // Chart en barres (nombre réservations par salle)
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

// Afficher les données dans le calendrier
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

<!-- Script pour FullCalendar -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

    });
</script>


@endsection
