<?php

namespace App\Http\Controllers\Siswa;

use App\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Detail_pembayaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::all();

        dd($siswa);
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
        if(\Gate::denies('isProfileUser', $id)){
            return abort(404);
        }

        $user = User::find($id);
        // dd($user->siswa->id);
        $data = Siswa::with('kelas', 'tagihan')->findOrFail($user->siswa->id);
        
        $this->siswaId = $user->siswa->id;
        $tahun_ajaran = Tahunajaran::all();
        
        $pembayaran = Detail_pembayaran::with('transaksi_pembayaran')->whereHas('transaksi_pembayaran', function ($query) {
            $query->where('siswa_id', $this->siswaId)->where('status', '<>', 'Draft');
        })->latest()->get();

        // dd($pembayaran);
        
        return view('user.siswa.profile', compact('data', 'tahun_ajaran', 'pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        // dd($siswa);
        $kelas = Kelas::all();
        return view('user.siswa.edit', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        
        $data = $request->only([
            'nis',
            'nama_lengkap',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'no_telp',
            'alamat',
            'nama_ibu_kandung',
            'nama_ayah_kandung',
            'no_telp_orangtua',
            'kelas_id',
        ]);

        if($request->hasFile('foto_siswa')){

            if($siswa->foto !== "siswa_default.png"){
                File::delete('img/siswa/'.$siswa->foto);
            }

            $gambar = $this->uploadGambar($request);
            $data['foto'] = $gambar;
        }


        $siswa->update($data);

        session()->flash('success', "Data Berhasil Diupdate");

        //redirect user
        return redirect()->back();
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

    /**
     * Upload gambar.
     *
     * @param  mixed  $request
     * @return string $nama file
     */
    public function uploadGambar($request)
    {
        $namafile = Str::slug($request->nama_lengkap);
        $ext = explode('/', $request->foto_siswa->getClientMimeType())[1];
        $gambar = "$namafile-$request->nis.$ext";
        $request->foto_siswa->move(public_path('img/siswa'), $gambar);

        return $gambar;
    }


    public function gantiPassword()
    {
        $user =  Auth::user();
        // dd($user);
        $foto = Siswa::where('nis', $user->username)->get()->first()->foto;
        
        return view('user.siswa.ganti_password', compact('user', 'foto'));
    }

    public function passUpdated(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'sometimes|nullable|confirmed|min:6',
        ]);
        $user = User::findOrFail($id);
        $foto = Siswa::where('nis', $user->username)->get()->first()->foto;
        // $password = !empty($request->password) ? bcrypt($request->password) : $user->password;
        $user->update([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);  
        session()->flash('success', "Data Berhasil Diupdate");
        return view('user.siswa.ganti_password', compact('user', 'foto'));
    }
}
