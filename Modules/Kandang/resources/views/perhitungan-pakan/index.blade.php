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
<div class="card" style="max-width: 1200px">
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
                <label class="form-label fw-semibold">Baris</label>
                <select id="flock_id" name="flock" class="form-control">
                     <option value="">-- Pilih Baris --</option>
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
    
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 align-middle table-auto" style="white-space: nowrap;">
            <thead  style="background-color: #495057; border-color: #495057;" class="table-light text-center text-white">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kandang</th>
                    <th>Baris</th>
                    <th>Pipa</th>
                    <th>Jumlah Ayam</th>
                    <th>Estimasi Pemberian Per Ekor (gram)</th>
                    <th>Jenis Pakan</th>
                    <th>Pemberian Per Pipa</th>
                    <th>Presentasi Pagi</th>
                    <th>Presentasi Sore</th>
                    <th>Pagi</th>
                    <th>Sore</th>
                    <th>Sisa Pakan Per Baris</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perhitunganPakan as $pp)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($pp->tanggal_pemberian_pakan)
                        ->translatedFormat('d F Y') }}</td>
                        <td>{{ $pp->pipe->flock->kandang->nama }}</td>
                        <td>{{ $pp->pipe->flock->nama }}</td>
                        <td>{{ $pp->pipe->nama ?? '-' }}</td>
                        <td>{{ $pp->jumlah_ayam_per_pipe }}</td>
                        <td>{{ $pp->jumlah_pakan_per_ekor_gram }}</td>
                        <td>{{ $pp->jenis_pakan->nama ?? '-' }}</td>
                        <td>{{ $pp->jumlah_ayam_per_pipe * $pp->jumlah_pakan_per_ekor_gram / 1000 }} kg</td>
                        <td>{{ $pp->proporsi_pemberian_pagi }}%</td>
                        <td>{{ $pp->proporsi_pemberian_sore }}%</td>
                        <td>
                            {{ number_format($pp->proporsi_pemberian_pagi) }} kg
                        </td>
                        <td>
                       {{ number_format($pp->proporsi_pemberian_sore) }} kg
                        <td>
                            {{-- Jumlah sisa pakan dari relasi --}}
                            {{ number_format($pp->pemberianPakanSisaPakan->sum('sisa_pakan_per_flock'), 2) ?? '0' }} kg
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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

$('#tanggal_pemberian_pakan').on('change', function() {
    let tanggalId = $(this).val();
    if (!tanggalId) return;

    $.ajax({
        url: "{{ route('ajax.show-detail-by-pipe', ['tanggalId' => 'TANGGAL_ID']) }}"
        .replace('TANGGAL_ID', tanggalId),
        type: "GET",
        dataType: "json",
         success: function(response) {
            console.log(response.results.pakanPerFlock)
                let kandangSelect = $('#kandang_id');
                kandangSelect.empty();
                kandangSelect.append('<option value="">-- Pilih Kandang --</option>');
                 if(response.results && response.results.kandang && response.results.kandang.length > 0) {
                    // load select kandang
                        $.each(response.results.kandang, function(index, kandang) {
                            kandangSelect.append('<option value="' + kandang.id + '">' +
                                 kandang.nama + '</option>');
                        });
                        // load input Flock
                        let flockSelect = $('#flock_id');
                        flockSelect.empty();
                        flockSelect.append('<option value="">-- Pilih Flock --</option>');
                        if(response.results && response.results.flock) {
                            $.each(response.results.flock, function(index, flock) {
                                flockSelect.append('<option value="' + flock.id + '">' + flock.nama + '</option>');
                            });
                        }
                        }
            },

        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});

</script>
@endpush