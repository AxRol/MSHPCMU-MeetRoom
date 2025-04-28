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
            <h5 class="card-title">Formulaire de modification de reservation</h5>

                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />

                    <!-- Champ pour la salle -->
                    <div class="mb-3">
                        <label for="salle_id" class="form-label">Salle</label>
                        <select name="salle_id" id="salle_id" class="form-select" required>
                            @foreach($salles as $salle)
                                <option value="{{ $salle->id }}" {{ old('salle_id', $reservation->salle_id) == $salle->id ? 'selected' : '' }}> {{ $salle->nom }} </option>
                            @endforeach
                        </select>
                        @if($errors->has('salle_id')) <div class="text-danger mt-2">{{ $errors->first('salle_id') }}</div> @endif
                    </div>

                    <!-- Champ pour la direction -->
                    <div class="mb-3">
                        <label for="direction_id" class="form-label">Direction</label>
                        <select name="direction_id" id="direction_id" class="form-select" required>
                            @foreach($directions as $direction)
                                <option value="{{ $direction->id }}" {{ old('direction_id', $reservation->direction_id) == $direction->id ? 'selected' : '' }}> {{ $direction->nom }} </option>
                            @endforeach
                        </select>
                        @if($errors->has('direction_id')) <div class="text-danger mt-2">{{ $errors->first('direction_id') }}</div> @endif
                    </div>

                    <!-- Champ pour le motif -->
                    <div class="mb-3">
                        <label for="motif" class="form-label">Motif de la réservation</label>
                        <input type="text" name="motif" id="motif" class="form-control" value="{{ old('motif', $reservation->motif) }}" placeholder="Motif de la réservation..." required />
                        @if($errors->has('motif'))  <div class="text-danger mt-2">{{ $errors->first('motif') }}</div>  @endif
                    </div>

                    <!-- Champ pour la date et heure de début -->
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Date et heure de début</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $reservation->start_time) }}" required />
                        @if($errors->has('start_time')) <div class="text-danger mt-2">{{ $errors->first('start_time') }}</div>  @endif
                    </div>

                    <!-- Champ pour la date et heure de fin -->
                    <div class="mb-3">
                        <label for="end_time" class="form-label">Date et heure de fin</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $reservation->end_time) }}" required />
                        @if($errors->has('end_time')) <div class="text-danger mt-2">{{ $errors->first('end_time') }}</div> @endif
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-flex gap-4">
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

@endsection
