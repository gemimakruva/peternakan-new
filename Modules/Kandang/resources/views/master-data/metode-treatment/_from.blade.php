{{-- Nama Metode Treatment --}}
<div class="mb-3">
    <x-adminlte-input
        name="nama"
        label="Metode Treatment"
        type="text"
        igroup-size="md"
        value="{{ old('nama', @$data->nama) }}"
        placeholder="Masukkan metode treatment"
        required>

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="bi bi-activity text-muted"></i>
            </div>
        </x-slot>

    </x-adminlte-input>
</div>
