@extends('backend/layouts.template')
@section('titlepage')
Penilaian Kinerja Guru
@endsection
@section('title')
Penilaian
@endsection
@section('content')

@if(session()->has('success'))
<div class="alert alert-primary" role="alert">{{ session('success')}}</div>
@endif

@if(session()->has('loginError'))
<div class="alert alert-danger" role="alert">{{ session('loginError')}}</div>
@endif
<div id="success_message"></div>

<?php
if (count($walii) < 1) {
    ?>
    <h1 class="text-danger">Silahkan Isi Identitas Diri Anda !!!!</h1>
<?php
} else {
    ?>
    <form action="{{route('nilaiguru')}}" method="get">
        <div class="row">
            <div class="mb-3">
                <label class="form-label">Nama Guru</label>
                <div class="w-100">
                    <div class="w-100">
                        <select name="user_id" class="user_id form-control theSelect" id="user_id">
                            <option selected disabled>Pilih Guru</option>
                            @foreach ($dataguru as $item)
                            <option value="{{ $item->user_id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <span class="text-danger error-text user_id_error"></span>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary w-100 me-1 btn-sm">Nilai</button>
    </form>
<?php
}
?>
@section('js')
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script>
		$(".theSelect").select2({
      theme: 'bootstrap4',
    });
	</script>
@endsection
@endsection