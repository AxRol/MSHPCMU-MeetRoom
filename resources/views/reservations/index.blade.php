@extends('master')

@section('content')

<main id="main" class="main" data-role="{{ Auth::user()->getRoleNames()->first() }}">

    <div class="pagetitle">
      <h1>Réservations</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item">Les réservations</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title"><a href="{{ route('reservations.create') }}" class="btn btn-primary" > Faire une reservation </a></h5>

 @if(session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: "{{ session('error') }}",
                                    confirmButtonText: 'OK'
                                });
                            });
                        </script>
@endif
@if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: "{{ session('success') }}",
                                    confirmButtonText: 'OK',
                                //    timer: 10000, // Fermer automatiquement après 3 secondes
                                    timerProgressBar: true
                                }).then(() => {
                                    // Rediriger après la fermeture de l'alerte
                                    // window.location.href = "{{ route('reservations.index') }}";
                                });
                            });
                        </script>
@endif
            <div class="mb-3">
                <a href="{{ route('reservations.index') }}" class="btn btn-outline-primary {{ request('status') === null ? 'active' : '' }}">Tous</a>
                <a href="{{ route('reservations.index', ['status' => 'en attente']) }}" class="btn btn-outline-warning {{ request('status') === 'en attente' ? 'active' : '' }}">En attente</a>
                <a href="{{ route('reservations.index', ['status' => 'validé']) }}" class="btn btn-outline-success {{ request('status') === 'validé' ? 'active' : '' }}">Validé</a>
                <a href="{{ route('reservations.index', ['status' => 'annulé']) }}" class="btn btn-outline-danger {{ request('status') === 'annulé' ? 'active' : '' }}">Annulé</a>
                <a href="{{ route('reservations.index', ['status' => 'terminé']) }}" class="btn btn-outline-secondary {{ request('status') === 'terminé' ? 'active' : '' }}">Terminé</a>
            </div>
@if(Auth::user()->getRoleNames()->first() === 'utilisateur')
                <!-- Table with stripped rows -->
            <table id="reservationsTable" class="dysplay" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Salle</th>
                        <th class="px-4 py-2">Motif</th>
                        <th class="px-4 py-2">Début</th>
                        <th class="px-4 py-2">Fin</th>
                        <th class="px-4 py-2">Status</th> <!-- Colonne status masquée -->
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
            @foreach($reservationsUser as $reservation)
                    <tr>
                        <td class="border px-4 py-2">{{ $reservation->salle?->nom ?? 'Non défini' }}
                        @if($reservation->priority)
                            <span class="text-warning" title="Réservation prioritaire">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </span>
                        @endif
                    </td>
                        <td class="border px-4 py-2">{{ $reservation->motif }}</td>
                        <td class="border px-4 py-2">{{ $reservation->start_time }}</td>
                        <td class="border px-4 py-2">{{ $reservation->end_time }}</td>
                        <td class="border px-4 py-2 status-value">{{ $reservation->status }}</td> <!-- Valeur du status pour la recherche -->
                        <td class="border px-4 py-2">
                                 <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-outline-primary" id="show-form-{{ $reservation->id }}" title="Voir"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
            @endforeach
                </tbody>
            </table>
@elseif(Auth::user()->getRoleNames()->first() === 'gestionnaire')
                <!-- Table with stripped rows -->
            <!-- <table id="reservationsTable" class="table datatable" style="width:100%"> -->
            <table id="reservationsTable" class="dysplay" style="width:100%">

                <thead>
                    <tr>
                        <th class="px-4 py-2">Salle</th>
                        <th class="px-4 py-2">Motif</th>
                        <th class="px-4 py-2">Début</th>
                        <th class="px-4 py-2">Fin</th>
                        <th class="px-4 py-2">Utilisateur</th>
                        <th class="px-4 py-2">Status</th> <!-- Colonne status masquée -->
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
             @foreach($reservationGestionnaire as $reservation)
                    <tr>
                        <td class="border px-4 py-2">{{ $reservation->salle?->nom ?? 'Non défini' }}
                            @if($reservation->priority)
                                <span class="text-warning" title="Réservation prioritaire">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $reservation->motif }}</td>
                        <td class="border px-4 py-2">{{ $reservation->start_time }}</td>
                        <td class="border px-4 py-2">{{ $reservation->end_time }}</td>
                        <td class="border px-4 py-2">{{ $reservation->user?->name ?? 'Non défini' }}</td>
                        <td class="border px-4 py-2 status-value">{{ $reservation->status }}</td> <!-- Valeur du status pour la recherche -->
                        <td class="border px-4 py-2">
                            @if ($reservation->status === 'en attente')
                                <form action="{{ route('reservations.valider', $reservation->id) }}" method="POST" style="display: inline;" id="validate-form-{{ $reservation->id }}">
                                    @csrf
                                    <button type="submit"class="btn btn-outline-success"><i class="bi bi-calendar2-check-fill" title="Valider"></i></button>
                                </form>
                                <form action="{{ route('reservations.annuler', $reservation->id) }}" method="POST" style="display: inline;" id="cancel-form-{{ $reservation->id }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning"><i class="bi bi-calendar-x" title="annuler"></i></button>
                                </form>
                            @endif
                                <!-- <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-outline-primary" id="show-form-{{ $reservation->id }}" title="Editer"><i class="bi bi-eye"></i></a> -->
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-outline-primary" id="show-form-{{ $reservation->id }}" title="Voir"><i class="bi bi-eye"></i></a>
                                <form id="delete-form-{{ $reservation->id }}" action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                       <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $reservation->id }}, event)" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                        </td>
                    </tr>
            @endforeach
                </tbody>
            </table>
@else
            <!-- <table id="reservationsTable" class="table datatable" style="width:100%"> -->
            <table id="reservationsTable" class="dysplay" style="width:100%">

                <thead>
                    <tr>
                        <th class="px-4 py-2">Salle</th>
                        <th class="px-4 py-2">Motif</th>
                        <th class="px-4 py-2">Début</th>
                        <th class="px-4 py-2">Fin</th>
                        <th class="px-4 py-2">Utilisateur</th>
                        <th class="px-4 py-2">Status</th> <!-- Colonne status masquée -->
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
             @foreach($reservations as $reservation)
                    <tr>
                        <td class="border px-4 py-2">{{ $reservation->salle?->nom ?? 'Non défini' }}
                            @if($reservation->priority)
                                <span class="text-warning" title="Réservation prioritaire">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $reservation->motif }}</td>
                        <td class="border px-4 py-2">{{ $reservation->start_time }}</td>
                        <td class="border px-4 py-2">{{ $reservation->end_time }}</td>
                        <td class="border px-4 py-2">{{ $reservation->user?->name ?? 'Non défini' }}</td>
                        <td class="border px-4 py-2 status-value">{{ $reservation->status }}</td> <!-- Valeur du status pour la recherche -->
                        <td class="border px-4 py-2">
                            @if ($reservation->status === 'en attente')
                                <form action="{{ route('reservations.valider', $reservation->id) }}" method="POST" style="display: inline;" id="validate-form-{{ $reservation->id }}">
                                    @csrf
                                    <button type="submit"class="btn btn-outline-success"><i class="bi bi-calendar2-check-fill" title="Valider"></i></button>
                                </form>
                                <form action="{{ route('reservations.annuler', $reservation->id) }}" method="POST" style="display: inline;" id="cancel-form-{{ $reservation->id }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning"><i class="bi bi-calendar-x" title="annuler"></i></button>
                                </form>
                            @endif
                                <!-- <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-outline-primary" id="show-form-{{ $reservation->id }}" title="Editer"><i class="bi bi-eye"></i></a> -->
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-outline-primary" id="show-form-{{ $reservation->id }}" title="Voir"><i class="bi bi-eye"></i></a>
                                <form id="delete-form-{{ $reservation->id }}" action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                       <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $reservation->id }}, event)" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                        </td>
                    </tr>
            @endforeach
                </tbody>
            </table>
@endif

<!-- jQuery -->


    <script>
    $(document).ready(function() {
        var table = $('#reservationsTable').DataTable({
            responsive: true,
           /*  columnDefs: [
                {
                    targets: [4], // Index de la colonne status (0-based)
                    visible: false, // Masquer la colonne
                    searchable: true // Rendre la colonne recherchable
                }
                @if(Auth::user()->getRoleNames()->first() !== 'utilisateur')
                ,{
                    targets: [5], // Pour la table admin/gestionnaire, la colonne status est à l'index 5
                    visible: false,
                    searchable: true
                }
                @endif
            ], */
            language: {
            "emptyTable": "Aucune donnée disponible dans le tableau",
            "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
            "infoFiltered": "(filtrées depuis _MAX_ entrées totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Afficher _MENU_ entrées",
            "loadingRecords": "Chargement...",
            "processing": "Traitement...",
            "search": "Rechercher:",
            "zeroRecords": "Aucun enregistrement correspondant trouvé",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            },
            "aria": {
                "sortAscending": ": activer pour trier par ordre croissant",
                "sortDescending": ": activer pour trier par ordre décroissant"
            }
        }
        });

        /* // Optionnel: ajouter un filtre dédié pour le status
        $('<div class="status-filter mb-3"><label>Filtrer par status: <select class="form-control form-control-sm"><option value="">Tous</option><option value="en attente">En attente</option><option value="validé">Validé</option><option value="annulé">Annulé</option><option value="terminé">Terminé</option></select></label></div>').prependTo('#reservationsTable_wrapper');

        $('.status-filter select').on('change', function() {
            var status = $(this).val();
                table.column(5).search(status).draw(); // Colonne status à l'index 5 pour admin/gestionnaire
        }); */
    });

    function confirmDelete(reservationId, event) {
        event.preventDefault();
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Vous ne pourrez pas revenir en arrière !",
            icon: 'warning',
            showCancelButton: true,            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + reservationId).submit();
            }
        });
    }
    </script>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
@endsection
