<div class="card">
    <div class="card-header">
        <h2 class="card-title">Form Kandang</h2>
    </div>
    <div class="card-body">
        <x-adminlte-input  name="nama" label="Nama" type="text" placeholder="Nama" :value="old('nama', @$data->nama)" />
        <x-adminlte-textarea  name="alamat" label="Alamat" placeholder="Alamat">{{ old('alamat', @$data->alamat) }}</x-adminlte-textarea>
    </div>
</div>
