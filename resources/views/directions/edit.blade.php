@extends('master')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Directions</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item">Les directions</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title">Formulaire de modification des directions</h5>

                <form action="{{ route('directions.update', $direction->id) }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Champ Nom de la salle -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la direction</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $direction->nom) }}" required autofocus placeholder="Exemple: Salle DISD...">
                        @error('nom')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Champ Description de la salle -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description de la direction</label>
                        <input type="text" id="description" name="description" class="form-control" value="{{ old('description', $direction->description) }}" placeholder="Exemple: Salle de reunion de la DISD...">
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-flex align-items-center gap-4">
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                        <a href="{{ route('directions.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

@endsection






