<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='icon' href='{{ public_path('/storage/').\Setting::getSetting()->favicon }}' type='image/x-icon' />
    <title>Data Siswa</title>
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
            top: 25;
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
            top: 60px;
            font-size: 20px;
            text-align: center;
        }

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
                    {{-- Website : http://www.example.com<br> --}}

                </p>
            </div>
            <div class="garis"></div>
        </div>
        
        {{-- <h5>Dicetak Tanggal : {{ date("d-m-Y") }}</h5> --}}
        {{-- <br> --}}
        @if (!empty($start_date))
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
        @endif
        {{-- <p><small style="opacity: 0.5;">{{ $penjualan->created_at->format('d-m-Y H:i:s') }}</small></p> --}}
    </div>
    {{-- <div>
        <strong>Laporan Data Siswa/i</strong>
    </div> --}}
    <div class="info">
        <strong>Laporan Data Siswa </strong> <br>
        <table style="margin-left: auto; margin-right: auto">
            
            {{-- <tr>
                <td>Tipe</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ ($jenisPembayaranTipe === "bulanan") ? 'Bulanan' : 'Angsuran/Bebas'}}</td>
            </tr> --}}
            <tr>
                <td>Kelas</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>
                    @if (empty(request()->session()->get('kelas_id')))
                        Semua Kelas
                    @else 
                        {{$siswa->first()->kelas->nama_kelas}}
                    @endif
                    
                </td>
            </tr>
            @if (!empty($status))
                <tr>
                    <td>Status</td>
                    <td style="padding-left: 10px; padding-right: 10px ">:</td>
                    <td>{{$status}}</td>
                </tr>
                
            @endif
            <tr>
                <td>Dicetak Tanggal</td>
                <td style="padding-left: 10px; padding-right: 10px ">:</td>
                <td>{{ date("d-m-Y") }}</td>
            </tr>
            
        </table>
    </div>
    <div class="page">
        
        <table class="layout display responsive-table" style="font-size: 18px">
            <thead>
                <tr >
                    <th style="text-align: center">#</th>
                    <th style="text-align: center">Foto</th>
                    <th style="text-align: center">Nis Nama</th>
                    <th style="text-align: center">Tgl.Lahir</th>
                    <th style="text-align: center">JK</th>
                    <th style="text-align: center">Kelas</th>
                    <th style="text-align: center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $row)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: center" >
                        <img width="64px" height="64px" src="{{ public_path('/img/siswa/').$row->foto }}" alt="">
                        
                    </td>
                    <td >
                        {{ $row->nis }} <br>
                         {{ $row->nama_lengkap }}
                    </td>
                    <td style="text-align: center" >{{ date_format(date_create($row->tanggal_lahir),"d-m-Y") }}</td>
                    <td style="text-align: center" >
                        {{ ($row->jenis_kelamin === "male") ? 'L' : 'P' }}
                    </td>
                    <td style="text-align: center" >{{ $row->kelas->nama_kelas }}</td>
                    <td style="text-align: center">{{ $row->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>