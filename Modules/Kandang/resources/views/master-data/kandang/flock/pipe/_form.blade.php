<div class="card">
    <div class="card-header">
        <h2 class="card-title">Form Baris</h2>
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
            label="Nama Baris"
            name="nama_baris"
            :value="$flock->nama"
            readonly
        />

        <x-adminlte-input
            label="Nama Pipa"
            name="nama"
            placeholder="Masukkan nama pipa..."
            :value="old('nama', @$pipe->nama)"
        />

        <x-adminlte-input
            label="Kapasitas"
            name="kapasitas"
            placeholder="Masukkan kapasitas..."
            :value="old('kapasitas', @$pipe->kapasitas)"
        />
    </div>
</div>