@extends('adminlte::page')

@section('title', 'Pencatatan Ayam Masuk')
@section('content_header')

{{-- # Card Header Detail Ayam --}}
<div class="card mb-4 d-flex flex-row justify-content-between 
     align-items-center text-center p-3 w-100">
        {{-- icon detail --}}
    
        {{-- judul detial --}}
        <div class="d-flex flex-row justify-center p-2 p-md">
            <div class="ms-2 text-start text-md-center">
                <h5 class="fw-bold text-dark mb-1 fs-5 fs-md-4 fs-lg-3">
                    Detail Pengadaan Ayam
                </h5>
                <span class="text-dark fw-semibold d-block fs-6 fs-md-5 fs-lg-4">
                    {{ \Carbon\Carbon::parse($pengadaanAyam->tanggal)
                    ->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>

    {{-- aksi header --}}
        <div class="d-flex align-items-center gap-3">
            {{-- Edit button --}}
            <a href="#" class="text-primary d-flex align-items-center justify-content-center 
                p-2 rounded hover-shadow"
                title="Edit Pengadaan">
                <i class="bi bi-pencil-square fs-4" style="font-size: 25px"></i>
            </a>
            {{-- Print button --}}
            <a href="#" class="text-success d-flex align-items-center justify-content-center 
                p-2 rounded hover-shadow"
                title="Print Detail">
                <i class="bi bi-printer fs-5" style="font-size: 25px"></i>
            </a>
        </div>
        <style>
            .hover-shadow:hover {
                background-color: #f1f1f1;
                transition: 0.2s;
            }
        </style>
</div>
@stop

@section('content')

    {{-- #Detail Infromasi Utama --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <!-- Header -->
            <div class="d-flex align-items-center mb-3  pb-2 border-bottom">
                <div class="text-warning ">
                    <i class="fas fa-exclamation-circle fs-4 fs-md-3 " style="font-size: 25px"></i>
                </div>

                <h3 class="fw-semibold text-dark fs-5 fs-md-4 mb-0 m-2">
                    Informasi Utama
                </h3>
            </div>
            <!--  Main Content -->
            <div class="mt-2">
                <div class="container">
                    {{-- Data Dummy  --}}
               @php
                        $items = [
                            [
                                'title' => 'Tanggal Input',
                                'text' => \Carbon\Carbon::parse($pengadaanAyam->tanggal)
                                ->translatedFormat('l, d F Y'),
                                'icon' => 'fas fa-calendar-alt',
                            ],
                            [
                                'title' => 'Umur Ayam',
                                'text' => $pengadaanAyam->umur_ayam . ' Minggu',
                                'icon' => 'fas fa-egg',
                            ],
                            [
                                'title' => 'Kondisi Ayam',
                                'text' => $pengadaanAyam->kondisi_ayam,
                                'icon' => 'fas fa-heartbeat',
                            ],
                            [
                                'title' => 'Jumlah Datang',
                                'text' => number_format($pengadaanAyam->jumlah_ayam_datang) .
                                 ' Ekor',
                                'icon' => 'fas fa-database',
                            ],
                            [
                                'title' => 'PIC User Input',
                                'text' => $pengadaanAyam->pic_user->name ?? 'Tidak Diketahui',
                                'icon' => 'fas fa-user',
                            ],
                            [
                                'title' => 'Jumlah Sakit',
                                'text' => number_format($pengadaanAyam->jumlah_ayam_sakit) .
                                 ' Ekor',
                                'icon' => 'fas fa-medkit',
                            ],
                            [
                                'title' => 'Jumlah Mati',
                                'text' => number_format($pengadaanAyam->jumlah_ayam_mati) .
                                 ' Ekor',
                                'icon' => 'fas fa-skull-crossbones',
                            ],
                            [
                                'title' => 'Jumlah Masuk Kandang',
                                'text' => number_format($pengadaanAyam->jumlah_ayam_masuk_kandang) .
                                 ' Ekor',
                                'icon' => 'fas fa-warehouse',
                            ],
                        ];
                @endphp


                    <div class="row">
                        @foreach ($items as $item)
                            <div class="col-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center gap-3">

                                        {{-- Icon --}}
                                        <div class="d-inline-flex align-items-center justify-content-center rounded"
                                            style="background-color: #f1f1f1; width: 50px; height: 50px;">
                                            <i class="{{ $item['icon'] }}" style="color: #7f7f7f;"></i>
                                        </div>

                                        {{-- Content --}}
                                        <div class="grow ml-2">
                                            <h6 class="mb-1 fw-bold">{{ $item['title'] }}</h6>
                                            <p class="mb-0 text-muted">{{ $item['text'] }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- # LIST Document Suplier--}}
    <div class="card shadow-sm border-0 mb-3 px-3">
    {{-- Header --}}
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-folder text-warning" style="font-size: 25px;"></i>
                <h5 class="fw-semibold text-dark mb-0 ml-2">Berkas Supplier</h5>
            </div>

            <span class="fw-bold text-muted">
                {{ $pengadaanAyam->berkasSupplier->count() }} Berkas
            </span>
        </div>

    {{-- Content --}}
            @forelse ($pengadaanAyam->berkasSupplier as $file)
                <div class="card shadow-md mb-3 mx-auto justify-content-between" style="width:100%">
                    <div class="card-body d-flex justify-content-between rounded shadow-md" style="width:100%">
                        {{-- Kiri --}}
                        <div style="width: 50%">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center rounded bg-light"
                                    style="width: 45px; height: 45px;">
                                    <i style="font-size: 25px" class="fas fa-file-alt text-secondary"></i>
                                </div>

                                <div class="ml-3">
                                    <h6 class="mb-1 fw-semibold">{{ $file->nama_berkas_display }}</h6>
                                </div>
                            </div>
                        </div>

                        {{-- Kanan --}}
                        <div class="d-flex justify-content-end" style="width: 50%">
                            <div class="d-flex justify-content-between">
                                {{-- View --}}
                               <a href="{{ Storage::url($file->file_path) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 ml-2"
                                    title="Lihat Berkas">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                {{-- Download --}}
                               <a href="{{ Storage::url($file->file_path) }}"
                                    download
                                    class="btn btn-sm btn-primary d-flex align-items-center gap-1 ml-2"
                                    title="Download Berkas">
                                    <i class="fas fa-download"></i> Download
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center text-muted pb-3">
                    Tidak ada berkas supplier.
                </div>
            @endforelse

    </div>

       {{-- # Photo Document Pengadaan Ayam--}}
    <div class="card shadow-sm border-0 mb-3 px-3">

        {{-- Heading --}}
        <div class="card-body d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-camera text-warning" style="font-size: 25px;"></i>
                    <h5 class="fw-semibold text-dark mb-0 ml-2">
                        Dokumentasi Pengadaan
                    </h5>
                </div>
        </div>
       
        {{-- Gallery Photo --}}
        <div class="container">
            <div class="row g-3">
                @forelse ($pengadaanAyam->dokumentasi as $i => $doc)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm overflow-hidden">

                            <button type="button" 
                                class="btn p-0 border-0" 
                                data-bs-toggle="modal"
                                data-bs-target="#lightboxModal"
                                data-src="{{ Storage::url($doc->file_path) }}" 
                                data-alt="Dokumentasi Ayam {{ $i + 1 }}">

                               <img src="{{ Storage::url($doc->file_path) }}" 
                                alt="Dokumentasi Ayam {{ $i + 1 }}"
                                loading="lazy"
                                class="img-fluid w-100"
                                style="max-height: 200px; object-fit: contain; 
                                background-color: #f8f9fa;">
                            </button>

                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Belum ada dokumentasi diunggah</p>
                @endforelse
            </div>
</div>

    </div>
    {{-- # List Distribusi Supplier --}}
     <div class="card shadow-sm border-0 mb-3 px-3">
         {{-- Heading --}}
        <div class="card-body d-flex align-items-center justify-content-between">
                <div style="width:50%" class="d-flex align-items-center gap-2" 
                     style="width: 50%; background-color: aquamarine;">
                    <i class="fas fa-warehouse text-warning" style="font-size: 25px;"></i>
                    <h5 class="fw-semibold text-dark mb-0 ml-2">
                        Distribusi Pengadaan
                    </h5>
                </div>
                {{-- Add distribtuon --}}
                {{-- <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-primary d-flex align-items-center">
                        <i class="fas fa-plus mr-2"></i>
                        <span> Tambah Distribusi</span>
                    </a>
                </div> --}}

        </div>

        {{-- Tabel Distribusi Pengadaan --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kandang</th>
                        <th>Flock ID</th>
                        <th>Pipe ID</th>
                        <th>Jumlah Ayam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse ($pengadaanAyam->distribusi as $i => $dist)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                           <td>{{ $dist->pipe->flock->kandang->nama ?? '-' }}</td>
                            <td>{{ $dist->pipe->flock->nama ?? '-' }}</td>
                            <td>{{ $dist->pipe->nama  ?? '-' }}</td>
                            <td class="text-center">{{ $dist->jumlah_ayam ?? 0 }}</td>

                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href=""
                                    class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href=""
                                    class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action=""
                                        method="POST"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data distribusi ayam
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



    </div>
@endsection