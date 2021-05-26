<?php

namespace App\Http\Controllers\Siswa;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Models\PengaturanPayment;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiPembayaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pembayaran = TransaksiPembayaran::where('siswa_id', auth()->user()->siswa->id)
        ->where('status','<>', 'Draft')
        ->latest();
        
        if (!empty($request->keyword)) {
            $this->keyword = $request->keyword;
            
            $pembayaran = $pembayaran->where('kode_pembayaran','like',"%".$this->keyword."%");
            // $pembayaran = $pembayaran->orWhere('kode_pembayaran','like',"%".$this->keyword."%");

            // $pembayaran = $pembayaran->orWhereHas('kategori', function ($query) {
            //     $query->where('nama_kategori', 'like', "%".$this->keyword."%");
            // });
            
        }

        return view('user.pembayaran.index')->with('pembayaran', $pembayaran->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('user.pembayaran.create');
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
        $detail = TransaksiPembayaran::with('siswa', 'detail_pembayaran')->findOrFail($id);
        
        $dueDate = new Carbon($detail->created_at);
        $dueDate->addDays(1);
        
        return view('user.pembayaran.detail', compact('detail', 'dueDate'));
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

    public function getTagihan(){
        
        // $data = Siswa::with('kelas', 'tagihan')->findOrFail($id)->first();
        // return $data;
        // Auth::user()->id;
        $tagihan = Tagihan::with('siswa', 'tagihan_detail', 'jenis_pembayaran')->where('siswa_id', Auth::user()->siswa->id);
        
        return response()->json($tagihan->get(), 200);
    }

    public function getSiswa(){
        
        // $siswa = Siswa::latest();
        // if (!empty($request->keyword)) {
            // $siswa = Siswa::with('kelas', 'tagihan')->where('nama_lengkap','like',"%".$request->keyword."%")
            //                 ->orWhere('nis', 'like', "%$request->keyword%");
            // $siswa = $siswa->orWhereHas('kelas', function ($query) {
            //     $query->where('nama_kelas', 'like', "%".request()->keyword."%");
            // });
        // }
        // $siswa->paginate(10);
        // return $siswa->paginate(10);
        $siswa = Siswa::with('kelas')->findOrfail(Auth::user()->siswa->id);
        return response()->json($siswa, 200);
    }

    public function invoice(Request $request)
    {
        
        $cartItems = Cart::content();
        
        $cartTotal = Cart::total();
        
        $user = Auth::user();
        $siswaId = auth()->user()->siswa->id;
        
        $item_details = [];
        foreach($cartItems as $item){
            $item_detail = [
                'id' => $item->id,
                'price' => $item->price,
                'name' => $item->name.'-'.$item->options->keterangan,
                'quantity' => 1,
            ];
            array_push($item_details, $item_detail);
        }    

        $orderId = "INV-".rand();
        $customer_details = array(
            'first_name'       => $user->siswa->nama_lengkap,
            // 'last_name'        => "tesaja",
            'email'            => $user->email,
            'phone'            => $user->siswa->no_telp_orangtua,
        );

        // $enable_payments = array('gopay', 'bca_va', 'permata_va', 'bni_va', 'echannel', 'other_va');
        $enable_payments = array($request->metode);

        $params = array(
            'enabled_payments' => $enable_payments,
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $cartTotal,
            ),
            'customer_details'    => $customer_details,
            'item_details' => $item_details,
        );

        try {
            // Get Snap Payment Page URL
            $paymentUrl = $this->snapMidtrans($params);
            
            $this->simpanTransaksi($orderId, $request->metode, $paymentUrl->token);

            return redirect()->to($paymentUrl->redirect_url);
            
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public function snapMidtrans($params)
    {
        $midtrans = PengaturanPayment::all()->first();
        
        if($midtrans->environment === "sandbox"){
            $server_key = $midtrans->server_key_sandbox;
            $prod = false;
        }else{
            $server_key = $midtrans->server_key_production;
            $prod = true;
        }

        \Midtrans\Config::$serverKey = $server_key;
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = $prod;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        return \Midtrans\Snap::createTransaction($params);
    }

    public function notifikasi(Request $request)
    {
        $midtrans = PengaturanPayment::all()->first();

        if($midtrans->environment === "sandbox"){
            $server_key = $midtrans->server_key_sandbox;
        }else{
            $server_key = $midtrans->server_key_production;
        }

        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . $server_key);

        if ($notification->signature_key != $validSignatureKey) {
			return response(['message' => 'Invalid signature'], 403);
        }

        if($notification->transaction_status === "pending"){
            $transaksi = TransaksiPembayaran::where('kode_pembayaran', $notification->order_id)->first();
            // $transaksi->metode_pembayaran = $notification->payment_type;
            $transaksi->status = $notification->transaction_status;
            $transaksi->pembayaran_detail = $payload;
            $transaksi->update();
        }

        if($notification->transaction_status === "settlement"){
            // dd($row->id);
            $transaksiPembayaran = TransaksiPembayaran::with('detail_pembayaran')->where('kode_pembayaran', $notification->order_id)->first();
            $transaksiPembayaran->status = $notification->transaction_status;
            $transaksiPembayaran->update();


            foreach($transaksiPembayaran->detail_pembayaran as $item){
                $tagihanDetail = TagihanDetail::findOrFail($item->tagihan_details_id);
                // return $tagihanDetail;
                $totalBayar = $tagihanDetail->total_bayar + $item->harga;
                $sisaBayar = $tagihanDetail->sisa - $item->harga;
                
                $tagihanDetail->total_bayar = $totalBayar;
                $tagihanDetail->sisa = $sisaBayar;

                if($sisaBayar == 0){
                    $tagihanDetail->status = "Lunas";
                }

                $tagihanDetail->update();
            }
        }

        if($notification->transaction_status === "cancel"){
            $transaksi = TransaksiPembayaran::where('kode_pembayaran', $notification->order_id)->first();
            $transaksi->status = $notification->transaction_status;
            $transaksi->update();
        }

        if($notification->transaction_status === "expire"){
            $transaksi = TransaksiPembayaran::where('kode_pembayaran', $notification->order_id)->first();
            $transaksi->status = $notification->transaction_status;
            $transaksi->update();
        }

        return response()->json(['message' => 'sukses']);


    }

    public function completed(Request $request)
    {
        $transaksi = TransaksiPembayaran::where('kode_pembayaran', $request->order_id)->first(); 
            
        return view('user.pembayaran.completed', compact('transaksi'));
    }

    public function setMetodePembayaran(Request $request)
    {   
        session(['metodePembayaran' => $request->metode]);
        return response()->json(['message' => 'sukses']);
    }

    public function simpanTransaksi($kodePembayaran, $metode, $token)
    {
        $cartItems = Cart::content();
        $cartTotal = Cart::total();
        $totalQty = Cart::count();

        // $enable_payments = array('gopay', 'bca_va', 'permata_va', 'bni_va', 'echannel', 'other_va');
        if($metode === "gopay"){
            $metodePembayaran = "GOPAY";
        }elseif($metode === "bca_va"){
            $metodePembayaran = "BCA VA";
        }elseif($metode === "permata_va"){
            $metodePembayaran = "PERMATA VA";
        }elseif($metode === "bni_va"){
            $metodePembayaran = "BNI VA";
        }elseif($metode === "echannel"){
            $metodePembayaran = "MANDIRI VA";
        }elseif($metode === "other_va"){
            $metodePembayaran = "Bank Lainnya";
        }
        
        DB::beginTransaction();
        try {         
              
            //menyimpan data ke table
            $pembayaran = TransaksiPembayaran::create([
                'siswa_id' => auth()->user()->siswa->id,
                'kode_pembayaran' => $kodePembayaran,
                'metode_pembayaran' => $metodePembayaran,
                'total' => $cartTotal,
                'status' => 'Draft',
                'token' => $token,
                'users_id' => auth()->user()->id,
            ]);

                
            // //looping cart untuk disimpan ke table 
            foreach ($cartItems as $row) {                
                $tes = $pembayaran->detail_pembayaran()->create([
                    'tagihan_details_id' => $row->id,
                    'nama_pembayaran' => $row->name,
                    'keterangan' => $row->options->keterangan,
                    'harga' => $row->price,
                ]);

            }
            //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();

            //hancurkan cart haha , maksudnya hapus data yang ada di dalam cart
            Cart::destroy();

            //me-return status dan message berupa code invoice, dan menghapus cookie
            return response()->json([
                'status' => 'success',
                // 'message' => $penjualan->invoice,
            ], 200);
        } catch (\Exception $e) {
            //jika ada error, maka akan dirollback sehingga tidak ada data yang tersimpan 
            DB::rollback();
            //pesan gagal akan di-return
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
        // return response()->json(['message' => 'berhasil disimpan'], 200);
    }
}
