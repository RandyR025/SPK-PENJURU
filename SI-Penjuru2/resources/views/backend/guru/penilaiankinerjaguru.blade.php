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

<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-5 g-4">
@foreach ($penilaian as $item)
    <div class="col">
        <div class="card h-100">
            <img src="{{asset('backend/img/background/sekolah2.jpeg')}}" class="card-img-top sh-25" alt="card image">
            <div class="card-body">
                <h5 class="heading mb-2">
                    <a href="Quiz.Detail.html" class="body-link">
                        <span class="clamp-line sh-6 lh-1-5" data-line="2">{{$item->nama_penilaian}}</span>
                    </a>
                </h5>
                <div class="mb-3 text-muted sh-8 clamp-line" data-line="3">
                    Pie fruitcake jelly beans. Candy tootsie chocolate croissant jujubes icing chocolate croissant jujubes icing macaroon croissant.
                </div>
                <div class="row g-0 align-items-center mb-1">
                    <div class="col ">
                        <div class="row g-0">
                            <div class="col">
                                <div class="text-alternate sh-4 d-flex align-items-center lh-1-25">Jumlah</div>
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
                                <div class="sh-4 d-flex align-items-center text-alternate">5m</div>
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
                <?php
                
                if (cekPenilaian($item->id_penilaian, Auth::user()->id)) {
                    ?>
                <div class="d-flex flex-row justify-content-between w-100 w-sm-50 w-xl-100">
                    <a href="{{ route('detailkinerjaguru', $item->id_penilaian) }}" class="btn btn-outline-primary w-100 me-1 btn-sm">Sudah Di Isi</a>
                </div>
                    <?php
                    
                }else {
                    ?>
                    <div class="d-flex flex-row justify-content-between w-100 w-sm-50 w-xl-100">
                        <a href="{{ route('detailkinerjaguru', $item->id_penilaian) }}" class="btn btn-outline-primary w-100 me-1 btn-sm">Start</a>
                    </div>
                    <?php
                }
                
                ?>
            </div>
        </div>
    </div>
@endforeach
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
<script src="{{asset('js/Guru.js')}}">
<script src = "//cdn.jsdelivr.net/npm/sweetalert2@11" >
</script>
@endsection