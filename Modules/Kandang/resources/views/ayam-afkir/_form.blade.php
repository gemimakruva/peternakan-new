  {{-- Populasi Ayam --}}
   <div class="mb-3">
        <x-adminlte-select2 
            name="populasi_ayam_id" 
            label="Pilih Populasi Ayam" 
            igroup-size="md"
            data-placeholder="Pilih Populasi Ayam...">

            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-layer-group text-muted"></i>
                </div>
            </x-slot>

            <option disabled selected>Pilih Populasi Ayam...</option>
            @foreach($listPopulasiAyam as $populasi)
                <option value="{{ $populasi->id }}"
                    {{ old('populasi_ayam_id', @$data->populasi_ayam_id) == $populasi->id ? 
                    'selected' : '' }}>
                    {{ $populasi->kandang->nama }} - Flock: {{ $populasi->flock->nama }} 
                    - Pipe: {{ $populasi->pipe->nama }}
                </option>
            @endforeach
        </x-adminlte-select2>
    </div>

 {{-- Tanggal --}}
    <div class="mb-3">
        <x-adminlte-input 
            name="tanggal" 
            label="Tanggal Transaksi" 
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


        {{-- Umur Ayam --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="umur_ayam" 
                label="Umur Ayam (mingguan)" 
                type="number" 
                igroup-size="md"
                value="{{ old('umur_ayam', @$data->umur_ayam) }}"
                placeholder="Masukkan umur ayam" required>
                
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-hourglass-half text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Jumlah ayam afkir --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="jumlah_ayam_afkir" 
                label="Jumlah Ayam Afkir" 
                type="number" 
                igroup-size="md"
                value="{{ old('jumlah_ayam_afkir', @$data->jumlah_ayam_afkir) }}"
                placeholder="Masukkan jumlah ayam afkir" required>
                
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-dove text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Nama Pembeli  --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="pembeli_afkir" 
                label="Nama Pembeli" 
                type="text" 
                igroup-size="md"
                value="{{ old('pembeli_afkir', @$data->pembeli_afkir) }}"
                placeholder="Masukkan nama pembeli (opsional)">
                
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-user-tie text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        {{-- Harga Jual --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="harga_jual" 
                label="Harga Jual (Rp)" 
                type="number" 
                igroup-size="md"
                value="{{ old('harga_jual', @$data->harga_jual) }}"
                placeholder="Masukkan harga jual (opsional)">
                
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-money-bill-wave text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Penyebab Afkir --}}
        <div class="mb-3">
            <x-adminlte-textarea 
                name="penyebab_afkir" 
                label="Penyebab Afkir" 
                igroup-size="md" 
                rows="5" 
                placeholder="Masukkan penyebab ayam afkir" required>
                
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-comment-alt text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-textarea>
        </div>
