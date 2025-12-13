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
            $selected = old('kandang_id', @$data->kandang_id ?? 1); 
        @endphp

        @foreach($kandang as $id => $item)
            <option value="{{ $item->id }}" {{ $selected == $id ? 'selected' : '' }}>
                {{ $item->nama }}
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
    let index = 0;

    function loadFlockOptions(selectElement, kandangId, selectedId = null) {
        if (!kandangId) {
            $(selectElement).html('<option value="">-- Pilih Flock --</option>');
            return;
        }

        $.ajax({
            url: "{{ route('ajax.getFlockByKandangId', ':id') }}".replace(':id', kandangId),
            type: "GET",
            dataType: "json",
            success: function(response) {
                $(selectElement).empty().append('<option value="">-- Pilih Flock --</option>');
                $.each(response.results, function(i, flock) {
                    let selected = selectedId == flock.id ? 'selected' : '';
                    $(selectElement).append(`<option value="${flock.id}" ${selected}>${flock.nama}</option>`);
                });
            },
            error: function(xhr) {
                console.log("Terjadi kesalahan:", xhr.responseText);
            }
        });
    }

    // --- Render data lama (edit) ---
    @if(isset($penjadwalan_treatment) && $penjadwalan_treatment->treatmentFlocks)
        @foreach($penjadwalan_treatment->treatmentFlocks as $tf)
            let oldRow = $(`
                <tr>
                    <td>
                        <select name="treatment[${index}][flock_id]" class="form-select">
                            <option value="">-- Pilih Flock --</option>
                        </select>
                    </td>
                    <td>
                        <select name="treatment[${index}][jenis_treatment_id]" class="form-select">
                            <option value="1" {{ $tf->jenis_treatment_id == 1 ? 'selected' : '' }}>Vaksin</option>
                            <option value="2" {{ $tf->jenis_treatment_id == 2 ? 'selected' : '' }}>Vitamin</option>
                            <option value="3" {{ $tf->jenis_treatment_id == 3 ? 'selected' : '' }}>Antibiotik</option>
                        </select>
                    </td>
                    <td>
                        <select name="treatment[${index}][metode_pemberian_id]" class="form-select">
                            <option value="1" {{ $tf->metode_pemberian_id == 1 ? 'selected' : '' }}>Oral</option>
                            <option value="2" {{ $tf->metode_pemberian_id == 2 ? 'selected' : '' }}>Injeksi</option>
                            <option value="3" {{ $tf->metode_pemberian_id == 3 ? 'selected' : '' }}>Campuran Pakan</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="treatment[${index}][dosis]" class="form-control" value="{{ $tf->dosis }}" placeholder="Dosis...">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger removeRow">Hapus</button>
                    </td>
                </tr>
            `);

            $('#treatmentTable tbody').append(oldRow);

            // Load flock untuk row lama sesuai flock_id
            let currentKandangId = $('#kandang_id').val();
            loadFlockOptions(oldRow.find('select[name*="[flock_id]"]'), currentKandangId, {{ $tf->flock_id }});

            index++;
        @endforeach
    @endif

    // --- Tambah row baru ---
    $('#addRow').click(function() {
        let newRow = $(`
            <tr>
                <td>
                    <select name="treatment[${index}][flock_id]" class="form-select">
                        <option value="">-- Pilih Flock --</option>
                    </select>
                </td>
                <td>
                    <select name="treatment[${index}][jenis_treatment_id]" class="form-select">
                        <option value="1">Vaksin</option>
                        <option value="2">Vitamin</option>
                        <option value="3">Antibiotik</option>
                    </select>
                </td>
                <td>
                    <select name="treatment[${index}][metode_pemberian_id]" class="form-select">
                        <option value="1">Oral</option>
                        <option value="2">Injeksi</option>
                        <option value="3">Campuran Pakan</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="treatment[${index}][dosis]" class="form-control" placeholder="Dosis...">
                </td>
                <td>
                    <button type="button" class="btn btn-danger removeRow">Hapus</button>
                </td>
            </tr>
        `);

        $('#treatmentTable tbody').append(newRow);

        // Ambil kandang_id default saat ini
        let currentKandangId = $('#kandang_id').val();

        // Load flock untuk row baru langsung
        loadFlockOptions(newRow.find('select[name*="[flock_id]"]'), currentKandangId);

        index++;
    });

    // --- Hapus row ---
    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
    });

    // --- Update semua flock saat ganti kandang ---
    $('#kandang_id').change(function() {
        let kandangId = $(this).val();
        $('select[name*="[flock_id]"]').each(function() {
            loadFlockOptions(this, kandangId, $(this).val());
        });
    });
});
</script>

@endpush



