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
@if (auth()->user()->level == "admin")
<!-- Public Info Start -->
<h2 class="small-title">Public Info</h2>
<div class="card mb-5">
  <div class="card-body">
    <form method="post" id="profile_form" enctype="multipart/form-data" action="">
      @csrf
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label" hidden>id</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_id" type="text" class="id form-control" value="{{ Auth::user()->id }}" name="edit_id" hidden />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label" hidden>Name</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_level" name="level" type="text" class="form-control" value="{{ Auth::user()->level }}" hidden />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Name</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_name" name="name" type="text" class="form-control" value="{{ Auth::user()->name }}" />
          <span class="text-danger error-text name_error"></span>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_email" name="email" type="email" class="form-control" value="{{ Auth::user()->email }}" />
          <span class="text-danger error-text email_error"></span>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Password</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_password" name="password" type="password" class="form-control" value="password" />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">NIK</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($admin->nik))
          <input id="edit_nik" name="nik" type="text" class="form-control" value="{{ $admin->nik }}" />
          <span class="text-danger error-text nik_error"></span>
          @else
          <input id="edit_nik" name="nik" type="text" class="form-control" value="" />
          <span class="text-danger error-text nik_error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($admin->tanggal_lahir))
          <input id="edit_tanggallahir" name="tanggal_lahir" type="date" class="form-control date-picker-close" id="birthday" value="{{ $admin->tanggal_lahir }}" />
          <span class="text-danger error-text tanggal_lahir_error"></span>
          @else
          <input id="edit_tanggallahir" name="tanggal_lahir" type="date" class="form-control date-picker-close" id="birthday" value="" />
          <span class="text-danger error-text tanggal_lahir_error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Tempat Lahir</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($admin->tempat_lahir))
          <input id="edit_tempatlahir" name="tempat_lahir" type="text" class="form-control" value="{{ $admin->tempat_lahir }}" />
          <span class="text-danger error-text tempat_lahir_error"></span>
          @else
          <input id="edit_tempatlahir" name="tempat_lahir" type="text" class="form-control" value="" />
          <span class="text-danger error-text tempat_lahir_error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($admin->jenis_kelamin))
          <select id="edit_jeniskelamin" class="select-single-no-search" data-width="100%" id="genderSelect" name="jenis_kelamin">
            @if($admin->jenis_kelamin == "laki-laki")
            <option value="{{ $admin->jenis_kelamin }}" label="&nbsp;">{{ $admin->jenis_kelamin }}</option>
            <option value="perempuan">perempuan</option>
            @else
            <option value="{{ $admin->jenis_kelamin }}" label="&nbsp;">{{ $admin->jenis_kelamin }}</option>
            <option value="laki-laki">laki-laki</option>
            @endif
          </select>
          @else
          <select id="edit_jeniskelamin" class="select-single-no-search" data-width="100%" id="genderSelect" name="jenis_kelamin">
            <option value="perempuan">perempuan</option>
            <option value="laki-laki">laki-laki</option>
          </select>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Alamat</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($admin->alamat))
          <textarea class="form-control" rows="3" name="alamat" id="edit_alamat">{{ $admin->alamat }}</textarea>
          <span class="text-danger error-text alamat_error"></span>
          @else
          <textarea class="form-control" rows="3" name="alamat" id="edit_alamat"></textarea>
          <span class="text-danger error-text alamat_error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">No Telp</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($admin->no_telp))
          <input id="edit_notelp" type="text" class="form-control" value="{{ $admin->no_telp }}" name="no_telp" />
          <span class="text-danger error-text no_telp_error"></span>
          @else
          <input id="edit_notelp" type="text" class="form-control" value="" name="no_telp" />
          <span class="text-danger error-text no_telp_error"></span>
          @endif
        </div>
      </div>
      <div class="position-relative d-inline-block" id="singleImageUploadExample">
        <div class="img-holder-update">
          <label for="" style="margin-right:100px;"> Foto Profil</label>
          @if (isset($admin->image))
          <img src="{{asset('images/'.$admin->image)}}" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
          @else
          <img src="backend/img/profile/profile-11.jpg" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
          @endif
        </div>
        <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light rounded-xl position-absolute e-0 b-0" type="button">
          <i data-cs-icon="upload"></i>
        </button>
        <input class="file-upload d-none" type="file" name="image" id="edit_image" data-value="" />
      </div>
      <div class="mb-3 row mt-5">
        <div class="col-sm-8 col-md-9 col-lg-10 ms-auto">
          <button type="submit" class="btn btn-primary admin_update">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Public Info End -->
@endif
@if (auth()->user()->level == "guru")
<!-- Public Info Start -->
<h2 class="small-title">Public Info</h2>
<div class="card mb-5">
  <div class="card-body">
    <form method="post" id="profileguru_form" enctype="multipart/form-data" action="">
      @csrf
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label" hidden>id</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_id" type="text" class="id form-control" value="{{ Auth::user()->id }}" name="edit_id" hidden />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label" hidden>Name</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_level" name="level" type="text" class="form-control" value="{{ Auth::user()->level }}" hidden />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Name</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_name" name="name" type="text" class="form-control" value="{{ Auth::user()->name }}" />
          <span class="text-danger error-text name_error"></span>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_email" name="email" type="email" class="form-control" value="{{ Auth::user()->email }}" />
          <span class="text-danger error-text name_error"></span>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Password</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input id="edit_password" name="password" type="password" class="form-control" value="password" />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">NIK</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($guru->nik))
          <input id="edit_nik" name="nik" type="text" class="form-control" value="{{ $guru->nik }}" />
          <span class="text-danger error-text nik_error"></span>
          @else
          <input id="edit_nik" name="nik" type="text" class="form-control" value="" />
          <span class="text-danger error-text nik_error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($guru->tanggal_lahir))
          <input id="edit_tanggallahir" name="tanggal_lahir" type="date" class="form-control date-picker-close" id="birthday" value="{{ $guru->tanggal_lahir }}" />
          <span class="text-danger error-text tanggal_lahir__error"></span>
          @else
          <input id="edit_tanggallahir" name="tanggal_lahir" type="date" class="form-control date-picker-close" id="birthday" value="" />
          <span class="text-danger error-text tanggal_lahir__error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Tempat Lahir</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($guru->tempat_lahir))
          <input id="edit_tempatlahir" name="tempat_lahir" type="text" class="form-control" value="{{ $guru->tempat_lahir }}" />
          <span class="text-danger error-text tempat_lahir__error"></span>
          @else
          <input id="edit_tempatlahir" name="tempat_lahir" type="text" class="form-control" value="" />
          <span class="text-danger error-text tempat_lahir_error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($guru->jenis_kelamin))
          <select id="edit_jeniskelamin" class="select-single-no-search" data-width="100%" id="genderSelect" name="jenis_kelamin">
            @if($guru->jenis_kelamin == "laki-laki")
            <option value="{{ $guru->jenis_kelamin }}" label="&nbsp;">{{ $guru->jenis_kelamin }}</option>
            <option value="perempuan">perempuan</option>
            @else
            <option value="{{ $guru->jenis_kelamin }}" label="&nbsp;">{{ $guru->jenis_kelamin }}</option>
            <option value="laki-laki">laki-laki</option>
            @endif
          </select>
          @else
          <select id="edit_jeniskelamin" class="select-single-no-search" data-width="100%" id="genderSelect" name="jenis_kelamin">
            <option value="perempuan">perempuan</option>
            <option value="laki-laki">laki-laki</option>
          </select>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Alamat</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($guru->alamat))
          <textarea class="form-control" rows="3" name="alamat" id="edit_alamat">{{ $guru->alamat }}</textarea>
          <span class="text-danger error-text alamat_error"></span>
          @else
          <textarea class="form-control" rows="3" name="alamat" id="edit_alamat"></textarea>
          <span class="text-danger error-text alamat_error"></span>
          @endif
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">No Telp</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          @if(isset($guru->no_telp))
          <input id="edit_notelp" type="text" class="form-control" value="{{ $guru->no_telp }}" name="no_telp" />
          <span class="text-danger error-text no_telp_error"></span>
          @else
          <input id="edit_notelp" type="text" class="form-control" value="" name="no_telp" />
          <span class="text-danger error-text no_telp_error"></span>
          @endif
        </div>
      </div>
      <div class="position-relative d-inline-block" id="singleImageUploadExample">
        <div class="img-holder-update">
          <label for="" style="margin-right:100px;"> Foto Profil</label>
          @if (isset($guru->image))
          <img src="{{asset('images/'.$guru->image)}}" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
          @else
          <img src="backend/img/profile/profile-11.jpg" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
          @endif
        </div>
        <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light rounded-xl position-absolute e-0 b-0" type="button">
          <i data-cs-icon="upload"></i>
        </button>
        <input class="file-upload d-none" type="file" name="image" id="edit_image" data-value="" />
      </div>
      <div class="mb-3 row mt-5">
        <div class="col-sm-8 col-md-9 col-lg-10 ms-auto">
          <button type="submit" class="btn btn-primary admin_update">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Public Info End -->
@endif
@if (auth()->user()->level == "wali")
<!-- Public Info Start -->
<h2 class="small-title">Public Info</h2>
<div class="card mb-5">
  <div class="card-body">
    <form>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Name</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input type="text" class="form-control" value="{{ Auth::user()->name }}" />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input type="email" class="form-control" value="{{ Auth::user()->email }}" />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Password</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input type="password" class="form-control" value="password" />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input type="date" class="form-control date-picker-close" id="birthday" value="{{ $wali->tanggal_lahir }}" />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Tempat Lahir</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input type="text" class="form-control" value="{{ $wali->tempat_lahir }}" />
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <select class="select-single-no-search" data-width="100%" id="genderSelect">
            @if($wali->jenis_kelamin == "laki-laki")
            <option value="{{ $wali->jenis_kelamin }}" label="&nbsp;">{{ $wali->jenis_kelamin }}</option>
            <option value="perempuan">perempuan</option>
            @else
            <option value="{{ $wali->jenis_kelamin }}" label="&nbsp;">{{ $wali->jenis_kelamin }}</option>
            <option value="laki-laki">laki-laki</option>
            @endif
          </select>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">Alamat</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <textarea class="form-control" rows="3">{{ $wali->alamat }}</textarea>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-2 col-md-3 col-sm-4 col-form-label">No Telp</label>
        <div class="col-sm-8 col-md-9 col-lg-10">
          <input type="text" class="form-control" value="{{ $wali->no_telp }}" />
        </div>
      </div>
      <div class="position-relative d-inline-block" id="singleImageUploadExample">
        <div class="img-holder-update">
          <label for="" style="margin-right:100px;"> Foto Profil</label>
          @if (isset($admin->image))
          <img src="{{asset('images/'.$wali->image)}}" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
          @else
          <img src="backend/img/profile/profile-11.jpg" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
          @endif
        </div>
        <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light rounded-xl position-absolute e-0 b-0" type="button">
          <i data-cs-icon="upload"></i>
        </button>
        <input class="file-upload d-none" type="file" name="image" id="edit_image" data-value="" />
      </div>
      <div class="mb-3 row mt-5">
        <div class="col-sm-8 col-md-9 col-lg-10 ms-auto">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Public Info End -->
@endif
<script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('js/Profil.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection