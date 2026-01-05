<x-adminlte-input
    name="nama"
    label="Jenis Treatment"
    type="text"
    placeholder="Masukkan jenis treatment..."
    :value="old('nama', @$data->nama)"
    igroup-size="md">
</x-adminlte-input>
