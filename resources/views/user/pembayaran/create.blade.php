@extends('layouts.master')

@section('content')
<section class="section"  v-cloak>
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Pembayaran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Transaksi Pembayaran</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <a href="{{ route('u.pembayaran.index') }}" class="btn">
                            <i class="fas fa-arrow-left  text-dark  "></i>
                        </a>
                        <h4 class="ml-3">Transaksi Pembayaran</h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {{-- <div class="row">
                            <div class="col-md-8 mx-auto">
                                <autocomplete
                                    :search="search"
                                    placeholder="Masukkan NIS atau Nama Siswa/i "
                                    aria-label="Search Wikipedia"
                                    :get-result-value="getResultValue"
                                    @submit="handleSubmit"
                                ></autocomplete>  
                            </div>
                        </div> --}}
                        <!-- /.card-row -->
                        <div class="row" style="min-height: 185px" v-if="dataSiswa">
                            {{-- info siswa --}}
                            <div class="col-md-2 mb-4">
                                <div class="user-item">
                                {{-- <img alt="image" height="128px" width="128px" :src="'http://localhost/lara7-spp/public/img/siswa/' + siswa.foto" class="img-fluid"> --}}
                                    <div class="user-details">
                                        <div class="user-name">@{{siswa.nama_lengkap}}</div>
                                        <div class="text-job text-muted">@{{siswa.nis}}</div>
                                        <div class="user-cta">
                                        <button class="btn btn-primary follow-btn" data-follow-action="alert('user5 followed');" data-unfollow-action="alert('user5 unfollowed');">@{{siswa.status}}</button>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <!-- /.col-md -->
                            <div class="col-md-6 small">
                                <div id="accordion">
                                    <div class="accordion" v-for="(row, p) in tagihan">
                                        <div class="accordion-header collapsed" role="button" data-toggle="collapse" :data-target="'#panel-body-'+row.id" aria-expanded="false">
                                            <h4>
                                                @{{ row.jenis_pembayaran.nama_pembayaran }}
                                                @{{ row.jenis_pembayaran.tipe }}
                                            </h4>
                                        </div>
                                        <div class="accordion-body collapse" :id="'panel-body-'+row.id" data-parent="#accordion" style="">
                                            <div class="row">
                                                <div class="" v-bind:class="{ 'col-md-10 col-10': row.jenis_pembayaran.tipe ==='bebas', 'col-md-4 col-6': row.jenis_pembayaran.tipe ==='bulanan' }" v-for="(oke, index) in row.tagihan_detail">
                                                    
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div v-if="row.jenis_pembayaran.tipe === 'bulanan'">
                                                                <strong>Rp.@{{ row.jenis_pembayaran.harga }}</strong><br>
                                                                @{{oke.keterangan}}
                                                            </div>
                                                            <div v-else>
                                                                <div class="d-flex justify-content-between">
                                                                    <span>Nominal</span>
                                                                    <strong>Rp.@{{ row.jenis_pembayaran.harga }}</strong>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <span>Total Bayar</span>
                                                                    <strong class="text-success">Rp.@{{ oke.total_bayar }}</strong>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <span>Sisa</span>
                                                                    <strong class="text-warning">Rp.@{{ oke.sisa }}</strong>
                                                                </div>
                                                                
                                                            
                                                                

                                                            </div>
                                                            {{-- <span v-if="oke.status === 'Lunas'">@{{ oke.status }}</span> --}}
                                                            
                                                        </div>
                                                            
                                                            <div v-if="oke.status === 'Lunas'">
                                                                <button class="btn btn-success btn-sm btn-block" disabled>
                                                                    <i class="fas fa-thumbs-up    "></i>
                                                                    Lunas
                                                                </button>
                                                            </div>
                                                            <div v-else>
                                                                <button class="btn btn-warning btn-sm btn-block" v-if="submit[oke.id]" disabled>
                                                                    <i class="fas fa-check    "></i>
                                                                    Bayar
                                                                </button>
                                                                <div v-else>
                                                                    <button v-if="row.jenis_pembayaran.tipe === 'bulanan'" @click="addToCart(oke.id, row.jenis_pembayaran.harga, row.jenis_pembayaran.nama_pembayaran, oke.keterangan, row.jenis_pembayaran.tipe)" class="btn btn-sm btn-block btn-light">
                                                                        @{{ submit[oke.id] ? 'Loading...':'Bayar' }}
                                                                    </button>
    
                                                                    <button v-else @click="bayarAngsuran(oke.id, oke.sisa, row.jenis_pembayaran.nama_pembayaran, oke.keterangan)" class="btn btn-sm btn-block btn-light">
                                                                        Bayar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                                <!-- /.col-md -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- @{{tagihan}} --}}
                            </div>
                            <!-- /.col-md -->
                            <div class="col-md-4">
                                {{-- @{{tagihan_id}} --}}
                                <div class="card card-info pembayaranDetail">
                                    
                                    <div class="card-body" >
                                        <div class="d-flex justify-content-between">
                                            <h6 class="card-title">Pembayaran Detail</h6>
                                            <div v-if="submitCart" class="spinner-border text-danger spinner-border-sm" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <div v-if="cartTotal > 0">
                                                <div class="d-flex justify-content-between border-bottom py-4" v-for="row in cart" :key="row.id">
                                                    <div>
                                                        <span><strong>@{{ row.name }}</strong></span><br>
                                                        <span class="small">@{{ row.options.keterangan }}</span>
                                                    </div>
                                                    <div>
                                                        <span>Rp.@{{ row.price }}-</span>
                                                        <button class="btn text-danger" @click="deleteItem(row.rowId, row.id)"><i class="fas fa-times-circle    "></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="d-flex justify-content-center">
                                                <img alt="image" style="opacity: 0.3" height="90px" width="90px" src="{{ asset('/img/undraw_empty_cart_co35.png')}}">
                                            </div>
                                        </div>
                                        
                                        <div class="py-4 ">
                                            <h6>Total Bayar</h6>
                                            <h4>Rp.@{{cartTotal}}-</h4>
                                        </div>
                                        <label for="">Pilih Metode Pembayaran :</label>
                                        <select v-model="metode" class="form-control mb-3" name="metode">
                                            {{-- <option value="">-Pilih Metode Pembayaran-</option> --}}
                                            <option value="gopay">GOPAY</option>
                                            <option value="bca_va">BCA Virtual Account</option>
                                            <option value="permata_va">Permata Virtual Account</option>
                                            <option value="echannel">Mandiri Virtual Account</option>
                                            <option value="bni_va">BNI Virtual Account</option>
                                            <option value="other_va">Bank Lain</option>
                                        </select>
                                        
                                        {{-- <button @click="pembayaranModal()" class="btn btn-primary btn-block">Lanjutkan Pembayaran</button> --}}
                                        <!-- Button trigger modal -->
                                        <button class="btn btn-primary btn-block" v-if="cartTotal <= 0" disabled>Lanjutkan Pembayaran</button>
                                        <button v-else class="btn btn-primary btn-block" @click="showModal = true">Lanjutkan Pembayaran</button>
                                    </div>

                                    
                                  
                                </div>
                            </div>
                            <!-- /.col-md -->
                        </div>
                        <div class="row mt-5 mb-5 py-5"  v-else>
                            <div class="col-md-2 mx-auto">
                                {{-- <img class="w-75" style="opacity: 0.3" src="{{ asset('/img/undraw_file_searching_duff.png')}}" alt=""> --}}
                                <div class="text-center">
                                    <div class="spinner-border text-info" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div>Loading ...</div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
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

    <!-- Modal -->
    
    <div class="modal fade show" style="z-index: 9998" id="pembayaranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Detail Penjualan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12" id="printmeme">
                                <div>
                                    <p class="text-center"> <strong>Isengoding POS</strong>  <br>
                                    2020-08-14<br>
                                    Sales Receipt<br>
                                    Sold By: John Doe<br>
                                    Sold To: Walk-in customer</p>
                                    <div>
                                        <div class="d-flex justify-content-between border-bottom py-4" v-for="row in cart" :key="row.id">
                                            <div>
                                                <span><strong>@{{ row.name }}</strong></span><br>
                                                <span class="small">@{{ row.options.keterangan }}</span>
                                            </div>
                                            <div>
                                                <span>Rp.@{{ row.price }}-</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="py-4 ">
                                        <h6>Total Bayar</h6>
                                        <h4>Rp.@{{cartTotal}}-</h4>
                                    </div>
                                </div>
                                <!-- /.faktur -->

                            </div>
                            
                                <!-- bayar -->
                            <!-- /.col-md -->
                            <!-- <div class="col-md-6">
                                
                            </div> -->
                            <!-- /.col-md -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container -->
                    
                    
                </div>
                
            </div>
        </div>
    </div>
    


    <div v-if="showModal">
        <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-light text-dark shadow">
                <div class="modal-body">
                    <div>
                        <div class="d-flex justify-content-between">
                            <span><strong>Detail Pembayaran</strong></span>
                            <span>
                                <strong>Tanggal : {{ date("d-m-Y") }}</strong><br>
                                <strong>Metode Pembayaran</strong><br>
                                @{{metode}}
                            </span>
                        </div>
                        <br>
                        @{{siswa.nama_lengkap}} <br>
                        @{{siswa.nis}} <br>
                        @{{siswa.kelas.nama_kelas}}
                        <hr>
                        <div style="height: 35vh; overflow-y: auto;">
                            <div class="d-flex justify-content-between border-bottom py-3" v-for="row in cart" :key="row.id">
                                <div>
                                    <span><strong>@{{ row.name }}</strong></span><br>
                                    <span class="small">@{{ row.options.keterangan }}</span>
                                </div>
                                <div>
                                    <span>Rp.@{{ row.price }}-</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="py-3">
                            <h6>Total Bayar</h6>
                            <h4>Rp.@{{cartTotal}}-</h4>
                            
                        </div>

                            
                            {{-- <label for="">Pilih Metode Pembayaran</label> --}}
                            
                        
                    </div>
                    <!-- /.faktur -->
                    
                </div>
                <div class="modal-footer">
                        
                        <button type="button" class="btn btn-danger mt-2 btn-block" @click="showModal = false">Close</button>
                        
                        
                        {{-- <button type="button" class="btn btn-info btn-block">Cetak Nota</button> --}}
                        {{-- <button type="button" class="btn btn-primary btn-block" @click="storePembayaran(siswa.id)">
                            <span v-if="simpanBtn">
                                <span v-if="simpanBtn" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Proses...
                            </span>
                            <span v-else>
                                Bayar
                            </span>
                        </button> --}}
                        {{-- <a href="{{ route('u.invoice', @{{metode}}) }}" type="button" class="btn btn-primary btn-block"> --}}
                        <a :href="'../invoice?metode=' + metode" type="button" class="btn btn-primary btn-block">
                            <span v-if="simpanBtn">
                                <span v-if="simpanBtn" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Proses...
                            </span>
                            <span v-else>
                                Bayar
                            </span>
                        </a>
                </div>
                </div>
            </div>
            </div>
        </div>
        </transition>
    </div>

    <div v-if="showModalAngsuran">
        <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-light text-dark shadow">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Masukkan Jumlah Yang akan Dibayar :</label>
                                <input type="number" min="1" :max="tmp.harga" v-model="tmp.harga" class="form-control" name="" id="" :autofocus="true">
                                <div v-if="showError">
                                    <span class="text-danger small">@{{msgError}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger mt-2 btn-block" @click="showModalAngsuran = false">Close</button>
                            <button type="button" class="btn btn-primary btn-block" @click="bayarAngsuranSubmit">
                                <span v-if="simpanBtn">
                                    <span v-if="simpanBtn" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Proses...
                                </span>
                                <span v-else>
                                    Bayar
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </transition>
    </div>

    
</section>
@endsection

@section('scripts')
<script src="{{asset('js/userPembayaran.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#siswa_id').select2()
        $('#bulan').select2()
        // $('#buku_id').select2()
    });

</script>

@if(session()->has('success'))
    <script>
        $(document).ready(function () {
            // toastr["success"]('{{ session()->get('success') }}')
            iziToast.success({
                title: '',
                message: '{{ session()->get('success') }}',
                position: 'bottomCenter'
            });
        });

    </script>
@endif
@endsection
