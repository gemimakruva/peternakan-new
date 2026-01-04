<x-adminlte-input 
    name="nama" 
    label="Nama Peternakan" 
    type="text" 
    placeholder="Masukkan nama Peternakan..." 
    :value="old('nama', @$peternakan->nama)" 
    igroup-size="md">
</x-adminlte-input>

<x-adminlte-textarea name="lokasi" label="Lokasi Peternakan" rows="5" placeholder="Masukkan alamat lengkap Peternakan..."
>{{ old('lokasi', @$peternakan->lokasi) }}</x-adminlte-textarea>