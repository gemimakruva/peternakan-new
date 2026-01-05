<x-adminlte-input
    name="name"
    label="Nama Role"
    type="text"
    placeholder="Masukkan nama Role..."
    :value="old('name', @$role->name)"
    igroup-size="md">
</x-adminlte-input>