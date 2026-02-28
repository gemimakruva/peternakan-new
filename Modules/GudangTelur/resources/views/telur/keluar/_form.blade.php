<div class="card">
    <div class="card-body">
        <x-adminlte-select2
            :config="[
                'tags' => true,
                'allowClear' => true,
                'placeholder' => 'Pilih atau ketik baru', 
            ]"
            label="Tujuan Telur"
            name="telur_tujuan_id"
        >
            <x-adminlte-options
                :options="$listTujuanTelur"
                :selected="old('telur_tujuan_id', @$data->telur_tujuan_id)"
            />
        </x-adminlte-select2>

        <x-adminlte-input
            type="date"
            label="Tanggal"
            name="tanggal"
            :value="old('tanggal', @$data->tanggal?->format('Y-m-d'))"
        />
    </div>
</div>