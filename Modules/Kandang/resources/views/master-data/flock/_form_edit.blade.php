<div class="mb-3">
    <x-adminlte-input 
        name="nama" 
        label="Nama Flock" 
        type="text" 
        placeholder="Masukkan nama flock..." 
        :value="old('nama', @$flock->flock_name)" 
        igroup-size="md">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

<div class="mb-3">
    <x-adminlte-select 
        name="kandang_id" 
        label="Pilih Kandang" 
        igroup-size="md"
        disabled>
        <option value="" readonly>-- Pilih Kandang --</option>
        @foreach($kandangs as $kandang)
            <option value="{{ $kandang->id }}" 
                {{ old('kandang_id', $flock->kandang_id) == $kandang->id ? 'selected' : '' }}>
                {{ $kandang->nama }}
            </option>
        @endforeach
    </x-adminlte-select>
</div>


<div class="mb-3">
    <x-adminlte-input 
        name="date_in" 
        label="Tanggal Masuk" 
        type="date" 
        :value="old('date_in', @$flock->date_in)" 
        igroup-size="md">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-calendar-alt text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

<div class="mb-3">
    <x-adminlte-input 
        name="total_capacity" 
        label="Total Kapasitas" 
        type="number" 
        min="0" 
        placeholder="Masukkan total kapasitas ayam..." 
        value="{{ $flock->pipes->sum('capacity') }}" 
        igroup-size="md"
        readonly>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-drumstick-bite text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

<div class="mb-3">
    <x-adminlte-input 
        name="pipe_count" 
        label="Jumlah Pipa per Flock" 
        type="number" 
        min="0" 
        placeholder="Masukkan jumlah pipa untuk flock ini..." 
        value="{{ $flock->pipes->count() }}" {{-- dummy value --}}
        igroup-size="md"
        readonly>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-tint text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>
