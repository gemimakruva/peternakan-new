<div class="row">

    {{-- Tanggal Pengecekan --}}
    <div class="col-12 mb-3">
        <label class="form-label">Tanggal Pengecekan</label>
        <input type="date"
               name="tanggal_pengecekan"
               class="form-control @error('tanggal_pengecekan') is-invalid @enderror"
               value="{{ old('tanggal_pengecekan', $item->tanggal ?? '') }}">
        @error('tanggal_pengecekan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Kandang --}}
    <div class="col-12 mb-3">
        <label class="form-label">Kandang</label>
        <select name="kandang_id"
                class="form-control @error('kandang_id') is-invalid @enderror">
            <option value="">-- Pilih Kandang --</option>
            @foreach ($kandangs as $kandang)
                <option value="{{ $kandang->id }}"
                    {{ old('kandang_id', $item->kandang_id ?? '') == $kandang->id ? 'selected' : '' }}>
                    {{ $kandang->nama }}
                </option>
            @endforeach
        </select>
        @error('kandang_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Jenis OVK --}}
    <div class="col-12 mb-3">
    <label class="form-label">Jenis OVK</label>
        <select name="jenis_ovk"
                class="form-control @error('jenis_ovk') is-invalid @enderror">
            <option value="">-- Pilih Jenis OVK --</option>
            <option value="disinfektan" {{ old('jenis_ovk', $item->jenis_ovk ?? '') 
            == 'disinfektan' ? 'selected' : '' }}>
                Disinfektan
            </option>
            <option value="vitamin" {{ old('jenis_ovk', $item->jenis_ovk ?? '') 
            == 'vitamin' ? 'selected' : '' }}>
                Vitamin
            </option>
            <option value="vaksin" {{ old('jenis_ovk', $item->jenis_ovk ?? '') 
            == 'vaksin' ? 'selected' : '' }}>
                Vaksin
            </option>
        </select>
    @error('jenis_ovk')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>


    {{-- Merk OVK --}}
    <div class="col-12 mb-3">
        <label class="form-label">Merk OVK</label>
        <input type="text"
               name="merk_ovk"
               class="form-control @error('merk_ovk') is-invalid @enderror"
               value="{{ old('merk_ovk', $item->merk_ovk ?? '') }}"
               placeholder="Contoh: Medion">
        @error('merk_ovk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Kemasan OVK --}}
    <div class="col-12 mb-3">
        <label class="form-label">Kemasan OVK</label>
        <input type="text"
               name="kemasan_ovk"
               class="form-control @error('kemasan_ovk') is-invalid @enderror"
               value="{{ old('kemasan_ovk', $item->kemasan_ovk ?? '') }}"
               placeholder="Contoh: Botol 100 ml">
        @error('kemasan_ovk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Total Kebutuhan --}}
    <div class="col-12 mb-3">
        <label class="form-label">Total Kebutuhan (Order)</label>
        <input type="number"
               name="total_kebutuhan_yang_diorder"
               class="form-control @error('total_kebutuhan') is-invalid @enderror"
               value="{{ old('total_kebutuhan_yang_diorder', $item->total_kebutuhan_yang_diorder ?? '') }}"
               placeholder="Masukkan jumlah">
        @error('total_kebutuhan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Maksimal Kedatangan --}}
    <div class="col-12 mb-3">
        <label class="form-label">Maksimal Kedatangan</label>
        <input type="date"
               name="maksimal_kedatangan"
               class="form-control @error('maksimal_kedatangan') is-invalid @enderror"
               value="{{ old('maksimal_kedatangan', $item->maksimal_kedatangan ?? '') }}">
        @error('maksimal_kedatangan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
