<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <x-adminlte-input label="Nama" name="nama" :value="old('nama', @$data->nama)" />
            </div>
            <div class="col-12 col-md-6">
                <x-adminlte-input label="Badan Usaha" name="badan_usaha" :value="old('badan_usaha', @$data->badan_usaha)" />
            </div>
            <div class="col-12 col-md-6">
                <x-adminlte-input label="Kontak" name="kontak" :value="old('kontak', @$data->kontak)" />
            </div>
        </div>

        <x-adminlte-textarea label="Alamat" name="alamat">{{ old('alamat', @$data->alamat) }}</x-adminlte-textarea>

        <x-adminlte-textarea label="Lokasi" name="lokasi">{{ old('lokasi', @$data->lokasi) }}</x-adminlte-textarea>
    </div>
</div>