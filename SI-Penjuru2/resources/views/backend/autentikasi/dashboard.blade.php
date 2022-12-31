@extends('backend/layouts.template')
@section('titlepage')
Dashboards
@endsection
@section('title')
Dashboard
@endsection
@section('content')
<p class="mb-0">
  <h1><b>Sistem Pendukung Keputusan Penilaian Kinerja Guru SDIT Harapan Umat Jember.</b></h1>
</p>
</div>
</div>
<!-- Content End -->

<!-- List Items Start -->
<!-- <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-2">
            <div class="col">
              <div class="card h-100">
                <div class="card-body row gx-4">
                  <div class="col-auto">
                    <i data-cs-icon="board-1" class="text-primary"></i>
                  </div>
                  <div class="col">
                    <a href="Dashboards.Default.html" class="heading stretched-link d-block">Default</a>
                    <div class="text-muted">Home screen that contains stats, charts, call to action buttons and various listing elements.</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card h-100">
                <div class="card-body row gx-4">
                  <div class="col-auto">
                    <i data-cs-icon="board-3" class="text-primary"></i>
                  </div>
                  <div class="col">
                    <a href="Dashboards.Visual.html" class="heading stretched-link d-block">Visual</a>
                    <div class="text-muted">A dashboard implementation that mainly has visual items such as banners, call to action buttons and stats.</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card h-100">
                <div class="card-body row gx-4">
                  <div class="col-auto">
                    <i data-cs-icon="board-2" class="text-primary"></i>
                  </div>
                  <div class="col">
                    <a href="Dashboards.Analytic.html" class="heading stretched-link d-block">Analytic</a>
                    <div class="text-muted">Another dashboard alternative that focused on data, listing and charts.</div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
<!-- List Items End -->


<!-- Inventory Start -->
<h2 class="small-title">Status</h2>
@if (auth()->user()->level == "admin")
<div class="mb-5">
  <div class="row g-2">
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card hover-scale-up cursor-pointer sh-19">
        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
          <div class="bg-gradient-2 sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center mb-2">
            <i data-cs-icon="radish" class="text-white"></i>
          </div>
          <div class="heading text-center mb-0 d-flex align-items-center lh-1">Radish</div>
          <div class="text-small text-primary">14 PRODUCTS</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card hover-scale-up cursor-pointer sh-19">
        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
          <div class="bg-gradient-2 sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center mb-2">
            <i data-cs-icon="mushrooms" class="text-white"></i>
          </div>
          <div class="heading text-center mb-0 d-flex align-items-center lh-1">Mushroom</div>
          <div class="text-small text-primary">8 PRODUCTS</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card hover-scale-up cursor-pointer sh-19">
        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
          <div class="bg-gradient-2 sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center mb-2">
            <i data-cs-icon="pepper" class="text-white"></i>
          </div>
          <div class="heading text-center mb-0 d-flex align-items-center lh-1">Pepper</div>
          <div class="text-small text-primary">21 PRODUCTS</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card hover-scale-up cursor-pointer sh-19">
        <div class="h-100 d-flex flex-column justify-content-between card-body align-items-center">
          <div class="sh-5 sw-5 border border-dashed rounded-xl mx-auto">
            <div class="bg-separator w-100 h-100 rounded-xl d-flex justify-content-center align-items-center mb-2">
              <i data-cs-icon="plus" class="text-white"></i>
            </div>
          </div>
          <div class="heading text-center text-muted mb-0 d-flex align-items-center lh-1">Add New</div>
          <div class="text-small text-primary">&nbsp;</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
<!-- Inventory End -->

<!-- Carousel Start -->
<section class="scroll-section" id="carousel">
  <!-- <h2 class="small-title">Carousel</h2> -->
  <div class="card mb-5">
    <div class="card-body p-0">
      <div class="glide glide-gallery" id="glideCarouselGallery">
        <div class="glide glide-large">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides gallery-glide-custom">
              <li class="glide__slide p-0">
                <a href="{{asset('backend/img/background/sekolah.jpg')}}">
                  <img alt="detail" src="{{asset('backend/img/background/sekolah.jpg')}}" class="responsive border-0 rounded-top-end rounded-top-start img-fluid mb-3 sh-50 w-100" />
                </a>
              </li>
              <li class="glide__slide p-0">
                <a href="{{asset('backend/img/background/sekolah2.jpeg')}}">
                  <img alt="detail" src="{{asset('backend/img/background/sekolah2.jpeg')}}" class="responsive border-0 rounded-top-end rounded-top-start img-fluid mb-3 sh-50 w-100" />
                </a>
              </li>
              <li class="glide__slide p-0">
                <a href="{{asset('backend/img/background/sekolah3.jpeg')}}">
                  <img alt="detail" src="{{asset('backend/img/background/sekolah3.jpeg')}}" class="responsive border-0 rounded-top-end rounded-top-start img-fluid mb-3 sh-50 w-100" />
                </a>
              </li>
              <li class="glide__slide p-0">
                <a href="{{asset('backend/img/product/large/guernsey-gache.jpg')}}">
                  <img alt="detail" src="{{asset('backend/img/product/large/guernsey-gache.jpg')}}" class="responsive border-0 rounded-top-end rounded-top-start img-fluid mb-3 sh-50 w-100" />
                </a>
              </li>
              <li class="glide__slide p-0">
                <a href="{{asset('backend/img/product/large/barmbrack.jpg')}}">
                  <img alt="detail" src="{{asset('backend/img/product/large/barmbrack.jpg')}}" class="responsive border-0 rounded-top-end rounded-top-start img-fluid mb-3 sh-50 w-100" />
                </a>
              </li>
              <li class="glide__slide p-0">
                <a href="{{asset('backend/img/product/large/baguette.jpg')}}">
                  <img alt="detail" src="{{asset('backend/img/product/large/baguette.jpg')}}" class="responsive border-0 rounded-top-end rounded-top-start img-fluid mb-3 sh-50 w-100" />
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="glide glide-thumb mb-3">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
              <li class="glide__slide p-0">
                <img alt="thumb" src="{{asset('backend/img/background/sekolah.jpg')}}" class="responsive rounded-md img-fluid" />
              </li>
              <li class="glide__slide p-0">
                <img alt="thumb" src="{{asset('backend/img/background/sekolah2.jpeg')}}" class="responsive rounded-md img-fluid" />
              </li>
              <li class="glide__slide p-0">
                <img alt="thumb" src="{{asset('backend/img/background/sekolah3.jpeg')}}" class="responsive rounded-md img-fluid" />
              </li>
              <li class="glide__slide p-0">
                <img alt="thumb" src="{{asset('backend/img/product/thumb/guernsey-gache-thumb.jpg')}}" class="responsive rounded-md img-fluid" />
              </li>
              <li class="glide__slide p-0">
                <img alt="thumb" src="{{asset('backend/img/product/thumb/barmbrack-thumb.jpg')}}" class="responsive rounded-md img-fluid" />
              </li>
              <li class="glide__slide p-0">
                <img alt="thumb" src="{{asset('backend/img/product/thumb/baguette-thumb.jpg')}}" class="responsive rounded-md img-fluid" />
              </li>
            </ul>
          </div>
          <div class="glide__arrows" data-glide-el="controls">
            <button class="btn btn-icon btn-icon-only btn-foreground hover-outline left-arrow" data-glide-dir="<">
              <i data-cs-icon="chevron-left"></i>
            </button>
            <button class="btn btn-icon btn-icon-only btn-foreground hover-outline right-arrow" data-glide-dir=">">
              <i data-cs-icon="chevron-right"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="card-body pt-0">
        <h4 class="mb-3">Carrot Cake Gingerbread</h4>
        <div>
          <p>
            Toffee croissant icing toffee. Sweet roll chupa chups marshmallow muffin liquorice chupa chups soufflé bonbon. Liquorice gummi bears
            cake donut chocolate lollipop gummi bears. Cotton candy cupcake ice cream gummies dessert muffin chocolate jelly. Danish brownie
            chocolate bar lollipop cookie tootsie roll candy canes. Jujubes lollipop cheesecake gummi bears cheesecake. Cake jujubes soufflé.
          </p>
          <p>
            Cake chocolate bar biscuit sweet roll liquorice jelly jujubes. Gingerbread icing macaroon bear claw jelly toffee. Chocolate cake
            marshmallow muffin wafer. Pastry cake tart apple pie bear claw sweet. Apple pie macaroon sesame snaps cotton candy jelly
            <u>pudding lollipop caramels</u>
            marshmallow. Powder halvah dessert ice cream. Carrot cake gingerbread chocolate cake tootsie roll. Oat cake jujubes jelly-o jelly
            chupa chups lollipop jelly wafer soufflé.
          </p>
          <h6 class="mb-3 mt-5 text-alternate">Sesame Snaps Lollipop Macaroon</h6>
          <p>
            Jelly-o jelly oat cake cheesecake halvah. Cupcake sweet roll donut. Sesame snaps lollipop macaroon.
            <a href="#">Icing tiramisu</a>
            oat cake chocolate cake marzipan pudding danish gummies. Dragée liquorice jelly beans jelly jelly sesame snaps brownie. Cheesecake
            chocolate cake sweet roll cupcake dragée croissant muffin. Lemon drops cupcake croissant liquorice donut cookie cake. Gingerbread
            biscuit bear claw marzipan tiramisu topping. Jelly-o croissant chocolate bar gummi bears dessert lemon drops gingerbread croissant.
            Donut candy jelly.
          </p>
          <ul class="list-unstyled">
            <li>Croissant</li>
            <li>Sesame snaps</li>
            <li>Ice cream</li>
            <li>Candy canes</li>
            <li>Lemon drops</li>
          </ul>
          <h6 class="mb-3 mt-5 text-alternate">Muffin Sweet Roll Apple Pie</h6>
          <p>
            Carrot cake gummi bears wafer sesame snaps soufflé cheesecake cheesecake cake. Sweet roll apple pie tiramisu bonbon sugar plum
            muffin sesame snaps chocolate. Lollipop sweet roll gingerbread halvah sesame snaps powder. Wafer halvah chocolate soufflé icing.
            Cotton candy danish lollipop jelly-o candy caramels.
          </p>
        </div>
      </div>
    </div>
    <div class="card-footer border-0 pt-0">
      <div class="row align-items-center">
        <div class="col-6">
          <div class="d-flex align-items-center">
            <div class="sw-5 d-inline-block position-relative me-3">
              <img src="{{asset('backend/img/profile/profile-1.jpg')}}" class="img-fluid rounded-xl" alt="thumb" />
            </div>
            <div class="d-inline-block">
              <a href="#" class="lh-1 mb-1 d-inline-block">Olli Hawkins</a>
              <div class="text-muted text-small">Development Lead</div>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="row g-0 justify-content-end">
            <div class="col-auto pe-3">
              <i data-cs-icon="eye" class="text-primary me-1" data-cs-size="15"></i>
              <span class="align-middle">169</span>
            </div>
            <div class="col col-auto">
              <i data-cs-icon="message" class="text-primary me-1" data-cs-size="15"></i>
              <span class="align-middle">4</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Carousel End -->
</div>
</main>

@endsection