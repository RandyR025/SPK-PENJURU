@extends('backend/layouts.template')
@section('titlepage')
Data Penilaian
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

<div class="col-sm-12 col-md-7 col-lg-9 col-xxl-10 mb-1" style="">
  <div class="d-inline-block me-0 me-sm-3 float-start float-md-none" style="margin-left: 300px;">
    <!-- Add Button Start -->
    <a href="#" class="btn btn-icon btn-icon-only btn-foreground-alternate shadow add-datatable" data-bs-toggle="modal" data-bs-placement="top" type="button" data-bs-delay="0" titte data-bs-original-title="Add" data-bs-target="#AddPenilaianModal">
      <i data-cs-icon="plus"></i>
    </a>
    <!-- Add Button End -->


    <div class="d-inline-block">
      <!-- Print Button Start -->
      <button class="btn btn-icon btn-icon-only btn-foreground-alternate shadow datatable-print" data-datatable="#datatableRows" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="Print" type="button">
        <i data-cs-icon="print"></i>
      </button>
      <!-- Print Button End -->

      <!-- Export Dropdown Start -->
      <div class="d-inline-block datatable-export" data-datatable="#datatableRows">
        <button class="btn p-0" data-bs-toggle="dropdown" type="button" data-bs-offset="0,3">
          <span class="btn btn-icon btn-icon-only btn-foreground-alternate shadow dropdown" data-bs-delay="0" data-bs-placement="top" data-bs-toggle="tooltip" title="Export">
            <i data-cs-icon="download"></i>
          </span>
        </button>
        <div class="dropdown-menu shadow dropdown-menu-end">
          <button class="dropdown-item export-copy" type="button">Copy</button>
          <button class="dropdown-item export-excel" type="button">Excel</button>
          <button class="dropdown-item export-cvs" type="button">Cvs</button>
        </div>
      </div>
      <!-- Export Dropdown End -->
    </div>
  </div>
</div>
<!-- Controls End -->
<!-- Content End -->
<div class="container">
  <div class="row">
    <table class="table table-hover" id="datatable">
      <thead>
        <tr>
          <th>No</th>
          <th>Id Penilaian</th>
          <th>Tangal Pelaksanaan</th>
          <th>Deadline</th>
          <th class="#"></th>
        </tr>
      </thead>
      <tbody>
      @foreach($tanggalpenilaian as $data)
      <tr>
      <td>{{$no++}}</td>
          <td>{{$data->id_penilaian}}</td>
          <td>{{$data->tanggal}}</td>
          <td>{{$data->deadline}}</td>
          <td>
          <button value="{{$data->id_penilaian}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_penilaian" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">
          <i class="fa-solid fa-pen-to-square"></i>
          </button>
            <button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_penilaian" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">
            <i class="fa-solid fa-trash-can"></i>
            </button>
            <!-- <a href="/show-pengisian/{{$data->id_penilaian}}" value="{{$data->id_penilaian}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_penilaian" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">
            <i class="fa-regular fa-eye"></i>
            </a> -->
          </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal modal-right large fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Penilaian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="" id="penilaian_form">
          <div class="mb-3 d-none">
              <label class="form-label">Kode Penilaian</label>
              <input id="hidden_id" type="text" class="id_penilaian form-control" value="" name="id_penilaian" />
              <span class="text-danger error-text id_penilaian_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Kode Penilaian</label>
              <input id="edit_id" type="text" class="id_penilaian form-control" value="" name="id_penilaian" />
              <span class="text-danger error-text id_penilaian_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Penilaian</label>
              <input id="edit_namapenilaian" type="text" class="nama_penilaian form-control" value="" name="nama_penilaian" />
              <span class="text-danger error-text nama_penilaian_error"></span>

            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Pelaksanaan</label>
              <input id="edit_tanggalpelaksanaan" type="date" class="tanggalpelaksanaan form-control" value="" name="tanggal_pelaksanaan" />
              <span class="text-danger error-text tanggalpelaksanaan_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Deadline</label>
              <input id="edit_deadline" type="date" class="deadline form-control" value="" name="deadline" />
              <span class="text-danger error-text deadline_error"></span>
            </div>
            <div class="position-relative d-inline-block" id="singleImageUploadExample">
              <div class="img-holder-update">
              </div>
              <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light rounded-xl position-absolute e-0 b-0" type="button">
                <i data-cs-icon="upload"></i>
              </button>
              <input class="file-upload d-none" type="file" name="image" id="edit_image" data-value="" />
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update_penilaian">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>



<?php
// $noUrut = (int) substr($maxpenilaian, 1, 2);
// $noUrut++;
// $char = "P";
// $newID = $char . sprintf("%02s", $noUrut);
?>

<div class="modal fade modal-close-out" id="AddPenilaianModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable mt-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Penilaian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="{{ route('tanggalpenilaian.store') }}" method="post" id="main_form">
            @csrf
            <div class="mb-3">
              <label class="form-label">Id Penilaian</label>
              <div class="w-100">
                <div class="w-100">
                    <select name="penilaian_id" class="user_id form-control theSelect" id="penilaian_id">
                      <option selected disabled>Pilih Penilaian</option>
                    @foreach ($penilaian as $item)
                      <option value="{{ $item->id_penilaian }}">{{ $item->id_penilaian }}</option>
                    @endforeach
                    </select>
                </div>
              </div>
              <span class="text-danger error-text user_id_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Pelaksanaan</label>
              <input name="tanggal_pelaksanaan" type="date" class="tanggal_pelaksanaan form-control" />
              <span class="text-danger error-text tanggalpelaksanaan_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Deadline</label>
              <input name="deadline" type="date" class="deadline form-control" />
              <span class="text-danger error-text deadline_error"></span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add_penilaian">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade modal-close-out" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="" id="edit_form">
            <div class="mb-3">
              <input id="delete_penilaian_id" type="hidden" class="id_penilaian form-control" value="" />
            </div>
            <h4 style="font-size: 30px;">Anda Yakin ??? Ingin Menghapus Data Ini ???</h4>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary delete_penilaian_btn">Delete</button>
      </div>
      </form>
    </div>
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
<script>
		$(".theSelect").select2({
      theme: 'bootstrap4',
    });
	</script>
  <script type="text/javascript">
    function guru_edit() {
      $(".edit_user_id").select2({
        theme: 'bootstrap4',
        dropdownParent: $('#editModal')
      });
    }
  </script>
<script src="{{asset('js/TanggalPenilaian.js')}}"></script>
@endsection
@endsection