@extends('adminlte::page')

@section('title', 'Transaksi Ayam Afkir')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">Rekapan Perhitungan Pakan</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk menampilkan daftar pembelian ayam afkir
    </span>
</div>
@endsection
@section('content')
<div class="card" style="max-width: 1200px;">
    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="background-color: #495057; border-color: #495057;">
        <h2 class="card-title mb-0 text-center">Rekapan Pemberian Pakan</h2>
    </div>

    {{-- FILTER DIBAWAH HEADER --}}
    <div class="card-body mb-10">
        <form action="{{ route('perhitungan-pakan.index') }}" 
              method="GET" class="row g-3 pb-3 px-4 align-items-end">

            <div class="col-md-3 col-6">
                <label class="form-label fw-semibold">Tanggal Pemberian Pakan</label>
                <div class="input-group">
                    <select name="tanggal" id="tanggal_pemberian_pakan" class="form-control">
                        <option value="">-- Pilih Tanggal --</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">Kandang</label>
                <select id="kandang_id" name="kandang" class="form-control">
                    <option value="">-- Pilih Kandang --</option>
                </select>
            </div>

            <div class="col-md-3 col-6">
                <label class="form-label fw-semibold">Flock</label>
                <select id="flock_id" name="flock" class="form-control">
                    <option value="">-- Pilih Flock --</option>
                </select>
            </div>

            <div class="col-md-2 col-6">
                <label class="form-label fw-semibold">Jenis Pakan</label>
                <select name="jenis_pakan" class="form-control">
                    <option value="">-- Semua Jenis --</option>
                    @foreach($jenisPakanList as $jenis)
                        <option value="{{ $jenis->nama }}" 
                            {{ request('jenis_pakan') == $jenis->nama ? 'selected' : '' }}>
                            {{ $jenis->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1 col-6 d-flex justify-content-center">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    
    {{-- TABEL DATA PEMBERIAN PAKAN --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle table-auto" style="white-space: nowrap;">
                <thead style="background-color: #495057; border-color: #495057;" class="table-light text-center text-white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kandang</th>
                        <th>Flock</th>
                        <th>Pipa</th>
                        <th>Jumlah Ayam</th>
                        <th>Estimasi Pemberian Per Ekor (gram)</th>
                        <th>Jenis Pakan</th>
                        <th>Pemberian Per Pipa</th>
                        <th>Persentase Pagi (%)</th>
                        <th>Persentase Sore (%)</th>
                        <th>Pagi (%)</th>
                        <th>Sore (%)</th>
                        <th>Sisa Pakan Per Flock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perhitunganPakan as $pp)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($pp->tanggal_pemberian_pakan)->translatedFormat('d F Y') }}</td>
                            <td>{{ $pp->pipe->flock->kandang->nama }}</td>
                            <td>{{ $pp->pipe->flock->nama }}</td>
                            <td>{{ $pp->pipe->nama ?? '-' }}</td>
                            <td>{{ $pp->jumlah_ayam_per_pipe }}</td>
                            <td>{{ $pp->jumlah_pakan_per_ekor_gram }}</td>
                            <td>{{ $pp->jenis_pakan->nama ?? '-' }}</td>
                            <td>{{ $pp->jumlah_ayam_per_pipe * $pp->jumlah_pakan_per_ekor_gram / 1000 }} kg</td>
                            <td>{{ $pp->proporsi_pemberian_pagi }}%</td>
                            <td>{{ $pp->proporsi_pemberian_sore }}%</td>
                            <td>{{ number_format($pp->proporsi_pemberian_pagi) }} %</td>
                            <td>{{ number_format($pp->proporsi_pemberian_sore) }} %</td>
                            @php
                                $sisaPakanRelasi = $pp->pipe->flock->pemberianPakanSisaPakan;
                                $sisaPakanPerFlock = $sisaPakanRelasi->sum(function($item) {
                                    return $item->pemberian_pakan_flock_kg - $item->sisa_pakan_per_flock_kg;
                                });
                            @endphp
                            <td>{{ $sisaPakanPerFlock }} kg</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
          <div class="card-footer d-flex justify-content-end">
            {{ $perhitunganPakan->links('components.pagination') }}
        </div>
    </div>

    {{-- TABEL DATA KANDANG --}}
    <div class="card mt-4">
        <div class="card-header" style="background-color: #495057; border-color: #495057; color: white;">
            Data Kandang
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kandang</th>
                    <th>Jumlah Ayam</th>
                    <th>Estimasi Pemberian Pakan (kg)</th>
                    <th>Pemberian per Pipa (kg)</th>
                    <th>Pagi %</th>
                    <th>Sore %</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataKandang as $kandang)
                    <tr>
                        <td>{{ $kandang['kandang_nama'] }}</td>
                        <td>{{ $kandang['total_ayam'] }}</td>
                        <td>{{ number_format($kandang['estimasi_pakan_per_ekor'], 2) }}</td>
                        <td>{{ number_format($kandang['estimasi_pakan_per_pipe'], 2) }}</td>
                        <td>{{ number_format($kandang['pemberian_pagi'], 2) }}%</td>
                        <td>{{ number_format($kandang['pemberian_sore'], 2) }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    function loadTanggalPakan(query = '') {
        $.ajax({
            url: "{{ route('ajax.tanggal-perhitungan') }}",
            type: "GET",
            data: { q: query },
            dataType: "json",
            success: function(response) {
                let select = $('#tanggal_pemberian_pakan');
                select.empty();
                select.append('<option value="">-- Pilih Tanggal --</option>');

                $.each(response.results, function(index, item) {

                    let parts = item.text.split('-');
                    let dateObj = new Date(parts[2], parts[1]-1, parts[0]);
                    let formattedDate = dateObj.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });

                    select.append('<option value="' + item.id + '">' + formattedDate + '</option>');
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }    
    loadTanggalPakan();
});

</script>
@endpush