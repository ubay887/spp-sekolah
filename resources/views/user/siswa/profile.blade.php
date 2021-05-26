@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Profile {{ $data->nama_lengkap }}</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card author-box">
                    <div class="card-header  iseng-sticky bg-white">
                        {{-- <a href="{{ route('siswa.index') }}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a> --}}
                        <h4 class="ml-3">Profile</h4>
                        <div class="card-header-action">
                            <a href="{{ route('u.siswa.edit', $data->id) }}" class="btn btn-primary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Edit">
                                <i class="fas fa-user-edit    "></i>
                            </a>
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="author-box-left">
                            <img width="100" height="100" alt="image" src="{{ asset('/img/siswa/'.$data->foto)}}"
                                class="rounded-circle author-box-picture">
                            <div class="clearfix"></div>
                            <div class="user-details mt-3">
                                <div class="user-name">{{ $data->nama_lengkap }}</div>
                                <div class="text-job text-muted">{{ $data->nis }}</div>
                                <div class="user-cta mt-3">
                                  <span class="badge badge-success">{{ $data->status }}</span>
                                </div>
                              </div>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-description">

                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="home-tab2" data-toggle="tab" href="#home2"
                                            role="tab" aria-controls="home" aria-selected="true">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#tagihan"
                                            role="tab" aria-controls="profile" aria-selected="false">Tagihan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#pembayaran"
                                            role="tab" aria-controls="profile" aria-selected="false">Riwayat Pembayaran</a>
                                    </li>
                                    
                                </ul>
                                <div class="tab-content tab-bordered" id="myTab3Content">
                                    <div class="tab-pane fade active show" id="home2" role="tabpanel"
                                        aria-labelledby="home-tab2">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-5 py-3">
                                                <h6> <u>Data Pribadi</u> </h6>
                                                <strong>Nomor Induk Siswa</strong><br>
                                                {{ $data->nis }}
                                                <br><br>
                                                <strong>Nama Lengkap</strong><br>
                                                {{ $data->nama_lengkap }}
                                                <br><br>
                                                <strong>Jenis Kelamin</strong><br>
                                                {{ ($data->nis === 'male') ? 'Laki-Laki' : 'Perempuan' }}
                                                <br><br>
                                                <strong>Tempat Lahir</strong><br>
                                                {{ $data->tempat_lahir }}
                                                <br><br>
                                                <strong>Tanggal Lahir</strong><br>
                                                {{ $data->tanggal_lahir }}
                                                <br><br>
                                                <strong>Kelas</strong><br>
                                                {{ $data->kelas->nama_kelas }}
                                                <br><br>
                                                <strong>No. HP</strong><br>
                                                {{ $data->no_telp }}
                                            </div>
                                            <!-- /.col-md -->
                                            <div class="col-md-6 py-3 px-3">
                                                <h6> <u>Data Orangtua</u> </h6>
                                                <strong>Nama Ibu Kandung</strong><br>
                                                {{ $data->nama_ibu_kandung }}
                                                <br><br>
                                                <strong>Nama Ayah Kandung</strong><br>
                                                {{ $data->nama_ayah_kandung }}
                                                <br><br>
                                                <strong>No. Telp Orangtua</strong><br>
                                                {{ $data->no_telp_orangtua }}
                                                <br><br>
                                                <strong>Alamat</strong><br>
                                                {{ $data->alamat }}
                                            </div>
                                            <!-- /.col-md -->
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="tab-pane fade" id="tagihan" role="tabpanel">
                                        <div id="accordion">
                                            
                                            {{-- <form action="" method="get" class="mb-4">
                                                <div class="form-group">
                                                    <label for="tahunajaran_id">Tahun Ajaran</label>
                                                    <select name="tahunajaran_id" id="tahunajaran_id" class="form-control @error('tahunajaran_id') is-invalid @enderror">
                                                        <option value="">-Pilih Tahun Ajaran-</option>
                                                        @foreach ($tahun_ajaran as $item)
                                                        <option value="{{ $item->id  }}"
                                                                @if ($item->id == old('tahunajaran_id'))
                                                                    selected
                                                                @endif    
                                                            >
                                                            
                                                            {{ $item->tahun_ajaran }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('tahunajaran_id')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button class="btn btn-primary">Filter</button>
                                            </form> --}}
                                            @foreach ($data->tagihan as $row)
                                            <div class="accordion">
                                                <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-{{$row->id}}" aria-expanded="false">
                                                    <div class="d-flex justify-content-between">
                                                        <h4>{{ $row->jenis_pembayaran->nama_pembayaran }}</h4>
                                                        {{-- <h4>
                                                        
                                                            {{ $row->jenis_pembayaran->tipe }}
                                                            
                                                        </h4> --}}
                                                        <h4>{{ $row->jenis_pembayaran->tahunajaran->tahun_ajaran }}</h4>
                                                    </div>
                                                    
                                                </div>
                                                <div class="accordion-body collapse" id="panel-body-{{$row->id}}" data-parent="#accordion" style="">
                                                    <div class="table-responsive">
                                                        @if ($row->jenis_pembayaran->tipe === "bulanan")
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nominal</th>
                                                                        <th>Keterangan</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($row->tagihan_detail as $item)
                                                                    <tr>
                                                                        <td>Rp.{{ number_format($row->jenis_pembayaran->harga) }}</td>
                                                                        <td>{{$item->keterangan}}</td>
                                                                        <td>
                                                                            @if ($item->status === "Lunas")
                                                                                <i class="fas fa-check-circle  text-success mr-2 "></i>
                                                                            @else 
                                                                                <i class="fas fa-times-circle text-info  mr-2 "></i>    
                                                                            @endif
                                                                            {{$item->status}}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else    
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nominal</th>
                                                                    <th>Total Bayar</th>
                                                                    <th>Sisa</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($row->tagihan_detail as $item)
                                                                <tr>
                                                                    <td>Rp.{{ number_format($row->jenis_pembayaran->harga) }}</td>
                                                                    <td>Rp.{{number_format($item->total_bayar)}}</td>
                                                                    <td>Rp.{{number_format($item->sisa)}}</td>
                                                                    <td>
                                                                        @if ($item->status === "Lunas")
                                                                                <i class="fas fa-check-circle  text-success mr-2  "></i>
                                                                            @else 
                                                                                <i class="fas fa-times-circle text-info mr-2  "></i>    
                                                                            @endif
                                                                        {{$item->status}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                    </div>
                                                    <!-- /.table-responsive -->
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pembayaran" role="tabpanel">
                                        @if (!empty($pembayaran))
                                        <div class="table-responsive">
                                            <table class="table table-striped small">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Tanggal Pembayaran</th>
                                                        <th>Nama Pembayaran</th>
                                                        <th>Keterangan</th>
                                                        <th>Jumlah Bayar</th>
                                                        <th>Metode Pembayaran</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pembayaran as $item)
                                                    <tr>
                                                        <td>
                                                            
                                                            {{$item->created_at}}
                                                        </td>
                                                        <td>{{$item->nama_pembayaran}}</td>
                                                        <td>{{$item->keterangan}}</td>
                                                        <td class="text-right">Rp.{{number_format($item->harga)}}</td>
                                                        <td class="text-center">{{$item->transaksi_pembayaran->metode_pembayaran}}</td>
                                                        <td class="text-center">
                                                            @if ($item->transaksi_pembayaran->status === "settlement" || $item->transaksi_pembayaran->status === "Success")
                                                                <span class="text-success" data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="Sukses">
                                                                    <i class="fas fa-check-circle    "></i>
                                                                    
                                                                </span>
                                                            @endif
                                                            @if ($item->transaksi_pembayaran->status === "expire")
                                                                <span class="text-danger" data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="Expire">
                                                                    <i class="fas fa-times-circle    "></i>
                                                                    
                                                                </span>
                                                            @endif
                                                            @if ($item->transaksi_pembayaran->status === "pending")
                                                                <span class="text-warning" data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="Pending">
                                                                    <i class="fas fa-info-circle    "></i>
                                                                    
                                                                </span>
                                                            @endif
                                                            @if ($item->transaksi_pembayaran->status === "cancel")
                                                                <span class="text-secondary" data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="Cancel">
                                                                    <i class="fas fa-info-circle    "></i>
                                                                    
                                                                </span>
                                                            @endif
                                                            {{-- {{$item->transaksi_pembayaran->status}} --}}
                                                        </td>
                                                    </tr>
                                                        
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @else 
                                            <div class="col-md-6 mx-auto">
                                                <div class="text-center">
                                                <img class="w-75" style="opacity: 0.3" src="{{ asset('/img/undraw_wallet_aym5.png')}}" alt="">
                                                    <p>Belum ada Riwayat Pembayaran</p>
                                                    <button class="btn btn-primary">Lakukan Pembayaran</button>
                                                </div>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    {{-- <div class="card-footer clearfix">
                        tes
                    </div> --}}
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
    <!-- /.content -->
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#kelas_id').select2()

        $('#foto_siswa').dropify({
            messages: {
                'default': '',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });

    });

</script>



@endsection
