@extends('backend/layouts.template')
@section('titlepage')
Data Kriteria
@endsection
@section('title')
Kelola Data
@endsection
@section('content')

@if(session()->has('success'))
<div class="alert alert-primary" role="alert">{{ session('success')}}</div>
@endif

@if(session()->has('loginError'))
<div class="alert alert-danger" role="alert">{{ session('loginError')}}</div>
@endif
<div id="success_message"></div>

<div class="col-sm-12 col-md-7 col-lg-9 col-xxl-10 mb-1 mt-5" style="">
</div>
<!-- Controls End -->
<!-- Content End -->
<div class="container">
  <div class="row">
    <table class="table table-hover" id="datatable">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode kriteria</th>
          <th>Nama Kriteria</th>
          <th class="#"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($kriteria as $data)
        <tr>
          <td>{{$no++}}</td>
          <td>{{$data->kode_kriteria}}</td>
          <td>{{$data->nama_kriteria}}</td>
          <td>
            <a href="/show-subkriteria/{{$data->kode_kriteria}}" value="{{$data->kode_kriteria}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_kriteria" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">
            <i class="fa-regular fa-eye"></i>
            </a>
            <a href="/show-perbandingansubkriteria/{{$data->kode_kriteria}}" value="{{$data->kode_kriteria}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_kriteria" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">
            <i class="fa-solid fa-table-cells"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#datatable').DataTable({
      responsive: true
    });

    /* table.on('click', '.edit', function (){
      $tr = $(this).closest('tr');
    if ($($tr).hasClass('child')) {
      $tr = $tr.prev('.parent');
    }

    var data = table.row($tr).data();
    console.log(data);

    $('#name').val(data[1]);
    $('#email').val(data[2]);

    $('#editForm').attr('action', '/datapengguna/'+data[0]);
    $('#editModal').modal('show');
    }); */
    new $.fn.dataTable.FixedHeader(table);
  });
</script>
<!-- <script src="{{asset('js/PerbandinganSubKriteria.js')}}"></script> -->
@endsection
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
@endsection