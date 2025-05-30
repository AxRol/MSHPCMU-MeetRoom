<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Gestion des salles de conference</title>
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

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <link href="{{asset('css/fullcalendar@5.11.3/main.min.css')  }}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/responsive.dataTables.min.css')}}">

  <!-- DataTables CSS & JS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> -->

    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

    <!-- Calendrier  -->
<!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script> -->
<script src="{{asset('js/fullcalendar@5.11.3/main.min.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.responsive.min.js')}}"></script>

<style>
        .status-bubble {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-validé .status-bubble {
            background-color: #2eca6a; /* Vert */
        }

        .status-annulé .status-bubble {
            background-color: #fe0303; /* Rouge */
        }

        .status-en-attente .status-bubble {
            background-color: #3c44f4; /* Jaune */
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main, #main {
            flex: 1 0 auto;
        }

        footer.footer {
            flex-shrink: 0;
        }
    </style>



  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
    @include('partials.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
    @include('partials.sidebar')
  <!-- End Sidebar-->

  <!-- #main -->
        @yield('content')
  <!-- End #main -->

  <!-- ======= Footer ======= -->
    @include('partials.footer')
  <!-- End Footer -->



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
  <script src="{{asset('js/fullcalendar@5.11.3/main.min.js') }}"></script>
  <script src="{{asset('js/jquery.dataTables.responsive.min.js')}}"></script>

</body>

</html>
