<div class="card">
    <div class="card-header text-white d-flex justify-content-between align-items-center">
        <form action="{{ route('master-data.kandang.show', $kandang) }}" method="get" class="w-100">            
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0 text-dark">Daftar Flock pada Kandang</h2>
                <div class="d-flex" style="gap: .5em">
                    <input type="search" 
                        name="search" 
                        class="form-control" 
                        placeholder="Cari flock..." 
                        value="{{ request()->query('search') }}">
                    <button class="btn btn-primary" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered text-center mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Nama Flock</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($flocks as $row)
                <tr>    
                    <td>{{ ($loop->index + 1) + ($flocks->currentPage() - 1) * $flocks->perPage() }}</td>
                    <td class="text-left">{{ $row->nama }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2" role="group">
                            <a
                                href="{{ route('master-data.kandang.flock.show', [$kandang, $row]) }}"
                                class="btn btn-info btn-sm"
                                title="Lihat Detail Flock"
                            >
                                <i class="fas fa-eye"></i>
                            </a>

                            <a 
                                href="{{ route('master-data.kandang.flock.edit', [$kandang, $row]) }}"
                                class="btn btn-warning text-white btn-sm"
                                title="Edit Flock"
                            >
                                <i class="fas fa-edit"></i>
                            </a>

                            @if (auth()->user()->can('Hapus Flock') && !$row->pipes()->exists())    
                                <form
                                    action="{{ route('master-data.kandang.flock.destroy', [$kandang, $row]) }}"
                                    method="post" 
                                    data-nama="{{ $row->nama }}" 
                                    class="form-delete d-inline">
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
                    <td colspan="6" class="text-muted">Belum ada data flock.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-end">
        {{ $flocks->links('components.pagination') }}
    </div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Flock "${nama}"?`,
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