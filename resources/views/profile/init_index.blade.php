@extends('master')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Profile utlisateur</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <img src="{{asset('img/profile2-img.png')}}" alt="Profile" class="rounded-circle">
              <h2>{{ Auth::user()->name }}</h2>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Details</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier Profile</button>
                </li>


                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer votre mot de passe</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-delete">Suppression</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">


                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nom utlisateur</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->name }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">login</div>
                    <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                        @csrf
                        @method('patch')

                        <!-- Champ pour le nom -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nom utlisateur') }}</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @if ($errors->has('name'))
                                <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <!-- Champ pour l'email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Login') }}</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                            @endif

                            <!-- Vérification de l'email -->
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-muted">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 text-success">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Bouton de sauvegarde -->
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">{{ __('Sauvegarder') }}</button>

                            <!-- Message de succès -->
                            @if (session('status') === 'profile-updated')
                                <!-- <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success mb-0">
                                    {{ __('Saved.') }}
                                </p> -->
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Succès',
                                            text: "Information(s) modifiée(s) avec success ",
                                            confirmButtonText: 'OK',
                                            timer: 10000, // Fermer automatiquement après 10 secondes
                                            timerProgressBar: true
                                        }).then(() => {

                                        });
                                    });
                                </script>
                            @endif
                        </div>
                    </form>
                  <!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                    <form method="post" action="{{ route('password.update') }}" class="mt-4">
                        @csrf
                        @method('put')

                        <!-- Champ pour le mot de passe actuel -->
                        <div class="mb-3">
                            <label for="update_password_current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" id="update_password_current_password" name="current_password" class="form-control" autocomplete="current-password">
                            @if ($errors->updatePassword->get('current_password'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->updatePassword->get('current_password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Champ pour le nouveau mot de passe -->
                        <div class="mb-3">
                            <label for="update_password_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" id="update_password_password" name="password" class="form-control" autocomplete="new-password">
                            @if ($errors->updatePassword->get('password'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->updatePassword->get('password') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Champ pour la confirmation du nouveau mot de passe -->
                        <div class="mb-3">
                            <label for="update_password_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                            @if ($errors->updatePassword->get('password_confirmation'))
                                <div class="text-danger mt-2">
                                    @foreach ($errors->updatePassword->get('password_confirmation') as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Bouton de soumission et message de succès -->
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>

                            @if (session('status') === 'password-updated')
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Succès',
                                            text: "Mot de passe modifié avec success ",
                                            confirmButtonText: 'OK',
                                            timer: 10000, // Fermer automatiquement après 10 secondes
                                            timerProgressBar: true
                                        }).then(() => {
                                            // Rediriger après la fermeture de l'alerte
                                            window.location.href = "{{ route('profile.edit') }}";
                                        });
                                    });
                                </script>
                            @endif
                        </div>
                    </form><!-- End Change Password Form -->

                </div>


                <div class="tab-pane fade pt-3" id="profile-delete">

                  <!-- Settings Form -->
                  <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                        @csrf
                        @method('delete')

                        <h2 class="h5 mb-3">
                            {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
                        </h2>

                        <p class="mb-4 text-muted">
                            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="{{ __('Password') }}"
                            />
                            @if ($errors->userDeletion->has('password'))
                                <div class="invalid-feedback"> {{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </button>

                            <button type="submit" class="btn btn-danger">
                                {{ __('Delete Account') }}
                            </button>
                        </div>
                  </form><!-- End settings Form -->

                </div>



              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

@endsection
