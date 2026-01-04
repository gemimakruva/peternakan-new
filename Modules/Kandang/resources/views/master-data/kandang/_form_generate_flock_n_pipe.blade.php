<div class="card">
    <div class="card-header">
        <h2 class="card-title">Generate Baris dan Pipa</h2>
    </div>
    <div class="card-body">
        <x-adminlte-input
            name="nama_baris"
            label="Nama Baris"
            type="text"
            placeholder="Masukkan nama baris..."
            :value="old('nama_baris')"
        />

        <x-adminlte-input
            name="banyak_baris"
            label="Banyak Baris"
            type="number"
            placeholder="Masukkan banyak baris..."
            :value="old('banyak_baris')"
        />

        <x-adminlte-input
            name="nama_pipa"
            label="Nama Pipa"
            type="text"
            placeholder="Masukkan nama pipa..."
            :value="old('nama_pipa')"
        />

        <x-adminlte-input
            name="banyak_pipa_per_baris"
            label="Banyak Pipa per Baris"
            type="number"
            placeholder="Masukkan Banyak Pipa per Baris..."
            :value="old('banyak_pipa_per_baris')"
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