<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='icon' href='{{ public_path('/storage/').\Setting::getSetting()->favicon }}' type='image/x-icon' />
    <title>Laporan Transaksi Pembayaran</title>
    <style>
        body{
            padding: 0;
            margin: 0;
        }
        .page{
            max-width: 80em;
            /* margin: 0 auto;' */
            /* position: absolute; */
            /* top: 170px; */
            position: relative;
            top: 15;
        }
         table th,
        table td{
            text-align: left;
        }
        
        table.layout{
            width: 100%;
            border-collapse: collapse;
        }
        
        table.display{
            margin: 1em 0;
        }
        table.display th,
        table.display td{
            border: 1px solid #B3BFAA;
            padding: .5em 1em;
        }

        table.display th{ background: #D5E0CC; }
        table.display td{ background: #fff; }
        
        /* table.responsive-table{
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
        }  */

        .customer {
            padding-left: 600px;
        }

        .logo{
            position: absolute;
            left: 150px;
            top: 20px;
            z-index: 999;
        }

        .koplaporan{
            position: relative;
            height: 120px;
        }

        .logo img{
            width: 120px;
            height: 120px;
            /* position: absolute; */
            
        }

        .judul{
            position: absolute;
            top: 0;
            text-align: center;
        }

        .garis{
            margin-top: 160px;
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
        }

        .info{
            position: relative;
            top: 45px;
            font-size: 20px;
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        /* .header{
            position: relative;
            top: 0px;
            font-size: 20px;
            text-align: right;
        } */
        .sub-header{
            font-size: 20px;
        }
        
    </style>
</head>
<body>
    <div class="header">
        <div class="koplaporan">
            <div class="logo">
                <img src="{{ public_path('/img/').\Setting::getSetting()->logo }}" alt="">
            </div>
            <div class="judul">
                <p>
                    {{$sekolahInfo->nama_sekolah}}<br>
                    <span class="sub-header">{{$sekolahInfo->alamat}}</span><br>
                    <span class="sub-header">{{$sekolahInfo->kota}}</span><br>
                    <span class="sub-header">Telp. {{$sekolahInfo->no_telp}}</span><br>

                </p>
            </div>
            <div class="garis"></div>
        </div>
        
        {{-- <h5>Dicetak Tanggal : {{ date("d-m-Y") }}</h5> --}}
        {{-- <br> --}}
        
        {{-- <p><small style="opacity: 0.5;">{{ $penjualan->created_at->format('d-m-Y H:i:s') }}</small></p> --}}
    </div>
    
    <div class="info">
        {{-- @if (!empty($start_date))
            <table>
                <tr>
                    <td>Dari Tanggal</td>
                    <td>: {{ date_format(date_create($start_date), "d/m/Y") }}</td>
                </tr>
                <tr>
                    <td>Sampai Tanggal</td>
                    <td>: {{ date_format(date_create($end_date), "d/m/Y") }}</td>
                </tr>
            </table>    
        @endif --}}
        <strong>Laporan Transaksi Pembayaran </strong> <br>
        <table style="margin-left: auto; margin-right: auto">
            <tr>
                <td>Dari Tanggal</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ date_format(date_create($start_date), "d-m-Y") }}</td>
            </tr>
            <tr>
                <td>Sampai Tanggal</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ date_format(date_create($end_date), "d-m-Y") }}</td>
            </tr>
            {{-- <tr>
                <td>Tipe</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ ($jenisPembayaranTipe === "bulanan") ? 'Bulanan' : 'Angsuran/Bebas'}}</td>
            </tr> --}}
            {{-- <tr>
                <td>Dicetak Tanggal</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ date("d-m-Y") }}</td>
            </tr> --}}
            {{-- <tr>
                <td>Kelas</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ ($namaKelas == "") ? 'Semua Kelas' : $namaKelas }}</td>
            </tr> --}}
        </table>
        
    </div>
    <div class="page">
        @if ($mode === 'simple')
            
        <table class="layout display responsive-table" style="font-size: 18px">
            <thead>
                <tr >
                    <th style="text-align: center">#</th>
                    <th style="text-align: center">Tgl.Pembayaran</th>
                    <th style="text-align: center">NIS/Nama</th>
                    <th style="text-align: center">Nama Pembayaran</th>
                    <th style="text-align: center">Keterangan</th>
                    <th style="text-align: center">Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                    <tr>
                        <td style="width: 20px">
                            {{ $loop->iteration }}
                        </td>
                        <td style="width: 90px; text-align: center" >
                            {{ date_format(date_create($row->transaksi_pembayaran->created_at), 'd-m-Y') }}
                        </td>
                        <td>
                            [{{ @$row->transaksi_pembayaran->siswa->nis}}] <br>
                            {{ @$row->transaksi_pembayaran->siswa->nama_lengkap}}
                        </td>
                        <td>
                            {{ $row->nama_pembayaran}}
                        </td>
                        <td style="width: 90px; text-align: center">
                            {{ $row->keterangan}}
                        </td>
                        <td style=" text-align: right">
                            Rp.{{ number_format($row->harga) }}
                        </td>
                    </tr>  
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="5" style=" text-align: right">Total</td>
                    <td  style=" text-align: right">Rp.{{number_format($total)}}</td>
                </tr>
            </tbody>
        </table>

        @else 

        @foreach ($data as $row)
            <table class="layout display responsive-table" style="font-size: 18px">
                <thead>
                    <tr >
                        <th style="text-align: center">#</th>
                        <th style="text-align: left">
                            Tgl.Pembayaran : <br>
                            {{ date_format(date_create($row->created_at), 'd-m-Y') }}
                        </th>
                        <th style="text-align: left">
                            [{{ @$row->siswa->nis}}] <br>
                            {{ @$row->siswa->nama_lengkap}}
                        </th>
                        <th style="text-align: center">
                            Metode Pembayaran
                            <br> {{ $row->metode_pembayaran }}
                        </th>
                        {{-- <th style="text-align: center">Keterangan</th> --}}
                        <th style="text-align: right">Total Bayar <br> Rp.{{ number_format($row->total) }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($row->detail_pembayaran as $item)
                    <tr>
                        <td style="width: 50px"></td>
                        <td colspan="3">
                            {{ $item->nama_pembayaran }} - {{ $item->keterangan }}
                        </td>
                        {{-- <td></td> --}}
                        <td style="text-align: right">
                            Rp.{{ number_format($item->harga) }}
                        </td>
                    </tr>                                  
                        
                    @endforeach
                    
                </tbody>
            </table>
            
        @endforeach
        <div style="font-size: 20px; text-align: right; margin-top: -10px">
            <span>Total : Rp.{{number_format($total)}}</span>

        </div>
        @endif
        <table border="0" style="width: 100%; font-size: 18px; margin-top: 20px">
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: center">{{$sekolahInfo->kota}}, {{ date("d-m-Y") }}</td>
            </tr>
            <tr >
                <td></td>
                <td style="text-align: center">Kepala Sekolah</td>
                <td></td>
                <td style="text-align: center">Bendahara</td>
            </tr>
            <tr>
                <td style="width: 100px"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center">_________________</td>
                <td style="height: 200px"></td>
                <td style="text-align: center">_________________</td>
            </tr>
        </table>
    </div>
</body>
</html>