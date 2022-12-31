<!DOCTYPE html>
<html lang="en" data-footer="true">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>{{config('app.name')}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Dashboard pages contains different layouts to provide stats, graphics, listings, categories, banners and so on. They have various implementations of plugins such as Datatables, Chart.js, Glide.js and Plyr.js with alternative extensions." />
  <!-- Favicon Tags Start -->
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{asset('backend/img/favicon/apple-touch-icon-57x57.png')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('backend/img/favicon/apple-touch-icon-114x114.png')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('backend/img/favicon/apple-touch-icon-72x72.png')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('backend/img/favicon/apple-touch-icon-144x144.png')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{asset('backend/img/favicon/apple-touch-icon-60x60.png')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{asset('backend/img/favicon/apple-touch-icon-120x120.png')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{asset('backend/img/favicon/apple-touch-icon-76x76.png')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{asset('backend/img/favicon/apple-touch-icon-152x152.png')}}" />
  <link rel="icon" type="image/png" href="{{asset('backend/img/favicon/favicon-196x196.png')}}" sizes="196x196" />
  <link rel="icon" type="image/png" href="{{asset('backend/img/favicon/favicon-96x96.png')}}" sizes="96x96" />
  <link rel="icon" type="image/png" href="{{asset('backend/img/favicon/favicon-32x32.png')}}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{asset('backend/img/favicon/favicon-16x16.png')}}" sizes="16x16" />
  <link rel="icon" type="image/png" href="{{asset('backend/img/favicon/favicon-128.png')}}" sizes="128x128" />
  <meta name="application-name" content="&nbsp;" />
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta name="msapplication-TileImage" content="{{asset('backend/img/favicon/mstile-144x144.png')}}" />
  <meta name="msapplication-square70x70logo" content="{{asset('backend/img/favicon/mstile-70x70.png')}}" />
  <meta name="msapplication-square150x150logo" content="{{asset('backend/img/favicon/mstile-150x150.png')}}" />
  <meta name="msapplication-wide310x150logo" content="{{asset('backend/img/favicon/mstile-310x150.png')}}" />
  <meta name="msapplication-square310x310logo" content="{{asset('backend/img/favicon/mstile-310x310.png')}}" />
  <!-- Favicon Tags End -->
  <!-- Font Tags Start -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('backend/font/CS-Interface/style.css')}}" />
  <!-- Font Tags End -->
  <!-- Vendor Styles Start -->
  <link rel="stylesheet" href="{{asset('backend/css/vendor/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/vendor/OverlayScrollbars.min.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/vendor/glide.core.min.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/vendor/baguetteBox.min.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/vendor/plyr.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/vendor/select2.min.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/vendor/select2-bootstrap4.min.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/vendor/datatables.min.css')}}">
  <!-- <link rel="stylesheet" href="cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->

  <!-- Vendor Styles End -->
  <!-- Template Base Styles Start -->
  <link rel="stylesheet" href="{{asset('backend/css/styles.css')}}" />
  <link rel="stylesheet" href="{{asset('css/datatable.css')}}" />
  <link rel="stylesheet" href="{{asset('css/responsive.css')}}" />

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
  <!-- Template Base Styles End -->

  <link rel="stylesheet" href="{{asset('backend/css/main.css')}}" />
  <script src="{{asset('backend/js/base/loader.js')}}"></script>
  <script src="https://kit.fontawesome.com/207ca6be0a.js" crossorigin="anonymous"></script>

</head>

<body>
  <div id="root">
    <div id="nav" class="nav-container d-flex">
      <div class="nav-content d-flex">
        <!-- Logo Start -->
        <div class="logo position-relative">
          <a href="Dashboards.Default.html" style="overflow: visible;">
            <!-- Logo can be added directly -->
            <!-- <img src="img/logo/logo-white.svg" alt="logo" /> -->

            <!-- Or added via css to provide different ones for different color themes -->
            <div class="d-flex align-items-center"><img class="imghilang" src="{{asset('backend/img/logo/penjuru.png')}}" alt="" style=" width: 80px; margin-left: -70px;"><strong class="menghilang" style="color: white; font-size: 30px;">PENJURU</strong></div>
          </a>
        </div>
        <!-- Logo End -->

        <!-- Language Switch Start -->
        <!--           <div class="language-switch-container">
            <button class="btn btn-empty language-button dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">EN</button>
            <div class="dropdown-menu">
              <a href="#" class="dropdown-item">DE</a>
              <a href="#" class="dropdown-item active">EN</a>
              <a href="#" class="dropdown-item">ES</a>
            </div>
          </div> -->
        <!-- Language Switch End -->

        @include('backend/layouts.navbar')
        @include('backend/layouts.sidebar')