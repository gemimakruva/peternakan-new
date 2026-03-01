<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Satuan"
            name="satuan_id"
        >
            <x-adminlte-options
                :options="$listSatuan"
                empty-option="Pilih Satuan"
                :selected="@$data->satuan_id"
            />
        </x-adminlte-select>

        <x-adminlte-input 
            label="Nama"
            name="nama"
            :value="old('nama', @$data->nama)"
        />
    </div>
</div>