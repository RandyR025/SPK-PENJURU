@extends('backend/layouts.template')
@section('titlepage')
Data Pengguna
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

@if(isset($errors) && $errors->any())
<div class="alert alert-danger" role="alert">
  @foreach ($errors->all() as $error)
  {{ $error }}
  @endforeach
</div>
@endif
<div id="success_message"></div>
<form action="{{route('datapenggunaimportexcel')}}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="input-group mb-4 row">
    <div class="col mb-2">
      <select name="akses" class="level form-control select-single-no-search" id="">
            <option value="guru">guru</option>
            <option value="wali">wali</option>
      </select>
    </div>
      <div class="row-10 mb-2">
        <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="file" />
      </div>
      <div class="row">
        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Uploud</button>
      </div>
  </div>
</form>

<div class="col-sm-12 col-md-7 col-lg-9 col-xxl-10 mb-1" style="">
  <div class="d-inline-block me-0 me-sm-3 float-start float-md-none" style="margin-left: 300px;">
    <!-- Add Button Start -->
    <a href="#" class="btn btn-icon btn-icon-only btn-foreground-alternate shadow add-datatable" data-bs-toggle="modal" data-bs-placement="top" type="button" data-bs-delay="0" titte data-bs-original-title="Add" data-bs-target="#AddPenggunaModal">
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
          <th>Nama</th>
          <th>Email</th>
          <th>Level</th>
          <th class="#"></th>
        </tr>
      </thead>
      <tbody>
      @foreach($user as $data)
        <tr>
        <td>{{$no++}}</td>
          <td>{{$data->name}}</td>
          <td>{{$data->email}}</td>
          <td>{{$data->level}}</td>
          <td><button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_user" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="modal">
          <i class="fa-solid fa-pen-to-square"></i>
          </button>
            <button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_user" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">
            <i class="fa-solid fa-trash-can"></i>
            </button>
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
        <h5 class="modal-title">Edit Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="" id="edit_form">
            <div class="mb-3">
              <input id="edit_id" type="hidden" class="name form-control" value="" />
            </div>
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input id="edit_name" type="text" class="name form-control" value="" />
              <span class="text-danger error-text name_error"></span>

            </div>
            <div class="mb-3">
              <label class="form-label">email</label>
              <input id="edit_email" type="email" class="email form-control" value="" />
              <span class="text-danger error-text email_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">password</label>
              <input name="password" type="password" class="password form-control" id="edit_password" />
              <span class="text-danger error-text password_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Level User</label>
              <div>
                <select name="level" class="level form-control select-single-no-search" id="edit_level">
                  <option value="admin">admin</option>
                  <option value="guru">guru</option>
                  <option value="wali">wali</option>
                </select>
              </div>
              <span class="text-danger error-text level_error"></span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update_user">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade modal-close-out" id="AddPenggunaModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable mt-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="{{ route('pengguna.store') }}" method="post" id="main_form" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input name="name" type="text" class="namapengguna form-control" />
              <span class="text-danger error-text name_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">email</label>
              <input name="email" type="email" class="email form-control" />
              <span class="text-danger error-text email_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">password</label>
              <input name="password" type="password" class="password form-control" />
              <span class="text-danger error-text password_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Level User</label>
              <div>
                <select name="level" id="" class="level form-control select-single-no-search">
                  <option value="0" label="&nbsp;" selected disabled>Pilih Level</option>
                  <option value="admin">admin</option>
                  <option value="guru">guru</option>
                  <option value="wali">wali</option>
                </select>
              </div>
              <span class="text-danger error-text level_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Tempat Lahir</label>
              <input name="tempat_lahir" type="text" class="tempat_lahir form-control" />
              <span class="text-danger error-text tempat_lahir_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input name="tanggal_lahir" type="date" class="tanggal_lahir form-control" />
              <span class="text-danger error-text tanggal_lahir_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">NIK</label>
              <input name="nik" type="text" class="nik form-control" />
              <span class="text-danger error-text nik_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <input name="alamat" type="text" class="alamat form-control" />
              <span class="text-danger error-text alamat_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">No Telepon</label>
              <input name="no_telp" type="text" class="no_telp form-control" />
              <span class="text-danger error-text no_telp_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <div>
                <select name="jenis_kelamin" id="" class="jenis_kelamin form-control select-single-no-search">
                  <option value="0" label="&nbsp;" selected disabled>Pilih Jenis Kelamin</option>
                  <option value="laki-laki">laki-laki</option>
                  <option value="perempuan">perempuan</option>
                </select>
              </div>
              <span class="text-danger error-text jenis_kelamin_error"></span>
            </div>
            <div class="position-relative d-inline-block" id="singleImageUploadExample">
              <img src="{{asset('backend/img/profile/profile-11.jpg')}}" alt="user" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
              <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light rounded-xl position-absolute e-0 b-0" type="button">
                <i data-cs-icon="upload"></i>
              </button>
              <input class="file-upload d-none" type="file" name="image"/>
            </div>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add_pengguna">Save changes</button>
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
              <input id="delete_user_id" type="hidden" class="name form-control" value="" />
            </div>
            <h4 style="font-size: 30px;">Anda Yakin ??? Ingin Menghapus Data Ini ???</h4>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary delete_user_btn">Delete</button>
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
<script src="{{asset('js/TambahPengguna.js')}}"></script>
@endsection
@endsection