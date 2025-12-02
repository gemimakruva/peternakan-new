<div class="card shadow-sm border-0">
    <div class="card-body pt-4">
        <div class="mb-3">
            <x-adminlte-input 
                name="nama" 
                label="Nama Peternakan" 
                type="text" 
                placeholder="Masukkan nama Peternakan..." 
                :value="old('nama', @$peternakan->nama)" 
                igroup-size="md">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-home text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-textarea 
                name="lokasi" 
                label="Lokasi Peternakan" 
                rows="5" 
                placeholder="Masukkan alamat lengkap Peternakan...">
                {{ old('lokasi', @$peternakan->lokasi) }}</x-adminlte-textarea>
        </div>
    </div>
</div>
