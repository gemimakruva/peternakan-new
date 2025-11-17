@extends('adminlte::page')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
    <h1 class="text-lg font-semibold text-gray-700">Pencatatan Ayam Masuk ke Kandang</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Data Pencatatan</h3>
    </div>

    <div class="card-body">
        <form action="" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tanggal Pencatatan</label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-control">
            </div>


            <div class="col-md-3">
                <label class="form-label">Dicatat Oleh</label>
                <input type="text" name="recorded_by" value="{{ request('recorded_by') }}" class="form-control" placeholder="Nama Pencatat">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Data Pencatatan Ayam Masuk</h3>
    </div>

    <div class="card-body table-responsive">
    <table class="table table-bordered table-striped align-middle">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Kandang</th>
            <th>Nama Flock</th>
            <th>Pipe</th>
            <th>Umur Ayam (Minggu)</th>
            <th>Jumlah Datang</th>
            <th>Kondisi Ayam</th>
            <th>Ayam Masuk</th>
            <th>Ayam Mati</th>
            <th>Ayam Afkir</th>
            <th>Ayam Sakit</th>
            <th>Dokumen Name</th>
            <th>Dokumen Supplier</th>
            <th>Foto Dokumentasi</th>
            <th>Catatan</th>
            <th>Dicatat Oleh</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($logs as $index => $log)
            <tr class="text-center">
                <td>{{ $logs->firstItem() + $index }}</td>
                <td>{{ \Carbon\Carbon::parse($log->log_date)->format('d-m-Y') }}</td>
                <td style="min-width: 180px;">{{ $log->pipe->flock->kandang->nama ?? '-' }}</td>
                <td style="min-width: 180px;">{{ $log->pipe->flock->flock_name ?? '-' }}</td>
                <td style="min-width: 180px;">{{ $log->pipe->pipe_name ?? '-' }}</td>
                <td>{{ $log->bird_age ?? 0 }}</td>
                <td>{{ $log->total_chicken ?? 0 }}</td>
                <td>{{ $log->bird_condition ?? '-' }}</td>
                <td>{{ $log->chicken_in ?? 0 }}</td>
                <td>{{ $log->died_chicken ?? 0 }}</td>
                <td>{{ $log->culled_chicken ?? 0 }}</td>
                <td>{{ $log->sick_chicken ?? 0 }}</td>
                <td>{{ $log->document_name ?? '-' }}</td>

                {{-- Dokumen Supplier --}}
                <td>
                    @if ($log->supplier_document)
                        <a href="{{ asset('storage/' . $log->supplier_document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-file-alt"></i> Lihat Dokumen
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                {{-- Foto Dokumentasi --}}
                <td>
                @if ($log->documentation_photo)
                    <a href="{{ asset('storage/' . $log->documentation_photo) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-card-image"></i> Lihat Foto
                    </a>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td>
                @if ($log->notes)
                    <button class="btn btn-sm btn-info show-notes" data-notes="{{ $log->notes }}">
                        <i class="fas fa-sticky-note"></i> Lihat Catatan
                    </button>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

                <td>{{ $log->recordedBy->name ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="17" class="text-center text-muted">Belum ada data pencatatan ayam masuk.</td>
            </tr>
        @endforelse
    </tbody>
</table>


        {{-- Pagination --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.show-notes');
    
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const notes = this.dataset.notes;
            
            Swal.fire({
                title: 'Catatan Lapangan',
                html: `<p style="text-align:left;">${notes}</p>`,
                icon: 'info',
                confirmButtonText: 'Tutup'
            });
        });
    });
});
</script>

@stop
