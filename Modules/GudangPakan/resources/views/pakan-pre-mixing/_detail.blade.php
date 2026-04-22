<div class="card">
    <div class="card-header">
        <h2 class="card-title">Rincian Formulasi</h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered mb-0">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Bahan Baku</th>
                    <th>Satuan</th>
                    <th>Jumlah</th>
                    <th>Sub Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->pakanPreMixingItem as $item)
                    {{-- @dd($item) --}}
                    <tr>
                        <td class="text-right">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->bahanPakan->nama }}</td>
                        <td>{{ $item->bahanPakan->satuan->nama }}</td>
                        <td class="text-right">{{ format_angka($item->jumlah) }}</td>
                        <td class="text-right">{{ format_angka($item->harga_sub_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total Harga Bahan Baku</td>
                    <td class="text-right">{{ format_angka($data->pakanPreMixingItem->sum('harga_sub_total')) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>