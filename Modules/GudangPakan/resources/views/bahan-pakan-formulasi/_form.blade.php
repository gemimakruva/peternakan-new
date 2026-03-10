<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Jenis Pakan"
            name="jenis_pakan_id"
        >
            <x-adminlte-options
                :options="$listJenisPakan"
                :selected="old('jenis_pakan_id', @$data->jenis_pakan_id)"
                empty-option="Pilih Jenis Pakan"
            />
        </x-adminlte-select>

        <x-adminlte-select
            label="Tipe"
            name="tipe"
        >
            <x-adminlte-options
                :options="$listTipe"
                :selected="old('tipe', @$data->tipe->value)"
                empty-option="Pilih Tipe"
            />
        </x-adminlte-select>

        <x-adminlte-input
            label="Nama"
            name="nama"
            :value="old('nama', @$data->nama)"
            placeholder="Nama Formulasi"
        />
    </div>
</div>