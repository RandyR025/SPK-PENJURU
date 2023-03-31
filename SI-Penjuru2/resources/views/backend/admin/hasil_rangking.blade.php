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

@if(isset($cek))
<a href="{{route('hasilpenilaianrangkingwalicetakpdf',$penilaian[0]->id_penilaian)}}"class="btn btn-outline-primary w-100 me-1 btn-sm mb-4">PDF</a>
<a href="{{route('hasilpenilaianrangkingwalicetakexcel',$penilaian[0]->id_penilaian)}}"class="btn btn-outline-primary w-100 me-1 btn-sm mb-4">Excel</a>
@else
<a href="{{route('hasilpenilaianrangkingcetakpdf',$penilaian[0]->id_penilaian)}}"class="btn btn-outline-primary w-100 me-1 btn-sm mb-4">PDF</a>
<a href="{{route('hasilpenilaianrangkingcetakexcel',$penilaian[0]->id_penilaian)}}"class="btn btn-outline-primary w-100 me-1 btn-sm mb-4">Excel</a>
@endif
<div class="col-xl-6 mb-5 h-100-card">
    <section class="scroll-section" id="additionalInfo">
        <div class="d-flex justify-content-between">
            <h2 class="small-title">Hasil Rangking</h2>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="additionalInfoWeek">
                            @foreach ($hasil as $data)
                          <div class="card mb-2">
                            <a href="#" class="row g-0 sh-10">
                              <div class="col-auto h-100">
                              @if (isset($data->image))
                                <img src="{{asset('images/'.$data->image)}}" alt="user" class="card-img card-img-horizontal sw-11" />
                                @else
                                <img src="{{asset('backend/img/profile/profile-11.jpg')}}" alt="user" class="card-img card-img-horizontal sw-11" />
                              @endif
                              </div>
                              <div class="col">
                                <div class="card-body d-flex flex-row pt-0 pb-0 h-100 align-items-center justify-content-between">
                                  <div class="d-flex flex-column justify-content-center">
                                    <div class="">{{$data->name}}</div>
                                  </div>
                                  <div class="d-flex flex-row ms-3">
                                    <div class="d-flex flex-column align-items-center">
                                      <div class="">Total Nilai</div>
                                      <div class="text-alternate">{{$data->totals}}</div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center ms-3">
                                      <div class="">Rangking</div>
                                      <div class="text-alternate">{{$no++}}</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                          @endforeach
                        </div>
                      </div>
                    </section>
                  </div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
<script src="{{asset('js/Guru.js')}}">
// <script src = "//cdn.jsdelivr.net/npm/sweetalert2@11" >
</script>
@endsection