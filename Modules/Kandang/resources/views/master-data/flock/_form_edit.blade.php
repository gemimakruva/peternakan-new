<div class="mb-3">
    <x-adminlte-input 
        name="nama" 
        label="Nama Baris" 
        type="text" 
        placeholder="Masukkan nama baris..." 
        :value="old('nama', $flock->nama)" 
        igroup-size="md">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Pilih Peternakan --}}
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
            <option value="{{ $item->id }}"
                {{ old('peternakan_id', $flock->kandang->peternakan_id ?? '')
                 == $item->id ? 'selected' : '' }}>
                {{ $item->nama }}
            </option>
        @endforeach

    </x-adminlte-select>
</div>

{{-- Pilih Kandang (Cascading) --}}
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

<div class="mb-3">
    <x-adminlte-input 
        name="pipe_count_display" 
        label="Jumlah Pipa per Baris" 
        type="number" 
        value="{{ $flock->pipes->count() }}"
        igroup-size="md"
        readonly>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-tint text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
    <small class="text-muted">Jumlah pipa tidak dapat diubah saat edit</small>
</div>

@push('js')
<script>
$(document).ready(function() {
    const peternakanData = @json($peternakan);
    const currentKandangId = {{ $flock->kandang_id }};
    const currentPeternakanId = {{ $flock->kandang->peternakan_id ?? 'null' }};
    
    function populateKandang(peternakanId, selectedKandangId = null) {
        const kandangSelect = $('#kandangSelect');
        kandangSelect.empty().append('<option value="">-- Pilih Kandang --</option>');
        
        if (peternakanId) {
            const selectedPeternakan = peternakanData.find(p => p.id == peternakanId);
            
            if (selectedPeternakan && selectedPeternakan.kandang) {
                selectedPeternakan.kandang.forEach(kandang => {
                    const isSelected = kandang.id == selectedKandangId ? 'selected' : '';
                    kandangSelect.append(
                        `<option value="${kandang.id}" ${isSelected}>${kandang.nama}</option>`
                    );
                });
            }
        }
    }
    
    if (currentPeternakanId) {
        populateKandang(currentPeternakanId, currentKandangId);
    }
    
    $('#peternakanSelect').on('change', function() {
        const peternakanId = $(this).val();
        populateKandang(peternakanId);
    });
});
</script>
@endpush
