@extends('master')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Utilisateurs</h1>
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
            <h5 class="card-title">Formulaire d'ajout utilisateur</h5>

               <!-- <form action="{{ route('users.store') }}" method="POST" class="mt-4"> -->
                <form method="POST" action="{{ route('users.store') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'utilisateur</label>
                        <input id="name" name="name" type="text" class="form-control" required placeholder="Exemple: Santé digitale...">
                        @if ($errors->has('name'))  <div class="text-danger mt-2">{{ $errors->first('name') }} </div> @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email :</label>
                        <input type="email" name="email" id="email" class="form-control" required placeholder="Exemple: santedigitale@mshpcmu.ci..." required>
                        @if ($errors->has('email')) <div class="text-danger mt-2"> {{ $errors->first('email') }} </div> @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="*********">
                        @if ($errors->has('password'))<div class="text-danger mt-2">  {{ $errors->first('password') }} </div>  @endif
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="*********">
                        @if ($errors->has('password_confirmation'))<div class="text-danger mt-2">  {{ $errors->first('password_confirmation') }} </div>  @endif
                    </div>
                    <div class="row mb-3">
                        <div class="col-xxl-6 col-md-6">
                            <label for="roles" class="form-label">Roles</label>
                            <select name="role" id="roles" class="form-select">
                                <option value="" disabled selected>Sélectionner les roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>
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
