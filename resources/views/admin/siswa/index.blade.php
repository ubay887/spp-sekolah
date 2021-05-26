@extends('layouts.master')

@section('content')
<section class="section">
    <!-- Content Header (Page header) -->
    <section class="section-header ">
        <h1>Manajemen Siswa</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Siswa</div>
        </div>
    </section>

    <!-- Main content -->
    <section class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="mycard-collapse" style="">
                        <div class="card-body">
                            <form action="" action="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin</label>
                                        <select name="jk" id="jk" class="form-control @error('jk') is-invalid @enderror">
                                            <option value="">-Pilih Semua-</option>
                                            <option value="male" {{ ('male' === request()->jk) ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="female" {{ ('female' === request()->jk) ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jk')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="">-Pilih Semua-</option>
                                            <option value="Aktif" {{ ('Aktif' === request()->status) ? 'selected' : '' }}>Aktif</option>
                                            <option value="Lulus" {{ ('Lulus' === request()->status) ? 'selected' : '' }}>Lulus</option>
                                            <option value="Pindah" {{ ('Pindah' === request()->status) ? 'selected' : '' }}>Pindah</option>
                                            <option value="Dikeluarkan" {{ ('Dikeluarkan' === request()->status) ? 'selected' : '' }}>Dikeluarkan</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kelas_id">Kelas</label>
                                        <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                                            <option value="">-Pilih Semua-</option>
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
                                    <div class="text-right">
                                        <button class="btn btn-primary ">Filter</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                            {{-- /.row --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header iseng-sticky bg-white">
                        <h4>Data Siswa</h4>
                        <div class="card-header-action">
                            <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-icon"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Tambah Data">
                                <i class="fas fa-plus-circle px-2    "></i>
                            </a>
                            <a href="#" class="btn btn-secondary btn-icon ml-2" onclick="handleImport()"
                                title="Import File" data-toggle="tooltip" data-placement="top"
                                data-original-title="Import Data Siswa">
                                <i class="fas fa-file-import px-2   "></i>
                            </a>
                            <a href="{{ route('siswa.pdf') }}" target="blank"
                                class="btn btn-secondary btn-icon ml-2" title="Cetak PDF" data-toggle="tooltip"
                                data-placement="top" data-original-title="Cetak PDF">
                                <i class="fas fa-file-pdf  px-2  "></i>
                            </a>

                            <a href="{{ route('siswa.excel') }}" target="_blank"
                                class="btn btn-secondary btn-icon ml-2" title="Export Excel" data-toggle="tooltip"
                                data-placement="top" data-original-title="Export Excel">
                                <i class="fas fa-file-excel  px-2  "></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        
                        <form action="{{ route('siswa.index') }}" method="GET">
                            {{-- @csrf --}}
                            <div class="input-group input-group mb-3 float-right" style="width: 300px;">
                                <input type="text" name="keyword" class="form-control float-right"
                                placeholder="Search" value="{{request()->query('keyword')}}">
    
                                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-light"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="input-group-append">
                                    <a href="{{ route('siswa.index') }}" title="Refresh" class="btn btn-light"><i class="fas fa-circle-notch mt-2    "></i></a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-head-fixed text-nowrap table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nis Nama</th>
                                        <th>Tgl.Lahir</th>
                                        <th>JK</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswa as $row)
                                        <tr>
                                            <td style="width: 20px">
                                                <div class="btn-group">
                                                    <button type="button" class="btn" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v    "></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('siswa.edit', $row->id) }}">
                                                                <i class="fas fa-edit    "></i>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="handleDelete ({{ $row->id }})">
                                                                <i class="fas fa-trash    "></i>
                                                                Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td style="width: 50px">{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                                            <td class="text-center">
                                                <a href="{{ asset('/img/siswa').'/'.$row->foto }}"
                                                    data-fancybox data-caption="{{ $row->nama_lengkap }}">
                                                    <img width="64px" height="64px" class="my-2 rounded-circle shadow"
                                                        src="{{ asset('/img/siswa').'/'. $row->foto }}"
                                                        alt="">
                                                </a>    
                                            </td>
                                            <td>
                                                
                                                <a href="{{ route('siswa.show', $row->id )}}" class="text-dark">
                                                    {{ $row->nis }} <br>
                                                    {{ $row->nama_lengkap }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ date_format(date_create($row->tanggal_lahir),"d-m-Y") }}</td>
                                            <td class="text-center">{{ $row->jk }}</td>
                                            <td>{{ (!empty($row->kelas->nama_kelas)) ? $row->kelas->nama_kelas : '' }}</td>
                                            <td>
                                                {{$row->status}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Data Tidak Ada</td>
                                        </tr>
                                    @endforelse
    
                                </tbody>
                            </table>
                            {{ $siswa->appends([
                                'keyword' => request()->query('keyword'), 
                                'kelas_id' => request()->query('kelas_id'),
                                'jk' => request()->query('jk'),
                                'status' => request()->query('status'),
                            ])->links() }}
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <span class="text-sm float-right">Total Entries : {{$siswa->total()}}</span>
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
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mt-3">Apakah kamu yakin menghapus Data Siswa ?</p>
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


<!-- Modal Import File-->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Import Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('siswa.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="import_siswa">Import File</label>
                        <input type="file" class="form-control-file" name="import_siswa" id="import_siswa"
                            placeholder="" aria-describedby="fileHelpId" required>
                        @error('import_siswa')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small id="fileHelpId" class="form-text text-muted">Tipe file : xls, xlsx</small>
                        <small id="fileHelpId" class="form-text text-muted">Pastikan file upload sesuai format. <br> <a
                                href="{{ url('template/contoh_format_import_siswa.xlsx') }}">Download
                                contoh format file xlsx <i class="fas fa-download ml-1   "></i></a></small>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleDelete(id) {
        let form = document.getElementById('deleteForm')
        form.action = `./siswa/${id}`
        console.log(form)
        $('#deleteModal').modal('show')
    }

    function handleImport(e) {
        // e.preventDefault()
        $('#importModal').modal('show')
    }

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

@error('import_siswa')
    <script>
        $(document).ready(function () {
            // toastr["info"]('{{ session()->get('error') }}')
            iziToast.error({
                title: '',
                message: 'Import Data Siswa Gagal!',
                position: 'bottomCenter'
            });
        });
    </script>
@enderror

@if(session()->has('error'))
    <script>
        $(document).ready(function () {
            // toastr["info"]('{{ session()->get('error') }}')
            iziToast.info({
                title: '',
                message: '{{ session()->get('error') }}',
                position: 'bottomCenter'
            });
        });

    </script>
@endif

@endsection
