<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kelas = kelas::latest();

        if (!empty($request->keyword)) {
            $kelas = $kelas->where('nama_kelas','like',"%".$request->keyword."%");
        }
        
        return view('admin.kelas.index')->with('kelas', $kelas->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_kelas' => 'required|string|max:100'
        ]);

        $kelas = Kelas::create(['nama_kelas' => $request->nama_kelas]);

        session()->flash('success', "Data Berhasil Disimpan");

        return redirect(route('kelas.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_kelas' => 'required|string|max:100'
        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->nama_kelas = $request->nama_kelas;

        $kelas->update();

        session()->flash('success', "Data Berhasil Diupdate");

        return redirect(route('kelas.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        if($kelas->siswa->count() > 0){
            session()->flash('error', "Tidak Bisa Menghapus Kelas, Karena Total Siswa Lebih Dari Nol!");
        }else{
            $kelas->delete();
            session()->flash('success', "Data Berhasil Dihapus");
        }


        return redirect(route('kelas.index'));
    }
}
