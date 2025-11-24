<div class="card shadow-sm border-0">
    {{-- ===========================
        Header Card
        Menampilkan judul form flock
    ============================ --}}
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
            <i class="fas fa-dove me-2 text-muted"></i> Form Pembuatan Flock
        </h5>
    </div>

    <div class="card-body pt-4">

        {{-- ===========================
            Input: Nama Flock
            Digunakan sebagai penanda flock
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="nama"
                label="Nama Flock"
                type="text"
                placeholder="Masukkan nama flock..."
                :value="old('nama', @$data->nama)"
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

        {{-- ===========================
            Input: Kata Kunci Pipe
            Digunakan sebagai awalan nama pipe (ex: Pipa-A1, Pipa-A2)
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="pipe_keyword"
                label="Kata Kunci Nama Pipe"
                type="text"
                placeholder="Masukkan kata kunci untuk nama pipe..."
                :value="old('pipe_keyword', @$data->pipe_keyword)"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-key text-muted"></i>
                    </div>
                </x-slot>

            </x-adminlte-input>
        </div>

        {{-- ===========================
            Select: Pilih Kandang
            Relasi flock terhadap kandang
        ============================ --}}
        <div class="mb-3">
            <x-adminlte-select 
                name="kandang_id"
                label="Pilih Kandang"
                igroup-size="md">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-home text-muted"></i>
                    </div>
                </x-slot>

                <option value="">-- Pilih Kandang --</option>

                @foreach($kandang as $item)
                    <option value="{{ $item->id }}" 
                        {{ old('kandang_id', @$data->kandang_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach

            </x-adminlte-select>
        </div>

        {{-- ===========================
            Input: Jumlah Pipe
            Jumlah total pipa dalam satu flock
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="pipe_count"
                label="Jumlah Pipa per Flock"
                type="number"
                min="0"
                placeholder="Masukkan jumlah pipa untuk flock ini..."
                :value="old('pipe_count', @$data->pipe_count)"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-tint text-muted"></i>
                    </div>
                </x-slot>

            </x-adminlte-input>
        </div>

     

    </div>
</div>
