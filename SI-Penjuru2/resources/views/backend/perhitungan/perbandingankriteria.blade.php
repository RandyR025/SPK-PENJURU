@extends('backend/layouts.template')
@section('titlepage')
Perbandingan Kriteria
@endsection
@section('title')
Perhitungan
@endsection
@section('content')

@if(session()->has('success'))
<div class="alert alert-primary" role="alert">{{ session('success')}}</div>
@endif

@if(session()->has('loginError'))
<div class="alert alert-danger" role="alert">{{ session('loginError')}}</div>
@endif
<div id="success_message"></div>
<!-- Content End -->
<div class="container">
  <div class="row">
    <!-- <table class="table table-bordered">
      <thead>
        <tr>
          <th>Kriteria</th>
          @foreach($kriteria as $item)
          <th>{{$item->nama_kriteria}}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($kriteria as $item)
        <tr>
          <th>{{$item->nama_kriteria}}</th>
          @foreach($kriteria as $item)
          <td>
            <input type="text" class="form-control">
          </td>
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table> -->
    <!-- @foreach($kriteria as $key => $value)
    @if(isset($kriteria[$key+1]->nama_kriteria))
    {{$value->nama_kriteria}} <input type="text" name="" id=""> {{$kriteria[$key+1]->nama_kriteria}}</br>
    @endif
    @endforeach -->
    {{showTabelPerbandingan('kriteria','kriteria')}}

  </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="{{asset('js/Guru.js')}}"></script> -->
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script type="text/javascript">
  function sum(no) {
     var txtkriteriavalue = document.getElementById('hkriteria'+no).value;
     var result = 1/parseFloat(txtkriteriavalue);
     if (!isNaN(result)) {
      document.getElementById('hkriteriaterbalik'+no).value = result.toFixed(2);
     }
  }
</script>

@endsection