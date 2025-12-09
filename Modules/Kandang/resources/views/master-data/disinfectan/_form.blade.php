{{-- Jenis Disinfektan--}}
<div class="mb-3">
    <x-adminlte-input 
        name="nama" 
        label="Jenis Disinfektan" 
        type="text" 
        igroup-size="md"
        value="{{ old('nama', @$data->nama) }}"
        placeholder="Masukkan Jenis Disinfektan" 
        required>

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="bi-shield-check text-muted"></i>
            </div>
        </x-slot>

    </x-adminlte-input>
</div>
