<div class="mb-4">
    <x-adminlte-input 
        name="nama"
        label="Nama Pipe"
        type="text"
        placeholder="Masukkan nama Pipe..."
        :value="old('nama', @$pipe->nama)"
        igroup-size="lg"
        fgroup-class="col-12"
        class="form-control form-control-lg py-3">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>

    </x-adminlte-input>
</div>

<div class="mb-4">
    <x-adminlte-input 
        name="kapasitas"
        label="Kapasitas"
        type="number"
        placeholder="Masukkan kapasitas..."
        :value="old('kapasitas', @$pipe->kapasitas)"
        igroup-size="lg"
        fgroup-class="col-12"
        class="form-control form-control-lg py-3">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-boxes text-muted"></i>
            </div>
        </x-slot>

    </x-adminlte-input>
</div>
