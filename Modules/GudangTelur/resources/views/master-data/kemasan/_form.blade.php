<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <x-adminlte-select label="Satuan" name="satuan_id">
                    <x-adminlte-options :options="$listSatuan" empty-option="Pilih Satuan" :selected="@$data->satuan_id" />
                </x-adminlte-select>
            </div>
            <div class="col-12 col-md-6">
                <x-adminlte-input label="Nama" name="nama" :value="old('nama', @$data->nama)" />
            </div>
        </div>
    </div>
</div>