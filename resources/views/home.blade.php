@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    @role('siswa')
        @include('layouts/partials/userHome')
    @else
        @include('layouts/partials/adminHome')
    @endrole
    
</section>
@endsection
