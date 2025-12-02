<div class="card shadow-sm border-0">
    <div class="card-body pt-4">


        {{-- Dropdown Peternakan --}}
        <div class="mb-3">
            <x-adminlte-select2
            name="peternakan_id" 
            label="Pilih Peternakan" 
            igroup-size="md">
    
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-warehouse text-muted"></i>
                </div>
            </x-slot>

            @foreach($peternakanList as $peternakan)
                <option 
                    value="{{ $peternakan->id }}"
                    {{ old('peternakan_id', @$data->peternakan_id) == $peternakan->id ? 'selected' : '' }}>
                    {{ $peternakan->nama }}
                </option>
            @endforeach
            </x-adminlte-select2>
        </div>

        {{-- Dropdown Strain --}}
        <div class="mb-3">
            <x-adminlte-select2 
            name="strain_id" 
            label="Pilih Strain" 
            igroup-size="md">
    
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-warehouse text-muted"></i>
                </div>
            </x-slot>

            @foreach($strainList as $strain)
                <option 
                    value="{{ $strain->id }}"
                    {{ old('peternakan_id', @$data->strain_id) == $strain->id ? 'selected' : '' }}>
                    {{ $strain->nama }}
                </option>
            @endforeach
            </x-adminlte-select2>
        </div>

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
    </div>
</div>
