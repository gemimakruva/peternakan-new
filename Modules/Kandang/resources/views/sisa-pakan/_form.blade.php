  {{-- tanggal pemberian pakan --}}
    <div class="mb-3">
        <x-adminlte-input 
            name="tanggal" 
            label="Tanggal Pemberian Pakan" 
            type="date" 
            igroup-size="md"
            value="{{ old('tanggal', @$data->tanggal ?? 
            \Carbon\Carbon::now()->format('Y-m-d')) }}">
            
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-calendar-alt text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>

    {{-- pilih kadang --}}
    <div class="mb-3">
        <x-adminlte-select
            name="kandang"
            label="Pilih Kandang"
            igroup-size="md">

            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-home text-muted"></i>
                </div>
            </x-slot>

            {{-- Dummy hardcode --}}
            <option value="">-- Pilih Kandang --</option>
            <option value="A1" {{ old('kandang', 
            @$data->kandang) == 'A1' ? 'selected' : '' }}>Kandang A1</option>
            <option value="B2" {{ old('kandang',
            @$data->kandang) == 'B2' ? 'selected' : '' }}>Kandang B2</option>
            <option value="C3" {{ old('kandang', 
            @$data->kandang) == 'C3' ? 'selected' : '' }}>Kandang C3</option>
            <option value="D4" {{ old('kandang', 
            @$data->kandang) == 'D4' ? 'selected' : '' }}>Kandang D4</option>

        </x-adminlte-select>
    </div>
    {{-- flock dropdown --}}
    <div class="mb-3">
        <x-adminlte-select
            name="flock"
            label="Pilih Flock"
            igroup-size="md">

            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-feather text-muted"></i>
                </div>
            </x-slot>

            {{-- Dummy hardcode --}}
            <option value="">-- Pilih Flock --</option>
            <option value="F001" {{ old('flock', @$data->flock) == 'F001' ? 
            'selected' : '' }}>Flock 001</option>
            <option value="F002" {{ old('flock', @$data->flock) == 'F002' ? 
            'selected' : '' }}>Flock 002</option>
            <option value="F003" {{ old('flock', @$data->flock) == 'F003' ? 
            'selected' : '' }}>Flock 003</option>
            <option value="F004" {{ old('flock', @$data->flock) == 'F004' ? 
            'selected' : '' }}>Flock 004</option>
        </x-adminlte-select>
    </div>
    {{-- jenis pakan --}}
    <div class="mb-3">
        <x-adminlte-select
            name="jenis_pakan"
            label="Jenis Pakan"
            igroup-size="md">

            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-drumstick-bite text-muted"></i>
                </div>
            </x-slot>

            {{-- Dummy hardcode --}}
            <option value="">-- Pilih Jenis Pakan --</option>
            <option value="BR1" {{ old('jenis_pakan', @$data->jenis_pakan) 
            == 'BR1' ? 'selected' : '' }}>BR 1 (Starter)</option>
            <option value="BR2" {{ old('jenis_pakan', @$data->jenis_pakan) 
            == 'BR2' ? 'selected' : '' }}>BR 2 (Grower)</option>
            <option value="BR3" {{ old('jenis_pakan', @$data->jenis_pakan) 
            == 'BR3' ? 'selected' : '' }}>BR 3 (Finisher)</option>
            <option value="MJ"  {{ old('jenis_pakan', @$data->jenis_pakan) 
            == 'MJ' ? 'selected' : '' }}>Mash Jagung</option>
            <option value="PK"  {{ old('jenis_pakan', @$data->jenis_pakan) 
            == 'PK' ? 'selected' : '' }}>Pakan Konsentrat</option>
        </x-adminlte-select>
    </div>
    {{-- pemberian pakan --}}
    <div class="mb-3">
        <x-adminlte-input 
            name="pemberian_pakan"
            label="Pemberian Pakan per Flock (Kg)"
            type="number"
            igroup-size="md"
            step="0.01"
            min="0"
            value="{{ old('pemberian_pakan', @$data->pemberian_pakan) }}">

            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-seedling text-muted"></i>
                </div>
            </x-slot>

            <x-slot name="appendSlot">
                <div class="input-group-text bg-white">
                    <span class="text-muted font-semibold">Kg</span>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    {{-- sisa pakan --}}
   <div class="mb-3">
    <x-adminlte-input 
        name="sisa_pakan"
        label="Sisa Pakan (Kg)"
        type="number"
        igroup-size="md"
        step="0.01"
        min="0"
        value="{{ old('sisa_pakan', @$data->sisa_pakan) }}">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-balance-scale text-muted"></i>
            </div>
        </x-slot>

        <x-slot name="appendSlot">
            <div class="input-group-text bg-white">
                <span class="text-muted font-semibold">Kg</span>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>





