<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiPembayaran;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
// use Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $cartItems = Cart::content();
        $cartTotal = Cart::total();

        // return Cart::content();
        return response()->json(['cartItems' => $cartItems, 'cartTotal' => $cartTotal ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $cartItems = Cart::content();
        $cartTotal = Cart::total();
        $totalQty = Cart::count();
        
        DB::beginTransaction();
        try {         
            
            $kode = 'LKT-'.rand();
            //menyimpan data ke table 
            $pembayaran = TransaksiPembayaran::create([
                'siswa_id' => $request->siswaId,
                'kode_pembayaran' => $kode,
                'metode_pembayaran' => 'Loket',
                'total' => $cartTotal,
                'status' => 'settlement',
                'users_id' => auth()->user()->id,
            ]);

                
            
            foreach ($cartItems as $row) {
                // dd($row->id);
                $tagihanDetail = TagihanDetail::findOrFail($row->id);
                
                $totalBayar = $tagihanDetail->total_bayar + $row->price;
                $sisaBayar = $tagihanDetail->sisa - $row->price;
                
                $tagihanDetail->total_bayar = $totalBayar;
                $tagihanDetail->sisa = $sisaBayar;

                if($sisaBayar == 0){
                    $tagihanDetail->status = "Lunas";
                }

                $tagihanDetail->update();
                
                $tes = $pembayaran->detail_pembayaran()->create([
                    'nama_pembayaran' => $row->name,
                    'keterangan' => $row->options->keterangan,
                    'harga' => $row->price,
                    'tagihan_details_id' => $row->id,
                ]);

            }
            //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();

            
            Cart::destroy();

            //me-return status dan message berupa code invoice, dan menghapus cookie
            return response()->json([
                'status' => 'success',
                
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

    public function addCart(Request $request) 
    {
        $cartItem = Cart::add([
            'id' => $request->id,
            'name' => $request->jenis,
            'qty' => 1,
            'price' => $request->harga,
            'weight' => 0,
            'options' => ['keterangan' => $request->keterangan]
        ]);

        // Cart::associate($cartItem->rowId, 'App\Produk');
        // $cartContent = Cart::content();
        // dd(Cart::count());

        // return view('cart.index')->with('cart', $cartContent);
        return response()->json($cartItem, 200);
    }

    public function removeCart(){

        //hancurkan cart haha , maksudnya hapus data yang ada di dalam cart
        $cartItem = Cart::destroy();

        if(empty($cartItem)){
            return response()->json(['message' => 'Item di Cart berhasil dihapus semua'], 200);    
        }else{
            return response()->json(['message' => 'Item di Cart gagal dihapus semua'], 500);
        }
    }

    public function deleteItem($rowId){
        $deleteItem = Cart::remove($rowId);
        return response()->json(['message' => 'Item Cart Berhasil Dihapus'], 200);
    }

    
}
