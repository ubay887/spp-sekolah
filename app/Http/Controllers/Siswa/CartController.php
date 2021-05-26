<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiPembayaran;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Cart::associate($cartItem->rowId, 'App\Produk');
        $cartItems = Cart::content();
        $cartTotal = Cart::total();

        // return Cart::content();
        return response()->json(['cartItems' => $cartItems, 'cartTotal' => $cartTotal ], 200);
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

        return response()->json(['message' => 'Item di Cart berhasil dihapus semua'], 200);
    }

    public function deleteItem($rowId){
        // $rowId = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        // return response()->json($rowId, 200);
        $deleteItem = Cart::remove($rowId);
        return response()->json(['message' => 'Item Cart Berhasil Dihapus'], 200);
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
        $cartItems = Cart::content();
        $cartTotal = Cart::total();
        $totalQty = Cart::count();
        // return $request->all();
        // return auth()->user()->id;
        // DB::beginTransaction();
        // try {         
              
        //     //menyimpan data ke table orders
        //     $pembayaran = TransaksiPembayaran::create([
        //         'siswa_id' => $request->siswaId,
        //         'metode_pembayaran' => 'Loket',
        //         'total' => $cartTotal,
        //         'status' => 'Success',
        //         'users_id' => auth()->user()->id,
        //     ]);

                
        //     // //looping cart untuk disimpan ke table order_details
        //     foreach ($cartItems as $row) {
        //         // dd($row->id);
        //         $tagihanDetail = TagihanDetail::findOrFail($row->id);
                
        //         $totalBayar = $tagihanDetail->total_bayar + $row->price;
        //         $sisaBayar = $tagihanDetail->sisa - $row->price;
                
        //         $tagihanDetail->total_bayar = $totalBayar;
        //         $tagihanDetail->sisa = $sisaBayar;

        //         if($sisaBayar == 0){
        //             $tagihanDetail->status = "Lunas";
        //         }

        //         $tagihanDetail->update();
                
        //         $tes = $pembayaran->detail_pembayaran()->create([
        //             'nama_pembayaran' => $row->name,
        //             'keterangan' => $row->options->keterangan,
        //             'harga' => $row->price,
        //         ]);

        //         // DB::table('produk')
        //         //     ->where('id', $row->id)
        //         //     ->decrement('stok', $row->qty);
        //     }
        //     //apabila tidak terjadi error, penyimpanan diverifikasi
        //     DB::commit();

        //     //hancurkan cart haha , maksudnya hapus data yang ada di dalam cart
        //     Cart::destroy();

        //     //me-return status dan message berupa code invoice, dan menghapus cookie
        //     return response()->json([
        //         'status' => 'success',
        //         // 'message' => $penjualan->invoice,
        //     ], 200);
        // } catch (\Exception $e) {
        //     //jika ada error, maka akan dirollback sehingga tidak ada data yang tersimpan 
        //     DB::rollback();
        //     //pesan gagal akan di-return
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => $e->getMessage()
        //     ], 400);
        // }
        // return response()->json(['message' => 'berhasil disimpan'], 200);
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
