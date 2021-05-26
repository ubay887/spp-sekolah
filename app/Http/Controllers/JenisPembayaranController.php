<?php

namespace App\Http\Controllers;

// use App\Tahunajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\JenisPembayaran;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Http\Requests\JenisPembayaran\StoreJenisPembayaranRequest;
// use App\Http\Requests\JenisPembayaran\UpdateJenisPembayaranRequest;

class JenisPembayaranController extends Controller
{
    public $tagihan;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jenis_pembayaran = JenisPembayaran::latest();

        if (!empty($request->keyword)) {
            $jenis_pembayaran = $jenis_pembayaran->where('nama_pembayaran','like',"%".$request->keyword."%");
        }
        
        return view('admin.jenis_pembayaran.index')->with('jenis_pembayaran', $jenis_pembayaran->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun_ajaran = Tahunajaran::all();
        $kelas = Kelas::all();
        return view('admin.jenis_pembayaran.create')
                        ->with('tahun_ajaran', $tahun_ajaran)
                        ->with('kelas', $kelas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisPembayaranRequest $request)
    {
        $bulan = \BulanHelper::getBulan();

        $jenisPembayaran = JenisPembayaran::create([
            'nama_pembayaran' => $request->nama_pembayaran,
            'tahunajaran_id' => $request->tahunajaran_id,
            'tipe' => $request->tipe,
            'harga' => $request->harga,
            // 'untuk_kelas' => $kelas_encode,
        ]);
        
        if(!empty($request->kelas_id)){
            foreach($request->kelas_id as $item){
                if($item !== 'semua'){
                    $siswa = Siswa::where('kelas_id', $item)->where('status', 'Aktif')->get();
    
                    foreach($siswa as $s){
                        $tagihan = Tagihan::create([
                            'siswa_id' => $s->id,
                            'jenis_pembayaran_id' => $jenisPembayaran->id,
                        ]);
    
                        if($request->tipe === "bulanan"){
                            foreach($bulan as $b){
                                TagihanDetail::create([
                                    'tagihan_id' => $tagihan->id,
                                    'status' => 'Belum Lunas',
                                    'keterangan' => $b,
                                    'total_bayar' => 0,
                                    'sisa' => $jenisPembayaran->harga,
                                ]);
                            }
                        }else{
                            TagihanDetail::create([
                                'tagihan_id' => $tagihan->id,
                                'status' => 'Belum Lunas',
                                'keterangan' => 'Bebas',
                                'total_bayar' => 0,
                                'sisa' => $jenisPembayaran->harga,
                            ]);
                        }
                        
                    }
                }
            }
        }

        session()->flash('success', 'Data Berhasil Disimpan');

        return redirect(route('jenispembayaran.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JenisPembayaran  $jenisPembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(JenisPembayaran $jenisPembayaran)
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
        $jenisPembayaran = JenisPembayaran::findOrFail($id);
        $tahun_ajaran = Tahunajaran::all();
        $kelas = Kelas::all();
        $tempKelas = [];

        foreach($kelas as $this->k){
            // return $this->k->id;
            $tagihan = Tagihan::with('siswa')->where('jenis_pembayaran_id', $id)
                        ->whereHas('siswa', function ($query) {
                                $query->where('kelas_id', $this->k->id);
                            });
            if($tagihan->count() > 0){
                array_push($tempKelas, $this->k->id);
            }
            
        }

        return view('admin.jenis_pembayaran.edit', compact('jenisPembayaran', 'tahun_ajaran', 'kelas', 'tempKelas'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreJenisPembayaranRequest $request, $id)
    {
       //hapus record tagihan berdasarkan jenis_pembayran_id
       $bulan = \BulanHelper::getBulan();

       //create record baru berdasarkan kelas tertentu
        // $tagihan = Tagihan::where('jenis_pembayaran_id', $id)->delete();
        // $tagihan = Tagihan::where('jenis_pembayaran_id', $id)->each( function($tagihan){
        //     TagihanDetail::where('tagihan_id', $tagihan->id)->delete();
        //     $tagihan->delete();
        // });

        // $tagihan->delete();
        
        // $tagihanDetail = TagihanDetail::where('tagihan_id', $tagihan->id)->delete();
        // dd($tagihan);

        $data = $request->only([
            'nama_pembayaran', 
            'tahunajaran_id', 
            'tipe', 
            'harga', 
        ]);

        $jenisPembayaran = JenisPembayaran::findOrFail($id);
        
        $jenisPembayaran->update($data);

        $this->tagihan = Tagihan::with('tagihan_detail')->where('jenis_pembayaran_id', $jenisPembayaran->id)->get();


        if($request->old_tipe !== $request->tipe){
            // hapus tagihan detail
            foreach($this->tagihan as $item){
                $tagihanDetail = TagihanDetail::where('tagihan_id', $item->id)->delete();
            }
        }else{
            foreach($this->tagihan as $item){
                $tagihanDetail = TagihanDetail::where('tagihan_id', $item->id);
                $tagihanDetail->update(['sisa' => $request->harga]);
            }   
        }
        
        // if(!empty($request->kelas_id)){
        foreach($request->kelas_id as $item){
            
            
            if($item !== 'semua'){
                $siswa = Siswa::where('kelas_id', $item)->where('status', 'Aktif')->get();
                              
                $no = 1;
                foreach($siswa as $s){
                    //cek sudah ada tagihan atau belum
                    $cek = Siswa::whereHas('tagihan', function ($query) use($jenisPembayaran) {
                                $query->where('jenis_pembayaran_id', $jenisPembayaran->id);
                            });
                    $cek = $cek->where('id', $s->id)->get()->first();
                                       
                    if(empty($cek)){
                        $tagihan = Tagihan::create([
                            'siswa_id' => $s->id,
                            'jenis_pembayaran_id' => $jenisPembayaran->id,
                        ]);
    
                        if($request->tipe === "bulanan"){
                            foreach($bulan as $b){
                                TagihanDetail::create([
                                    'tagihan_id' => $tagihan->id,
                                    'status' => 'Belum Lunas',
                                    'keterangan' => $b,
                                    'total_bayar' => 0,
                                    'sisa' => $jenisPembayaran->harga,
                                ]);
                            }
                        }else{
                            TagihanDetail::create([
                                'tagihan_id' => $tagihan->id,
                                'status' => 'Belum Lunas',
                                'keterangan' => 'Bebas',
                                'total_bayar' => 0,
                                'sisa' => $jenisPembayaran->harga,
                            ]);
                        }
                    }else{
                        if($request->old_tipe !== $request->tipe){
                            $tagihanCari = Tagihan::where('siswa_id', $s->id)->where('jenis_pembayaran_id', $jenisPembayaran->id)->get()->first();
                            
                            if($request->tipe === "bulanan"){
                                foreach($bulan as $b){
                                    TagihanDetail::create([
                                        'tagihan_id' => $tagihanCari->id,
                                        'status' => 'Belum Lunas',
                                        'keterangan' => $b,
                                        'total_bayar' => 0,
                                        'sisa' => $jenisPembayaran->harga,
                                    ]);
                                }
                            }else{
                                TagihanDetail::create([
                                    'tagihan_id' => $tagihanCari->id,
                                    'status' => 'Belum Lunas',
                                    'keterangan' => 'Bebas',
                                    'total_bayar' => 0,
                                    'sisa' => $jenisPembayaran->harga,
                                ]);
                            }
                        }
                    }
                }
               
            }
        }

        foreach($request->old_kelas_id as $item){
            if (!in_array($item, $request->kelas_id)) {
                $siswa = Siswa::where('kelas_id', $item)->get();

                foreach($siswa as $s){
                    $tagihan = Tagihan::where('jenis_pembayaran_id', $id)->where('siswa_id', $s->id)->each( function($tagihan){
                        TagihanDetail::where('tagihan_id', $tagihan->id)->delete();
                        $tagihan->delete();
                    });
                }
            }
        }
        // }
        
        session()->flash('success', "Data Berhasil Diubah!");

        //redirect user
        return redirect(route('jenispembayaran.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenisPembayaran = JenisPembayaran::findOrFail($id);
        // return $jenisPembayaran->total_byr;
        if($jenisPembayaran->lunas > 0 || $jenisPembayaran->total_byr > 0){
            session()->flash('error', "Gagal menghapus $jenisPembayaran->nama_pembayaran !!");
        }else{
            $tagihan = Tagihan::where('jenis_pembayaran_id', $id)->each( function($tagihan){
                TagihanDetail::where('tagihan_id', $tagihan->id)->delete();
                $tagihan->delete();
            });

            $jenisPembayaran->delete();

            session()->flash('success', "Data Berhasil Dihapus!");
        }    

        //redirect user
        return redirect(route('jenispembayaran.index'));
    }
}
