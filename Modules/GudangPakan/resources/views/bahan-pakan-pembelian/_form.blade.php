<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Supplier"
            name="supplier_id"
            :disabled="@$data->id"
        >
            <x-adminlte-options
                :options="$listSupplier"
                :selected="old('supplier_id', @$data->supplier_id)"
                empty-option="Pilih Supplier"
            />
        </x-adminlte-select>

        <x-adminlte-input
            type="date"
            label="Tanggal Pemesanan"
            name="tanggal_pesan"
            :value="old('tanggal_pesan', @$data->tanggal_pesan?->format('Y-m-d'))"
        />

        <x-adminlte-input
            type="date"
            label="Tanggal Kedatangan"
            name="tanggal_datang"
            :value="old('tanggal_datang', @$data->tanggal_datang?->format('Y-m-d'))"
        />
    </div>
</div>