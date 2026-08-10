@extends('layouts.dashboard')

@section('title', 'User')

@section('content_header')
<x-page-header title="User" :breadcrumbs="['User Management' => '#', 'User' => '']">
    @can('Tambah User')
    <x-slot name="actions">
        <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah User</a>
    </x-slot>
    @endcan
</x-page-header>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel action="{{ route('user.index', request()->all()) }}">
            <div class="col-12 col-md-4">
                <input type="search" name="search" class="form-control" placeholder="Cari User..." value="{{ request()->query('search') }}">
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($datas as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td class="text-left">{{ $row->name }}</td>
                                <td class="text-left">{{ $row->email }}</td>
                                <td class="text-left">{{ $row->getRoleNames()->implode(', ') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        @can('Edit User')
                                            <a href="{{ route('user.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('Hapus User')
                                            <form action="{{ route('user.destroy', $row->id) }}" method="post"
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
                                <td colspan="5" class="text-center text-muted py-3">
                                    Tidak ada data user ditemukan.
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
                <x-mobile-card title="{{ $row->name }}" subtitle="{{ $row->email }}">
                    <div class="data-row">
                        <span class="data-label">Role</span>
                        <span class="data-value">{{ $row->getRoleNames()->implode(', ') }}</span>
                    </div>
                    <x-slot name="actions">
                        @can('Edit User')
                            <a href="{{ route('user.edit', $row->id) }}" class="btn btn-warning btn-sm text-white">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endcan
                        @can('Hapus User')
                            <form action="{{ route('user.destroy', $row->id) }}" method="post" data-nama="{{ $row->name }}" class="form-delete">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        @endif
                    </x-slot>
                </x-mobile-card>
            @empty
                <p class="text-center text-muted py-3">Tidak ada data user ditemukan.</p>
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
                title: `Hapus User "${nama}"?`,
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