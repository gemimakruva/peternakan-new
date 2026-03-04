<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Tipe"
            name="tipe"
        >
            <x-adminlte-options
                :options="$listTipe"
                empty-option="Pilih Tipe"
                :selected="@$data->tipe"
            />
        </x-adminlte-select>

        <x-adminlte-input 
            label="Nama"
            name="nama"
            :value="old('nama', @$data->nama)"
        />
    </div>
</div>