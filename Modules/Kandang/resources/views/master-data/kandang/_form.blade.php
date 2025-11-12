<div class="card shadow-sm border-0">
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
            <i class="fas fa-clipboard-list me-2 text-muted"></i> Form Kandang
        </h5>
    </div>

    <div class="card-body pt-4">
        <div class="mb-3">
            <x-adminlte-input 
                name="nama" 
                label="Nama Kandang" 
                type="text" 
                placeholder="Masukkan nama kandang..." 
                :value="old('nama', @$data->nama)" 
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
                name="alamat" 
                label="Alamat Kandang" 
                rows="5" 
                placeholder="Masukkan alamat lengkap kandang...">{{ old('alamat', @$data->alamat) }}</x-adminlte-textarea>
        </div>
    </div>
</div>
