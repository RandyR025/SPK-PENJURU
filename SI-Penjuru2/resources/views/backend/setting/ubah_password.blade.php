@extends('backend/layouts.template')
@section('titlepage')
Edit Profile
@endsection
@section('title')
Setting
@endsection
@section('content')

@if(session()->has('success'))
<div class="alert alert-primary" role="alert">{{ session('success')}}</div>
@endif

@if(session()->has('loginError'))
<div class="alert alert-danger" role="alert">{{ session('loginError')}}</div>
@endif
<div id="success_message"></div>
<!-- Public Info Start -->
<h2 class="small-title">Ubah Password</h2>
<div class="card mb-5">
  <div class="card-body">
    <form method="post" action="{{route('changepassword')}}">
      @csrf
      @method('PUT')
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Password Lama</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="lama_password" name="password_lama" type="password" class="form-control" required />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Password Baru</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="baru_password" name="password_baru" type="password" class="form-control" required />
        </div>
      </div>
      <div class="mb-3 row mt-5">
        <div class="col-sm-8 col-md-9 col-lg-10 ms-auto">
          <button type="submit" class="btn btn-primary admin_update">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script>
@endsection