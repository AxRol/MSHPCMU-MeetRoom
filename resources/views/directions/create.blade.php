@extends('master')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Directions</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title">Formulaire d'ajout d'une direction</h5>

                <form action="{{ route('directions.store') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la direction</label>
                        <input id="nom" name="nom" type="text" class="form-control" required placeholder="Exemple: DISD...">
                        @if ($errors->has('nom'))  <div class="text-danger mt-2">{{ $errors->first('nom') }} </div> @endif
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description de la direction</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Exemple: Direction de l'Informatique...." rows="2"></textarea>
                        @if ($errors->has('description')) <div class="text-danger mt-2"> {{ $errors->first('description') }} </div> @endif
                    </div>

                    <div class="d-flex gap-3">
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





