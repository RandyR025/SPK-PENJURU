<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Hasilpilihan;
use App\Models\HasilPilihanKepsek;
use App\Models\HasilPilihanWali;
use App\Models\HasilKepsek;
use App\Models\Pengisian;
use App\Models\Penilaian;
use App\Models\Pilihan;
use App\Models\JumlahTotal;
use App\Models\JumlahWaliTotal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PenilaianKinerjaKepalaSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penilaian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->join('tanggal', 'penilaian.id_penilaian', '=', 'tanggal.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','tanggal.deadline','penilaian.image','tanggal.id')->where('pengisian.level','=','wali')->groupBy('tanggal.id')->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->find(Auth::user()->id);
        $no = 1; 
        $tanggal = Carbon::now('Asia/Jakarta');
        $dt = $tanggal->toDateString();
        $future = $tanggal->addWeek();
        // $walii = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
        // $kelas = DB::table('detail_kelas')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->where('detail_kelas.user_id','=',Auth::user()->id)->get();
        // if (isset($wali->kode_kelas)) {
        //     $dataguru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->where('detail_kelas.kode_kelas', $wali->kode_kelas)->get();
            
        // }
        $dataguru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->get();
        /* dd($future); */
        return view('backend/perhitungan.penilaiankinerjakepalasekolah', compact('admin','guru', 'wali', 'penilaian','dt','future','dataguru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$user_id,$tgl)
    {
        // $pengisian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->get();
        // foreach ($pengisian as $key => $value) {
        //     $pilihan[$key] = DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->groupByRaw('pilihan.kode_pengisian')->having('pilihan.kode_pengisian','=',$value->kode_pengisian)->get();
        // }
        // $pilihan = DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->having('pilihan.kode_pengisian','=','C1')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);

        // $pengisian = collect(DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->join('subkriteria', 'pengisian.kode_subkriteria', '=', 'subkriteria.kode_subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->get()->groupBy('kode_pengisian'));
        // $jumlah = Pengisian::with('penilaian')->where('id_penilaian','=',$id)->get()->count();
        $kriteria = DB::table('kriteria')->join('subkriteria','kriteria.kode_kriteria','=','subkriteria.kode_kriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->join('penilaian','pengisian.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$id)->get()->groupBy('kode_kriteria');
        // $collection = collect($kriteria);
        // $grouped = $kriteria->groupBy('kode_kriteria');
        // $kriteria->each(function ($item, $key) {
        //     echo $key . ':<br>';
        //     $item->each(function ($sub_item) {
        //         echo $sub_item->level;
        //     });
        //     echo '<br>';
        // });
        // dd($kriteria);
        $kriteriatelahdifilter = [];
        foreach ($kriteria as $key => $data) {
            foreach ($data as $key => $value) {
                $tes = json_decode($value->level);
                if (property_exists( $tes, 'kepalasekolah') ) {
                    array_push($kriteriatelahdifilter, $value);
                }
            }
        }
        $oke = collect($kriteriatelahdifilter)->groupBy('kode_kriteria');
        // dd($oke);
        $data_with_paginate = $this->paginate($oke);
        //set path of pagination
        $data_with_paginate->withPath($tgl);
        // $jumlah = DB::table('kriteria')->get()->count();
        $jumlah = count($oke);
        // $jumlah = count($kriteriatelahdifilter);
        // dd($jumlah);
        $penilaian = Penilaian::where('id_penilaian','=',$id)->first();
        $tanggal = DB::table('tanggal')->where('id','=',$tgl)->first();
        $coba = [];
        foreach ($data_with_paginate as $keykriteria => $data) {
            foreach ($data as $key => $value) {
                // $coba1[$keykriteria] = Pengisian::with('penilaian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where([['id_penilaian','=',$id], ['kode_kriteria','=',$value->kode_kriteria]])->get();
                // dd($coba1);
                    $cek = Pilihan::with('pengisian')->where('kode_pengisian','=',$value->kode_pengisian)->get();
                    if (isset($cek)) {
                        
                        $coba[$key] = Pilihan::with('pengisian')->where('kode_pengisian','=',$value->kode_pengisian)->get();
                    }
            }
        }
        // dd($data);
        $user = DB::table('users')->where('id','=',$user_id)->get();
        $hasilpilihan = DB::table('hasilpilihan')->where('user_id','=',Auth::user()->id)->get();
        // dd($hasilpilihan);
        return view('backend/perhitungan.detailpenilaiankinerjakepalasekolah', compact('admin','guru', 'wali','coba','hasilpilihan','jumlah','kriteria','penilaian','user','tanggal','data_with_paginate','oke'));
    }
    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function cari(Request $request){
        $user_id = $request->get('user_id');
        if (isset($user_id)) {
            $user = DB::table('users')->where('id','=',$user_id)->get();
            $penilaian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->join('tanggal', 'penilaian.id_penilaian', '=', 'tanggal.id_penilaian')->get();
            // dd($penilaian);
            $penilaianfilter = [];
            foreach ($penilaian as $key => $data) {
                    $tes = json_decode($data->level);
                    if (property_exists( $tes, 'kepalasekolah') ) {
                        array_push($penilaianfilter, $data);
                    }
                }
            $oke = collect($penilaianfilter)->groupBy('id');
            
            
            // dd($oke);
            
            
            
            $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
            $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->find(Auth::user()->id);
            $no = 1; 
            $tanggal = Carbon::now('Asia/Jakarta');
            $dt = $tanggal->toDateString();
            $future = $tanggal->addWeek();
            $walii = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
            $dataguru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->get();
            /* dd($future); */
            return view('backend/perhitungan.cekpenilaiankinerjakepalasekolah', compact('admin','guru', 'wali', 'penilaian','dt','future','walii','dataguru','user','oke'));
        }else {
            return redirect()->route('penilaiankinerjakepalasekolah');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function hasilpilihankepalasekolah(Request $request){
        $query = HasilPilihanKepsek::where([
            ['user_id_kepsek','=',Auth::user()->id],
            ['kode_pengisian','=',$request->pengisian_id],
            ['user_id_guru','=',$request->user_id],
            ['tanggal_id','=',$request->tanggal_id],
        ])->count();

        if ($query == 0) {
            $hasilpilihan = new HasilPilihanKepsek;
            // return $request;
            // $pilihan = "answer".$request->input('question');
            $hasilpilihan->kode_pilihan = $request->option_id;
            $hasilpilihan->kode_pengisian = $request->pengisian_id;
            $hasilpilihan->user_id_kepsek = Auth::user()->id;
            $hasilpilihan->user_id_guru = $request->user_id;
            $hasilpilihan->tanggal_id = $request->tanggal_id;
            $hasilpilihan->save();   
        }else {
            HasilPilihanKepsek::where([
            ['user_id_kepsek','=',Auth::user()->id],
            ['kode_pengisian','=',$request->pengisian_id],
            ['user_id_guru','=',$request->user_id],
            ['tanggal_id','=',$request->tanggal_id],
        ])->update(['kode_pilihan'=> $request->option_id]);
        }
    }

    public function totalnilaikepalasekolah($id,$user_id,$tgl){
        // $nilaikriteria = DB::table('kriteria')->join('pv_kriteria', 'kriteria.kode_kriteria','=','pv_kriteria.id_kriteria')->get();
        // foreach ($nilaikriteria as $keykriteria => $valuekriteria) {
        //     $nilaisubkriteria[$keykriteria] = DB::table('subkriteria')->join('pv_subkriteria','subkriteria.kode_subkriteria','=','pv_subkriteria.id_subkriteria')->where('subkriteria.kode_kriteria','=',$valuekriteria->kode_kriteria)->get();
        //     foreach ($nilaisubkriteria as $keysubkriteria => $valuesubkriteria) {
        //         foreach ($valuesubkriteria as $keynilaisub => $valuenilaisub) {
        //             $nilaipengisian[$keynilaisub] = DB::table('pilihan')->join('hasilpilihan','pilihan.kode_pilihan','=','hasilpilihan.kode_pilihan')->where('hasilpilihan.user_id','=',Auth::user()->id)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->where('pengisian.kode_subkriteria',$valuenilaisub->kode_subkriteria)->get();
        //         }
        //     }
        //     dd($nilaipengisian);
        // }

            $coba = DB::table('pengisian')->get();
            $nilai = 0;
            $cobatelahdifilter = [];
            foreach ($coba as $key => $value) {
                $tes = json_decode($value->level);
                if (property_exists( $tes, 'kepalasekolah') && $value->id_penilaian == $id ) {
                    array_push($cobatelahdifilter, $value);
                }
            }
            foreach ($cobatelahdifilter as $key => $value) {
                $coba1[$key] = DB::table('hasilpilihankepsek')
                ->where('hasilpilihankepsek.kode_pengisian','=',$value->kode_pengisian)
                ->where('user_id_kepsek','=',Auth::user()->id)
                ->where('user_id_guru','=',$user_id)
                ->where('tanggal_id','=',$tgl)
                ->join('pilihan','hasilpilihankepsek.kode_pilihan','=','pilihan.kode_pilihan')
                ->join('pengisian','hasilpilihankepsek.kode_pengisian','=','pengisian.kode_pengisian')
                ->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')
                ->join('kriteria','subkriteria.kode_kriteria','=','kriteria.kode_kriteria')
                ->join('pv_subkriteria','subkriteria.kode_subkriteria','=','pv_subkriteria.id_subkriteria')
                ->join('pv_kriteria','kriteria.kode_kriteria','=','pv_kriteria.id_kriteria')->first();
                if ($coba1[$key] ==  null) {
                    return back()->with('loginError','Silahkan Jawab Semua Pertanyaan');
                }else {
                    $nilai = $nilai + $coba1[$key]->points * $coba1[$key]->nilai_kriteria * $coba1[$key]->nilai_subkriteria ;   
                }
            }
            $bobot = 0.6;
            $bobott = 0.5;
            $query = HasilKepsek::where([
                ['user_id_kepsek','=',Auth::user()->id],
                ['user_id_guru','=',$user_id],
                ['id_penilaian','=',$id],
                ['tanggal_id','=',$tgl],
            ])->count();
            if ($query == 0) {     
                $total = new HasilKepsek;
                $total->totals = round($nilai,5);
                $total->user_id_kepsek = Auth::user()->id;
                $total->user_id_guru = $user_id;
                $total->tanggal_id = $tgl;
                $total->id_penilaian = $id;
                $total->save();

                $queryt = JumlahTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->count();
                $data = JumlahTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                if ($queryt == 0) {     
                    $total = new JumlahTotal;
                    $total->totals = round(($nilai*$bobot),5);
                    $total->user_id_guru = $user_id;
                    $total->id_penilaian = $id;
                    $total->tanggal_id = $tgl;
                    $total->save();
                }else {
                    JumlahTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->update(['totals'=> round((($nilai*$bobot) + $data[0]->totals),5)]);
                }
                $guru = DB::table('guru')->join('users','guru.user_id','=','users.id')->join('detail_kelas','users.id','=','detail_kelas.user_id')->where('guru.user_id','=',$user_id)->get();
                if (count($guru) > 0) {
                    $queryt = JumlahWaliTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->count();
                    $data = JumlahWaliTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->get();
                    if ($queryt == 0) {     
                        $total = new JumlahWaliTotal;
                        $total->totals = round(($nilai*$bobott),5);
                        $total->user_id_guru = $user_id;
                        $total->id_penilaian = $id;
                        $total->tanggal_id = $tgl;
                        $total->save();
                    }else {
                        JumlahWaliTotal::where([
                            ['user_id_guru','=',$user_id],
                            ['id_penilaian','=',$id],
                            ['tanggal_id','=',$tgl],
                        ])->update(['totals'=> round((($nilai*$bobott) + $data[0]->totals),5)]);
                    }
                }
            }else {
                $data = JumlahTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                $dataaa = JumlahWaliTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                $dataa = HasilKepsek::where([
                    ['user_id_kepsek','=',Auth::user()->id],
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                
                    JumlahTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->update(['totals'=> round((($nilai*$bobot) + ($data[0]->totals - ($dataa[0]->totals * $bobot))),5)]);
                $guru = DB::table('guru')->join('users','guru.user_id','=','users.id')->join('detail_kelas','users.id','=','detail_kelas.user_id')->where('guru.user_id','=',$user_id)->get();
                if (count($guru) > 0) {
                    JumlahWaliTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->update(['totals'=> round((($nilai*$bobott) + ($dataaa[0]->totals - ($dataa[0]->totals * $bobott))),5)]);
                }
                HasilKepsek::where([
                    ['user_id_kepsek','=',Auth::user()->id],
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round($nilai,5)]);
            }
            
            // dd($coba1);
            return redirect()->route('penilaiankinerjakepalasekolah');
    }
}
