<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Bukti_pembayaran-{{$detail->siswa->nis}}-{{$detail->siswa->nama_lengkap}}</title>
</head>
<body>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5 mx-auto ">
                {{-- <div class="h4 text-center">Pembayaran</div> --}}
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-3">
                    <div class="ml-5">
                        <img height="64px" width="64px" src="{{ asset('/img/').'/'.\Setting::getSetting()->logo}}" alt="">
                    </div>
                    <div class="d-flex flex-column jutsify-content-center mr-5 text-center">
                        <span>{{$sekolahInfo->nama_sekolah}}</span> 
                        <span>{{$sekolahInfo->alamat}}</span> 
                        <span>{{$sekolahInfo->kota}}</span> 
                        <span>No. Telp : {{$sekolahInfo->no_telp}}8</span> 
                    </div>
                </div>
                <div class="text-center mb-2">
                    <strong>Bukti Pembayaran</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <address>
                        <strong>Data Siswa/i:</strong><br>
                        {{ $detail->siswa->nis }}<br>
                        {{ $detail->siswa->nama_lengkap }}<br>
                        {{ $detail->siswa->kelas->nama_kelas }}<br>
                    </address>
                    <address class="text-right">
                        <strong>Tanggal Pembayaran:</strong><br>
                        {{ date_format(date_create($detail->created_at), 'd-m-Y') }}<br>
                        <strong>Metode Pembayaran</strong><br>
                        {{ $detail->metode_pembayaran }}<br><br>
                    </address>
                </div>

                <div class="section-title">Detail Pembayaran</div>
                <div>
                    @foreach ($detail->detail_pembayaran as $item)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <span><strong>{{ $item->nama_pembayaran}}</strong></span><br>
                                <span class="small">{{ $item->keterangan}}</span>
                            </div>
                            <div>
                                <span>Rp.{{ number_format($item->harga) }}</span>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4 d-flex justify-content-between">
                        <span class="">Total</span>
                        <h6>Rp.{{ number_format($detail->total) }}</h6>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mt-4">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 text-center">
                            @role('admin')
                            {{ date_format(date_create($detail->created_at), 'd-M-Y') }} <br>
                            Admin <br><br><br>
                            {{ \Auth::user()->name }}
                            @endrole
                        </div>
                    </div>
                </div>


            </div>
            
        </div>

    </div>
    {{-- <div class="header">
        <h3>Point of Sales Isengoding</h3>
        <h4 style="line-height: 0px;">Invoice: #{{ $penjualan->invoice }}</h4>
        <p><small style="opacity: 0.5;">{{ $penjualan->created_at->format('d-m-Y H:i:s') }}</small></p>
    </div>
    <div class="customer">
        <table>
            <tr>
                <th>Nama Pelanggan</th>
                <td>:</td>
                <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
            </tr>
            <tr>
                <th>No Telp</th>
                <td>:</td>
                <td>{{ $penjualan->pelanggan->no_telpon }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>:</td>
                <td>{{ $penjualan->pelanggan->alamat }}</td>
            </tr>
        </table>
    </div>
    <div class="page">
        <table class="layout display responsive-table">
            <thead>
                <tr >
                    <th style="text-align: center">#</th>
                    <th style="text-align: center">Buku</th>
                    <th style="text-align: center">Harga</th>
                    <th style="text-align: center">Jumlah</th>
                    <th style="text-align: center">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1;
                    $totalPrice = 0;
                    $totalQty = 0;
                    $total = 0;
                @endphp
                @forelse ($penjualan->penjualan_detail as $row)
                <tr>
                    <td style="text-align: center">{{ $no++ }}</td>
                    <td >{{ $row->buku->judul }}</td>
                    <td style="text-align: right">Rp {{ number_format($row->price) }}</td>
                    <td style="text-align: center">{{ $row->qty }} Item</td>
                    <td style="text-align: right">Rp {{ number_format($row->price * $row->qty) }}</td>
                </tr>
​
                @php
                    $totalPrice += $row->price;
                    $totalQty += $row->qty;
                    $total += ($row->price * $row->qty);
                @endphp
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align: right;">Total</th>
                    
                    <td style="text-align: center">{{ number_format($totalQty) }} Item</td>
                    <td style="text-align: right">Rp {{ number_format($total) }}</td>
                </tr>
            </tfoot>
        </table> --}}
    </div>
    <script>
        window.print();
        setTimeout(function() { window.close(); }, 100);
    </script>
</body>
</html>