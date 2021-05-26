<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='icon' href='{{ public_path('/storage/').\Setting::getSetting()->favicon }}' type='image/x-icon' />
    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}
    <title>Laporan Tagihan</title>
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
        <strong>Laporan Tagihan </strong> <br>
        <table style="margin-left: auto; margin-right: auto;">
            <tr>
                <td style="vertical-align: text-top">Jenis Pembayaran</td>
                <td style="padding-left: 10px; padding-right: 10px; vertical-align: text-top">:</td>
                <td >{{$data->first()->jenis_pembayaran->nama_pembayaran}}</td>
            </tr>
            <tr>
                <td>Tahun Pelajaran</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{$data->first()->jenis_pembayaran->tahunajaran->tahun_ajaran}}</td>
            </tr>
            <tr>
                <td>Nominal</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>Rp. {{ number_format($data->first()->jenis_pembayaran->harga)}}</td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ ($jenisPembayaranTipe === "bulanan") ? 'Bulanan' : 'Angsuran/Bebas'}}</td>
            </tr>
            <tr>
                <td>Dicetak Tanggal</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ date("d-m-Y") }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ ($namaKelas == "") ? 'Semua Kelas' : $namaKelas }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>Keterangan :</td>
            </tr>
            <tr>
                <td><span style="color: green">v</span> = Lunas |</td>
                <td><span style="color: red">x</span> = Belum Lunas</td>
            </tr>
        </table>
    </div>
    <div class="page">
        {{-- @if ($mode === 'simple') --}}
            
        <table class="layout display responsive-table" style="font-size: 18px">
            <thead>
                <tr >
                    <th style="text-align: center">#</th>
                    <th style="text-align: center">NIS/Nama</th>
                    @if ($jenisPembayaranTipe === 'bulanan')
                        @foreach ($bulan as $item)
                        <th>{{$item}}</th>
                        @endforeach
                        <th>Total</th>
                    @else
                    <th>Sisa</th> 
                    <th>Total Bayar</th> 
                    <th>
                        Status
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                    $totalBayar = 0;
                @endphp
                @foreach ($data as $row)
                <tr>
                    <td style="width: 30px">{{ $loop->iteration }}</td>
                    <td>
                        {{@$row->siswa->nis}} -
                        {{@$row->siswa->kelas->nama_kelas}} <br>
                        {{@$row->siswa->nama_lengkap}}
                    </td>
                    @if ($jenisPembayaranTipe !== 'bulanan')
                        <td style="width: 100px; text-align:right;">
                            @if ($row->tagihan_detail[0]->sisa != 0)
                            {{ number_format($row->tagihan_detail[0]->sisa) }}
                                
                            @endif
                        </td>
                        <td style="width: 100px; text-align:right;">
                            @if ($row->tagihan_detail[0]->total_bayar != 0)

                            {{-- @else   --}}
                                {{ number_format($row->tagihan_detail[0]->total_bayar) }}
                                @php
                                    $totalBayar = $totalBayar + $row->tagihan_detail[0]->total_bayar
                                @endphp
                            @endif
                        </td>
                    @endif
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($row->tagihan_detail as $item)
                        <td style="width: 30px; text-align:center;">
                            @if ($item->status === 'Lunas')
                            <span style="color: green">v</span>
                                @php
                                    $total = $total + $data->first()->jenis_pembayaran->harga;
                                @endphp
                            {{-- <i class="fas fa-check-circle text-success   " title="{{$item->status}}"></i> --}}
                            @endif
                            @if ($item->status === 'Belum Lunas')
                            <span style="color: red">x</span>
                                {{-- <i class="fas fa-times-circle text-danger   "></i> --}}
                            @endif
                        </td>
                    @endforeach
                    @php
                        $grandTotal = $grandTotal + $total;
                    @endphp
                    @if ($jenisPembayaranTipe === 'bulanan')
                    <td style="width: 30px;text-align:right;">{{number_format($total)}}</td>
                        
                    @endif
                </tr>
            @endforeach 
            @if ($jenisPembayaranTipe === 'bulanan')
                <tr>
                    <td colspan="12"style="text-align:right;"></td>
                    <td colspan="2" style="text-align:right;">Total</td>
                    <td style="text-align:right;">{{number_format($grandTotal)}}</td>
                </tr>
                @else 
                <tr>
                    {{-- <td colspan="14"style="text-align:right; border: 1px solid black;"></td> --}}
                    <td colspan="3" style="text-align:right;">Total</td>
                    <td style="text-align:right;">{{number_format($totalBayar)}}</td>
                    <td></td>
                </tr>
                @endif
            
            </tbody>
        </table>
        {{-- <div style="text-align: right"> --}}
            {{-- <div style="float: right">
                <p>Tanjungpinang, 12-2-2021</p>
                <p>Bendahara</p>
                <br>
                <br>
                <br>
                <p>________________</p>

            </div> --}}
            <table border="0" style="width: 100%; font-size: 20px">
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

        {{-- </div> --}}
        {{-- @else  --}}

        

        {{-- @endif --}}
    
    </div>
</body>
</html>