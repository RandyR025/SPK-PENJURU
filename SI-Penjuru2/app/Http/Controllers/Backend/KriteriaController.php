<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KriteriaController extends Controller
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
        $kriteria = Kriteria::all();
        $no = 1;
        return view('backend/admin.data_kriteria', compact('admin','guru', 'wali','kriteria','no'));
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
            'kode_kriteria' => 'required|max:10|unique:kriteria',
            'nama_kriteria' => 'required|max:30',
            
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $kriteria = new Kriteria;
            $kriteria->kode_kriteria = $request->input('kode_kriteria');
            $kriteria->nama_kriteria = $request->input('nama_kriteria');
            $kriteria->save();

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kriteria = DB::table('kriteria')->where('kode_kriteria',$id)->get();
        if ($kriteria) {
            return response()->json([
                'status' => 200,
                'kriteria' => $kriteria,
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
            'kode_kriteria' => 'required',
            'nama_kriteria' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $kriteria = DB::table('kriteria')->where('kode_kriteria',$id);
            if ($kriteria) {
                $kriteria->update([
                    'kode_kriteria' => $request->kode_kriteria,
                    'nama_kriteria' => $request->nama_kriteria,
                
                
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'kriteria' => $kriteria
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
        DB::table('kriteria')->where('kode_kriteria',$id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }


    // public function fetchkriteria()
    // {
    //     $kriteria = Kriteria::all();
    //     return response()->json([
    //         'kriteria' => $kriteria,
    //     ]);
    // }
}
