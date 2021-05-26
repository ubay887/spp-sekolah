<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Produk</title>
</head>
<body>
    <div class="header" style="text-align:center;">
        <h4>{{$sekolahInfo->nama_sekolah}}</h4>
        <h4>{{$sekolahInfo->alamat}} {{$sekolahInfo->kota}}</h4>
        <h4>No. Telpon : {{$sekolahInfo->no_telp}}</h4>
        {{-- <h4 style="line-height: 0px;">Invoice: #{{ $penjualan->invoice }}</h4>
        <p><small style="opacity: 0.5;">{{ $penjualan->created_at->format('d-m-Y H:i:s') }}</small></p> --}}
    </div>
    <p></p>
    <p>Laporan Transaksi Pembayaran</p>
    @if (!empty($start_date))
        <div class="customer">
            <table>
                {{-- <tr>
                    <th>Laporan Transaksi Pembayaran</th>
                    <td></td>
                    <td></td>
                </tr> --}}
                <tr>
                    <th>Dari Tanggal</th>
                    <td></td>
                    <td>{{ $start_date }}</td>
                </tr>
                <tr>
                    <th>Sampai Tanggal</th>
                    <td></td>
                    <td>{{ $end_date }}</td>
                </tr>
                
            </table>
        </div>
        
    @else 
        <p>Dicetak Tanggal : {{ date("d-m-Y") }}</p>
        <p></p>       
        <p></p>       
    @endif
    <div class="page">
        <table>
            <thead>
                <tr>
                    <th style="text-align:center; border: 1px solid black">#</th>
                    <th style="text-align:center; border: 1px solid black">Tgl.Pembayaran</th>
                    <th style="text-align:center; border: 1px solid black">NIS</th>
                    <th style="text-align:center; border: 1px solid black">Nama</th>
                    <th style="text-align:center; border: 1px solid black">Nama Pembayaran</th>
                    <th style="text-align:center; border: 1px solid black">Keterangan</th>
                    <th style="text-align:center; border: 1px solid black">Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $row)
                <tr >
                    <td style="text-align:center; border: 1px solid black">{{ $loop->iteration }}</td>
                    <td style="text-align:center; border: 1px solid black">{{ date_format(date_create($row->transaksi_pembayaran->created_at), 'd-m-Y') }}</td>
                    <td style="text-align:center; border: 1px solid black">{{ $row->transaksi_pembayaran->siswa->nis}}</td>
                    <td style="text-align:left; border: 1px solid black">
                        {{ $row->transaksi_pembayaran->siswa->nama_lengkap}}
                    </td>
                    <td style="text-align:left; border: 1px solid black">{{ $row->nama_pembayaran}}</td>
                    <td style="text-align:left; border: 1px solid black">{{ $row->keterangan}}</td>
                    <td style="text-align:right; border: 1px solid black">Rp.{{ number_format($row->harga) }}</td>
                     
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="6" style="text-align:right;"><strong>Total</strong></td>
                    <td style="text-align:right; border: 1px solid black"><strong>Rp.{{ number_format($total) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>