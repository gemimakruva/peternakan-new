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
    label="Nama Flock" 
    type="text" 
    placeholder="Masukkan nama flock..." 
    :value="old('nama', $flock->nama)" 
/>