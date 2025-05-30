@extends('master')

@section('content')

<main id="main" class="main" data-role="{{ Auth::user()->getRoleNames()->first() }}">

    <div class="pagetitle">
      <h1>Utilisateurs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item">Les utilisateurs</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title"><a href="{{ route('users.create') }}" class="btn btn-primary" > Ajouter un utilisateur </a></h5>

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
                                });
                            });
                        </script>
@endif
              <!-- Table with stripped rows -->
              <table id="usersTable" class="display">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Rôle(s)</th>
                        <th class="px-4 py-2">Permission(s)</th>
                        <th class="px-4 py-2">Salle(s) assignée(s)</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2">{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td class="border px-4 py-2">{{ $user->getAllPermissions()->pluck('name')->implode(', ') }}</td>
                            <td class="border px-4 py-2">{{ $user->salles && $user->salles->count() > 0 ? $user->salles->pluck('nom')->implode(', ') : '' }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-success"><i class="bi bi-pencil-square"></i></a>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"  onclick="confirmDelete({{ $user->id }}, event)"><i class="bi bi-trash"></i></button>
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
        document.addEventListener('DOMContentLoaded', function () {
            let userRole = document.main.getAttribute('data-role');
           // if (userRole != 'admin' || userRole === 'null') { window.location.href = "{{ route('403') }}"; }

        });
  </script>
  <script>
    function confirmDelete(userId, event) {
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
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
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
