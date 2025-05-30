<section class="section dashboard">
    <div class="row">
        <!-- Réservations en cours -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title"> Réservations<span>| En cours</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar4-week"></i>
                        </div>
                        <div class="ps-3">
                            <h6> {{ $reservationsEnCours }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations du jour -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title"> Réservations <span>| Du jour</span> </h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar4-week"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $reservationsDuJour }} </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total des réservations -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title"> Réservations<span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar4-week"></i>
                        </div>
                        <div class="ps-3">
                            <h6> {{ $totalReservations }} </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations archivées -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Réservations <span>| Archivées</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-archive" style="color: #6c757d;"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $reservationsStats->archivees }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques secondaires -->
    <div class="row">
        <!-- Réservations en attente -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Réservations <span>| En attente</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-hourglass-split" style="color: orange;"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $reservationsStats->en_attente }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations validées -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Réservations <span>| Validées</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle" style="color:rgb(10, 1, 189);"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $reservationsStats->validees }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations annulées -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Réservations <span>| Annulées</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-x-circle" style="color: red;"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $reservationsStats->annulees }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations terminées -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Réservations <span>| Terminées</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle" style="color:#2eca6a;"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $reservationsStats->terminees }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et données supplémentaires -->
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

    <!-- Agenda des réservations -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> Agenda des réservations </h5>
                    <div id="calendar"></div>
                    <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex flex-wrap justify-content-center gap-3 align-items-center">
                                    <span class="d-flex align-items-center">
                                        <span style="display:inline-block;width:18px;height:18px;background:#e8f5e9;border-left:4px solid #2e7d32;border-radius:4px;margin-right:6px;"></span>
                                        Terminé
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <span style="display:inline-block;width:18px;height:18px;background:#ffebee;border-left:4px solid #c62828;border-radius:4px;margin-right:6px;"></span>
                                        Annulé
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <span style="display:inline-block;width:18px;height:18px;background:#e3f2fd;border-left:4px solid #3640f5;border-radius:4px;margin-right:6px;"></span>
                                        Validé
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <span style="display:inline-block;width:18px;height:18px;background:#fffde7;border-left:4px solid #ffb300;border-radius:4px;margin-right:6px;"></span>
                                        En attente
                                    </span>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Disponibilité des salles -->
    <div class="row mt-3">
        <div class="col-12">
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
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Données dynamiques passées depuis le contrôleur Laravel
    const tauxLabels = @json($labels_reserv_salle ?? []);
    const tauxData = @json($data_reserv_salle ?? []);

    var options = {
        series: tauxData,
        chart: {
            type: 'pie',
            height: 320,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: { enabled: true, delay: 150 },
                dynamicAnimation: { enabled: true, speed: 350 }
            }
        },
        labels: tauxLabels,
        legend: {
            position: 'bottom',
            fontSize: '16px'
        },
        dataLabels: {
            enabled: true,
            style: { fontSize: '15px' }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " réservations";
                }
            }
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: { width: '100%' },
                legend: { position: 'bottom' }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#reservationpieChart"), options);
    chart.render();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Données dynamiques passées depuis le contrôleur Laravel
    const salleLabels = @json($labels_reserv_salle ?? []);
    const salleData = @json($data_reserv_salle ?? []);

    const ctx = document.getElementById('reservationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: salleLabels,
            datasets: [{
                label: 'Nombre de réservations',
                data: salleData,
                backgroundColor: [
                    '#3640f5', '#2eca6a', '#ffb300', '#c62828', '#90a4ae', '#6c757d'
                ],
                borderRadius: 8,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' réservations';
                        }
                    }
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutBounce'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>
