@extends('backend/layouts.template')
@section('titlepage')
Data Pengisian Dari Penilaian {{$penilaian[0]->nama_penilaian}}
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
    <a href="#" class="btn btn-icon btn-icon-only btn-foreground-alternate shadow add-datatable" data-bs-toggle="modal" data-bs-placement="top" type="button" data-bs-delay="0" titte data-bs-original-title="Add" data-bs-target="#AddPengisianModal">
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
          <th>Kode Pengisian</th>
          <th>Nama Pengisian</th>
          <th>Nama Subkriteria</th>
          <th>Id Penilaian</th>
          <th class="#"></th>
        </tr>
      </thead>
      <tbody>
      @foreach ($pengisian as $data)
      <tr>
          <td>{{ $no++ }}</td>
          <td>{{ $data->kode_pengisian }}</td>
          <td>{{ $data->nama_pengisian }}</td>
          <td>{{ $data->nama_subkriteria }}</td>
          <td>{{ $data->id_penilaian }}</td>
          <td>
          <button value="{{ $data->kode_pengisian }}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 edit_pengisian" type="button" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">
          <i class="fa-solid fa-pen-to-square"></i>
          </button>
            <button value="{{ $data->kode_pengisian }}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_pengisian" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">
            <i class="fa-solid fa-trash-can"></i>
            </button>
          <a href="/show-pilihan/{{ $data->kode_pengisian }}" value="{{ $data->kode_pengisian }}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 view_pengisian" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="View">
            <i class="fa-solid fa-list"></i>
          </a>
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
        <h5 class="modal-title">Edit Kriteria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="" id="pengisian_form">
            <div class="mb-3" hidden>
              <label class="form-label">Id Penilaian</label>
              <input id="edit_id" type="text" class="id_penilaian form-control" value="" name="id_penilaian" />
              <span class="text-danger error-text id_penilaian_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Kode Pengisian</label>
              <input id="edit_kodepengisian" type="text" class="kode_pengisian form-control" value="" name="kode_pengisian" />
              <span class="text-danger error-text kode_pengisian_error"></span>
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Kode Sub Kriteria</label>
              <input id="edit_kodesubkriteria" type="text" class="kodesubkriteria form-control" value="" name="kode_subkriteria" />
              <span class="text-danger error-text kode_subkriteria_error"></span>
            </div> -->
            <div class="mb-3">
              <label class="form-label">Nama Subkriteria</label>
              <div>
                <select name="kode_subkriteria" class="kode_subkriteria form-control" id="edit_kodesubkriteria">
                @foreach ($subkriteria as $item)
                  <option value="{{ $item->kode_subkriteria }}">{{ $item->nama_subkriteria }}</option>
                @endforeach
                </select>
              </div>
              <span class="text-danger error-text kode_subkriteria_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Pengisian</label>
              <input id="edit_namapengisian" type="text" class="namapengisian form-control" value="" name="nama_pengisian" />
              <span class="text-danger error-text nama_pengisian_error"></span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary update_pengisian">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade modal-close-out" id="AddPengisianModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable mt-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengisian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="{{ route('pengisian.store') }}" method="post" id="main_form">
            @csrf
            <div class="mb-3" hidden>
              <label class="form-label">Id Penilaian</label>
              <input name="id_penilaian" type="text" class="id_penilaian form-control" value="{{$penilaian[0]->id_penilaian}}" />
              <span class="text-danger error-text id_penilaian_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Kode Pengisian</label>
              <input name="kode_pengisian" type="text" class="kode_pengisian form-control" />
              <span class="text-danger error-text kode_pengisian_error"></span>
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Kode Sub Kriteria</label>
              <input name="kode_subkriteria" type="text" class="kode_subkriteria form-control" />
              <span class="text-danger error-text kode_subkriteria_error"></span>
            </div> -->
            <div class="mb-3">
              <label class="form-label">Kriteria</label>
              <div>
                <select name="kode_kriteria" class="kode_kriteria form-control" id="kode_kriteria">
                @foreach ($kriteria as $item)
                  <option value="{{ $item->kode_kriteria }}">{{ $item->nama_kriteria }}</option>
                @endforeach
                </select>
              </div>
              <span class="text-danger error-text kriteria_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Subkriteria</label>
              <div>
                <select name="kode_subkriteria" class="kode_subkriteria form-control" id="kode_subkriteria">
                </select>
              </div>
              <span class="text-danger error-text kode_subkriteria_error"></span>
            </div>
            <div class="mb-3">
              <label class="form-label">Name Pengisian</label>
              <input name="nama_pengisian" type="text" class="nama_pengisian form-control" />
              <span class="text-danger error-text nama_pengisian_error"></span>
            </div>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add_pengisian">Save changes</button>
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
              <input id="delete_pengisian_id" type="hidden" class="name form-control" value="" />
            </div>
            <h4 style="font-size: 30px;">Anda Yakin ??? Ingin Menghapus Data Ini ???</h4>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary delete_pengisian_btn">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#datatable').DataTable({
      responsive: true
      // scrollX: true
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
<script src="{{asset('js/Pengisian.js')}}"></script>
@endsection
@endsection