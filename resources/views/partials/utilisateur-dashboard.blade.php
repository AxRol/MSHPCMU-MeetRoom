<section class="section dashboard">
    <div class="row">
        <!-- Réservations en attente -->
        <div class="col-xxl-3 col-md-4">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Mes réservations <span>| En attente</span></h5>
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
        <div class="col-xxl-3 col-md-4">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Mes réservations <span>| Validées</span></h5>
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
        <div class="col-xxl-3 col-md-4">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Mes réservations <span>| Annulées</span></h5>
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

        <!-- Total des réservations -->
        <div class="col-xxl-3 col-md-4">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Mes réservations <span>| Total</span></h5>
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
        </div>
    </div>

    <!-- Agenda des réservations -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Agenda des réservations</h5>
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

</section>
