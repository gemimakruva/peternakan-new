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

     {{-- Pilih Pipe --}}
    <div class="mb-3">
        <x-adminlte-select name="pipe_id" label="Pilih Pipa" igroup-size="md">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-cogs text-muted"></i>
                </div>
            </x-slot>

            @foreach ($listPipe as $pipe)
                <option value="{{ $pipe->id }}"
                    {{ old('pipe_id', @$data->pipe_id) == $pipe->id ? 'selected' : '' }}>
                    {{ $pipe->nama }}
                </option>
            @endforeach

        </x-adminlte-select>
    </div>


        {{-- Jumlah Ayam per --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="jumlah_ayam" 
                label="Jumlah Ayam" 
                type="number" 
                igroup-size="md"
                value="{{ old('jumlah_ayam', @$data->jumlah_ayam) }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-drumstick-bite text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Jumlah Pakan per Ekor (gram) --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="jumlah_pakan_per_ekor_gram" 
                label="Jumlah Pakan per Ekor (gram)" 
                type="number" 
                step="0.01"
                igroup-size="md"
                value="{{ old('jumlah_pakan_per_ekor_gram', @$data->jumlah_pakan_per_ekor_gram) }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-bread-slice text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{--  Proposi pemberian pakan + jenis pakan pagi --}}

        <div class="row mb-3">
            <div class="col-md-6">
                <x-adminlte-input 
                    name="proporsi_pemberian_pagi" 
                    label="Proporsi Pemberian Pagi (%)" 
                    type="number" 
                    step="0.01"
                    igroup-size="md"
                    value="{{ old('proporsi_pemberian_pagi', @$data->proporsi_pemberian_pagi) }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-sun text-muted"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>

    {{-- Jenis Pakan --}}
        <div class="col-md-6">
            <x-adminlte-input 
                name="jam_pemberian_pagi" 
                label="Jam Pemberian Pagi (WIB)" 
                type="time" 
                igroup-size="md"
                value="{{ old('jam_pemberian_pagi', @$data->jam_pemberian_pagi) }}"
                min="05:00"
                max="09:30">
                
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-clock text-muted"></i>
                    </div>
                </x-slot>

                <x-slot name="appendSlot">
                    <div class="input-group-text bg-white font-bold text-sm">
                        WIB
                    </div>
                </x-slot>

            </x-adminlte-input>
        </div>

    </div>

     {{--  Proposi pemberian pakan + jenis pakan sore --}}

<div class="row mb-3">
    <div class="col-md-6">
        <x-adminlte-input 
            name="proporsi_pemberian_sore" 
            label="Proporsi Pemberian Sore" 
            type="number" 
            step="0.01"
            igroup-size="md"
            value="{{ old('proporsi_pemberian_sore', @$data->proporsi_pemberian_sore) }}">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-cloud-moon text-secondary"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="col-md-6">
        <x-adminlte-input 
            name="jam_pemberian_sore" 
            label="Jam Pemberian Sore (WIB)" 
            type="time" 
            igroup-size="md"
            value="{{ old('jam_pemberian_sore', @$data->jam_pemberian_sore) }}"
            min="15:00"
            max="18:30">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-clock text-secondary"></i>
                </div>
            </x-slot>
            <x-slot name="appendSlot">
                <div class="input-group-text bg-white font-bold text-sm">
                    WIB
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>

</div>

{{-- jenis pakan --}}
<div class="mb-3">
    <x-adminlte-select name="jenis_pakan_id" label="Jenis Pakan" igroup-size="md">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-seedling text-muted"></i>
            </div>
        </x-slot>

        <option value="">-- Pilih Jenis Pakan --</option>
        @foreach($listJenisPakan as $pakan)
            <option value="{{ $pakan->id }}" 
                {{ old('jenis_pakan_id', @$data->jenis_pakan_id) 
                == $pakan->id ? 'selected' : '' }}>
                {{ $pakan->nama }}
            </option>
        @endforeach
    </x-adminlte-select>
</div>

{{-- catatan --}}
<div class="mb-3">
    <x-adminlte-textarea 
        name="catatan" 
        label="Catatan" 
        igroup-size="md"
        rows="5"
        placeholder="Tulis catatan di sini...">
        
        {{ old('catatan', @$data->catatan) }}

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-sticky-note text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-textarea>
</div>





