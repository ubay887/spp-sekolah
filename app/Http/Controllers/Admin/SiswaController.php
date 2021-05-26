<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\JenisPembayaran;
use App\Models\Tahunajaran;
use Illuminate\Support\Str;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Models\Detail_pembayaran;
use App\Models\PengaturanSekolah;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Siswa\StoreSiswaRequest;
use App\Http\Requests\Siswa\UpdateSiswaRequest;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget(['jenis_kelamin', 'status', 'kelas_id', 'keyword']);
        
        $siswa = Siswa::orderBy('nama_lengkap', 'asc');
        $kelas = Kelas::all();

        if(!empty($request->jk)){
            $siswa = $siswa->where('jenis_kelamin', $request->jk);
            session(['jenis_kelamin' => $request->jk]);
        }

        if(!empty($request->status)){
            $siswa = $siswa->where('status', $request->status);
            session(['status' => $request->status]);
        }

        if(!empty($request->kelas_id)){
            $siswa = $siswa->where('kelas_id', $request->kelas_id);
            session(['kelas_id' => $request->kelas_id]);
        }

        if (!empty($request->keyword)) {
            $siswa = $siswa->where('nama_lengkap','like',"%".$request->keyword."%")
                            ->orWhere('nis', 'like', "%$request->keyword%");
            $siswa = $siswa->orWhereHas('kelas', function ($query) {
                $query->where('nama_kelas', 'like', "%".request()->keyword."%");
            });
            session(['keyword' => $request->keyword]);
        }

        return view('admin.siswa.index')
                ->with('siswa', $siswa->paginate(10))
                ->with('kelas', $kelas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiswaRequest $request)
    {

        $gambar = '';
        if($request->hasFile('foto_siswa')){
            $gambar = $this->uploadGambar($request);
        }else{
            $gambar = "siswa_default.png";
        }

        $tesid = uniqid();
        $user = User::create([
            'name' => $request->nama_lengkap,
            'username' => $request->nis,
            'email' => "email-$tesid@example.com",
            'password'  => bcrypt('123456'),
            'status'  => true,
        ]);

        $user->assignRole('siswa');
        // $user->assignRole($request->role);
        Siswa::create([
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'nama_ibu_kandung' => $request->nama_ibu_kandung,
            'nama_ayah_kandung' => $request->nama_ayah_kandung,
            'no_telp_orangtua' => $request->no_telp_orangtua,
            'status' => 'Aktif',
            'kelas_id' => $request->kelas_id,
            'user_id' => $user->id,
            'foto' => $gambar,
        ]);

        session()->flash('success', 'Data Siswa Berhasil Ditambahkan');

        return redirect(route('siswa.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Siswa::with('kelas', 'tagihan')->findOrFail($id);
        $jenisPembayaran = JenisPembayaran::all();
        // $jp = [];

        $this->siswaId = $id;
        $tahun_ajaran = Tahunajaran::all();
        
        $pembayaran = Detail_pembayaran::with('transaksi_pembayaran')->whereHas('transaksi_pembayaran', function ($query) {
            $query->where('siswa_id', $this->siswaId);
        })->latest()->get();

        return view('admin.siswa.show', compact('data', 'tahun_ajaran', 'pembayaran', 'jenisPembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
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
            'status',
            'kelas_id',
        ]);
        
        $user = User::findOrFail($siswa->user_id);
        $user->name = $request->nama_lengkap;
        $user->username = $request->nis;
        $user->update();

        if($request->hasFile('foto_siswa')){

            if($siswa->foto !== "siswa_default.png"){
                File::delete('img/siswa/'.$siswa->foto);
            }

            $gambar = $this->uploadGambar($request);
            $data['foto'] = $gambar;
        }


        $siswa->update($data);

        session()->flash('success', "Data Siswa : $siswa->nama_lengkap  Berhasil Di ubah");

        //redirect user
        return redirect(route('siswa.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        if($siswa->status === "Aktif"){
            session()->flash('error', "Data Siswa $siswa->nama_lengkap tidak bisa hapus!!");

            return redirect(route('siswa.index'));
        }

        if($siswa->foto !== "siswa_default.png"){
            File::delete('img/siswa/'.$siswa->foto);
        }

        
        $siswa->user->delete();
        $siswa->delete();

        session()->flash('success', "Data siswa : $siswa->nama_lengkap Berhasil Dihapus");

        return redirect(route('siswa.index'));
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

    public function createTagihan(Request $request)
    {
        $this->validate($request, [
            'jenisPembayaran_id' => 'required',
        ]);

        $bulan = \BulanHelper::getBulan();
        // $tagihan = $request->jenisPembayaran_id;

        foreach($request->jenisPembayaran_id as $item){
            $jenisPembayaran = JenisPembayaran::find($item);
            
            $tagihan = Tagihan::create([
                'siswa_id' => $request->siswaId,
                'jenis_pembayaran_id' => $jenisPembayaran->id,
            ]);

            if($jenisPembayaran->tipe === "bulanan"){
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
        session()->flash('success', "Tagihan Berhasil Ditambahkan");

        return redirect()->back();
    }

    public function deleteTagihan($id)
    {
        // return $id;
        $tagihan = Tagihan::with('tagihan_detail')->findOrFail($id);
        $tagihanDetail = TagihanDetail::where('tagihan_id', $tagihan->id);
        $count = $tagihanDetail->where('total_bayar','<>', '0')->count();
        if($count > 0){
            session()->flash('error', "Tagihan Gagal Dihapus!");

            return redirect()->back();
        }
        
        
        $tagihan->delete();
        $tagihanDetail = TagihanDetail::where('tagihan_id', $tagihan->id)->delete();
        
        session()->flash('success', "Tagihan Berhasil Dihapus");

        return redirect()->back();
    }

    public function cetakPdf(Request $request)
    {
        $siswa = $this->filter($request);
        $sekolahInfo = PengaturanSekolah::all()->first();
        // dd($sekolahInfo);
        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('admin.siswa.cetak.pdf', [
                'siswa' => $siswa,
                'sekolahInfo' => $sekolahInfo,
                'status' => $request->session()->get('status'),
                // 'kelas' => $request->session()->get('status'),
                // 'start_date' => $request->session()->get('start_date'),
                // 'end_date' => $request->session()->get('end_date'),
            ]);
        return $pdf->stream();
    }

    public function excel(Request $request)
    {
        
        $siswa = $this->filter($request);
        $sekolahInfo = PengaturanSekolah::all()->first();
        return (new SiswaExport($siswa, $sekolahInfo))->download('Data_siswa.xlsx');
    }

    public function filter($request)
    {
        $siswa = Siswa::orderBy('nama_lengkap', 'asc');

        if(!empty($request->session()->get('jenis_kelamin'))){
            // return $request->session()->get('jenis_kelamin');
            $siswa = $siswa->where('jenis_kelamin', $request->session()->get('jenis_kelamin'));
        }

        if(!empty($request->session()->get('status'))){
            $siswa = $siswa->where('status', $request->session()->get('status'));
        }

        if(!empty($request->session()->get('kelas_id'))){
            $siswa = $siswa->where('kelas_id', $request->session()->get('kelas_id'));
        }

        if (!empty($request->session()->get('keyword'))) {
            $siswa = $siswa->where('nama_lengkap','like',"%".$request->session()->get('keyword')."%")
                            ->orWhere('nis', 'like', "%".$request->session()->get('keyword')."%");
            $siswa = $siswa->orWhereHas('kelas', function ($query) use($request) {
                $query->where('nama_kelas', 'like', "%".$request->session()->get('keyword')."%");
            });
        }
        
        return $siswa->get();
    }


    public function import(Request $request)
    {
        $this->validate($request, [
            'import_siswa' => 'required|nullable|mimes:xls,xlsx|max:15'
        ]);
        

        $file = request()->file('import_siswa');
              
        Excel::import(new SiswaImport, request()->file('import_siswa'));
        
        session()->flash('success', "Data siswa Berhasil di import");

        //redirect user
        return redirect(route('siswa.index'));
    }
}
