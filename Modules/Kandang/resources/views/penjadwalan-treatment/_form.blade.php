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
           <option value="">Pilih Kandang</option>
        @foreach($kandang as $item)
            <option value={{ $item->id }} >
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
            <thead>
                <tr>
                   <th style="width: 20%; min-height: 50px; line-height: 1.4; text-align: center; vertical-align: middle;">
                        Baris
                    </th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4; text-align: center; vertical-align: middle;">
                        Jenis Treatment
                    </th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4; text-align: center; vertical-align: middle;">
                        Metode Pemberian
                    </th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4; text-align: center; vertical-align: middle;">
                        Dosis Pemberian (gram/ml)
                    </th>
                    <th style="width: 15%; min-height: 50px; line-height: 1.4; text-align: center; vertical-align: middle;">
                        <button type="button" class="btn btn-success mt-2" id="addRow">
                            <i class="fas fa-plus"></i>
                        </button>
                    </th>
            </thead>
                <tbody>
                <tr>
                    <td>
                        <select id="flock_id" name="treatment[0][flock_id]" 
                        class="form-control" style="max-width: 200px;">
                        <option value="">-- Pilih Flock --</option>  
                        </select>
                    </td>
                    <td>
                        <select name="treatment[0][jenis_treatment_id]" class="form-control">
                            @foreach ($jenisTreatment as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <select name="treatment[0][metode_pemberian_id]" class="form-control">
                            @foreach ($metodeTreatment as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="text" name="treatment[0][dosis]" class="form-control"
                         placeholder="Dosis...">
                    </td>

                    <td>
                        <button type="button" class="btn btn-danger removeRow">Hapus</button>
                    </td>
                </tr>
                </tbody>
        </table>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
    let index = 1;

    function loadFlockOptions(selectElement, kandangId, selectedId = null) {
        if (!kandangId) {
            $(selectElement).html('<option value="">-- Pilih Flock --</option>');
            return;
        }

        $.ajax({
            url: "{{ route('ajax.getFlockByKandangTreatment', ':id') }}".replace(':id', kandangId),
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log(response)
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

    // --- Tambah row baru ---
    $('#addRow').click(function() {
        let newRow = $(`
            <tr>
                <td>
                    <select name="treatment[${index}][flock_id]" class="form-control">
                        <option value="">-- Pilih Flock --</option>
                    </select>
                </td>

                <td>
                    <select name="treatment[${index}][jenis_treatment_id]" class="form-control">
                         @foreach ($jenisTreatment as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                    </select>
                </td>

                <td>
                    <select name="treatment[${index}][metode_pemberian_id]" class="form-control">
                       @foreach ($metodeTreatment as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                    </select>
                </td>

                <td>
                    <input type="text" name="treatment[${index}][dosis]" 
                    class="form-control" placeholder="Dosis...">
                </td>

                <td>
                    <button type="button" class="btn btn-danger removeRow">Hapus</button>
                </td>
            </tr>
        `);

        $('#treatmentTable tbody').append(newRow);
        let selectFlock = newRow.find('select[name*="[flock_id]"]');
        let currentKandangId = $('#kandang_id').val();
        loadFlockOptions(selectFlock, currentKandangId);

        index++;
    });

    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
    });

    $('#kandang_id').change(function() {
        let kandangId = $(this).val();

        $('select[name*="[flock_id]"]').each(function() {
            loadFlockOptions(this, kandangId, $(this).val());
        });
    });
});

</script>
@endpush



