@include('backend/layouts.header')
<main>
  <div class="container">
    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
      <div class="row">
        <!-- Title Start -->
        <div class="col-12 col-md-7">
          <h1 class="mb-0 pb-0 display-4" id="title">@yield('titlepage')</h1>
          <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
            <ul class="breadcrumb pt-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="Dashboards.html">@yield('title')</a></li>
            </ul>
          </nav>
        </div>
        <!-- Title End -->
      </div>
    </div>
    <!-- Title and Top Buttons End -->

    <!-- Content Start -->
    <div>
      <div class="card mb-5">
        <div class="card-body overflow-auto">
          @yield('content')

          @include('backend/layouts.footer')