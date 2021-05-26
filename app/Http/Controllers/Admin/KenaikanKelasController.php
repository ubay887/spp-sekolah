<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KenaikanKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        if (!empty($request->kelas_id)) {
            $siswa = Siswa::with('kelas')->where('kelas_id', $request->kelas_id)->where('status', 'Aktif')->orderBy('nama_lengkap', 'ASC')->get();
            // return view('admin.kenaikan_kelas.index', \compact('kelas', 'siswa'));
        }else{
            $siswa = Null;
        }
        // return $siswa;
        return view('admin.kenaikan_kelas.index', \compact('kelas', 'siswa'));
    }

    public function getSiswa(Request $request)
    {
        
        // if (!empty($request->kelas_id)) {
            $siswa = Siswa::with('kelas')->where('kelas_id', $request->kelas_id)->orderBy('nama_lengkap', 'ASC')->get();
            // return view('admin.kenaikan_kelas.index', \compact('kelas', 'siswa'));
        // }else{
        //     $siswa = Null;
        // }
        return response()->json($siswa, 200);
    }

    
    public function prosesKenaikanKelas(Request $request)
    {
        $this->validate($request, [
            'kelas_id' => 'required',
            'siswa_id' => 'required',
        ]);

        foreach($request->siswa_id as $item){
            $siswa = Siswa::findOrFail($item);
            $siswa->kelas_id = $request->kelas_id;
            $siswa->update();
        }

        session()->flash('success', "Data Berhasil Disimpan");

        return redirect("/kenaikanKelas?kelas_id=$request->kelas_id");
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
}
