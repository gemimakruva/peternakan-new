@extends('layouts.dashboard')

@section('title', 'Ayam Karantina')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Ayam Karantina</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">  
                    <li class="breadcrumb-item active">Ayam Karantina</li>
                </ol>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="mx-1400">
        <x-form-alert />
        <div class="card">
            <div class="card-header">
                <form
                    action="{{ route('ayam-karantina.index', request()->all()) }}" 
                    method="get" 
                    class="w-100"
                >
                    <div class="d-flex justify-content-end">
                        <div class="d-flex gap-3">
                            <input 
                                type="search" 
                                name="search" 
                                class="form-control" 
                                placeholder="Nama Pencatat"
                                value="{{ request()->query('search') }}"
                            >
                            <button class="btn btn-primary" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle" style="width: 40px;">#</th>
                            <th class="align-middle" style="width: 200px;">Tanggal</th>
                            <th class="align-middle" style="width: 160px;">Kandang</th>
                            <th class="align-middle">Nama Pencatat</th>
                            <th class="align-middle">Ayam Mati</th>
                            <th class="align-middle">Ayam Afkir</th>
                            <th class="align-middle">Pakan Diberikan (kg)</th>
                            <th class="align-middle">Sisa Pakan (kg)</th>
                            <th class="align-middle">Telur Bagus</th>
                            <th class="align-middle">Telur retak</th>
                            <th class="align-middle">Telur rusak</th>
                            {{-- <th class="align-middle">Pengobatan</th> --}}
                            {{-- <th class="align-middle">Jumlah Ayam Diobati</th> --}}
                            {{-- <th class="align-middle">Penyemprotan</th> --}}
                            {{-- <th class="align-middle">Vaksin</th> --}}
                            <th class="align-middle" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                    @forelse($listKarantinaPopulasi as $item)
                    <tr>
                        <td class="text-right">{{ ($listKarantinaPopulasi->currentPage() - 1) * $listKarantinaPopulasi->perPage() + $loop->iteration }}</td>
                        <td class="text-left">{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                        <td class="text-left">{{ $item->kandang->nama ?? '-' }}</td>
                        <td class="text-left">{{ $item->picUser->name ?? '-' }}</td>
                        <td class="text-right">{{ number_format($item->ayam_mati ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->ayam_afkir ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->pemberian_pakan ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->sisa_pakan ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->jumlah_telur_bagus ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->jumlah_telur_retak ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->jumlah_telur_rusak ?? 0, 0, ',', '.') }}</td>
                        {{-- <td class="text-left">{{ $item->pengobatan_yang_dilakukan ?? '-' }}</td> --}}
                        {{-- <td class="text-right">{{ number_format($item->jumlah_ayam_diobati ?? 0, 0, ',', '.') }}</td> --}}
                        {{-- <td class="text-left">{{ $item->penyemprotan ?? '-' }}</td> --}}
                        {{-- <td class="text-left">{{ $item->vaksin ?? '-' }}</td> --}}
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button
                                    onclick="showCatatan(`{{ $item->catatan ?? 'Tidak ada catatan' }}`)" 
                                    class="btn btn-info btn-sm"
                                >
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <a href="{{ route('ayam-karantina.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <button
                                    class="btn btn-danger btn-sm"
                                    onclick="deleteData('{{ route('ayam-karantina.destroy', $item->id) }}')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button> --}}
                            </div>
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

            @if ($listKarantinaPopulasi->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listKarantinaPopulasi->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection
@push('js')
    <script>
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



