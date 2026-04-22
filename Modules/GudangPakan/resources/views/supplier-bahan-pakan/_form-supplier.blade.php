<div class="card">
    <div class="card-body">
        <x-adminlte-input 
            label="Nama"
            name="nama"
            :value="old('nama', @$data->nama)"
        />

        <x-adminlte-input
            label="Badan Usaha"
            name="badan_usaha"
            :value="old('badan_usaha', @$data->badan_usaha)"
        />

        <x-adminlte-input
            label="Kontak"
            name="kontak"
            :value="old('kontak', @$data->kontak)"
        />

        <x-adminlte-textarea
            label="Alamat"
            name="alamat"
        >{{ old('alamat', @$data->alamat) }}</x-adminlte-textarea>

        <x-adminlte-textarea
            label="Lokasi"
            name="lokasi"
        >{{ old('lokasi', @$data->lokasi) }}</x-adminlte-textarea>
    </div>
</div>