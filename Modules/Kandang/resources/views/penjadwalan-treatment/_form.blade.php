 <div class="mb-3">
        <x-adminlte-input 
            name="tanggal" 
            label="Tanggal Penjadwalan Treatment" 
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

<div class="mb-3">
    <x-adminlte-select
        name="kandang_id"
        label="Pilih Kandang"
        igroup-size="md">
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-warehouse text-muted"></i>
            </div>
        </x-slot>
        @php
            $kandangs = [
                1 => 'Kandang A',
                2 => 'Kandang B',
                3 => 'Kandang C',
            ];
            $selected = old('kandang_id', @$data->kandang_id ?? 1); 
        @endphp

        @foreach($kandangs as $id => $name)
            <option value="{{ $id }}" {{ $selected == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </x-adminlte-select>
</div>

<div class="mb-3">
    <x-adminlte-input 
        name="waktu_pelaksanaan" 
        label="Waktu Pelaksanaan Treatment" 
        type="time" 
        igroup-size="md"
        value="{{ old('detail_waktu', @$data->waktu_pelaksanaan ?? 
        \Carbon\Carbon::now()->format('H:i')) }}">
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-clock text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

<div class="mb-3">
    <div class="table-responsive">
        <table class="table table-bordered" id="treatmentTable">
            <thead class="text-white" style="background-color: #495057; border-color: #495057; text-align: center;">
                <tr>
                    <th style="width: 10%; min-height: 50px; line-height: 1.4;">Baris</th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4;">Jenis Treatment</th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4;">Metode Pemberian</th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4;">Dosis Pemberian (gram/ml)</th>
                    <th style="width: 15%; min-height: 50px; line-height: 1.4;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="baris[]" class="form-select">
                            <option value="1">Baris 1</option>
                            <option value="2">Baris 2</option>
                            <option value="3">Baris 3</option>
                        </select>
                    </td>
                    <td>
                        <select name="jenis_treatment[]" class="form-select">
                            <option value="Vaksin">Vaksin</option>
                            <option value="Vitamin">Vitamin</option>
                            <option value="Antibiotik">Antibiotik</option>
                        </select>
                    </td>
                    <td>
                        <select name="metode_pemberian[]" class="form-select">
                            <option value="Oral">Oral</option>
                            <option value="Injeksi">Injeksi</option>
                            <option value="Campuran Pakan">Campuran Pakan</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="diagram[]" class="form-control" placeholder="Diagram / Catatan">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger removeRow">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Tombol Tambah Baris --}}
    <button type="button" class="btn btn-primary mt-2" id="addRow">
        <i class="fas fa-plus"></i> Tambah Baris
    </button>
</div>

@push('js')

<script>
$(document).ready(function() {
    $('#addRow').click(function() {
        let newRow = `<tr>
            <td>
                <select name="baris[]" class="form-select">
                    <option value="1">Baris 1</option>
                    <option value="2">Baris 2</option>
                    <option value="3">Baris 3</option>
                </select>
            </td>
            <td>
                <select name="jenis_treatment[]" class="form-select">
                    <option value="Vaksin">Vaksin</option>
                    <option value="Vitamin">Vitamin</option>
                    <option value="Antibiotik">Antibiotik</option>
                </select>
            </td>
            <td>
                <select name="metode_pemberian[]" class="form-select">
                    <option value="Oral">Oral</option>
                    <option value="Injeksi">Injeksi</option>
                    <option value="Campuran Pakan">Campuran Pakan</option>
                </select>
            </td>
            <td>
                <input type="text" name="diagram[]" class="form-control" placeholder="Diagram / Catatan">
            </td>
            <td>
                <button type="button" class="btn btn-danger removeRow">Hapus</button>
            </td>
        </tr>`;
        $('#treatmentTable tbody').append(newRow);
    });

    // Hapus baris
    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
    });
});
</script>
@endpush



