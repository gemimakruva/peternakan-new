<x-adminlte-input
    name="nama"
    label="Metode Treatment"
    type="text"
    placeholder="Masukkan metode treatment..."
    :value="old('nama', @$data->nama)"
    igroup-size="md">
</x-adminlte-input>
