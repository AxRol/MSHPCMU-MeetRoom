@extends('master')

@section('content')

<main id="main" class="main" data-role="{{ Auth::user()->getRoleNames()->first() }}">

    <div class="pagetitle">
      <h1>Salles de conférence</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item">Les salles</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title"><a href="{{ route('salles.create') }}" class="btn btn-primary" > Ajouter une salle </a></h5>

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
                                    timer: 10000, // Fermer automatiquement après 3 secondes
                                    timerProgressBar: true
                                }).then(() => {
                                    // Rediriger après la fermeture de l'alerte
                                    // window.location.href = "{{ route('salles.index') }}";
                                });
                            });
                        </script>
@endif
              <!-- Table with stripped rows -->
              <table id="sallesTable" class="display">
                <thead>
                  <tr>
                    <th>Salle</th>
                    <th>Description</th>
                    <th>Capacité</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
            @foreach($salles as $salle)
                    <tr>
                        <td class="border px-4 py-2">{{ $salle->nom  }}</td>
                        <td class="border px-4 py-2">{{ $salle->description }}</td>
                        <td class="border px-4 py-2">{{ $salle->capacité }}</td>
                        <td class="border px-4 py-2">
                                <a href="{{ route('salles.show', $salle->id) }}" class="btn btn-outline-primary" id="show-form-{{ $salle->id }}" title="Voir"><i class="bi bi-eye"></i></a>
                                    <form id="delete-form-{{ $salle->id }}" action="{{ route('salles.destroy', $salle->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"  onclick="confirmDelete({{ $salle->id }}, event)"><i class="bi bi-trash"></i></button>
                                    </form>
                        </td>
                    </tr>
            @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
  <script>
    function confirmDelete(salleId, event) {
        event.preventDefault(); // Empêcher le comportement par défaut
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Vous ne pourrez pas revenir en arrière !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + salleId).submit();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#sallesTable').DataTable({
            responsive: true,
            language: {
                "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                "sInfo":           "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "sInfoEmpty":      "Affichage de 0 à 0 sur 0 entrées",
                "sInfoFiltered":   "(filtré à partir de _MAX_ entrées totales)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Afficher _MENU_ entrées",
                "sLoadingRecords": "Chargement...",
                "sProcessing":     "Traitement...",
                "sSearch":         "Rechercher :",
                "sZeroRecords":    "Aucun enregistrement correspondant trouvé",
                "oPaginate": {
                    "sFirst":    "Premier",
                    "sLast":     "Dernier",
                    "sNext":     "Suivant",
                    "sPrevious": "Précédent"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                }
            }
        });
    });
</script>

@endsection
