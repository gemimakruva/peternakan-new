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

        <x-adminlte-select
            label="Asal"
            name="asal"
        >
            <x-adminlte-options
                :options="$listAsal"
                :selected="old('asal', @$data->asal->value)"
                empty-option="Pilih Asal"
            />
        </x-adminlte-select>

        <x-adminlte-input
            type="date"
            label="Tanggal"
            name="tanggal"
            :value="old('tanggal', @$data->tanggal?->format('Y-m-d'))"
        />
    </div>
</div>