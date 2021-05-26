<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Siswa;
// use Spatie\Permission\Models\Permission;
use App\Models\Tagihan;
use App\JenisPembayaran;
use Illuminate\Http\Request;
use App\Models\Detail_pembayaran;
use Spatie\Permission\Models\Role;
use App\Models\TransaksiPembayaran;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $user =  Auth::user();
        
        $siswa = Siswa::whereStatus('aktif');
        
        $jumlahLaki = Siswa::where('jenis_kelamin', 'male')->whereStatus('aktif')->count();
        $jumlahPerempuan = Siswa::where('jenis_kelamin', 'female')->whereStatus('aktif')->count();
        $jumlahAlumni = Siswa::where('status', 'lulus')->count();
        
        $transaksi = TransaksiPembayaran::with('siswa')->where('status', '<>', 'Draft')->latest()->take(10)->get();
        $jenisPembayaran = JenisPembayaran::get();
        // $jenisPembayaran = JenisPembayaran::where('tipe', 'bebas')->get();
        
        if($user->hasRole('siswa')){
            // $pembayaran = TransaksiPembayaran::where('siswa_id', auth()->user()->siswa->id)->latest()->get();
            $pembayaran = Detail_pembayaran::with('transaksi_pembayaran')
            ->whereHas('transaksi_pembayaran', function ($query) {
                $query->where('siswa_id', auth()->user()->siswa->id)
                ->where(function ($query) {
                    $query->where('status', 'Success')
                          ->orWhere('status', 'settlement');
                });
                // ->where('status', 'settlement')
                // ->orWhere('status', 'Success');
            })->latest()->get();
            
            return view('home', compact('pembayaran'));
        }else{

            return view('home', compact('siswa',
                                        // 'users',
                                        // 'rolesCount',
                                        'transaksi',
                                        'jenisPembayaran',
                                        'jumlahLaki',
                                        'jumlahPerempuan',
                                        'jumlahAlumni',
                                ));
        }
        
        
        
    }
}
