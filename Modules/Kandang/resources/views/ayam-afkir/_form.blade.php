<div class="card shadow-sm border-0">
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
            <i class="fas fa-dove me-2 text-muted"></i> Form Transaksi Ayam Afkir
        </h5>
    </div>

    <div class="card-body pt-4">

        {{-- Input tanggal afkir ayam --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="tanggal_afkir"
                label="Tanggal Afkir"
                type="date"
                :value="old('tanggal_afkir', @$data->tanggal_afkir)"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-calendar-alt text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Dropdown kandang --}}
        <div class="mb-4">
            <x-adminlte-select 
                name="kandang_id"
                label="Pilih Kandang"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-home text-muted"></i>
                    </div>
                </x-slot>

                <option value="" disabled selected>Pilih Kandang</option>

                @foreach($kandangs as $item)
                    <option value="{{ $item->id }}" 
                        {{ old('kandang_id', @$data->kandang_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </x-adminlte-select>
        </div>

        {{-- Dropdown flock --}}
        <div class="mb-4">
            <x-adminlte-select 
                name="flock_id"
                label="Pilih Flock"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-feather-alt text-muted"></i>
                    </div>
                </x-slot>

                <option value="" disabled selected>Pilih Flock</option>

                @foreach($flocks as $item)
                    <option value="{{ $item->id }}" 
                        {{ old('flock_id', @$data->flock_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->flock_name }}
                    </option>
                @endforeach
            </x-adminlte-select>
        </div>

        {{-- Dropdown pipe / kapasitas --}}
        <div class="mb-4">
            <x-adminlte-select 
                name="pipe_id"
                label="Pilih Pipe"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-database text-muted"></i>
                    </div>
                </x-slot>

                <option value="" disabled selected>Pilih Pipe</option>

                @foreach($pipes as $item)
                    <option value="{{ $item->id }}"
                        {{ old('pipe_id', @$data->pipe_id) == $item->id ? 'selected' : '' }}>
                        Pipe #{{ $item->id }} — Kapasitas: {{ $item->capacity }}
                    </option>
                @endforeach
            </x-adminlte-select>
        </div>

        {{-- Input umur ayam (hari) --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="umur_ayam"
                label="Umur Ayam (hari)"
                type="number"
                placeholder="Contoh: 420"
                :value="old('umur_ayam', @$data->umur_ayam)"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-clock text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Input jumlah ayam afkir --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="jumlah_ayam_afkir"
                label="Jumlah Ayam Afkir"
                type="number"
                placeholder="Masukkan jumlah..."
                :value="old('jumlah_ayam_afkir', @$data->jumlah_ayam_afkir)"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-list-ol text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Input penyebab afkir --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="penyebab_afkir"
                label="Penyebab Afkir"
                type="text"
                placeholder="Contoh: Produksi menurun"
                :value="old('penyebab_afkir', @$data->penyebab_afkir)"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-exclamation-triangle text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Input nama pembeli --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="nama_pembeli"
                label="Nama Pembeli"
                type="text"
                placeholder="Masukkan nama pembeli..."
                :value="old('nama_pembeli', @$data->nama_pembeli)"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-user text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Input harga jual --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="harga_jual_per_kg"
                label="Harga Jual per KG (Rp)"
                type="number"
                placeholder="Contoh: 23000"
                :value="old('harga_jual_per_kg', @$data->harga_jual_per_kg)"
                igroup-size="lg"
                fgroup-class="col-12">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-money-bill-wave text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

    </div>
</div>
