@extends('backend/layouts.template')
@section('titlepage')
Data Guru
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
          <th>Foto</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>Tanggal Lahir</th>
          <th>Tempat Lahir</th>
          <th>Jenis Kelamin</th>
          <th>Alamat</th>
          <th>Nomor Telepon</th>
          <th class="#"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($dataguru as $data)
        @if($data->image == null)
        <tr>
          <td>{{$no++}}</td>
          <td><image src="backend/img/profile/profile-11.jpg" width="100px" height="100px" alt="image"></td>
          <td>{{$data->nik}}</td>
          <td>{{$data->name}}</td>
          <td>{{$data->tanggal_lahir}}</td>
          <td>{{$data->tempat_lahir}}</td>
          <td>{{$data->jenis_kelamin}}</td>
          <td>{{$data->alamat}}</td>
          <td>{{$data->no_telp}}</td>
          <td><button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_guru" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">
            <i class="fa-solid fa-trash-can"></i>
          </button>
          <button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">
            <i class="fa-regular fa-eye"></i>
          </button>
        </td>
        </tr>
        @else
        <tr>
          <td>{{$no++}}</td>
          <td><image src="images/{{$data->image}}" width="100px" height="100px" alt="image"></td>
          <td>{{$data->nik}}</td>
          <td>{{$data->name}}</td>
          <td>{{$data->tanggal_lahir}}</td>
          <td>{{$data->tempat_lahir}}</td>
          <td>{{$data->jenis_kelamin}}</td>
          <td>{{$data->alamat}}</td>
          <td>{{$data->no_telp}}</td>
          <td><button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_guru" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">
            <i class="fa-solid fa-trash-can"></i>
          </button>
          <button value="{{$data->id}}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_guru" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">
            <i class="fa-regular fa-eye"></i>
          </button>
        </td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal modal-right large fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form id="guru_form" enctype="multipart/form-data" method="post" action="">
            <div class="mb-3">
              <input id="edit_id" type="text" class="id form-control" value="" name="edit_id" />
            </div>
            <div class="mb-3">
              <label class="form-label">NIK</label>
              <input id="edit_nik" type="text" class="nik form-control" value="" name="nik" />
              <span class="text-danger error-text nik_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input id="edit_name" type="text" class="name form-control" value="" name="name" />
              <span class="text-danger error-text name_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input id="edit_tanggallahir" type="date" class="tanggallahir form-control" value="" name="tanggal_lahir" />
              <span class="text-danger error-text tanggallahir_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Tempat Lahir</label>
              <input id="edit_tempatlahir" type="text" class="tempatlahir form-control" value="" name="tempat_lahir" />
              <span class="text-danger error-text tempatlahir_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <div>
                <select name="jenis_kelamin" id="edit_jeniskelamin" class="jeniskelamin form-control select-single-no-search">
                  <option value="laki-laki">laki-laki</option>
                  <option value="perempuan">perempuan</option>
                </select>
              </div>
              <span class="text-danger error-text jeniskelamin_error"></span>
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Alamat</label>
              <input id="edit_alamat" type="text" class="alamat form-control" value="" name="alamat"/>
              <span class="text-danger error-text alamat_error"></span>
            </div> -->
            <div class="mb-3 row">
              <label class="form-label">Alamat</label>
              <div class="">
                <textarea class="form-control" rows="3" id="edit_alamat" name="alamat"></textarea>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">No Telp</label>
              <input id="edit_notelp" type="text" class="notelp form-control" value="" name="no_telp" />
              <span class="text-danger error-text notelp_error"></span>
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
        <button type="submit" class="btn btn-primary update_guru">Save changes</button>
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
              <input id="delete_guru_id" type="hidden" class="name form-control" value="" />
            </div>
            <h4 style="font-size: 30px;">Anda Yakin ??? Ingin Menghapus Data Ini ???</h4>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary delete_guru_btn">Delete</button>
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
<script src="{{asset('js/Guru.js')}}"></script>
@endsection

@endsection