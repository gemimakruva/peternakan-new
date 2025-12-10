@extends('adminlte::page')

@section('title', 'Transaksi Ayam Afkir')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">List Pakan Harian</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk menampilkan list data pakan harian
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
       <form action="{{ route('perhitungan-pakan.listdata') }}" 
      method="GET" class="row g-3 pb-3 px-4 align-items-end">

        {{-- Filter Tanggal --}}
        <div class="col-md-3 col-6">
            <label class="form-label fw-semibold">Tanggal Pemberian Pakan</label>
            <input 
            type="date" 
            name="tanggal"
            id="tanggal_pemberian_pakan"
            class="form-control"
            >
        </div>

    {{-- Filter Kandang --}}
    <div class="col-md-3 col-6">
        <label class="form-label fw-semibold">Kandang</label>
        <select id="kandang_id" name="kandang" class="form-control">
            <option value="">-- Pilih Kandang --</option>
            @foreach ($kandang as $item)
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
        </select>
    </div>

    {{-- Filter Petugas --}}
    <div class="col-md-3 col-6">
        <label class="form-label fw-semibold">Petugas Pencatat</label>
        <input type="text" id="petugas_pencatatan" name="petugas_pencatatan"
               class="form-control" placeholder="Cari Petugas Pencatat"
               value="{{ request('petugas_pencatatan') }}">
    </div>

    {{-- Tombol Submit --}}
    <div class="col-md-1 col-6 d-flex justify-content-center">
        <button class="btn btn-primary w-100" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </div>

</form>

    </div>
    
<div class="card-body p-0">
    <x-form-alert />
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 align-middle table-auto" style="white-space: nowrap;">
            <thead  style="background-color: #495057; border-color: #495057;" class="table-light text-center text-white">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Petugas pencatat</th>
                    <th>Kandang</th>
                    <th>Baris</th>
                    <th>Pipa</th>
                    <th>Jumlah ayam</th>
                    <th>Pemberian pakan per ekor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perhitunganPakan as $pp)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($pp->tanggal_pemberian_pakan)
                        ->translatedFormat('d F Y') }}</td>
                        <td>{{ $pp->userExecutor->name }}</td>
                        <td>{{ $pp->pipe->flock->kandang->nama ?? '-' }}</td>
                        <td>{{ $pp->pipe->flock->nama ?? '-' }}</td>
                        <td>{{ $pp->pipe->nama }}</td>
                        <td>{{ $pp->jumlah_ayam_per_pipe }}</td>
                        <td>{{ $pp->jumlah_pakan_per_ekor_gram ?? '-' }}</td>
                         <td class="text-center">
                            <a href="{{ route('perhitungan-pakan.edit', $pp) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <button type="button" class="btn btn-sm btn-danger
                             btn-delete" data-id="{{ $pp->id }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>

                            <form id="delete-form-{{ $pp->id }}" 
                                action="{{ route('perhitungan-pakan.destroy', $pp->id) }}" 
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
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
     <div class="card-footer d-flex justify-content-end">
            {{ $perhitunganPakan->links('components.pagination') }}
        </div>
        @include('components.snackbar')
</div>
@endsection

@push('js')
<script>
// $(document).ready(function() {
//     function loadTanggalPakan(query = '') {
//         $.ajax({
//             url: "{{ route('ajax.tanggal-perhitungan') }}",
//             type: "GET",
//             data: { q: query },
//             dataType: "json",
//             success: function(response) {
//                 let select = $('#tanggal_pemberian_pakan');
//                 select.empty();
//                 select.append('<option value="">-- Pilih Tanggal --</option>');

//                 $.each(response.results, function(index, item) {

//                     let parts = item.text.split('-');
//                     let dateObj = new Date(parts[2], parts[1]-1, parts[0]);
//                     let formattedDate = dateObj.toLocaleDateString('id-ID', {
//                         day: '2-digit',
//                         month: 'long',
//                         year: 'numeric'
//                     });

//                     select.append('<option value="' + item.id + '">' + formattedDate + '</option>');
//                 });
//             },
//             error: function(xhr) {
//                 console.error(xhr.responseText);
//             }
//         });
//     }    
//     loadTanggalPakan();
// });

$('.btn-delete').click(function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var form = $('#delete-form-' + id);

        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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