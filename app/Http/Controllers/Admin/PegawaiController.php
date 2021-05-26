<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pegawai\StorePegawaiRequest;
use App\Http\Requests\Pegawai\UpdatePegawaiRequest;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pegawai = Pegawai::latest();

        if (!empty($request->keyword)) {
            $pegawai = $pegawai->where('nama_pegawai','like',"%".$request->keyword."%")
                            ->orWhere('nip', 'like', "%$request->keyword%");
        }
        
        return view('admin.pegawai.index')->with('pegawai', $pegawai->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePegawaiRequest $request)
    {
        $gambar = '';
        if($request->hasFile('foto_pegawai')){
            $gambar = $this->uploadGambar($request);
        }else{
            $gambar = "pegawai_default.png";
        }
        $tesid = uniqid();
        $user = User::create([
            'name' => $request->nama_pegawai,
            'username' => $request->nip,
            'email' => "email-$tesid@example.com",
            'password'  => bcrypt('123456'),
            'status'  => true,
        ]);

        $user->assignRole('pegawai');
        // $user->assignRole($request->role);
        Pegawai::create([
            'nip' => $request->nip,
            'nama_pegawai' => $request->nama_pegawai,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'user_id' => $user->id,
            'foto' => $gambar
        ]);

        session()->flash('success', 'Data pegawai Berhasil Ditambahkan');

        return redirect(route('pegawai.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        // dd($pegawai);
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai)
    {
        $data = $request->only([
            'nip', 
            'nama_pegawai',
            'no_telp',
            'alamat',
            // 'users_id',
        ]);

        $user = User::findOrFail($pegawai->user_id);
        $user->name = $request->nama_pegawai;
        $user->username = $request->nip;
        $user->update();
        
        if($request->hasFile('foto_pegawai')){
            
            if($pegawai->foto !== "pegawai_default.png"){
                File::delete('img/pegawai/'.$pegawai->foto);
            }
            
            $gambar = $this->uploadGambar($request);
            $data['foto'] = $gambar;
        }

        
        $pegawai->update($data);

        session()->flash('success', "Data Pegawai : $pegawai->nama_pegawai  Berhasil Di ubah");

        //redirect user
        return redirect(route('pegawai.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        
        if($pegawai->foto !== "pegawai_default.png"){
            File::delete('img/pegawai/'.$pegawai->foto);
        }
        
        $pegawai->user->delete();
        $pegawai->delete();

        session()->flash('success', "Data Pegawai : $pegawai->nama_pegawai Berhasil Dihapus");

        return redirect(route('pegawai.index'));
    }

    /**
     * Upload gambar produk.
     *
     * @param  mixed  $request
     * @return string $nama file
     */
    public function uploadGambar($request)
    {
        $namafile = Str::slug($request->nama_pegawai);
        $ext = explode('/', $request->foto_pegawai->getClientMimeType())[1];
        $gambar = "$namafile-$request->nip.$ext";
        $request->foto_pegawai->move(public_path('img/pegawai'), $gambar);

        return $gambar;
    }

}
