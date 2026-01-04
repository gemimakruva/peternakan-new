<x-adminlte-input 
    name="nama_peternakan" 
    label="Nama Peternakan"
    :value="@$flock->kandang->peternakan->nama"
    readonly
/>

<x-adminlte-input 
    name="nama_kandang" 
    label="Nama Kandang"
    :value="@$flock->kandang->nama"
    readonly
/>

<x-adminlte-input 
    name="nama" 
    label="Nama Baris" 
    type="text" 
    placeholder="Masukkan nama baris..." 
    :value="old('nama', $flock->nama)" 
/>