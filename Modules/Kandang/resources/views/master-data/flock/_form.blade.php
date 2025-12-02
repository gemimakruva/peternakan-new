<div class="card shadow-sm border-0">
    {{-- ===========================
        Header Card
        Menampilkan judul form flock
    ============================ --}}
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
            <i class="fas fa-dove me-2 text-muted"></i> Form Pembuatan Baris
        </h5>
    </div>

    <div class="card-body pt-4">

        {{-- ===========================
            Select: Pilih Peternakan
            Relasi flock terhadap peternakan
        ============================ --}}
        <div class="mb-3">
            <x-adminlte-select 
                id="peternakanSelect"
                name="peternakan_id"
                label="Pilih Peternakan"
                igroup-size="md">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-warehouse text-muted"></i>
                    </div>
                </x-slot>

                <option value="">-- Pilih Peternakan --</option>

                @foreach($peternakan as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->nama }}
                    </option>
                @endforeach

            </x-adminlte-select>
        </div>

        {{-- ===========================
            Select: Pilih Kandang (Cascading)
            Relasi flock terhadap kandang
        ============================ --}}
        <div class="mb-3">
            <x-adminlte-select 
                id="kandangSelect"
                name="kandang_id"
                label="Pilih Kandang"
                igroup-size="md">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-home text-muted"></i>
                    </div>
                </x-slot>

                <option value="">-- Pilih Kandang --</option>

            </x-adminlte-select>
        </div>

        {{-- ===========================
            Input: Nama Flock
            Digunakan sebagai penanda flock
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="nama"
                label="Nama Baris"
                type="text"
                placeholder="Masukkan nama baris..."
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
                label="Kata Kunci Nama Pipa"
                type="text"
                placeholder="Masukkan kata kunci untuk nama pipa..."
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
            Input: Jumlah Pipe
            Jumlah total pipa dalam satu flock
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="pipe_count"
                label="Jumlah Pipa per Baris"
                type="number"
                min="0"
                placeholder="Masukkan jumlah pipa untuk baris ini..."
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

@push('js')
<script>
$(document).ready(function() {
    const peternakanData = @json($peternakan);
    
    $('#peternakanSelect').on('change', function() {
        const peternakanId = $(this).val();
        const kandangSelect = $('#kandangSelect');
        
        kandangSelect.empty().append('<option value="">-- Pilih Kandang --</option>');
        
        if (peternakanId) {
            const selectedPeternakan = peternakanData.find(p => p.id == peternakanId);
            
            if (selectedPeternakan && selectedPeternakan.kandang) {
                selectedPeternakan.kandang.forEach(kandang => {
                    kandangSelect.append(
                        `<option value="${kandang.id}">${kandang.nama}</option>`
                    );
                });
            }
        }
    });
});
</script>
@endpush
