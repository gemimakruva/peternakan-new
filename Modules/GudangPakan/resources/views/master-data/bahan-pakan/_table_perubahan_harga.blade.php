<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered mb-0">
            <thead>
                <tr class="text-center">
                    <th class="align-middle" style="width: 300px;">Tanggal</th>
                    <th class="align-middle" style="width: 200px;">Diubah Oleh</th>
                    <th class="align-middle" style="width: 150px;">Harga per 1 {{ $data->satuan->nama }}</th>
                    <th class="align-middle" style="width: 150px;">Harga per {{ format_angka($data->jumlah_satuan) }} {{ $data->satuan->nama }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->priceable as $item)
                    <tr>
                        <td>{{ $item->created_at->translatedFormat('l, d F Y - H:i') }}</td>
                        <td>{{ $item->picUser->name }}</td>
                        <td class="text-right">{{ format_angka($item->harga) }}</td>
                        <td class="text-right">{{ format_angka($item->harga * $data->jumlah_satuan) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>