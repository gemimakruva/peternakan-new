<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Formulasi"
            name="formulasi_premix_id"
        >
            <x-adminlte-options
                :options="$listFormulasi"
                :selected="old('formulasi_premix_id', @$data->formulasi_premix_id)"
                empty-option="Pilih Formulasi"
            />
        </x-adminlte-select>
        
        <x-adminlte-input
            type="datetime-local"
            name="tanggal"
            label="Waktu Penggilihan"
            :value="old('tanggal', @$data->tanggal)"
        />

        <x-adminlte-input
            type="number"
            name="jumlah_campuran"
            label="Jumlah Campuran"
            :value="old('jumlah_campuran', @$data->jumlah_campuran)"
        />
    </div>
</div>