@extends('layouts.dashboard')

@section('title', 'Role')

@section('content_header')
<x-page-header title="Role" :breadcrumbs="['Master Data' => '#', 'Role' => '']">
    @can('Tambah Role')
    <x-slot name="actions">
        <a href="{{ route('role.create') }}" class="btn btn-primary">Tambah Role</a>
    </x-slot>
    @endcan
</x-page-header>
@endsection

@php
    if (!function_exists('getRoleName')) {
        function getRoleName($name) {
            $slug = explode('.', $name)[2];
            return str_replace('-', ' ', $slug);
        }
    }
@endphp

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel action="{{ route('role.index', request()->all()) }}">
            <div class="col-12 col-md-4">
                <input type="search" name="search" class="form-control" placeholder="Cari Role..." value="{{ request()->query('search') }}">
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <th>Nama Role</th>
                        <th>Permissions</th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($datas as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td class="text-left">{{ $row->name }}</td>
                                <td class="text-left">
                                    @foreach($row->permissions as $permission)
                                        <span class="badge badge-secondary text-capitalize">{{ getRoleName($permission->name) }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        @can('Edit Role')
                                            <a href="{{ route('role.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('Hapus Role')
                                            <form action="{{ route('role.destroy', $row->id) }}" method="post"
                                                data-nama="{{ $row->name }}" class="form-delete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Tidak ada data role ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($datas->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $datas->links('components.pagination') }}
                </div>
            @endif
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse($datas as $row)
                <x-mobile-card title="{{ $row->name }}">
                    <div class="data-row" style="flex-wrap: wrap;">
                        <span class="data-label">Permissions</span>
                        <span class="data-value" style="text-align: right;">
                            @foreach($row->permissions as $permission)
                                <span class="badge badge-secondary text-capitalize">{{ getRoleName($permission->name) }}</span>
                            @endforeach
                        </span>
                    </div>
                    <x-slot name="actions">
                        @can('Edit Role')
                            <a href="{{ route('role.edit', $row->id) }}" class="btn btn-warning btn-sm text-white">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endcan
                        @can('Hapus Role')
                            <form action="{{ route('role.destroy', $row->id) }}" method="post" data-nama="{{ $row->name }}" class="form-delete">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        @endif
                    </x-slot>
                </x-mobile-card>
            @empty
                <p class="text-center text-muted py-3">Tidak ada data role ditemukan.</p>
            @endforelse
            @if ($datas->hasPages())
                <div class="d-flex justify-content-end mt-2">
                    {{ $datas->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('submit', '.form-delete', function (e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Role "${nama}"?`,
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endpush