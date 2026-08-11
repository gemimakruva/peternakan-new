@extends('layouts.dashboard')

@section('title', 'Pengadaan Ayam')

@section('content_header')
    <x-page-header title="Pengadaan Ayam" :breadcrumbs="[
        'Pengadaan Ayam' => route('pengadaan-ayam.index'),
        'Tambah' => null,
    ]" />
@stop

@section('content')
    <div class="mx-1200">
        <x-form-alert />
        <div class="row">
            <div class="col-md-9 col-12">
                <form
                    enctype="multipart/form-data"
                    action="{{ route('pengadaan-ayam.store') }}"
                    method="post"
                    id="form-pengadaan"
                >
                    @csrf
                    <input type="hidden" name="distribusi_json" id="distribusi_json">
                    @include('kandang::pengadaan-ayam._form')
                </form>
            </div>
            <div class="col-md-3 col-12">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('pengadaan-ayam.index') }}" class="btn btn-outline-secondary flex-1">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary flex-1" id="submit-form-pengadaan">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#submit-form-pengadaan').click(function (e) {
            Swal.fire({
                title: 'Simpan Data?',
                text: "Data yang tersimpan tidak akan bisa diupdate!",
                showCancelButton: true,
                icon: "warning",
                confirmButtonColor: 'var(--primary)',
                cancelButtonColor: 'var(--secondary)',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-pengadaan').submit();
                }
            });
        });
    </script>
@endpush
