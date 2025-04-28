@extends('master')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Utilisateurs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Modifier un utilisateur</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Formulaire de modification d'utilisateur</h5>

              <form method="POST" action="{{ route('users.update', $user->id) }}" class="mt-4">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'utilisateur</label>
                    <input id="name" name="name" type="text" class="form-control" required
                           value="{{ old('name', $user->name) }}" placeholder="Exemple: Santé digitale...">
                    @if ($errors->has('name'))<div class="text-danger mt-2">{{ $errors->first('name') }}</div>@endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" required
                           value="{{ old('email', $user->email) }}" placeholder="Exemple: santedigitale@mshpcmu.ci...">
                    @if ($errors->has('email')) <div class="text-danger mt-2">{{ $errors->first('email') }}</div> @endif
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="*********">
                    @if ($errors->has('password')) <div class="text-danger mt-2">{{ $errors->first('password') }}</div> @endif
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="*********">
                    @if ($errors->has('password_confirmation'))<div class="text-danger mt-2">{{ $errors->first('password_confirmation') }}</div>  @endif
                </div>
                <div class="row mb-3">
                    <div class="col-xxl-6 col-md-6">
                        <label for="role" class="form-label">Rôle</label>
                        <select name="role" id="role" class="form-select">
                            <option value="" disabled>Sélectionner un rôle</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

</main>

@endsection
