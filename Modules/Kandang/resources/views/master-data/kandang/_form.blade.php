<x-adminlte-select2
    name="peternakan_id"
    label="Pilih Peternakan"
    igroup-size="md"
    class="mb-3"
>
    @foreach($peternakanList as $peternakan)
        <option
            value="{{ $peternakan->id }}"
            {{ old('peternakan_id', @$data->peternakan_id) == $peternakan->id ? 'selected' : '' }}>
            {{ $peternakan->nama }}
        </option>
    @endforeach
</x-adminlte-select2>

<x-adminlte-select2
    name="strain_id"
    label="Pilih Strain"
    igroup-size="md"
    class="mb-3"
>
    @foreach($strainList as $strain)
        <option
            value="{{ $strain->id }}"
            {{ old('strain_id', @$data->strain_id) == $strain->id ? 'selected' : '' }}>
            {{ $strain->nama }}
        </option>
    @endforeach
</x-adminlte-select2>

<x-adminlte-input
    name="nama"
    label="Nama Kandang"
    type="text"
    placeholder="Masukkan nama kandang..."
    :value="old('nama', @$data->nama)"
    igroup-size="md" 
/>
