@extends('adminlte::page')

@section('title', 'Transaksi Ayam Karantina')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">List Ayam karantina</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk Menampilkan detail ayam karantina
    </span>
</div>
@endsection


@section('content')
<div>
    <div>
    <x-form-alert />
    <div style="max-width: 1200px" class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between
         align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.kandang.index', request()->all()) }}" 
                  method="get" 
                  class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Transaksi Ayam Afkir</h2>
                    <div class="d-flex" style="gap: .5em">
                        <input 
                            type="search" 
                            name="search" 
                            class="form-control form-control-sm" 
                            placeholder="Kandang atau Flock"
                            value="{{ request()->query('search') }}"
                        >

                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        @can('Tambah Ayam Akfir')
                        <a href="{{ route('ayam-karantina.create') }}" 
                           class="btn btn-light btn-sm text-dark" 
                           title="Tambah Transaksi">
                            <i class="fas fa-plus"></i>
                        </a>
                        @endcan

                    </div>

                </div>

            </form>
        </div>


        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                {{-- Column Headers --}}
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Tanggal Karantina</th>
                        <th>Nama Pencatat</th>
                        <th>Ayam Mati</th>
                        <th>Ayam Afkir</th>
                        <th>Pakan Diberikan (kg)</th>
                        <th>Sisa Pakan (kg)</th>
                        <th>Telur Bagus</th>
                        <th>Telur retak</th>
                         <th>Telur rusak</th>
                        <th>Pengobatan</th>
                        <th>Jumlah Ayam Diobati</th>
                        <th>Penyemprotan</th>
                        <th>Vaksin</th>
                        <th>Catatan</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
              <tbody>
                @forelse($listAyamKarantina as $item)
                <tr>
                    <td>{{ ($listAyamKarantina->currentPage() - 1) * $listAyamKarantina->perPage() + $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $item->pic_user->name ?? '-' }}</td>
                    <td>{{ $item->ayam_mati ?? 0 }}</td>
                    <td>{{ $item->ayam_afkir ?? 0 }}</td>
                    <td>{{ $item->pemberian_pakan ?? 0 }}</td>
                    <td>{{ $item->sisa_pakan ?? 0 }}</td>
                    <td>{{ $item->jumlah_telur_bagus ?? 0 }}</td>
                    <td>{{ $item->jumlah_telur_retak ?? 0 }}</td>
                    <td>{{ $item->jumlah_telur_rusak ?? 0 }}</td>
                    <td>{{ $item->pengobatan_yang_dilakukan ?? '-' }}</td>
                    <td>{{ $item->jumlah_ayam_diobati ?? 0 }}</td>
                    <td>{{ $item->penyemprotan ?? '-' }}</td>
                    <td>{{ $item->vaksin ?? '-' }}</td>
                    <td>
                        <button onclick="showCatatan(`{{ $item->catatan ?? 'Tidak ada catatan' }}`)"
                                class="btn btn-warning btn-sm">
                            Detail
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                            onclick="deleteData('{{ route('ayam-karantina.destroy', $item->id) }}')">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="18" class="text-center text-muted">Data Ayam Karantina belum tersedia</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $listAyamKarantina->links('components.pagination') }}
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Identitas Populasi
function showPopulasi(kandang, flock, pipe) {
    Swal.fire({
        title: "Identitas Populasi",
        html: `
            <div style="text-align:left">
                <p><strong>Kandang:</strong> ${kandang}</p>
                <p><strong>Flock:</strong> ${flock}</p>
                <p><strong>Pipe:</strong> ${pipe}</p>
            </div>`,
        icon: "info",
    });
}

// Catatan
function showCatatan(catatan) {
    Swal.fire({
        title: "Catatan",
        text: catatan,
        icon: "info",
    });
}

// Delete
function deleteData(url) {
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data yang sudah dihapus tidak dapat dikembalikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.createElement("form");
            form.action = url;
            form.method = "POST";
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush



