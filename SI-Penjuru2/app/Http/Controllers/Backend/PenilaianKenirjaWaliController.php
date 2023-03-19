<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\HasilPilihanWali;
use App\Models\HasilWali;
use App\Models\JumlahTotal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Penilaian;
use App\Models\Pengisian;
use App\Models\Pilihan;

class PenilaianKenirjaWaliController extends Controller
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
        $walii = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
        $kelas = DB::table('detail_kelas')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->where('detail_kelas.user_id','=',Auth::user()->id)->get();
        if (isset($wali->kode_kelas)) {
            $dataguru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->where('detail_kelas.kode_kelas', $wali->kode_kelas)->get();
            return view('backend/wali.penilaiankinerjawali', compact('admin','guru', 'wali', 'penilaian','dt','future','walii','dataguru','kelas'));
            
        }
        /* dd($future); */
        return view('backend/wali.penilaiankinerjawali', compact('admin','guru', 'wali', 'penilaian','dt','future','walii','kelas'));
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
        $kriteria = DB::table('kriteria')->join('subkriteria','kriteria.kode_kriteria','=','subkriteria.kode_kriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->join('penilaian','pengisian.id_penilaian','=','penilaian.id_penilaian')->groupBy('kriteria.kode_kriteria')->where('penilaian.id_penilaian','=',$id)->where('pengisian.level','=','wali')->paginate(1);
        // dd($kriteria);
        // $jumlah = DB::table('kriteria')->get()->count();
        $jumlah = DB::table('kriteria')->join('subkriteria','kriteria.kode_kriteria','=','subkriteria.kode_kriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->join('penilaian','pengisian.id_penilaian','=','penilaian.id_penilaian')->groupBy('kriteria.kode_kriteria')->where('penilaian.id_penilaian','=',$id)->where('pengisian.level','=','wali')->get()->count();
        $penilaian = Penilaian::where('id_penilaian','=',$id)->first();
        $tanggal = DB::table('tanggal')->where('id','=',$tgl)->first();
        $coba = [];
        foreach ($kriteria as $keykriteria => $data) {
            $coba1[$keykriteria] = Pengisian::with('penilaian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where([['id_penilaian','=',$id], ['kode_kriteria','=',$data->kode_kriteria],['level','=','wali']])->get();
            // dd($coba1);
            foreach ($coba1[$keykriteria] as $key => $value) {
                $cek = Pilihan::with('pengisian')->where('kode_pengisian','=',$value->kode_pengisian)->get();
                if (isset($cek)) {
                    
                    $coba[$key] = Pilihan::with('pengisian')->where('kode_pengisian','=',$value->kode_pengisian)->get();
                }
            }
        }
        // dd($coba);
        $user = DB::table('users')->where('id','=',$user_id)->get();
        $hasilpilihan = DB::table('hasilpilihan')->where('user_id','=',Auth::user()->id)->get();
        // dd($hasilpilihan);
        return view('backend/wali.detailpenilaiankinerjawali', compact('admin','guru', 'wali','coba','coba1','hasilpilihan','jumlah','kriteria','penilaian','user','tanggal'));
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

    public function cari(Request $request){
        $user_id = $request->get('user_id');
        if (isset($user_id)) {
            $user = DB::table('users')->where('id','=',$user_id)->get();
            $penilaian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->join('tanggal', 'penilaian.id_penilaian', '=', 'tanggal.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','tanggal.deadline','penilaian.image','tanggal.id')->where('pengisian.level','=','wali')->groupBy('tanggal.id')->get();
            $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
            $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->find(Auth::user()->id);
            $no = 1; 
            $tanggal = Carbon::now('Asia/Jakarta');
            $dt = $tanggal->toDateString();
            $future = $tanggal->addWeek();
            $walii = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
            $dataguru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->where('detail_kelas.kode_kelas', $wali->kode_kelas)->get();
            /* dd($future); */
            return view('backend/wali.cekpenilaiankinerjawali', compact('admin','guru', 'wali', 'penilaian','dt','future','walii','dataguru','user'));
        }else {
            return redirect()->route('penilaiankinerjawali');
        }
    }

    public function hasilpilihanwali(Request $request){
        $query = HasilPilihanWali::where([
            ['user_id_wali','=',Auth::user()->id],
            ['kode_pengisian','=',$request->pengisian_id],
            ['user_id_guru','=',$request->user_id],
            ['tanggal_id','=',$request->tanggal_id],
        ])->count();

        if ($query == 0) {
            $hasilpilihan = new HasilPilihanWali;
            // return $request;
            // $pilihan = "answer".$request->input('question');
            $hasilpilihan->kode_pilihan = $request->option_id;
            $hasilpilihan->kode_pengisian = $request->pengisian_id;
            $hasilpilihan->user_id_wali = Auth::user()->id;
            $hasilpilihan->user_id_guru = $request->user_id;
            $hasilpilihan->tanggal_id = $request->tanggal_id;
            $hasilpilihan->save();   
        }else {
            HasilPilihanWali::where([
            ['user_id_wali','=',Auth::user()->id],
            ['kode_pengisian','=',$request->pengisian_id],
            ['user_id_guru','=',$request->user_id],
            ['tanggal_id','=',$request->tanggal_id],
        ])->update(['kode_pilihan'=> $request->option_id]);
        }
    }

    public function totalnilaiwali($id,$user_id,$tgl){
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

            $coba = DB::table('pengisian')->where('id_penilaian','=',$id)->where('pengisian.level','=','wali')->get();
            $nilai = 0;
            foreach ($coba as $key => $value) {
                $coba1[$key] = DB::table('hasilpilihanwali')
                ->where('hasilpilihanwali.kode_pengisian','=',$value->kode_pengisian)
                ->where('user_id_wali','=',Auth::user()->id)
                ->where('user_id_guru','=',$user_id)
                ->where('tanggal_id','=',$tgl)
                ->join('pilihan','hasilpilihanwali.kode_pilihan','=','pilihan.kode_pilihan')
                ->join('pengisian','hasilpilihanwali.kode_pengisian','=','pengisian.kode_pengisian')
                ->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')
                ->join('kriteria','subkriteria.kode_kriteria','=','kriteria.kode_kriteria')
                ->join('pv_subkriteria','subkriteria.kode_subkriteria','=','pv_subkriteria.id_subkriteria')
                ->join('pv_kriteria','kriteria.kode_kriteria','=','pv_kriteria.id_kriteria')->first();
                if ($coba1[$key] ==  null) {
                    return back()->with('status','Silahkan Jawab Semua Pertanyaan');
                }else {
                    $nilai = $nilai + $coba1[$key]->points * $coba1[$key]->nilai_kriteria * $coba1[$key]->nilai_subkriteria ;   
                }
            }
            

            $query = HasilWali::where([
                ['user_id_wali','=',Auth::user()->id],
                ['user_id_guru','=',$user_id],
                ['id_penilaian','=',$id],
                ['tanggal_id','=',$tgl],
            ])->count();
            if ($query == 0) {     
                $total = new HasilWali;
                $total->totals = round($nilai,5);
                $total->user_id_wali = Auth::user()->id;
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
                    $total->totals = round($nilai,5);
                    $total->user_id_guru = $user_id;
                    $total->id_penilaian = $id;
                    $total->save();
                }else {
                    JumlahTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->update(['totals'=> round(($nilai + $data[0]->totals),5)]);
                }
            }else {
                HasilWali::where([
                    ['user_id_wali','=',Auth::user()->id],
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round($nilai,5)]);
            }
            
            // dd($coba1);
            return redirect()->route('penilaiankinerjawali');
    }
}
