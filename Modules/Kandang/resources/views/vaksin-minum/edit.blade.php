@extends('layouts.dashboard')

@section('title', 'Form Vaksin Minum')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">Form Vaksin Minum</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk input vaksin Minum
        </span>
    </div>
@endsection

@section('content')
    <div style="max-width: 1200px">
        @include('components.form-alert')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('vaksin-minum.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Form Vaksin Minum</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::vaksin-minum._form',['kandangList' => $kandangList])
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Pemberian Vaksin Minum</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::vaksin-minum._form-pemberian-vaksin-minum',['kandangList' => $kandangList])
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="{{ route('vaksin-minum.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#tanggal_vaksin_minum').on('change', function() {
                let tanggalVaksinMinum = $(this).val();
                countingAyamSehatVaksinMinum(tanggalVaksinMinum);
            });


            function countingAyamSehatVaksinMinum(tanggal = new Date().toISOString().split('T')[0]) {

                let url = '/master-data/ajax/jumlah-ayam-sehat/' + tanggal;
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        $('#jumlah-ayam-per-flock-vaksin-minum').val(Number(response.ayam_sehat));
                        
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#jumlah-ayam-per-flock-vaksin-minum').val(0);
                    }
                });
            }
        });
    </script>
@endpush