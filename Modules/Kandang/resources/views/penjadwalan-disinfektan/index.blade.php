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
    <x-form-alert />
    <div class="card" style="max-width:1200px">
        <div class="card-header">
            <h3 class="card-title">Filter Data Pencatatan</h3>
        </div>

        <div class="card-body">
            <form action="" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4 col-5">
                    <label class="form-label">Range Tanggal</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-5">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-control">
                        <option selected disabled>Pilih Kandang...</option>
                        @foreach ($kandang as $item)
                            <option value="{{ $item->id }}" {{ $item->id == request('kandang_id') ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('penjadwalan-disinfektan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3" style="max-width:1200px">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center" style="background-color: #495057; border-color: #495057; color: white;">
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:20%">Tanggal</th>
                        <th style="width:15%">Kandang</th>
                        <th style="width:17%">Waktu Treatment</th>
                        <th style="width:28%">Data Kebutuhan Disinfektan per Flock</th>
                        <th style="width:15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)
                        ->translatedFormat('l, d F Y') }}</td>
                                    <td>{{ $item->kandang->nama ?? '-' }}</td>
                                    <td>{{ $item->detail_waktu }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm btn-detail" data-id="{{ $item->id }}">
                                            <i class="fa fa-eye"></i> Detail
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('penjadwalan-disinfektan.edit', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i> Edit
                                        </a>
                                        <form action="{{ route('penjadwalan-disinfektan.destroy', $item->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">
                                Belum ada data penjadwalan disinfektan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Data Kebutuhan Disinfektan per Flock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row col-5">
                        <div class="mb-4">
                            <label class="form-label">Tanggal Penjadwalan Disinfektan Kandang</label>
                            <div><span id="tanggal"></span></div>
                        </div>
                    </div>
                    <div class="row col-5">
                        <div class="mb-4">
                            <label class="form-label">Kandang</label>
                            <div><span id="kandang"></span></div>
                        </div>
                    </div>
                    <div class="row col-5">
                        <div class="mb-4">
                            <label class="form-label">Waktu Disinfektan</label>
                            <div><span id="waktu"></span></div>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped" id="detailModalTable">
                        <thead>
                            <tr>
                                <th>Flock</th>
                                <th>Area</th>
                                <th>Jenis Disinfektan</th>
                                <th>Merk Disinfektan</th>
                                <th>Dosis Per Tangki(gram/ml)</th>
                            </tr>
                        </thead>
                        <tbody id="detail-table-body">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
    </div>
@endsection
@push('js')
    <script>
        function formatTanggalIndo(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }
        $(document).ready(function () {
            // Set CSRF header for POST/DELETE if needed
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Click handler
            $(document).on('click', '.btn-detail', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                if (!id) return;

                // reset modal UI
                $('#detailModalError').hide().text('');
                $('#detailModalContent').hide();
                $('#detailModalLoading').show();

                // show modal immediately
                $('#detailModal').modal('show');

                // request URL — adjust route name or path
                const url = `/penjadwalan-disinfektan/${id}/detail`; // contoh endpoint

                $.get(url)
                    .done(function (res) {
                        // expected JSON: { success: true, data: [...] }
                        if (!res || !res.success) {
                            $('#detailModalError').text(res?.message || 'Failed to load data').show();
                            return;
                        }

                        const rows = res.data.penjadwalan_flocks || [];

                        // clear tbody
                        const $tbody = $('#detailModalTable tbody').empty();

                        $('#tanggal').text(formatTanggalIndo(res.data.tanggal));
                        $('#kandang').text(res.data.kandang.nama);
                        $('#waktu').text(res.data.detail_waktu);

                        if (rows.length === 0) {
                            $tbody.append('<tr><td colspan="3" class="text-center">No data</td></tr>');
                        } else {
                            rows.forEach(function (r) {
                                $tbody.append(
                                    `<tr>
                                    <td>${escapeHtml(r.flock.nama ?? '')}</td>
                                    <td>${escapeHtml(r.area ?? '')}</td>
                                    <td>${escapeHtml(r.jenis_disinfektan.nama ?? '')}</td>
                                    <td>${escapeHtml(r.merk_disinfektan ?? '')}</td>
                                    <td>${escapeHtml(r.dosis_per_tangki ?? '')}</td>
                                </tr>`
                                );
                            });
                        }

                        $('#detailModalLoading').hide();
                        $('#detailModalContent').show();
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        const msg = jqXHR.responseJSON?.message || errorThrown || 'Terjadi kesalahan saat mengambil data';
                        $('#detailModalLoading').hide();
                        $('#detailModalError').text(msg).show();
                    });
            });

            // small helper to avoid XSS
            function escapeHtml(unsafe) {
                return String(unsafe)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }
        });
    </script>
@endpush