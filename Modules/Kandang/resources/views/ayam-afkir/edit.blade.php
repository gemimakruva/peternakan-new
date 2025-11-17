@extends('adminlte::page')

@section('title', 'Edit Transaksi Ayam Afkir')

{{-- ==========================================================
    PAGE HEADER  
    Displays the title and short description for the form.
========================================================== --}}
@section('content_header')
    <div class="mb-4 text-center">
        <h1 class="h4 fw-bold text-dark mb-1">Edit Transaksi Ayam Afkir</h1>
        <p class="text-muted">
            Perbarui data Transaksi Ayam Afkir di bawah ini
        </p>
    </div>
@stop


@section('content')
<div class="row">

    {{-- ==========================================================
        LEFT SECTION (MAIN EDIT FORM)
        Contains the editable form for updating transaction data.
    =========================================================== --}}
    <div class="col-12 col-md-8 mb-4">

        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- ==================================================
                    EDIT FORM  
                    This form updates existing data using PUT method.
                    The form fields are loaded from a shared partial.
                =================================================== --}}
                <form 
                    action="" 
                    method="POST"
                    id="form-afkir">

                    @csrf
                    @method('PUT')

                    {{-- Load reusable form fields --}}
                    @include('kandang::ayam-afkir._form')

                    {{-- ACTION BUTTONS --}}
                    <div class="mt-4 d-flex justify-content-between px-3">

                        {{-- Back Button --}}
                        <a href="{{ route('ayam-afkir.index') }}" 
                           class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Update
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>



    {{-- ==========================================================
        RIGHT SECTION (HELP INFORMATION)
        Displays guidance and tips for editing data.
    =========================================================== --}}
    <div class="col-12 col-md-4">

        <div class="card border-0 shadow-sm">

            {{-- Info Section Header --}}
            <div class="card-header bg-light">
                <h5 class="m-0 fw-semibold text-secondary">
                    <i class="fas fa-info-circle me-2"></i> Informasi Edit
                </h5>
            </div>

            {{-- Info Content --}}
            <div class="card-body">

                {{-- Short instructions --}}
                <p class="text-muted mb-3">
                    Anda sedang mengedit data transaksi. Pastikan perubahan yang Anda masukkan sudah benar.
                </p>

                {{-- Important tips --}}
                <ul class="small text-muted ps-3">
                    <li>Periksa ulang tanggal afkir</li>
                    <li>Pastikan Kandang, Flock, dan Pipe sesuai</li>
                    <li>Update jumlah ayam afkir jika diperlukan</li>
                    <li>Harga per kg sesuai catatan terakhir</li>
                </ul>

                <hr>

                {{-- Additional Notice --}}
                <p class="text-muted small">
                    Jika terjadi kesalahan pada relasi data (Kandang / Flock / Pipe), pastikan datanya sudah terdaftar.
                </p>

            </div>

        </div>

    </div>

</div>
@endsection
