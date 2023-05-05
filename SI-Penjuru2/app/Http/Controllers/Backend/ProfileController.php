<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DetailKelas;
use App\Models\Guru;
use App\Models\User;
use App\Models\Wali;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
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
        $kelas = DB::table('detail_kelas')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->where('detail_kelas.user_id','=',Auth::user()->id)->first();
        $datakelas = DB::table('kelas')->get();
        // dd($kelas);
        return view('backend/setting.profile', compact('admin', 'guru', 'wali', 'datakelas','kelas'));
    }
    public function index_ubahpassword()
    {
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        return view('backend/setting.ubah_password', compact('admin', 'guru', 'wali'));
    }
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $currentPassword = $request->input('password_lama');
        $newPassword = $request->input('password_baru');

        if (!Hash::check($currentPassword, $user->password)) {
            return redirect()->back()->with('loginError', 'Current password is incorrect');
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return redirect()->back()->with('success', 'Password has been changed');
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
        $user = $request->input('level');
        // dd($user);
        if ($user == "admin") {
            $adminn = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
            if (count($adminn) < 1) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:32',
                    'email' => ['required','email',Rule::unique('users')->ignore(User::find($id))],
                    'nik' => 'required|unique:guru|unique:admin|unique:wali|min:15',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_telp' => 'required',
                    'alamat' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages(),
                    ]);
                } else {
                    $admin = new Admin;
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move(public_path('images'), $filename);

                        $admin->user_id = $request->edit_id;
                        $admin->nik = $request->nik;
                        $admin->tempat_lahir = $request->tempat_lahir;
                        $admin->tanggal_lahir = $request->tanggal_lahir;
                        $admin->jenis_kelamin = $request->jenis_kelamin;
                        $admin->no_telp = $request->no_telp;
                        $admin->alamat = $request->alamat;
                        $admin->image = $filename;
                        $admin->save();
                    } else {
                        $admin->user_id = $request->edit_id;
                        $admin->nik = $request->nik;
                        $admin->tempat_lahir = $request->tempat_lahir;
                        $admin->tanggal_lahir = $request->tanggal_lahir;
                        $admin->jenis_kelamin = $request->jenis_kelamin;
                        $admin->no_telp = $request->no_telp;
                        $admin->alamat = $request->alamat;
                        $admin->save();
                    }
                    return response()->json([
                        'status' => 200,
                        'message' => "Data Berhasil Di Perbarui !!!",
                    ]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:32',
                    'email' => ['required','email',Rule::unique('users')->ignore(User::find($id))],
                    'nik' => 'required|min:15',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_telp' => 'required',
                    'alamat' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages(),
                    ]);
                } else {
                    $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->where('user_id', Auth::user()->id);
                    if ($admin) {
                        if ($request->hasFile('image')) {
                            $gambar = DB::table('admin')->where('user_id', Auth::user()->id)->first();
                            File::delete('images/' . $gambar->image);
                            $file = $request->file('image');
                            $extension = $file->getClientOriginalExtension();
                            $filename = time() . '.' . $extension;
                            $file->move(public_path('images'), $filename);
                            $admin->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                                'image' => $filename,

                            ]);
                        } else {
                            $admin->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => "Data Berhasil Di Perbarui !!!",
                    ]);
                }
            }
        } elseif ($user == "guru") {
            $guruu = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
            if (count($guruu) < 1) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:32',
                    'email' => ['required','email',Rule::unique('users')->ignore(User::find($id))],
                    'nik' => 'required|unique:guru|unique:admin|unique:wali',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_telp' => 'required',
                    'alamat' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages(),
                    ]);
                } else {
                    $guru = new Guru;
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move(public_path('images'), $filename);

                        $guru->user_id = $request->edit_id;
                        $guru->nik = $request->nik;
                        $guru->tempat_lahir = $request->tempat_lahir;
                        $guru->tanggal_lahir = $request->tanggal_lahir;
                        $guru->jenis_kelamin = $request->jenis_kelamin;
                        $guru->no_telp = $request->no_telp;
                        $guru->alamat = $request->alamat;
                        $guru->image = $filename;
                        $guru->save();
                    } else {
                        $guru->user_id = $request->edit_id;
                        $guru->nik = $request->nik;
                        $guru->tempat_lahir = $request->tempat_lahir;
                        $guru->tanggal_lahir = $request->tanggal_lahir;
                        $guru->jenis_kelamin = $request->jenis_kelamin;
                        $guru->no_telp = $request->no_telp;
                        $guru->alamat = $request->alamat;
                        $guru->save();
                    }
                    return response()->json([
                        'status' => 200,
                        'message' => "Data Berhasil Di Perbarui !!!",
                    ]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:32',
                    'email' => ['required','email',Rule::unique('users')->ignore(User::find($id))],
                    'nik' => 'required',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_telp' => 'required',
                    'alamat' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages(),
                    ]);
                } else {
                    $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->where('user_id', Auth::user()->id);
                    if ($guru) {
                        if ($request->hasFile('image')) {
                            $gambar = DB::table('guru')->where('user_id', Auth::user()->id)->first();
                            File::delete('images/' . $gambar->image);
                            $file = $request->file('image');
                            $extension = $file->getClientOriginalExtension();
                            $filename = time() . '.' . $extension;
                            $file->move(public_path('images'), $filename);
                            $guru->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                                'image' => $filename,

                            ]);
                        } else {
                            $guru->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => "Data Berhasil Di Perbarui !!!",
                    ]);
                }
            }
        } elseif ($user == "wali") {
            $walii = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
            $kelas = DB::table('detail_kelas')->join('users', 'detail_kelas.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
            if (count($walii) < 1 && count($kelas) < 1) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:32',
                    'email' => ['required','email',Rule::unique('users')->ignore(User::find($id))],
                    'nik' => 'required|unique:guru|unique:admin|unique:wali|min:15',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_telp' => 'required',
                    'alamat' => 'required',
                    'wali_murid' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages(),
                    ]);
                } else {
                    $wali = new Wali;
                    $detail_kelas = new DetailKelas;
                    $maxdetailkelas = DetailKelas::max('kode_detail_kelas');
                    $noUrut = (int) substr($maxdetailkelas, 1, 2);
                    $noUrut++;
                    $char = "D";
                    $newID = $char . sprintf("%02s", $noUrut);
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move(public_path('images'), $filename);

                        $wali->user_id = $request->edit_id;
                        $wali->nik = $request->nik;
                        $wali->tempat_lahir = $request->tempat_lahir;
                        $wali->tanggal_lahir = $request->tanggal_lahir;
                        $wali->jenis_kelamin = $request->jenis_kelamin;
                        $wali->no_telp = $request->no_telp;
                        $wali->alamat = $request->alamat;
                        $wali->image = $filename;
                        $wali->save();
                        $detail_kelas->kode_detail_kelas = $newID;
                        $detail_kelas->kode_kelas = $request->wali_murid;
                        $detail_kelas->user_id = $request->edit_id;
                        $detail_kelas->save();
                    } else {
                        $wali->user_id = $request->edit_id;
                        $wali->nik = $request->nik;
                        $wali->tempat_lahir = $request->tempat_lahir;
                        $wali->tanggal_lahir = $request->tanggal_lahir;
                        $wali->jenis_kelamin = $request->jenis_kelamin;
                        $wali->no_telp = $request->no_telp;
                        $wali->alamat = $request->alamat;
                        $wali->save();
                        $detail_kelas->kode_detail_kelas = $newID;
                        $detail_kelas->kode_kelas = $request->wali_murid;
                        $detail_kelas->user_id = $request->edit_id;
                        $detail_kelas->save();
                    }
                    return response()->json([
                        'status' => 200,
                        'message' => "Data Berhasil Di Perbarui !!!",
                    ]);
                }
            }elseif(count($kelas) < 1) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:32',
                    'email' => ['required','email',Rule::unique('users')->ignore(User::find($id))],
                    'nik' => 'required|min:15',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_telp' => 'required',
                    'alamat' => 'required',
                    'wali_murid' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages(),
                    ]);
                } else {
                    $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id);
                    $detail_kelas = new DetailKelas;
                    $maxdetailkelas = DetailKelas::max('kode_detail_kelas');
                    $noUrut = (int) substr($maxdetailkelas, 1, 2);
                    $noUrut++;
                    $char = "D";
                    $newID = $char . sprintf("%02s", $noUrut);
                    if ($wali) {
                        if ($request->hasFile('image')) {
                            $gambar = DB::table('wali')->where('user_id', Auth::user()->id)->first();
                            File::delete('images/' . $gambar->image);
                            $file = $request->file('image');
                            $extension = $file->getClientOriginalExtension();
                            $filename = time() . '.' . $extension;
                            $file->move(public_path('images'), $filename);
                            $wali->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                                'image' => $filename,

                            ]);
                        $detail_kelas->kode_detail_kelas = $newID;
                        $detail_kelas->kode_kelas = $request->wali_murid;
                        $detail_kelas->user_id = $request->edit_id;
                        $detail_kelas->save();
                        } else {
                            $wali->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                            ]);
                        $detail_kelas->kode_detail_kelas = $newID;
                        $detail_kelas->kode_kelas = $request->wali_murid;
                        $detail_kelas->user_id = $request->edit_id;
                        $detail_kelas->save();
                        }
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => "Data Berhasil Di Perbarui !!!",
                    ]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:32',
                    'email' => ['required','email',Rule::unique('users')->ignore(User::find($id))],
                    'nik' => 'required|min:15',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'jenis_kelamin' => 'required',
                    'no_telp' => 'required',
                    'alamat' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages(),
                    ]);
                } else {
                    $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id);
                    $detail_kelas = DB::table('detail_kelas')->join('users', 'detail_kelas.user_id', '=', 'users.id')->where('user_id', Auth::user()->id);
                    if ($wali) {
                        if ($request->hasFile('image')) {
                            $gambar = DB::table('wali')->where('user_id', Auth::user()->id)->first();
                            File::delete('images/' . $gambar->image);
                            $file = $request->file('image');
                            $extension = $file->getClientOriginalExtension();
                            $filename = time() . '.' . $extension;
                            $file->move(public_path('images'), $filename);
                            $wali->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                                'image' => $filename,

                            ]);
                            $detail_kelas->update([
                                'kode_detail_kelas' => $request->edit_kelas,
                                'user_id' => Auth::user()->id,
                                'kode_kelas' => $request->wali_murid,
                            ]);
                        } else {
                            $wali->update([
                                'name' => $request->name,
                                'nik' => $request->nik,
                                'tanggal_lahir' => $request->tanggal_lahir,
                                'tempat_lahir' => $request->tempat_lahir,
                                'jenis_kelamin' => $request->jenis_kelamin,
                                'alamat' => $request->alamat,
                                'no_telp' => $request->no_telp,
                            ]);
                            $detail_kelas->update([
                                'kode_detail_kelas' => $request->edit_kelas,
                                'user_id' => Auth::user()->id,
                                'kode_kelas' => $request->wali_murid,
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => "Data Berhasil Di Perbarui !!!",
                    ]);
                }
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
        //
    }
}
