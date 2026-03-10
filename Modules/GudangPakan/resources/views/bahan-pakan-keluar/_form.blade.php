<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Tujuan"
            name="tujuan"
        >
            <x-adminlte-options
                :options="$listTujuan"
                :selected="old('tujuan', @$data->tujuan->value)"
                empty-option="Pilih Tujuan"
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