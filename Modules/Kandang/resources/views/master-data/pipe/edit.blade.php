@extends('adminlte::page')

@section('title', 'Edit Pipe')

@section('content_header')
    <h1 class="fw-bold text-dark">Edit Pipe</h1>
@endsection

@section('content')
<div class="card shadow-sm border-0">

    {{-- ===========================
        Body Card
        Menampilkan form edit data Pipe
    ============================ --}}
    <div class="card-body">

        <form action="{{ route('master-data.pipe.update', $pipe) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ===========================
                Field: Nama Flock (readonly)
                Menampilkan flock yang terkait dengan pipe ini
            ============================ --}}
            <div class="form-group mb-4">
                <label for="flock_name" class="font-weight-bold text-secondary">
                    Nama Flock (Terkait)
                </label>

                <input 
                    type="text"
                    id="flock_name"
                    class="form-control border-0 text-white"
                    style="background-color: #343a40; opacity: 0.9;"
                    value="{{ $pipe->flock->flock_name ?? '-' }}"
                    readonly
                >
            </div>

            {{-- ===========================
                Field: Nama Pipe
                Input utama untuk memperbarui nama pipe
            ============================ --}}
            <div class="form-group mb-4">
                <label for="pipe_name" class="font-weight-bold">Nama Pipe</label>

                <input 
                    type="text"
                    name="pipe_name"
                    id="pipe_name"
                    class="form-control"
                    value="{{ old('pipe_name', $pipe->pipe_name) }}"
                    placeholder="Masukkan nama pipe..."
                >
            </div>

            {{-- ===========================
                Field: Kapasitas Pipe
                Menentukan jumlah kapasitas pipe
            ============================ --}}
            <div class="form-group mb-4">
                <label for="capacity" class="font-weight-bold">Kapasitas</label>

                <input 
                    type="number"
                    name="capacity"
                    id="capacity"
                    class="form-control"
                    value="{{ old('capacity', $pipe->capacity) }}"
                    placeholder="Masukkan kapasitas..."
                >
            </div>

            {{-- ===========================
                Tombol Aksi
                Navigasi kembali & submit data
            ============================ --}}
            <div class="d-flex justify-content-end">
                <a 
                    href="{{ route('master-data.pipe.index') }}" 
                    class="btn btn-secondary mr-2"
                >
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
