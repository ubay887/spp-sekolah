<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Siswa</title>
    
</head>
<body>
    <div class="header" style="text-align: center;">
        <h4 >{{$sekolahInfo->nama_sekolah}}</h4>
        <p>{{$sekolahInfo->alamat}}</p>
        <p>{{$sekolahInfo->kota}}</p>
        <p>No. Telpon : {{$sekolahInfo->no_telp}}</p>
        {{-- <h4 style="line-height: 0px;">Invoice: #{{ $penjualan->invoice }}</h4>
        <p><small style="opacity: 0.5;">{{ $penjualan->created_at->format('d-m-Y H:i:s') }}</small></p> --}}
    </div>
    
        {{-- <p>Dicetak Tanggal : {{ date("d-m-Y") }}</p>
        <p></p>        --}}
        <p></p>       
        <p><strong>Laporan Data Siswa/i</strong></p>       
        <p></p>       
    <div class="page">
        <table>
            <thead>
                <tr>
                    <th style="text-align:center; border: 1px solid black">NO</th>
                    <th style="text-align:center; border: 1px solid black">Nis</th>
                    <th style="text-align:center; border: 1px solid black">Nama</th>
                    <th style="text-align:center; border: 1px solid black">Tgl.Lahir</th>
                    <th style="text-align:center; border: 1px solid black">JK</th>
                    <th style="text-align:center; border: 1px solid black">Kelas</th>
                    <th style="text-align:center; border: 1px solid black">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                <tr >
                    <td style="text-align:center; border: 1px solid black">{{ $loop->iteration }}</td>
                    <td style="text-align:center; border: 1px solid black">{{$row->nis}}</td>
                    <td style="text-align:left; border: 1px solid black">{{$row->nama_lengkap}}</td>
                    <td style="text-align:center; border: 1px solid black">{{date_format(date_create($row->tanggal_lahir),"d-m-Y")}}</td>
                    <td style="text-align:center; border: 1px solid black">
                        {{$row->jk}}   
                    </td>
                    <td style="text-align:center; border: 1px solid black">
                        {{$row->kelas->nama_kelas}}   
                    </td>
                    <td style="text-align:center; border: 1px solid black">
                        {{$row->status}}   
                    </td>
                     
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