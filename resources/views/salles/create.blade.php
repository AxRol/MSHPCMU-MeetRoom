@extends('master')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Salles de conférence</h1>
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
            <h5 class="card-title">Formulaire d'ajout de salle</h5>

                <form action="{{ route('salles.store') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la salle</label>
                        <input id="nom" name="nom" type="text" class="form-control" required placeholder="Exemple: Salle DISD...">
                        @if ($errors->has('nom'))  <div class="text-danger mt-2">{{ $errors->first('nom') }} </div> @endif
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description de la salle</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Exemple: Salle de reunion de la DISD..." rows="2"></textarea>
                        @if ($errors->has('description')) <div class="text-danger mt-2"> {{ $errors->first('description') }} </div> @endif
                    </div>

                    <div class="mb-3">
                        <label for="capacité" class="form-label">Capacité de la salle</label>
                        <input id="capacité" name="capacité" type="number" class="form-control" placeholder="Exemple: 10...">
                        @if ($errors->has('capacité'))<div class="text-danger mt-2">  {{ $errors->first('capacité') }} </div>  @endif
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

@endsection
