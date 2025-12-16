@extends('adminlte::page')

@section('title', 'Pencatatan OVK & Pakan')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">List request OVK</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk menampilkan data request pemesanan OVK
        </span>
    </div>
@endsection

@section('content')
    <x-form-alert />

    {{-- Filter --}}
    <div class="card" style="max-width:1200px">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <form action={{ route("order-ovk.index") }} method="GET" class="row g-2 align-items-end">
                <div class="col-md-4 col-6">
                    <label class="form-label">Range Tanggal</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" name="start_date"
                                value="{{ request('start_date') }}"
                                class="form-control">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date"
                                value="{{ request('end_date') }}"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-4">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-control">
                        <option value="">Semua Kandang</option>
                        @foreach ($kandang as $item)
                            <option value="{{ $item->id }}"
                                {{ request('kandang_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('order-ovk.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
   

    {{-- Table --}}
    <div class="card mt-3" style="max-width:1200px">
        <div class="card-body table-responsive">
           <table class="table table-bordered table-striped align-middle">
                <thead class="text-center bg-dark text-white">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Tanggal Pengecekan</th>
                        <th>Kandang</th>
                        <th>Jenis OVK</th>
                        <th>Merk OVK</th>
                        <th>Kemasan OVK</th>
                        <th>Total Kebutuhan (Order)</th>
                        <th>Maksimal Kedatangan</th>
                        <th style="width:20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse(
                                    $item->tanggal_pengecekan)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $item->kandang->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $item->jenis_ovk ?? '-' }}
                            </td>

                            <td>
                                {{ $item->merk_ovk ?? '-' }}
                            </td>

                            <td>
                                {{ $item->kemasan_ovk ?? '-' }}
                            </td>

                            <td>
                                {{ number_format($item->total_kebutuhan_yang_diorder ?? 0) }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::
                                parse($item->maksimal_kedatangan)->format('d-m-Y') }}
                            </td>

                            <td>
                                <a href="{{ route('order-ovk.edit', $item->id) }}" 
                                class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                               <form action="{{ route('order-ovk.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-sm btn-danger btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Data belum tersedia
                        </td>
                    </tr>
    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    @push('js')
        
<script>
$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();

    const form = $(this).closest('.delete-form');

    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    });
});
</script>
    @endpush

@endsection
