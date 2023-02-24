@extends('backend/layouts.template')
@section('titlepage')
Rekap Laporan
@endsection
@section('title')
Cetak Laporan
@endsection
@section('content')

@if(session()->has('success'))
<div class="alert alert-primary" role="alert">{{ session('success')}}</div>
@endif

@if(session()->has('rekapError'))
<div class="alert alert-danger" role="alert">{{ session('rekapError')}}</div>
@endif
<div id="success_message"></div>

<form action="{{route('rekaplaporancetak')}}" method="get" class="mb-6" class="form-group">

    <div class="row mb-4">
        <div class="col">
            <select style="cursor:pointer;" class="select-single-no-search" id="tag_select1" data-width="100%" name="firstmonth">
                <option value="0" selected disabled> Pilih Bulan Awal</option>
                <option value="01"> Januari</option>
                <option value="02"> Februari</option>
                <option value="03"> Maret</option>
                <option value="04"> April</option>
                <option value="05"> Mei</option>
                <option value="06"> Juni</option>
                <option value="07"> Juli</option>
                <option value="08"> Agustus</option>
                <option value="09"> September</option>
                <option value="10"> Oktober</option>
                <option value="11"> November</option>
                <option value="12"> Desember</option>
            </select>
        </div>
        <div class="col">
            <select style="cursor:pointer;" class="select-single-no-search" id="tag_select2" data-width="100%" name="lastmonth">
                <option value="0" selected disabled> Pilih Bulan Akhir</option>
                <option value="01"> Januari</option>
                <option value="02"> Februari</option>
                <option value="03"> Maret</option>
                <option value="04"> April</option>
                <option value="05"> Mei</option>
                <option value="06"> Juni</option>
                <option value="07"> Juli</option>
                <option value="08"> Agustus</option>
                <option value="09"> September</option>
                <option value="10"> Oktober</option>
                <option value="11"> November</option>
                <option value="12"> Desember</option>
            </select>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <select style="cursor:pointer;" class="select-single-no-search" id="tag_select3" data-width="100%" name="firstyear">
                <option value="0" selected disabled> Pilih Tahun Awal</option>
                <?php
                $year = date('Y');
                $min = $year - 60;
                $max = $year;
                for ($i = $max; $i >= $min; $i--) {
                    echo '<option value=' . $i . '>' . $i . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col">
            <select style="cursor:pointer;" class="select-single-no-search" id="tag_select4" data-width="100%" name="lastyear">
                <option value="0" selected disabled> Pilih Tahun Akhir</option>
                <?php
                $year = date('Y');
                $min = $year - 60;
                $max = $year;
                for ($i = $max; $i >= $min; $i--) {
                    echo '<option value=' . $i . '>' . $i . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <select name="opsi" id="opsi" class="select-single-no-search" data-width="100%">
                <option value="0" selected disabled> Pilih Opsi</option>
                <option value="pdf">Cetak PDF</option>
                <option value="excel">Cetak Excel</option>
            </select>
        </div>
        <div class="col">
            <select name="laporan" id="laporan" class="select-single-no-search" data-width="100%">
                <option value="0" selected disabled> Pilih Laporan</option>
                <option value="jawaban">Laporan Jawaban</option>
                <option value="hasil">Laporan Hasil</option>
            </select>
        </div>
    </div>



    <button type="submit" class="btn btn-outline-primary w-100 me-1 btn-sm">Cetak Laporan</button>
</form>



<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
<script src="{{asset('js/Guru.js')}}">
    // <script src = "//cdn.jsdelivr.net/npm/sweetalert2@11" >
</script>
@endsection