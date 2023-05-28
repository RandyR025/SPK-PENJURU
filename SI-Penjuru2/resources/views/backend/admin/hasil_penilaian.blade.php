@extends('backend/layouts.template')
@section('titlepage')
Data Jawaban Dari Penilaian {{$penilaian[0]->nama_penilaian}}
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
        <!-- <a href="#" class="btn btn-icon btn-icon-only btn-foreground-alternate shadow add-datatable" data-bs-toggle="modal" data-bs-placement="top" type="button" data-bs-delay="0" titte data-bs-original-title="Add" data-bs-target="#AddKriteriaModal">
            <i data-cs-icon="plus"></i>
        </a> -->
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
                    <!-- <button class="dropdown-item export-copy" type="button">Copy</button> -->
                    <a href="{{route('hasilpenilaiancetakexcel',[$penilaian[0]->id_penilaian,$tanggal[0]->id])}}" class="dropdown-item export-excel" type="button">Excel</a>
                    <a href="{{route('hasilpenilaiancetakpdf',$penilaian[0]->id_penilaian)}}" class="dropdown-item export-cvs" type="button">PDF</a>
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
                    <th>Nama Guru</th>
                    <th>Kelas</th>
                    @foreach($pengisian as $data)
                    <?php
                    $tes = json_decode($data->level);
                    ?>
                    @if (property_exists( $tes, 'wali'))
                    <th>{{$data->nama_pengisian}}</th>
                    @endif
                    @endforeach
                    <th>Cek Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wali_kelas as $key => $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->wali }}</td>
                    <td>{{ $item->guru }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    @foreach ($coba[$key] as $keycoba => $p)
                    <td>{{$p->nama_pilihan}} ({{ $p->points }})</td>
                    @endforeach
                    <td>
                        <a href="{{ route('hasilpenilaiancek', [$item->user_id_guru,$item->id_penilaian,$item->tanggal_id]) }}" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1" data-bs-placement="top" titte data-bs-original-title="Edit" data-bs-toggle="tooltip">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                        <button value="{{$item->user_id_guru}}" onclick="handleClick(this,'<?=$item->id_penilaian;?>','<?=$item->tanggal_id;?>');" class="btn btn-icon btn-icon-only btn-outline-secondary mb-1 delete_cekjawaban" type="button" data-bs-toggle="tooltip" data-bs-placement="top" titte data-bs-original-title="Hapus">
                        <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            // responsive: true
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
<!-- <script src="{{asset('js/Subkriteria.js')}}"></script> -->
<script src="{{asset('js/hasilcek.js')}}"></script>
@endsection
@endsection