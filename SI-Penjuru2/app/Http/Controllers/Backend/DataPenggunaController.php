<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\User;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class DataPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $user = User::all();
        $no = 1;
        return view('backend/admin.data_pengguna', compact('admin','guru', 'wali','user','no'));
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
            'name' => 'required|max:32',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:8',
            'level' => 'required',
            'nik' => 'required|unique:guru',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->password);
            $user->level = $request->input('level');
            $user->save();

            if ($user->level == 'admin') {
                $admin = new Admin;
                $admin->user_id = $user->id;
                $admin->nik = $request->nik;
                $admin->tempat_lahir = $request->tempat_lahir;
                $admin->tanggal_lahir = $request->tanggal_lahir;
                $admin->jenis_kelamin = $request->jenis_kelamin;
                $admin->no_telp = $request->no_telp;
                $admin->alamat = $request->alamat;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('images',$filename);
                    $admin->image = $filename;
                }
                $admin->save();
            } elseif ($user->level == 'guru') {
                $guru = new Guru;
                $guru->user_id = $user->id;
                $guru->nik = $request->nik;
                $guru->tempat_lahir = $request->tempat_lahir;
                $guru->tanggal_lahir = $request->tanggal_lahir;
                $guru->jenis_kelamin = $request->jenis_kelamin;
                $guru->no_telp = $request->no_telp;
                $guru->alamat = $request->alamat;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('images',$filename);
                    $guru->image = $filename;
                }
                $guru->save();
            } else {
                $wali = new Wali;
                $wali->user_id = $user->id;
                $wali->nik = $request->nik;
                $wali->tempat_lahir = $request->tempat_lahir;
                $wali->tanggal_lahir = $request->tanggal_lahir;
                $wali->jenis_kelamin = $request->jenis_kelamin;
                $wali->no_telp = $request->no_telp;
                $wali->alamat = $request->alamat;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('images',$filename);
                    $wali->image = $filename;
                }
                $wali->save();
            }

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

        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
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
    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:32',
            'email' => 'required|email',
            'level' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = User::find($id);
            if ($user) {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->level = $request->input('level');
                if (isset($request->password)) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
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
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    // public function fetchuser()
    // {
    //     $user = User::all();
    //     return response()->json([
    //         'user' => $user,
    //     ]);
    // }
}
