<x-adminlte-input
    name="nama"
    label="Jenis Pakan"
    type="text"
    placeholder="Masukkan jenis pakan..."
    :value="old('nama', @$data->nama)"
    igroup-size="md">
</x-adminlte-input>
