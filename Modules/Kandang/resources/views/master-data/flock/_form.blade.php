<x-adminlte-select 
    id="peternakanSelect"
    name="peternakan_id"
    label="Pilih Peternakan">
    <option value="">-- Pilih Peternakan --</option>
    @foreach($peternakan as $item)
        <option value="{{ $item->id }}">
            {{ $item->nama }}
        </option>
    @endforeach
</x-adminlte-select>

<x-adminlte-select 
    id="kandangSelect"
    name="kandang_id"
    label="Pilih Kandang"
    igroup-size="md">
    <option value="">-- Pilih Kandang --</option>
</x-adminlte-select>

<x-adminlte-input 
    name="nama"
    label="Nama Baris"
    type="text"
    placeholder="Masukkan nama baris..."
    :value="old('nama', @$data->nama)">
</x-adminlte-input>

<x-adminlte-input 
    name="pipe_keyword"
    label="Kata Kunci Nama Pipa"
    type="text"
    placeholder="Masukkan kata kunci untuk nama pipa..."
    :value="old('pipe_keyword', @$data->pipe_keyword)">
</x-adminlte-input>

<x-adminlte-input 
    name="pipe_count"
    label="Jumlah Pipa per Baris"
    type="number"
    min="0"
    placeholder="Masukkan jumlah pipa untuk baris ini..."
    :value="old('pipe_count', @$data->pipe_count)">
</x-adminlte-input>

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
