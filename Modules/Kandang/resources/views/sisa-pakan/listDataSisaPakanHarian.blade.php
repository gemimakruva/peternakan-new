@extends('adminlte::page')

@section('title', 'Transaksi Ayam Afkir')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">List Sisa Pakan Harian</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk menampilkan list sisa pakan harian
    </span>
</div>
@endsection

@section('content')
<div class="card" style="max-width: 1200px">
    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="background-color: #495057; border-color: #495057;">
        <h2 class="card-title mb-0 text-center">Rekapan Sisa Pakan</h2>
    </div>

    {{-- FILTER DIBAWAH HEADER --}}
    <div class="card-body mb-10">
       <form action="{{ route('sisa-pakan.listDataSisaPakanHarian') }}" 
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
                    <th>Tanggal Transaksi</th>
                    <th>Petugas pencatat</th>
                    <th>Kandang</th>
                    <th>Flock</th>
                    <th>Jenis Pakan</th>
                    <th>Pemberian Paykan per Flock</th>
                    <th>Sisa Pakan per Flock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data  as $pp)
                {{-- @dd($pp) --}}
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($pp->tanggal)
                        ->translatedFormat('d F Y') }}</td>
                        <td>{{ $pp->userExecutor->name }}</td>
                        <td>{{ $pp->flock->kandang->nama?? '-' }}</td>
                        <td>{{ $pp->flock->nama ?? '-' }}</td>
                        <td>{{ $pp->jenisPakan->nama }}</td>
                        <td>{{ $pp->pemberian_pakan_flock_kg ?? '-' }}</td>
                        <td>{{ $pp->sisa_pakan_per_flock_kg ?? '-' }}</td>
                         <td class="text-center">
                            <a href="{{ route('sisa-pakan.edit', $pp->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action={{ route('sisa-pakan.delete',$pp->id) }}
                                 method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
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
            {{ $data->links('components.pagination') }}
        </div>
</div>
   @include('components.snackbar')
@endsection

@push('js')
<script>

  $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();

        let form = $(this).closest('form');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            console.log(result)
            if (result.value) {
                form.submit();
            }
        });
    });


</script>
@endpush