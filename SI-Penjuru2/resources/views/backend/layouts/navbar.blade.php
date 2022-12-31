<!-- User Menu Start -->
<div class="user-container d-flex">
@if (auth()->user()->level == "admin")
  <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    @if (isset($admin->image))
    <img class="profile" alt="profile" src="{{asset('images/'.$admin->image)}}" style="" />
    @else
    <img class="profile" alt="profile" src="{{asset('backend/img/profile/profile-9.jpg')}}" style="min-height: 40px !important; height: 90%!important; max-height: 100px!important; min-width: 40px !important; width: 90%!important; max-width: 100px;" />
    @endif
    <div class="name" style="padding-top: 15px; padding-bottom: 5px; font-size: 15px;">{{ Auth::user()->name }}</div>
  </a>
@endif
@if (auth()->user()->level == "guru")
  <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  @if (isset($guru->image))
    <img class="profile" alt="profile" src="{{asset('images/'.$guru->image)}}" style="" />
    @else
    <img class="profile" alt="profile" src="{{asset('backend/img/profile/profile-9.jpg')}}" style="min-height: 40px !important; height: 90%!important; max-height: 100px!important; min-width: 40px !important; width: 90%!important; max-width: 100px;" />
    @endif
    <div class="name" style="padding-top: 15px; padding-bottom: 5px; font-size: 15px;">{{ Auth::user()->name }}</div>
  </a>
@endif
@if (auth()->user()->level == "wali")
  <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  @if (isset($wali->image))
    <img class="profile" alt="profile" src="{{asset('images/'.$wali->image)}}" style="" />
    @else
    <img class="profile" alt="profile" src="{{asset('backend/img/profile/profile-9.jpg')}}" style="min-height: 40px !important; height: 90%!important; max-height: 100px!important; min-width: 40px !important; width: 90%!important; max-width: 100px;" />
    @endif
    <div class="name" style="padding-top: 15px; padding-bottom: 5px; font-size: 15px;">{{ Auth::user()->name }}</div>
  </a>
@endif
  <div class="dropdown-menu dropdown-menu-end user-menu wide">
    <!-- <div class="row mb-3 ms-0 me-0">
      <div class="col-12 ps-1 mb-2">
        <div class="text-extra-small text-primary">ACCOUNT</div>
      </div>
      <div class="col-6 ps-1 pe-1">
        <ul class="list-unstyled">
          <li>
            <a href="#">User Info</a>
          </li>
          <li>
            <a href="#">Preferences</a>
          </li>
          <li>
            <a href="#">Calendar</a>
          </li>
        </ul>
      </div>
      <div class="col-6 pe-1 ps-1">
        <ul class="list-unstyled">
          <li>
            <a href="#">Security</a>
          </li>
          <li>
            <a href="#">Billing</a>
          </li>
        </ul>
      </div>
    </div> -->
    <!-- <div class="row mb-1 ms-0 me-0">
      <div class="col-12 p-1 mb-2 pt-2">
        <div class="text-extra-small text-primary">APPLICATION</div>
      </div>
      <div class="col-6 ps-1 pe-1">
        <ul class="list-unstyled">
          <li>
            <a href="#">Themes</a>
          </li>
          <li>
            <a href="#">Language</a>
          </li>
        </ul>
      </div>
      <div class="col-6 pe-1 ps-1">
        <ul class="list-unstyled">
          <li>
            <a href="#">Devices</a>
          </li>
          <li>
            <a href="#">Storage</a>
          </li>
        </ul>
      </div>
    </div> -->
    <div class="row mb-1 ms-0 me-0">
      <!-- <div class="col-12 p-1 mb-3 pt-3">
        <div class="separator-light"></div>
      </div> -->
      <div class="col-6 ps-1 pe-1">
        <ul class="list-unstyled">
          <li>
            <a href="#">
              <i data-cs-icon="help" class="me-2" data-cs-size="17"></i>
              <span class="align-middle">Help</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i data-cs-icon="document-full" class="me-2" data-cs-size="17"></i>
              <span class="align-middle">Docs</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="col-6 pe-1 ps-1">
        <ul class="list-unstyled">
        @if (auth()->user()->level == "admin")
          <li>
            <a href="{{route('profile')}}">
              <i data-cs-icon="gear" class="me-2" data-cs-size="17"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
        @endif
        @if (auth()->user()->level == "guru")
          <li>
            <a href="{{route('profileguru')}}">
              <i data-cs-icon="gear" class="me-2" data-cs-size="17"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
        @endif
        <!-- @if (auth()->user()->level == "wali")
          <li>
            <a href="{{route('profilewali')}}">
              <i data-cs-icon="gear" class="me-2" data-cs-size="17"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
        @endif -->
          <li>
            <a href="{{route('keluarlogout')}}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
              <i data-cs-icon="logout" class="me-2" data-cs-size="17"></i>
              <span class="align-middle">Logout</span>
            </a>
            <form action="{{route('keluarlogout')}}" method="POST" id="logout-form">
              {{ csrf_field()}}
            </form>

          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- User Menu End -->

<!-- Icons Menu Start -->
<ul class="list-unstyled list-inline text-center menu-icons">
  <li class="list-inline-item">
    <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">
      <i data-cs-icon="search" data-cs-size="18"></i>
    </a>
  </li>
  <li class="list-inline-item">
    <a href="#" id="pinButton" class="pin-button">
      <i data-cs-icon="lock-on" class="unpin" data-cs-size="18"></i>
      <i data-cs-icon="lock-off" class="pin" data-cs-size="18"></i>
    </a>
  </li>
  <li class="list-inline-item">
    <a href="#" id="colorButton">
      <i data-cs-icon="light-on" class="light" data-cs-size="18"></i>
      <i data-cs-icon="light-off" class="dark" data-cs-size="18"></i>
    </a>
  </li>
  <li class="list-inline-item">
    <a href="#" data-bs-toggle="dropdown" data-bs-target="#notifications" aria-haspopup="true" aria-expanded="false" class="notification-button">
      <div class="position-relative d-inline-flex">
        <i data-cs-icon="bell" data-cs-size="18"></i>
        <span class="position-absolute notification-dot rounded-xl"></span>
      </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end wide notification-dropdown scroll-out" id="notifications">
      <div class="scroll">
        <ul class="list-unstyled border-last-none">
          <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
            <img src="img/profile/profile-1.jpg" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
            <div class="align-self-center">
              <a href="#">Joisse Kaycee just sent a new comment!</a>
            </div>
          </li>
          <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
            <img src="img/profile/profile-2.jpg" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
            <div class="align-self-center">
              <a href="#">New order received! It is total $147,20.</a>
            </div>
          </li>
          <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
            <img src="img/profile/profile-3.jpg" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
            <div class="align-self-center">
              <a href="#">3 items just added to wish list by a user!</a>
            </div>
          </li>
          <li class="pb-3 pb-3 border-bottom border-separator-light d-flex">
            <img src="img/profile/profile-6.jpg" class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
            <div class="align-self-center">
              <a href="#">Kirby Peters just sent a new message!</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </li>
</ul>
<!-- Icons Menu End -->