<div class="card">
    <div class="card-header">
        <h2 class="card-title">Generate Flock dan Pipa</h2>
    </div>
    <div class="card-body">
        <x-adminlte-input
            name="nama_flock"
            label="Nama Flock"
            type="text"
            placeholder="Masukkan nama flock..."
            :value="old('nama_flock')"
        />

        <x-adminlte-input
            name="banyak_flock"
            label="Banyak Flock"
            type="number"
            placeholder="Masukkan banyak flock..."
            :value="old('banyak_flock')"
        />

        <x-adminlte-input
            name="nama_pipa"
            label="Nama Pipa"
            type="text"
            placeholder="Masukkan nama pipa..."
            :value="old('nama_pipa')"
        />

        <x-adminlte-input
            name="banyak_pipa_per_flock"
            label="Banyak Pipa per Flock"
            type="number"
            placeholder="Masukkan Banyak Pipa per Flock..."
            :value="old('banyak_pipa_per_flock')"
        />

        <x-adminlte-input
            name="kapasitas_pipa"
            label="Kapasitas Pipa"
            type="number"
            placeholder="Masukkan Kapasitas Pipa..."
            :value="old('kapasitas_pipa')"
        />

    </div>
</div>