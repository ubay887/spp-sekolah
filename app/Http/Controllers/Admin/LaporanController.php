<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\JenisPembayaran;
use App\Helper\BulanHelper;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Exports\TagihanExport;
use App\Exports\PembayaranExport;
use App\Models\Detail_pembayaran;
use App\Models\PengaturanSekolah;
use App\Models\TransaksiPembayaran;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    protected $sekolahi;

    public function getSekolahi()
    {
        return $this->sekolahi = PengaturanSekolah::all()->first();
    }

    public function laporanPembayaran(Request $request)
    {
        $request->session()->forget(['jenisPembayaran']);
        $jenisPembayaran = JenisPembayaran::all();

        if(!empty($request->mode)){
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);
            if($request->mode === 'simple'){
                $data = Detail_pembayaran::with('transaksi_pembayaran')->latest();
                $data = $data->whereHas('transaksi_pembayaran', function ($query) {
                    $query->where('status', 'settlement');
                });
            }else{
                $data = TransaksiPembayaran::with('detail_pembayaran', 'siswa')->latest()->where('status', 'settlement');
            }            // return $data->get();
        }

        // dd($data->get());

        if(!empty($request->jenisPembayaran)){
            $this->validate($request, [
                'mode' => 'required',
            ]);
            $this->jenisPembayaran = $request->jenisPembayaran;

            if($request->mode === 'simple'){
                $data = $data->where('nama_pembayaran', $request->jenisPembayaran);
            }else{
                $data = $data->whereHas('detail_pembayaran', function ($query) {
                    $query->where('nama_pembayaran', $this->jenisPembayaran);
                });
            }

            session(['jenisPembayaran' => $request->jenisPembayaran]);

            // return $data->get();
        }

        if (!empty($request->start_date) && !empty($request->end_date)) {
            // $this->keyword = $request->keyword;
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'mode' => 'required',
            ]);

            //START & END DATE DI RE-FORMAT MENJADI Y-m-d H:i:s
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';

            session(['start_date' => $start_date]);
            session(['end_date' => $end_date]);
            session(['mode' => $request->mode]);
    
            $data = $data->whereBetween('created_at', [$start_date, $end_date]);
            // dd($data->get());
            return view('admin.laporan.index')
                                ->with('jenisPembayaran', $jenisPembayaran)
                                ->with('data', $data->get());
        }
        // return $data->get();
        return view('admin.laporan.index', compact('jenisPembayaran'));
        
    }

    public function laporanPembayaranPdf(Request $request){
        
        $data = $this->filterPembayaran($request);

        ($request->session()->get('mode') === 'simple') ? $total = $data->sum('harga') : $total = $data->sum('total');

        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('admin.laporan.cetakPembayaranPdf', [
                'data' => $data->get(),
                'total' => $total,
                'start_date' => $request->session()->get('start_date'),
                'end_date' => $request->session()->get('end_date'),
                'mode' => $request->session()->get('mode'),
                'sekolahInfo' => $this->getSekolahi(),
            ]);

        return $pdf->stream('laporan-transaksi-pembayaran.pdf');
    }

    public function laporanPembayaranExcel(Request $request){
        $data = $this->filterPembayaran($request);

        ($request->session()->get('mode') === 'simple') ? $total = $data->sum('harga') : $total = $data->sum('total');

        return (new PembayaranExport($data->get(), $this->getSekolahi(), $total, $request->session()->get('start_date'), $request->session()->get('end_date'), $request->session()->get('mode')))->download('laporan-pembayaran.xlsx');
    }

    public function filterPembayaran($request)
    {
        if($request->session()->get('mode') === 'simple'){
            $data = Detail_pembayaran::with('transaksi_pembayaran')->latest();
            $data = $data->whereHas('transaksi_pembayaran', function ($query) {
                $query->where('status', 'settlement');
            });
        }else{
            $data = TransaksiPembayaran::with('detail_pembayaran', 'siswa')->latest()->where('status', 'settlement');
        }
        
        if(!empty($request->session()->get('jenisPembayaran'))){

            $this->jenisPembayaran = $request->session()->get('jenisPembayaran');

            if($request->session()->get('mode') === 'simple'){
                $data = $data->where('nama_pembayaran', $this->jenisPembayaran);
            }else{
                $data = $data->whereHas('detail_pembayaran', function ($query) {
                    $query->where('nama_pembayaran', $this->jenisPembayaran);
                });
            }
        }

        $data = $data->whereBetween('created_at', [$request->session()->get('start_date'), $request->session()->get('end_date')]);

        return $data;
    }

    public function laporanTagihan(Request $request)
    {
        $request->session()->forget(['nama_kelas', 'kelas_id']);

        $jenisPembayaranTipe = '';

        $tagihan = Tagihan::with('siswa', 'jenis_pembayaran', 'tagihan_detail');
        
        if(!empty($request->jenisPembayaran)){
            $jenisPembayaranTipe = JenisPembayaran::findOrFail($request->jenisPembayaran)->tipe;
            $tagihan = $tagihan->where('jenis_pembayaran_id', $request->jenisPembayaran);
            session(['jenisPembayaranTipe' => $jenisPembayaranTipe]);
            session(['jenisPembayaran' => $request->jenisPembayaran]);
            
        }

        if(!empty($request->kelas_id)){
            $this->kelas_id = $request->kelas_id;
            $tagihan = $tagihan->whereHas('siswa', function ($query) {
                $query->where('kelas_id', $this->kelas_id);
            });
            $namaKelas = Kelas::findOrFail($this->kelas_id)->nama_kelas;
            session(['nama_kelas' => $namaKelas]);
            session(['kelas_id' => $request->kelas_id]);
        }
        
        return view('admin.laporan.laporanTagihan', [
            'jenisPembayaran' => JenisPembayaran::all(),
            'kelas' => Kelas::all(),
            'bulan' => BulanHelper::getBulanSingkat(),
            'tagihan' => $tagihan->get()->sortBy('siswa.nama_lengkap'),
            'jenisPembayaranTipe' => $jenisPembayaranTipe,
        ]);
        
    }

    public function laporanTagihanPdf(Request $request)
    {
        $bulan = BulanHelper::getBulanSingkat();

        $data = $this->filterTagihan($request);

        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('admin.laporan.cetakTagihanPdf', [
                'data' => $data->get()->sortBy('siswa.nama_lengkap'),
                'jenisPembayaranTipe' => $request->session()->get('jenisPembayaranTipe'),
                'bulan' => $bulan,
                'sekolahInfo' => $this->getSekolahi(),
                'namaKelas' => $request->session()->get('nama_kelas'),
            ])->setPaper('a4', 'landscape');

        return $pdf->stream("laporan-tagihan-siswa.pdf");
        
    }

    public function laporanTagihanExcel(Request $request)
    {
        $bulan = BulanHelper::getBulanSingkat();
        
        $data = $this->filterTagihan($request);

        return (new TagihanExport(
                        $data->get()->sortBy('siswa.nama_lengkap'), 
                        $this->getSekolahi(), 
                        $bulan, 
                        $request->session()->get('jenisPembayaranTipe'), 
                        $request->session()->get('nama_kelas')
                    )
            )->download('laporan-tagihan.xlsx');
    }

    public function filterTagihan($request)
    {
        
        $data = Tagihan::with('siswa', 'jenis_pembayaran', 'tagihan_detail');

        $data = $data->where('jenis_pembayaran_id', $request->session()->get('jenisPembayaran'));

        if(!empty(request()->session()->get('kelas_id'))){
            $data = $data->whereHas('siswa', function ($query) {
                $query->where('kelas_id', request()->session()->get('kelas_id'));
            });
        }

        return $data;
    }
}
