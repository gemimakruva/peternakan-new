<div class="card">
    <div class="card-header">
        <h2 class="card-title">Form Pipa</h2>
    </div>
    <div class="card-body">
        <x-adminlte-input 
            name="nama"
            label="Nama Pipa"
            type="text"
            placeholder="Masukkan nama Pipa..."
            :value="old('nama', @$pipe->nama)"
        />

        <x-adminlte-input 
            name="kapasitas"
            label="Kapasitas"
            type="number"
            placeholder="Masukkan kapasitas..."
            :value="old('kapasitas', @$pipe->kapasitas)"
        />
    </div>
</div>