@extends('master')

@section('content')

<main id="main" class="main">

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
            <h5 class="card-title">Detail de la reservation</h5>

                <form action="" method="" class="mt-4">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />

                    <!-- Champ pour la salle -->
                    <div class="mb-3">
                        <label for="salle_id" class="form-label">Salle</label>
                        <select name="salle_id" id="salle_id" class="form-select" required readonly>
                                <option value="{{ $reservation->salle_id }}" {{ old('salle_id', $reservation->salle_id) == $reservation->salle->id ? 'selected' : '' }}> {{ $reservation->salle->nom }} </option>
                        </select>
                    </div>

                    <!-- Champ pour la direction -->
                    <div class="mb-3">
                        <label for="direction_id" class="form-label">Direction</label>
                        <select name="direction_id" id="direction_id" class="form-select" required readonly>
                                <option value="{{ $reservation->direction_id }}" {{ old('direction_id', $reservation->direction_id) == $reservation->direction->id ? 'selected' : '' }}> {{ $reservation->direction->nom }} </option>

                        </select>
                    </div>

                    <!-- Champ pour le motif -->
                    <div class="mb-3">
                        <label for="motif" class="form-label">Motif de la réservation</label>
                        <input type="text" name="motif" id="motif" class="form-control" value="{{ old('motif', $reservation->motif) }}" placeholder="Motif de la réservation..." required readonly/>
                    </div>

                     <!-- Champ pour la priorité -->
                    @if (Auth::check() && in_array(Auth::user()->getRoleNames()->first(), ['administrateur', 'gestionnaire']))
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priorité</label>
                        <input type="hidden" name="priority" value="0"> <!-- Important pour quand la case n'est pas cochée -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="priority" id="priority" value="1" {{ $reservation->priority ? 'checked' : '' }}>
                            <label class="form-check-label" for="priority">Réservation prioritaire </label>
                        </div>
                        <small class="text-muted">Les réservations prioritaires annuleront automatiquement les autres réservations en conflit</small>
                    </div>
                    @endif
                    <!-- Champ pour l'état -->
                    <div class="mb-3">
                        <label for="status" class="form-label">État</label>
                        <input type="text" name="status" id="status" class="form-control" value="{{ $reservation->status }}" readonly>
                    </div>

                    <!-- Champ pour la date et heure de début -->
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Date et heure de début</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $reservation->start_time) }}" required readonly/>
                    </div>

                    <!-- Champ pour la date et heure de fin -->
                    <div class="mb-3">
                        <label for="end_time" class="form-label">Date et heure de fin</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $reservation->end_time) }}" required readonly/>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-flex gap-4">
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-outline-primary">Modifier</a>
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>

            </div>
          </div>

        </div>
      </div>
    </section>
<scri
</script>
  </main>

@endsection
