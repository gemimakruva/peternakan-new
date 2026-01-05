<x-adminlte-input
    name="nama"
    label="Jenis Disinfektan"
    type="text"
    placeholder="Masukkan jenis disinfektan..."
    :value="old('nama', @$data->nama)"
    igroup-size="md">
</x-adminlte-input>
