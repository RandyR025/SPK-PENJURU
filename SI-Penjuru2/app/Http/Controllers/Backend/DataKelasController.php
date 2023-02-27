<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DetailKelas;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $kelas = DB::table('kelas')->get();
        $maxkelas =Kelas::max('kode_kelas');
        $no = 1;
        return view('backend/admin.data_kelas', compact('admin', 'guru', 'wali','kelas','no','maxkelas'));
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
        $validator = Validator::make($request->all(), [
            'kode_kelas' => 'required|max:10|unique:kelas',
            'nama_kelas' => 'required|max:30',
            
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $kelas = new Kelas;
            $kelas->kode_kelas = $request->input('kode_kelas');
            $kelas->nama_kelas = $request->input('nama_kelas');
            $kelas->save();

            return response()->json([
                'status' => 200,
                'message' => "Data Berhasil Di Tambahkan !!!",
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detailkelas = DB::table('detail_kelas')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->where('kelas.kode_kelas',$id)->join('users', 'detail_kelas.user_id', '=', 'users.id')->join('guru', 'users.id', '=', 'guru.user_id')->get();
        $kelas = DB::table('kelas')->where('kode_kelas', $id)->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $no = 1;
        $maxdetailkelas = DetailKelas::max('kode_detail_kelas');
        $dataguru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->get();
        // dd($pengisian);
        return view('backend/admin.data_detailkelas', compact('admin','guru', 'wali','detailkelas','kelas','maxdetailkelas','dataguru','no'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = DB::table('kelas')->where('kode_kelas',$id)->get();
        if ($kelas) {
            return response()->json([
                'status' => 200,
                'kelas' => $kelas,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User Not Found',
            ]);
        }
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
        $validator = Validator::make($request->all(), [
            'kode_kelas' => 'required',
            'nama_kelas' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $kelas = DB::table('kelas')->where('kode_kelas',$id);
            if ($kelas) {
                    $kelas->update([
                        'kode_kelas' => $request->kode_kelas,
                        'nama_kelas' => $request->nama_kelas,
                    ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'kelas' => $kelas
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'User Not Found',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('kelas')->where('kode_kelas',$id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }
}
