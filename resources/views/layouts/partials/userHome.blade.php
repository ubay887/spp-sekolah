<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h4>Welcome {{ Auth::user()->name }}</h4>

            </div>
        </div>
    </div>
</div>

<div class="row">
    @if (auth()->attempt(['username' => auth()->user()->username,'password' => '123456', 'status' => 1]))
        <div class="col-md-12">
            <div class="alert alert-light alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                    <span>×</span>
                    </button>
                    Kamu masih menggunakan password default 123456 untuk login. <br>
                    Segera ubah password Kamu demi keamanan. <strong><a class="text-danger" href="{{route('u.gantiPassword')}}">Ganti Password Sekarang!.</a></strong>
                </div>
            </div>
        </div>   
    @endif
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Pembayaran Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaran as $item)
                            <tr>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    {{$item->nama_pembayaran}}
                                </td>
                                <td>
                                    @if ($item->keterangan === "Bebas")
                                        Angsuran/Bebas
                                    @else 
                                        {{$item->keterangan}}
                                    @endif
                                </td>
                                <td class="text-right">{{number_format($item->harga)}}</td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

