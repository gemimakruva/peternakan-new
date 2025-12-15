@extends('adminlte::page')

@section('title', 'Penjadwalan Disinfektan')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">List Penjadwalan Treatment</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk menampilkan penjadwalan treatment
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
                            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                            class="form-control">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                            class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-5">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-control">
                        <option selected disabled>Pilih Kandang...</option>
                        @foreach ($kandang as $item)
                            <option value="{{ $item->id }}"
                                 {{ $item->id == request('kandang_id') ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('penjadwalan-treatment.index') }}" class="btn btn-secondary">
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
                    <th style="width:20%">Kandang</th>
                    <th style="width:20%">PIC</th>
                    <th style="width:20%">Waktu Treatment</th>
                    <th style="width:30%">Data Kebutuhan Treatment</th>
                    <th style="width:15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kandang->nama ?? '-' }}</td>
                        <td>{{ $item->picUser->name ?? '-' }}</td>
                        <td>
                         {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')
                         ->isoFormat('D MMMM YYYY') }}
                            <small class="text-muted">{{ $item->detail_waktu }}</small>
                        </td>
                       <td class="d-flex justify-content-center align-items-center">
                            <button type="button" 
                                class="btn btn-primary btn-sm btn-detail"
                                data-id="{{ $item->id }}"
                                data-kandang="{{ $item->kandang->nama }}"
                                data-flock={{ $item->treatmentFlocks }}
                                data-pic="{{ $item->picUser->name }}"
                                data-tanggal="{{ $item->tanggal }}"
                                data-waktu="{{ $item->detail_waktu }}"
                                data-treatment='@json($item->treatmentFlocks)'
                                data-toggle="modal" 
                                data-target="#exampleModal">
                                Detail
                            </button>
                        </td>

                    <td class="text-center">
                            <div class="btn-group" role="group">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('penjadwalan-treatment.edit', $item->id) }}" 
                                    class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('penjadwalan-treatment.destroy', $item->id) }}" 
                                        method="POST" 
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm" 
                                                title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    </div>

    {{-- ================== Model detail data =====exampleModal================== --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Penjadwalan Treatment</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p><strong>Kandang:</strong> <span id="modal_kandang"></span></p>
                <p><strong>PIC:</strong> <span id="modal_pic"></span></p>
                <p><strong>Tanggal:</strong> <span id="modal_tanggal"></span></p>
                <p><strong>Waktu:</strong> <span id="modal_waktu"></span></p>

                <hr>
                <h6>Detail Treatment Flock</h6>
                <div id="modal_treatment_list"></div>
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
$(document).on('click', '.btn-detail', function () {
    let kandang = $(this).data('kandang');
    let pic = $(this).data('pic');
    let tanggal = $(this).data('tanggal');
    let waktu = $(this).data('waktu');
    let treatment = $(this).data('treatment');

    // isi data modal
    $('#modal_kandang').text(kandang);
    $('#modal_pic').text(pic);
    $('#modal_tanggal').text(tanggal);
    $('#modal_waktu').text(waktu);

    let html = '';

    if (!treatment || treatment.length === 0) {
        html = `<p class="text-muted">Tidak ada data treatment.</p>`;
    } else {
        html += `
            <table class="table table-bordered">
                <thead>
                    <tr style="background-color: #495057; color: white;">
                        <th>#</th>
                        <th>Baris</th>
                        <th>Jenis Treatment</th>
                        <th>Metode Pemberian</th>
                        <th>Dosis Pemberian</th>
                    </tr>
                </thead>
                <tbody>
        `;

        treatment.forEach(function(t, index) {
            html += `
                <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${t.flock.nama}</td>
                    <td>${t.jenis_treatment?.nama ?? '-'}</td>
                    <td>${t.metode_treatment?.nama ?? '-'}</td>
                    <td>${t.dosis_pemberian ?? '-'}</td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
        `;
    }

$("#modal_treatment_list").html(html);
});
 $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus permanen!",
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