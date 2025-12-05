{{-- Jenis Treatment --}}
<div class="mb-3">
    <x-adminlte-input 
        name="nama" 
        label="Jenis Treatment" 
        type="text" 
        igroup-size="md"
        value="{{ old('nama', @$data->nama) }}"
        placeholder="Masukkan jenis treatment" 
        required>

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="bi-tools text-muted"></i> {{-- icon diubah sesuai treatment --}}
            </div>
        </x-slot>

    </x-adminlte-input>
</div>
