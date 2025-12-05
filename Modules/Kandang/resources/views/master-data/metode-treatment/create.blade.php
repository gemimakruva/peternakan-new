@extends('adminlte::page')

@section('title', 'Metode Treatment')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Form Metode Treatment</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk menambah Metode Treatment untuk Peternakan
    </span>
</div>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4" style="max-width: 1200px">
    <div class="row justify-content-center">
        {{-- Form Content --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('master-data.metode-treatment.store') }}"
                          method="post" id="form-metode-treatment">
                        @csrf
                     {{-- Nama Metode Treatment --}}
                    <div class="mb-3">
                        <x-adminlte-input
                            name="nama"
                            label="Metode Treatment"
                            type="text"
                            igroup-size="md"
                            value="{{ old('nama', @$data->nama) }}"
                            placeholder="Masukkan metode treatment"
                            required>

                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="bi bi-activity text-muted"></i>
                                </div>
                            </x-slot>

                        </x-adminlte-input>
                    </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end" style="gap: 1rem; margin-top: 1.5rem;">
                            <a href="{{ route('master-data.metode-treatment.index') }}"
                               class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            <button type="submit"
                                class="btn btn-success px-4 py-2 shadow-sm"
                                style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-save me-2"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
