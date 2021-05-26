@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Kenaikan Kelas</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Kenaikan Kelas</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <h4>Kelas</h4>
                        <div class="card-header-action">
                            <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Tambah Data">
                                <i class="fas fa-plus-circle px-2    "></i>
                            </a>
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <form action="{{ route('kenaikanKelas.index') }}" method="get">
                                    <div class="form-group">
                                        <label for="kelas_id">Pilih Kelas</label>
                                        <select v-model="kelas_id" name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                                            <option value="">-Pilih Kelas-</option>
                                            @foreach ($kelas as $item)
                                            <option value="{{ $item->id  }}"
                                                    @if ($item->id == request()->kelas_id)
                                                        selected
                                                    @endif    
                                                >
                                                
                                                {{ $item->nama_kelas }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('kelas_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>                                
                            </div>
                        </div>
                        <!-- /.row -->   
                        @if ($siswa)
                        <form action="{{ route('kenaikanKelas.proses')}}" action="get">
                        <div class="row">
                            <div class="col-md-9">
                                {{-- <div class="form-group"> --}}
                                        
                                <div class="custom-control custom-checkbox py-3">
                                    <input type="checkbox" 
                                    name="pilih_semua" 
                                    value="semua" 
                                    class="custom-control-input" 
                                    id="one"
                                    >
                                    <label class="custom-control-label" for="one">Pilih Semua</label>
                                </div>
                                @error('siswa_id')
                                    <div class="text-danger small mb-4">Pilih Salah Satu Siswa/i</div>
                                @enderror
                                <div class="form-group">
                                    {{-- <label class="form-label">Image Check</label> --}}
                                    <div class="row gutters-sm">
                                        @foreach ($siswa as $row)
                                            <div class="col-6 col-sm-4 col-md-2" >
                                                <label class="imagecheck mb-4">
                                                <input name="siswa_id[]" type="checkbox" value="{{$row->id}}" class="imagecheck-input"
                                                {{(is_array(old('siswa_id')) && in_array($row->id, old('siswa_id'))) ? 'checked' : ''}}
                                                >
                                                <figure class="imagecheck-figure">
                                                    <img height="120" width="120px" src="{{ asset('/img/siswa/').'/'.$row->foto }}" alt="" class="imagecheck-image">
                                                </figure>
                                                <span class="small">
                                                    <strong>{{ $row->nama_lengkap }}</strong><br>
                                                    {{ $row->nis }} <br>
                                                    {{ $row->kelas->nama_kelas }}
                                                </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- </div> --}}

                            </div>
                            <div class="col-md-3">
                                <div class="pembayaranDetail">
                                    <div class="form-group ">
                                        <label for="kelas_id">Pindah Ke Kelas</label>
                                        <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                            <option value="">-Pilih Kelas-</option>
                                            @foreach ($kelas as $item)
                                            <option value="{{ $item->id  }}"
                                                    @if ($item->id == old('kelas_id'))
                                                        selected
                                                    @endif    
                                                >
                                                
                                                {{ $item->nama_kelas }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('kelas_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block mb-3">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            {{-- /.col-md --}}
                        </div>
                        </form>
                        @else 
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <img class="w-75" style="opacity: 0.3" src="{{ asset('/img/undraw_true_friends_c94g.png')}}" alt="">
                            </div>
                        </div>
                        @endif
                    </div> 
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
    <!-- /.content -->
</section>

<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mt-3">Apakah kamu yakin menghapus Data Kelas ?</p>
            </div>
            <div class="modal-footer">
                <form action="" method="POST" id="deleteForm">
                    @method('DELETE')
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak, Kembali</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- <script src="{{asset('js/pindahKelas.js')}}"></script> --}}
<script>
    function handleDelete(id) {
        let form = document.getElementById('deleteForm')
        form.action = `./kelas/${id}`
        console.log(form)
        $('#deleteModal').modal('show')
    }
    $(document).ready(function () {
        $("#one").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#kelas_id").change(function(){
            filter();
        });
        // $("#keyword").keypress(function(event){
        //     if(event.keyCode == 13){ // 13 adalah kode enter
        //         filter();
        //     }
        // });
        var filter = function(){
            var kelas_id = $("#kelas_id").val();
            // var keyword = $("#keyword").val();
            window.location.replace(`./kenaikanKelas?kelas_id=${kelas_id}`);
        }
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

@if(session()->has('error'))
    <script>
        $(document).ready(function () {
            // toastr["info"]('{{ session()->get('error') }}')
            iziToast.info({
                title: '',
                message: '{{ session()->get('success') }}',
                position: 'bottomCenter'
            });
        });

    </script>
@endif

@endsection
