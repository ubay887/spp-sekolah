<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Siswa/i</h4>
                </div>
                <div class="card-body">
                    {{ $siswa->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-male    "></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Laki-Laki</h4>
                </div>
                <div class="card-body">
                    {{ $jumlahLaki }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-female    "></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Perempuan</h4>
                </div>
                <div class="card-body">
                    {{ $jumlahPerempuan }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-user-graduate    "></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <a href="{{ route('kelulusan.alumni') }}" class="">
                        <h4>Alumni</h4>
                    </a>
                </div>
                <div class="card-body">
                    {{$jumlahAlumni}}
                </div>
                    
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 col-md-12 col-12 col-sm-12">
        <div class="card gradient-bottom">
            <div class="card-header">
            <h4>Jenis Pembayaran</h4>
            
            </div>
            <div class="card-body" id="top-4-scroll" tabindex="2" style="height: 315px; overflow: hidden; outline: none;">
            <ul class="list-unstyled list-unstyled-border">
                @foreach ($jenisPembayaran as $row)
                    
                <li class="media">
                {{-- <img class="mr-3 rounded" width="55" src="assets/img/products/product-3-50.png" alt="product"> --}}
                <div class="media-body">
                    <div class="float-right"><div class="font-weight-600 text-muted text-small pl-1">{{ $row->tagihan->count()}} Orang</div></div>
                    <div class="media-title">
                        <a target="_blank" href="laporan/tagihan?kelas_id=&jenisPembayaran={{$row->id}}">
                            {{ $row->nama_pembayaran }}
                        </a>
                        <br>
                        <span class="text-muted small">T.P {{$row->tahunajaran->tahun_ajaran}}</span>
                    </div>
                    <div class="mt-1">
                    <div class="budget-price">
                        <div class="budget-price-square bg-success" data-width="{{ $row->lunas}}%" ></div>
                        <div class="budget-price-label">{{ $row->lunas}} Orang</div>
                    </div>
                    <div class="budget-price">
                        <div class="budget-price-square bg-danger" data-width="{{ $row->belum_lunas}}%"></div>
                        <div class="budget-price-label">{{ $row->belum_lunas}} Orang</div>
                    </div>
                    </div>
                </div>
                </li>
                @endforeach
                
                
                
                
            </ul>
            </div>
            <div class="card-footer pt-3 d-flex justify-content-center">
                <div class="budget-price justify-content-center">
                    <div class="budget-price-square bg-success" data-width="20" style="width: 20px;"></div>
                    <div class="budget-price-label">Lunas</div>
                </div>
                <div class="budget-price justify-content-center">
                    <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
                    <div class="budget-price-label">Belum Lunas</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Transaksi Pembayaran</h4>
                <div class="card-header-action">
                    <a href="{{route('pembayaran.index')}}" class="btn btn-primary">Selengkapnya..</a>
                </div>
            </div>
            <div class="card-body" id="top-5-scroll" style="height: 315px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 small">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                {{-- <th>Kode</th> --}}
                                <th>Nis|Nama</th>
                                {{-- <th>Metode</th> --}}
                                <th>Metode Pembayaran <br>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $row)
                                <tr>
                                    <td>
                                        <a class=""
                                            href="{{ route('pembayaran.show', $row->id) }}">
                                            {{ $row->kode_pembayaran }}
                                        </a> <br>
                                        {{ $row->for_human }}
                                    </td>
                                    
                                    <td>
                                        {{ $row->siswa->nis }} <br>
                                        {{ $row->siswa->nama_lengkap }}
                                    </td>
                                    <td class="text-right">
                                        {{$row->metode_pembayaran}} <br>
                                        {{ number_format($row->total) }}
                                    </td>
                                    <td class="text-center">
                                        @if ($row->status === "settlement")
                                            <i class="fas fa-check-circle text-success"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Settlement"
                                                data-original-title="Settlement"
                                            ></i>
                                        @endif
                                        @if ($row->status === "pending")
                                            <i class="fas fa-info-circle text-warning"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Pending"
                                                data-original-title="Pending"
                                            ></i>
                                        @endif
                                        @if ($row->status === "expire")
                                            <i class="fas fa-times-circle text-danger"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Expire"
                                                data-original-title="Expire"
                                            ></i>
                                        @endif
                                        {{-- {{ $row->status }} --}}
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="card-footer pt-3 d-flex justify-content-center">
                <div class="budget-price justify-content-center">
                    <i class="fas fa-check-circle text-success mr-2   "></i> Settlement
                </div>
                <div class="budget-price justify-content-center">
                    <i class="fas fa-times-circle text-danger mr-2 "></i> Expire
                </div>
                <div class="budget-price justify-content-center">
                    <i class="fas fa-info-circle text-warning mr-2 "></i> Pending
                </div>
            </div>
        </div>


        
    </div>
</div>