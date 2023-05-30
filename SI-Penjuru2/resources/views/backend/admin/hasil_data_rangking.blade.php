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

<form action="{{route('daftarpenilaianrangking')}}" method="get" class="mb-6" class="form-group">

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



    <button type="submit" class="btn btn-outline-primary w-100 me-1 btn-sm">Filter</button>
</form>

<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-5 g-4">
@foreach ($penilaian as $item)
@if(isset($item->id_penilaian))
    <div class="col penilaian">
        <div class="card h-100">
            @if($item->image == null)
            <img src="{{asset('backend/img/background/sekolah2.jpeg')}}" class="card-img-top sh-25" alt="card image">
            @else
            <img src="images/{{$item->image}}" class="card-img-top sh-25" alt="card image">
            @endif
            <div class="card-body">
                <h5 class="heading mb-2">
                    <a href="Quiz.Detail.html" class="body-link">
                        <span class="clamp-line sh-6 lh-1-5" data-line="2">{{$item->nama_penilaian}}</span>
                    </a>
                </h5>
                <!-- <div class="mb-3 text-muted sh-8 clamp-line" data-line="3">
                    Pie fruitcake jelly beans. Candy tootsie chocolate croissant jujubes icing chocolate croissant jujubes icing macaroon croissant.
                </div> -->
                <div class="row g-0 align-items-center mb-1">
                    <div class="col ">
                        <div class="row g-0">
                            <div class="col">
                                <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Responden</div>
                            </div>
                            <div class="col-auto">
                                <div class="sh-4 d-flex align-items-center text-alternate">{{$item->jumlah}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-0 align-items-center mb-4">
                    <div class="col">
                        <div class="row g-0">
                            <div class="col">
                                <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Tanggal</div>
                            </div>
                            <div class="col-auto">
                                <div class="sh-4 d-flex align-items-center text-alternate">{{$item->tanggal}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row g-0 align-items-center mb-4">
                    <div class="col-auto">
                        <div class="sw-3 sh-4 d-flex justify-content-center align-items-center">
                            <i data-acorn-icon="graduation" class="text-primary"></i>
                        </div>
                    </div>
                    <div class="col ps-3">
                        <div class="row g-0">
                            <div class="col">
                                <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Level</div>
                            </div>
                            <div class="col-auto">
                                <div class="sh-4 d-flex align-items-center text-alternate">Beginner</div>
                            </div>
                        </div>
                    </div>
                </div> -->
 
                <div class="d-flex flex-row justify-content-between w-100 w-sm-50 w-xl-100 mb-3">
                        <a href="{{ route('hasilrangkingpenilaianwali',[$item->id_penilaian, $item->id]) }}" class="btn btn-outline-primary w-100 me-1 btn-sm">Rangking Wali</a> 
                </div>
                <div class="d-flex flex-row justify-content-between w-100 w-sm-50 w-xl-100">
                        <a href="{{ route('hasilrangkingpenilaian',[$item->id_penilaian, $item->id]) }}" class="btn btn-outline-primary w-100 me-1 btn-sm">Rangking Guru</a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
<script src="{{asset('js/Guru.js')}}">
// <script src = "//cdn.jsdelivr.net/npm/sweetalert2@11" >
</script>
@endsection