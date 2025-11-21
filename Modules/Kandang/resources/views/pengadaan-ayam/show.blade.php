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
                                'title' => 'Nama Pengadaan',
                                'text' => 'Pengadaan Ayam Pipe-3 Kandang 3',
                                'icon' => 'fas fa-tag',
                            ],
                            [
                                'title' => 'Jumlah Ayam',
                                'text' => '2000 Ekor',
                                'icon' => 'fas fa-list',
                            ],
                            [
                                'title' => 'ID Pengadaan',
                                'text' => '#PGD-09243',
                                'icon' => 'fas fa-hashtag',
                            ],
                            [
                                'title' => 'Nama Flock',
                                'text' => 'Kandang A-03',
                                'icon' => 'fas fa-database',
                            ],
                            [
                                'title' => 'PIC User Input',
                                'text' => 'Ilham Suryana',
                                'icon' => 'fas fa-user',
                            ],
                            [
                                'title' => 'Pipe ID',
                                'text' => 'PIPE-0003',
                                'icon' => 'fas fa-key',
                            ],
                            [
                                'title' => 'Status Pengadaan',
                                'text' => 'Sedang Diproses',
                                'icon' => 'fas fa-check-circle',
                            ],
                            [
                                'title' => 'Tanggal Input',
                                'text' => '21 November 2025 • 10:45',
                                'icon' => 'fas fa-calendar-alt',
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
        {{-- Heading --}}
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-folder text-warning" style="font-size: 25px;"></i>
                <h5 class="fw-semibold text-dark mb-0 ml-2">
                    Berkas Supplier
                </h5>
            </div>
            <span class="fw-bold text-muted">
                12 Berkas
            </span>
        </div>
           {{-- content --}}
             @php
                $files = [
                    [
                        'name' => 'Surat Kedatangan.pdf',
                        'desc' => 'Dokumen resmi supplier',
                        'icon' => 'fas fa-file-alt',
                        'url_view' => '#',
                        'url_download' => '#',
                    ],
                    [
                        'name' => 'Kontrak Supplier.docx',
                        'desc' => 'Perjanjian kerja sama',
                        'icon' => 'fas fa-file-word',
                        'url_view' => '#',
                        'url_download' => '#',
                    ],
                    [
                        'name' => 'Bukti Pembayaran.jpg',
                        'desc' => 'Pembayaran awal pemasokan',
                        'icon' => 'fas fa-file-image',
                        'url_view' => '#',
                        'url_download' => '#',
                    ],
                ];
            @endphp

        @foreach ($files as $file)
        <div class="card shadow-md mb-3 mx-auto justify-content-between" style="width:100%">
                <div style="width:100%" class="card-body d-flex justify-content-between rounded shadow-md" >
                   <div style="width: 50%">
                        <div class="d-flex flex-col">
                            <div class="d-flex align-items-center justify-content-center rounded bg-light"
                                style="width: 45px; height: 45px;">
                                <i style="font-size: 25px" class="fas fa-file-alt text-secondary"></i>
                            </div>

                            <div class="grow ml-3">
                                <h6 class="mb-1 fw-semibold">Surat Kedatangan.pdf</h6>
                                <p class="mb-0 text-muted" style="font-size: 14px;">Dokumen resmi supplier</p>
                            </div>
                        </div>
                   </div>
                   <div class="d-flex justify-content-end" style="width: 50%;">
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-sm btn-outline-secondary d-flex 
                            align-items-center gap-1" style="min-height: 20px" title="Lihat Berkas">
                                <i class="fas fa-eye"></i>
                                <span> View File</span>
                            </a>
                            <a href="#" class="btn btn-sm btn-primary d-flex align-items-center
                             gap-1 ml-2" title="Download Berkas">
                                <i class="fas fa-download"></i>
                                <span> Download</span>
                            </a>
                        </div>
                   </div>
                </div>
        </div>
        @endforeach
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
        <div>
            {{-- data dummy --}}
            @php
                $images = [
                            ['src' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?
                            auto=format&fit=crop&w=800&q=80', 'alt' => 'Foto Alam 1'],
                            ['src' => 'https://images.unsplash.com/photo-1526045612212-70caf35c14df?
                            auto=format&fit=crop&w=800&q=80', 'alt' => 'Foto Dokumentasi 2'],
                            ['src' => 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?
                            auto=format&fit=crop&w=800&q=80', 'alt' => 'Foto Pekerjaan 3'],
                            ['src' => 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?
                            auto=format&fit=crop&w=800&q=80', 'alt' => 'Foto Proses 4'],
                            ['src' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?
                            auto=format&fit=crop&w=800&q=80', 'alt' => 'Foto Aktivitas 5'],
                            ['src' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?
                            auto=format&fit=crop&w=800&q=80', 'alt' => 'Foto Lokasi 6'],
                        ];
            @endphp

        <div class="container">
                <div class="row g-3">
                    @foreach ($images as $i => $img)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm overflow-hidden">
                            <button type="button" class="btn p-0 border-0" data-bs-toggle="modal"
                                    data-bs-target="#lightboxModal" data-src="{{ $img['src'] }}" 
                                    data-alt="{{ $img['alt'] }}">
                                    <img src="{{ $img['src'] }}" alt="{{ $img['alt'] }}" loading="lazy"
                                        class="img-fluid w-100" style="height:200px; object-fit:cover;">
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
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
                        Dokumentasi Pengadaan
                    </h5>
                </div>
                {{-- Add distribtuon --}}
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-primary d-flex align-items-center">
                        <i class="fas fa-plus mr-2"></i>
                        <span> Tambah Distribusi</span>
                    </a>
                </div>

        </div>

        {{-- Tabel Distribusi Pengadaan --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>ID Pengadaan Ayam</th>
                        <th>Flock ID</th>
                        <th>Pipe ID</th>
                        <th>Jumlah Ayam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>PGD-2025-001</td>
                        <td>FCK-01</td>
                        <td>PIPE-3</td>
                        <td class="text-center">500</td>
                        <td>
                            <span class="badge bg-success">Complete</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-center">2</td>
                        <td>PGD-2025-002</td>
                        <td>FCK-02</td>
                        <td>PIPE-7</td>
                        <td class="text-center">450</td>
                        <td><span class="badge bg-warning text-dark">Proses</span></td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-center">3</td>
                        <td>PGD-2025-003</td>
                        <td>FCK-03</td>
                        <td>PIPE-1</td>
                        <td class="text-center">600</td>
                        <td><span class="badge bg-success">Complete</span></td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
@endsection