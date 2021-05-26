<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;

class TahunajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunajaran = Tahunajaran::latest();

        if (!empty($request->keyword)) {
            $tahunajaran = $tahunajaran->where('tahun_ajaran','like',"%".$request->keyword."%");
        }
        
        return view('admin.tahunajaran.index')->with('tahunajaran', $tahunajaran->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tahunajaran.create');
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
            'tahun_ajaran' => 'required|string|max:100'
        ]);

        $tahunajaran = Tahunajaran::create(['tahun_ajaran' => $request->tahun_ajaran]);

        session()->flash('success', "Data Berhasil Disimpan");

        return redirect(route('tahunajaran.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function show(Tahunajaran $tahunajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Tahunajaran $tahunajaran)
    {
        return view('admin.tahunajaran.edit')->with('tahunajaran', $tahunajaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tahunajaran $tahunajaran)
    {
        $this->validate($request, [
            'tahun_ajaran' => 'required|string|max:100'
        ]);

        $tahunajaran->tahun_ajaran = $request->tahun_ajaran;

        $tahunajaran->update();

        session()->flash('success', "Data Berhasil Diupdate");

        return redirect(route('tahunajaran.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tahunajaran  $tahunajaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tahunajaran $tahunajaran)
    {
        if($tahunajaran->jenis_pembayaran->count() > 0){
            session()->flash('error', "Data Gagal Dihapus");
            return redirect(route('tahunajaran.index'));
        }

        $tahunajaran->delete();

        session()->flash('success', "Data Berhasil Dihapus");

        return redirect(route('tahunajaran.index'));
    }
}
