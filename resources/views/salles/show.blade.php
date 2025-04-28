@extends('master')

@section('content')

<main id="main" class="main">

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
            <h5 class="card-title">Detail de la salle</h5>

                <form action="" method="" class="mt-6 space-y-6">
                    @csrf
                    <!-- Champ Nom de la salle -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la salle</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $salle->nom) }}" required autofocus placeholder="Exemple: Salle DISD..." readonly>
                    </div>

                    <!-- Champ Description de la salle -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description de la salle</label>
                        <input type="text" id="description" name="description" class="form-control" value="{{ old('description', $salle->description) }}" placeholder="Exemple: Salle de reunion de la DISD..." readonly>
                    </div>

                    <!-- Champ Capacité de la salle -->
                    <div class="mb-3">
                        <label for="capacité" class="form-label">Capacité de la salle</label>
                        <input type="number" id="capacité" name="capacité" class="form-control" value="{{ old('capacité', $salle->capacité) }}" placeholder="Exemple: 10...." readonly>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-flex align-items-center gap-4">
                        <a href="{{ route('salles.edit', $salle->id) }}" class="btn btn-outline-primary">Modifier</a>
                        <a href="{{ route('salles.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

@endsection
