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
        {{-- @dd( $populasi->pengadaanDistribusi->pipe->nama) --}}
        @php
            $pipe = $populasi->pengadaanDistribusi->pipe ?? null;
            $flock = $pipe->flock ?? null;
            $kandang = $flock->kandang ?? null;
        @endphp
            <option value="{{ $populasi->id }}"
                {{ old('populasi_ayam_id', @$data->populasi_ayam_id) == $populasi->id ? 'selected' : '' }}>
               {{ $kandang->nama ?? '-' }} - Flock: {{ $flock->nama ?? '-' }} - Pipe: {{ $pipe->nama ?? '-' }}
        @endforeach
    </x-adminlte-select2>
</div>

{{-- Tanggal Transaksi --}}
<div class="mb-3">
    <x-adminlte-input 
        name="tanggal_karantina" 
        label="Tanggal Transaksi" 
        type="date" 
        igroup-size="md"
        value="{{ old('tanggal', @$data->tanggal ?? \Carbon\Carbon::now()->format('Y-m-d')) }}">
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-calendar-alt text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Ayam Masuk Karantina --}}
<div class="mb-3">
    <x-adminlte-input 
        name="ayam_masuk_karantina" 
        label="Ayam Masuk Karantina" 
        type="number" 
        igroup-size="md"
        value="{{ old('ayam_masuk_karantina', @$data->ayam_masuk_karantina) }}"
        placeholder="Masukkan jumlah ayam masuk karantina" 
        required>
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-warehouse text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Ayam Mati --}}
<div class="mb-3">
    <x-adminlte-input 
        name="ayam_mati" 
        label="Ayam Mati" 
        type="number" 
        igroup-size="md"
        value="{{ old('ayam_mati', @$data->ayam_mati) }}"
        placeholder="Masukkan jumlah ayam mati" 
        required>
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-skull text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- ayam afkir --}}
<div class="mb-3">
    <x-adminlte-input 
        name="ayam_afkir" 
        label="Ayam Afkri" 
        type="number" 
        igroup-size="md"
        value="{{ old('ayam_afkir', @$data->ayam_afkir) }}"
        placeholder="Masukkan jumlah ayam afkir" 
        required>
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
              <i class="fas fa-drumstick-bite text-muted"></i>

            </div>
        </x-slot>
    </x-adminlte-input>
</div>


{{-- Ayam Keluar Karantina --}}
<div class="mb-3">
    <x-adminlte-input 
        name="ayam_keluar_karantina" 
        label="Ayam Keluar Karantina" 
        type="number" 
        igroup-size="md"
        value="{{ old('ayam_keluar_karantina', @$data->ayam_keluar_karantina) }}"
        placeholder="Masukkan jumlah ayam keluar karantina" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-dove text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Pemberian Pakan --}}
<div class="mb-3">
    <x-adminlte-input 
        name="pemberian_pakan" 
        label="Pemberian Pakan (kg)" 
        type="number" step="0.01"
        igroup-size="md"
        value="{{ old('pemberian_pakan', @$data->pemberian_pakan) }}"
        placeholder="Masukkan jumlah pakan" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-seedling text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Sisa Pakan --}}
<div class="mb-3">
    <x-adminlte-input 
        name="sisa_pakan" 
        label="Sisa Pakan (kg)" 
        type="number" step="0.01"
        igroup-size="md"
        value="{{ old('sisa_pakan', @$data->sisa_pakan) }}"
        placeholder="Masukkan sisa pakan" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-seedling text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Jumlah Telur Bagus --}}
<div class="mb-3">
    <x-adminlte-input 
        name="jumlah_telur_bagus" 
        label="Jumlah Telur Bagus" 
        type="number" 
        igroup-size="md"
        value="{{ old('jumlah_telur_bagus', @$data->jumlah_telur_bagus) }}"
        placeholder="Masukkan jumlah telur bagus" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-egg text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Jumlah Telur Retak --}}
<div class="mb-3">
    <x-adminlte-input 
        name="jumlah_telur_retak" 
        label="Jumlah Telur Retak" 
        type="number" 
        igroup-size="md"
        value="{{ old('jumlah_telur_retak', @$data->jumlah_telur_retak) }}"
        placeholder="Masukkan jumlah telur retak" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-egg text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Jumlah Telur Rusak --}}
<div class="mb-3">
    <x-adminlte-input 
        name="jumlah_telur_rusak" 
        label="Jumlah Telur Rusak" 
        type="number" 
        igroup-size="md"
        value="{{ old('jumlah_telur_rusak', @$data->jumlah_telur_rusak) }}"
        placeholder="Masukkan jumlah telur rusak" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-egg text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Berat Telur Bagus --}}
<div class="mb-3">
    <x-adminlte-input 
        name="berat_telur_bagus" 
        label="Berat Telur Bagus (gram)" 
        type="number" step="0.01"
        igroup-size="md"
        value="{{ old('berat_telur_bagus', @$data->berat_telur_bagus) }}"
        placeholder="Masukkan berat telur bagus" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-weight text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Berat Telur Retak --}}
<div class="mb-3">
    <x-adminlte-input 
        name="berat_telur_retak" 
        label="Berat Telur Retak (gram)" 
        type="number" step="0.01"
        igroup-size="md"
        value="{{ old('berat_telur_retak', @$data->berat_telur_retak) }}"
        placeholder="Masukkan berat telur retak" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-weight text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Berat Telur Rusak --}}
<div class="mb-3">
    <x-adminlte-input 
        name="berat_telur_rusak" 
        label="Berat Telur Rusak (gram)" 
        type="number" step="0.01"
        igroup-size="md"
        value="{{ old('berat_telur_rusak', @$data->berat_telur_rusak) }}"
        placeholder="Masukkan berat telur rusak" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-weight text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Penyebab ayam karantina  --}}
<div class="mb-3">
    <x-adminlte-textarea
        name="penyebab_karantina"
        label="Penyebab Karantina"
        igroup-size="md"
        placeholder="Masukkan penyebab ayam masuk karantina"
        rows="3">
        
        {{ old('penyebab_karantina', @$data->penyebab_karantina) }}
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-info-circle text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-textarea>
</div>



{{-- Pengobatan yang Dilakukan --}}
<div class="mb-3">
    <x-adminlte-input 
        name="pengobatan_yang_dilakukan" 
        label="Pengobatan yang Dilakukan" 
        type="text" 
        igroup-size="md"
        value="{{ old('pengobatan_yang_dilakukan', @$data->pengobatan_yang_dilakukan) }}"
        placeholder="Masukkan jenis pengobatan" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-pills text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Jumlah Ayam Diobati --}}
<div class="mb-3">
    <x-adminlte-input 
        name="jumlah_ayam_diobati" 
        label="Jumlah Ayam Diobati" 
        type="number" 
        igroup-size="md"
        value="{{ old('jumlah_ayam_diobati', @$data->jumlah_ayam_diobati) }}"
        placeholder="Masukkan jumlah ayam diobati" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-user-md text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Penyemprotan --}}
<div class="mb-3">
    <x-adminlte-input 
        name="penyemprotan" 
        label="Penyemprotan" 
        type="text" 
        igroup-size="md"
        value="{{ old('penyemprotan', @$data->penyemprotan) }}"
        placeholder="Masukkan jenis penyemprotan" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-spray-can text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Vaksin --}}
<div class="mb-3">
    <x-adminlte-input 
        name="vaksin" 
        label="Vaksin" 
        type="text" 
        igroup-size="md"
        value="{{ old('vaksin', @$data->vaksin) }}"
        placeholder="Masukkan jenis vaksin" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-syringe text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Catatan --}}
<div class="mb-3">
    <x-adminlte-textarea 
        name="catatan" 
        label="Catatan" 
        igroup-size="md" 
        placeholder="Tambahkan catatan jika perlu" 
        rows="4">{{ old('catatan', @$data->catatan) }}</x-adminlte-textarea>
</div>
