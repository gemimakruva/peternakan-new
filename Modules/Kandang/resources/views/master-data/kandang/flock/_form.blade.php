<div class="card">
    <div class="card-header">
        <h2 class="card-title">Form Flock</h2>
    </div>
    <div class="card-body">
        <x-adminlte-input
            label="Nama Peternakan"
            name="nama_peternakan"
            :value="$kandang->peternakan->nama"
            readonly
        />

        <x-adminlte-input
            label="Nama Kandang"
            name="nama_kandang"
            :value="$kandang->nama"
            readonly
        />

        <x-adminlte-input
            label="Nama Flock"
            name="nama"
            placeholder="Masukkan nama flock..."
            :value="old('nama', @$flock->nama)"
        />
    </div>
</div>