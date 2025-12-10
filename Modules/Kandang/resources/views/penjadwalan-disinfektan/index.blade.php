@extends('adminlte::page')

@section('title', 'Penjadwalan Disinfektan')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">List Penjadwalan Disinfektan</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk Menampilkan daftar Penjadwalan Disinfektan
        </span>
    </div>
@endsection


@section('content')
    <div>
        <div>
            <x-form-alert />
            <div style="max-width: 1200px" class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between
             align-items-center" style="background-color: #495057; border-color: #495057;">
                    <form action="{{ route('penjadwalan-disinfektan.index', request()->all()) }}" method="get"
                        class="w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">Penjadwalan Disinfektan</h2>
                            <div class="d-flex" style="gap: .5em">
                                <input type="search" name="search" class="form-control form-control-sm"
                                    placeholder="Kandang atau Flock" value="{{ request()->query('search') }}">

                                <button class="btn btn-dark btn-sm" title="Cari">
                                    <i class="fas fa-search"></i>
                                </button>

                                @can('Tambah Penjadwalan Disinfektan')
                                    <a href="{{ route('penjadwalan-disinfektan.create') }}"
                                        class="btn btn-light btn-sm text-dark" title="Tambah Penjadwalan Disinfektan">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endcan

                            </div>

                        </div>

                    </form>
                </div>


                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped table-bordered 
                text-center mb-0">

                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush