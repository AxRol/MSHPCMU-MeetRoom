<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Login / Gestion des salles de conference</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon"> -->
  <link href="{{asset('img/logo_mshpcmu.png')}}" rel="icon">
  <link href="{{asset('img/logo_mshpcmu.png')}}" rel="logo_mshpcmu">


  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="{{asset ('css/sweetalert2.min.css')}}">

  <!-- Template Main CSS File -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="{{asset ('css/jquery.dataTables.min.css')}}">

  <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>




  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<!-- Ajoutez ce bloc juste après la balise <body> -->
<div id="loginLoader" style="position:fixed;z-index:10000;top:0;left:0;width:100vw;height:100vh;background:#fff;display:flex;justify-content:center;align-items:center;">
    <img src="{{asset('img/logo_mshpcmu.png')}}" alt="Logo Ministère" style="max-width:180px;max-height:180px;">
</div>

<script>
    // Masquer le loader après le chargement de la page
    window.addEventListener('load', function() {
        document.getElementById('loginLoader').style.display = 'none';
    });
</script>
<style>
    /* Animation d'apparition */
    @keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
    }
    .card.mb-3 {
        animation: fadeInUp 0.7s cubic-bezier(.4,0,.2,1);
    }
    .form-control:focus {
        border-color: #3640f5;
        box-shadow: 0 0 0 0.2rem rgba(54, 64, 245, 0.15);
    }
    #pageLoader {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        background: rgba(255,255,255,0.8);
        justify-content: center;
        align-items: center;
    }
</style>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center w-auto">
                  <img src="{{asset('img/logo_mshpcmu.png')}}" alt="">
                  <span class="d-none d-lg-block">Gestion des salles de réunion</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
                <div class="card-body">

                  <!-- <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Connectez-vous</h5>
                  </div> -->

                    <form method="POST" action="{{ route('login') }}" class="p-4">
                        @csrf
                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@admin.com"/>
                            @if ($errors->get('email'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                            <div class="input-group">
                                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="*********"/>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @if ($errors->get('password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary" id="loginBtn">
                                <span id="loginBtnText">{{ __('Connectez-vous') }}</span>
                                <span id="loginBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
<!-- loader -->
<div id="pageLoader" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.8);justify-content:center;align-items:center;">
    <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
        <span class="visually-hidden">Chargement...</span>
    </div>
</div>
<!-- loader -->

<!-- Vendor JS Files -->
  <script src="{{asset('vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('vendor/quill/quill.js')}}"></script>
  <script src="{{asset('vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('js/main.js')}}"></script>
  <script src="{{asset('js/sweetalert2@11.js')}}"></script>
  <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
  <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const pwd = document.getElementById('password');
        const icon = this.querySelector('i');
        if (pwd.type === "password") {
            pwd.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            pwd.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('loginBtnText').classList.add('d-none');
    document.getElementById('loginBtnSpinner').classList.remove('d-none');
    document.getElementById('pageLoader').style.display = 'flex';
    });
</script>

</body>

</html>
