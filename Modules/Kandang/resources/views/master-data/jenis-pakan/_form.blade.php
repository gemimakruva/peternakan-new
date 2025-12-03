{{-- Jenis Pakan --}}
<div class="mb-3">
    <x-adminlte-input 
        name="nama" 
        label="Jenis Pakan" 
        type="text" 
        igroup-size="md"
        value="{{ old('jenis_pakan', @$data->nama) }}"
        placeholder="Masukkan jenis pakan" 
        required>
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="bi-leaf-fill text-muted"></i>
                
            </div>
        </x-slot>
    </x-adminlte-input>
</div>
