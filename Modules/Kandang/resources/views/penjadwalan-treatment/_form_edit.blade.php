
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
            igroup-size="md"
            disabled
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-warehouse text-muted"></i>
                </div>
            </x-slot>
                @php
                    $selected = old('kandang_id', @$data->kandang_id ?? 1);
                @endphp

            @foreach($kandang as $id => $item)
                  <option value="{{ $item->id }}" {{ $selected == $item->id ? 'selected' : '' }}>
                {{ $item->nama }}
                </option>
            @endforeach
</x-adminlte-select>


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
            <thead class="table table-bordered" id="treatmentTable">
                <tr>
                    <th style="width: 15%; min-height: 50px; line-height: 1.4;">Flock</th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4;">Jenis Treatment</th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4;">Metode Pemberian</th>
                    <th style="width: 25%; min-height: 50px; line-height: 1.4;">Dosis Pemberian (gram/ml)</th>
                    <th style="width: 15%; min-height: 50px; line-height: 1.4;"> 
                    <button type="button" class="btn btn-primary mt-2" id="addRow">
                         <i class="fas fa-plus"></i>
                    </button>
                    </th>
                </tr>
            </thead>
              <tbody>
                @foreach ($penjadwalan_treatment->treatmentFlocks as $tf)
                <tr>
                    <td>
                        <select name="treatment[{{ $loop->index }}][flock_id]" class="form-control flock-select"
                            data-selected="{{ $tf->flock_id ?? '' }}">
                            <option value="">-- Pilih Flock --</option>
                        </select>
                    </td>

                        <td>
                            <select name="treatment[{{ $loop->index }}][jenis_treatment_id]" class="form-control">
                                @foreach ($jenisTreatment as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $tf->jenis_treatment_id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <select name="treatment[{{ $loop->index }}][metode_pemberian_id]" class="form-control">
                                @foreach ($metodeTreatment as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $tf->metodeTreatment->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="text"
                                name="treatment[{{ $loop->index }}][dosis]"
                                class="form-control"
                                value="{{ $tf->dosis_pemberian }}"
                                placeholder="Dosis...">
                        </td>

                    <td>
                        <button type="button" class="btn btn-danger removeRow">Hapus</button>
                    </td>
                </tr>
                @endforeach
</tbody>


        </table>
    </div>

    {{-- Tombol Tambah Flock --}}
   
</div>

@push('js')
<script>
$(document).ready(() => {
    let index = $('#treatmentTable tbody tr').length;
    const loadFlockOptions = (selectElement, kandangId, selectedId = null) => {
        if (!kandangId) {
            $(selectElement).html('<option value="">-- Pilih Flock --</option>');
            return;
        }

        $.ajax({
            url: @js(route('ajax.flock', ':kandangId')).replace(':kandangId', kandangId),
            method: 'GET',
            success: (data) => {
                console.log()
                let options = '<option value="">-- Pilih Flock --</option>';
                data.results.forEach(flock => {
                    options += `<option value="${flock.id}" ${selectedId == flock.id ? 
                    'selected' : ''}>${flock.text}</option>`;
                });
                $(selectElement).html(options);
            },
            error: (err) => {
                console.error(err);
            }
        });
    };
    $('.flock-select').each(function() {
        const selectedId = $(this).data('selected');
        const kandangId = $('#kandang_id').val();
        loadFlockOptions($(this), kandangId, selectedId);
    });
    $('#kandang_id').change(function() {
        const kandangId = $(this).val();
        $('.flock-select').each(function() {
            loadFlockOptions($(this), kandangId);
        });
    });
    $('#addRow').click(() => {
        const newRow = $(`
            <tr>
                <td>
                    <select name="treatment[${index}][flock_id]" class="form-control flock-select">
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
                    <input type="text" name="treatment[${index}][dosis]" class="form-control"
                     placeholder="Dosis...">
                </td>
                <td>
                    <button type="button" class="btn btn-danger removeRow">Hapus</button>
                </td>
            </tr>
        `);
        $('#treatmentTable tbody').append(newRow);
        const currentKandangId = $('#kandang_id').val();
        loadFlockOptions(newRow.find('.flock-select'), currentKandangId);

        index++;
    });
    $(document).on('click', '.removeRow', (e) => {
        $(e.currentTarget).closest('tr').remove();
    });
});
</script>
@endpush




