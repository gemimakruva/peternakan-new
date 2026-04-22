<div class="card">
    <div class="card-header">
        <h2 class="card-title">Perubahan harga</h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered mb-0">
            <thead class="text-center">
                <tr>
                    <th class="align-middle">Tanggal</th>
                    <th class="align-middle">Diubah Oleh</th>
                    <th class="align-middle">Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data->priceable as $item)
                    <tr>
                        <td>{{ $item->created_at->translatedFormat('l, d F Y - H:i') }}</td>
                        <td>{{ $item->picUser->name }}</td>
                        <td>{{ format_angka($item->harga) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Data Perubahan Harga Tidak Ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>