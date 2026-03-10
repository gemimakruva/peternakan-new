<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Formulasi"
            name="formulasi_mix_id"
        >
            <x-adminlte-options
                :options="$listFormulasi"
                :selected="old('formulasi_mix_id', @$data->formulasi_mix_id)"
                empty-option="Pilih Formulasi"
            />
        </x-adminlte-select>

        <x-adminlte-input
            type="datetime-local"
            label="Tanggal"
            name="tanggal"
            :value="old('tanggal', @$data->tanggal)"
        />
        
        <x-adminlte-input
            type="number"
            label="Jumlah (Kg)"
            name="jumlah"
            :value="old('jumlah', @$data->jumlah)"
        />

        <x-adminlte-input
            type="text"
            label="Tujuan"
            name="tujuan"
            :value="old('tujuan', @$data->tujuan)"
        />
    </div>
</div>