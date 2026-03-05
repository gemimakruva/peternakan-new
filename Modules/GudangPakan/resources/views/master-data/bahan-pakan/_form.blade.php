<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Tipe"
            name="tipe"
        >
            <x-adminlte-options
                :options="$listTipe"
                empty-option="Pilih Tipe"
                :selected="old('tipe', @$data->tipe)"
            />
        </x-adminlte-select>

        <x-adminlte-input 
            label="Nama"
            name="nama"
            :value="old('nama', @$data->nama)"
        />

        <x-adminlte-select
            label="Satuan"
            name="satuan_id"
        >
            <x-adminlte-options
                :options="$listSatuan"
                empty-option="Pilih Satuan"
                :selected="old('satuan_id', @$data->satuan_id)"
            />
        </x-adminlte-select>

        <x-adminlte-input
            type="number"
            label="Harga"
            name="harga"
            :value="old('harga', @$data->harga)"
        />

        <x-adminlte-input
            type="number"
            label="Jumlah Satuan"
            name="jumlah_satuan"
            :value="old('jumlah_satuan', @$data->jumlah_satuan)"
        />
    </div>
</div>