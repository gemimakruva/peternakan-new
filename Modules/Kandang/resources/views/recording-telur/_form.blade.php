<x-adminlte-input
    id="tanggal_produksi"
    type="date"
    name="tanggal"
    label="Tanggal Produksi"
    value="{{ old('tanggal', @$produksiTelur->tanggal?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
/>

<x-adminlte-select 
    name="kandang_id"
    label="Pilih Kandang"
    :readonly="@$produksiTelur->kandang_id"
    :disabled="@$produksiTelur->kandang_id"
>
    <x-adminlte-options 
        :options="$listKandang"
        empty-option="Pilih Kandang"
        :selected="old('kandang_id', @$produksiTelur->kandang_id)"
    />
</x-adminlte-select>

@if (@$items && count($items) > 0)
<div
    x-data="{
        items: @js(old('items', $items)),
    }"
    class="table-responsive"
>
    {{-- <pre x-text="JSON.stringify(items, 1, 2)"></pre> --}}
    <table class="table table-hover table-striped table-bordered text-center">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle" style="min-width: 180px;">Nama Flock</th>
                <th colspan="2">Telur Bagus</th>
                <th colspan="2">Telur Putih</th>
                <th colspan="2">Telur Reject</th>
            </tr>
            <tr>
                <th style="min-width: 100px;">Jumlah</th>
                <th style="min-width: 100px;">Berat</th>
                <th style="min-width: 100px;">Jumlah</th>
                <th style="min-width: 100px;">Berat</th>
                <th style="min-width: 100px;">Jumlah</th>
                <th style="min-width: 100px;">Berat</th>
            </tr>
        </thead>
        <tbody>
            <template x-for="(item, key) in items" :key="key">
                <tr>
                    <td class="text-left" x-text="item.nama_flock"></td>
                    <td>
                        <input
                            type="hidden"
                            :name="`items[${key}][flock_id]`"
                            :value="item.flock_id"
                        />
                        <input
                            type="hidden"
                            :name="`items[${key}][nama_flock]`"
                            :value="item.nama_flock"
                        />
                        <input
                            type="number"
                            class="form-control"
                            x-model="item.jumlah_telur_bagus"
                            :name="`items[${key}][jumlah_telur_bagus]`"
                            min="0"
                        />
                    </td>
                    <td>
                        <input
                            type="number"
                            class="form-control"
                            x-model="item.berat_telur_bagus"
                            :name="`items[${key}][berat_telur_bagus]`"
                            min="0"
                            step="0.001"
                        />
                    </td>
                    <td>
                        <input
                            type="number"
                            class="form-control"
                            x-model="item.jumlah_telur_putih"
                            :name="`items[${key}][jumlah_telur_putih]`"
                            min="0"
                        />
                    </td>
                    <td>
                        <input
                            type="number"
                            class="form-control"
                            x-model="item.berat_telur_putih"
                            :name="`items[${key}][berat_telur_putih]`"
                            min="0"
                            step="0.001"
                        />
                    </td>
                    <td>
                        <input
                            type="number"
                            class="form-control"
                            x-model="item.jumlah_telur_reject"
                            :name="`items[${key}][jumlah_telur_reject]`"
                            min="0"
                        />
                    </td>
                    <td>
                        <input
                            type="number"
                            class="form-control"
                            x-model="item.berat_telur_reject"
                            :name="`items[${key}][berat_telur_reject]`"
                            min="0"
                            step="0.001"
                        />
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
@endif