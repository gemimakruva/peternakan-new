  {{-- tanggal pemberian pakan --}}
    
<div class="form-group col-12">
    <label for="tanggal_pemberian_pakan">Tanggal Pemberian Pakan</label>
    <div class="input-group input-group-lg">
       <input
            type="date"
            name="tanggal"
            id="tanggal_pemberian_pakan"
            class="form-control form-control-lg"
        />
    </div>
</div>

    {{-- pilih kadang --}}
    <div class="form-group col-12">
    <label for="kandang_id">Pilih Kandang</label>
        <div class="input-group input-group-lg">
            <select id="kandang_id" name="kandang_id" id="kandang_id" class="form-control form-control-lg">
                    <option value="">-- Pilih Kandang --</option>
                    @foreach ($kandang as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
            </select>
        </div>
    </div>

    {{-- flock dropdown --}}
    <div class="form-group col-12">
         <label for="flock_id">Pilih Baris</label>
        <div class="input-group input-group-lg">
            <select name="flock_id" id="flock_id" class="form-control form-control-lg">
                <option value="">-- Pilih Baris --</option>
            </select>
        </div>
    </div>

    {{-- jenis pakan --}}
   <div class="form-group col-12">
    <label for="jenis_pakan_id">Pilih Jenis Pakan</label>
    <div class="input-group input-group-lg">
        <select name="jenis_pakan_id" id="jenis_pakan_id" class="form-control form-control-lg">
            <option value="">-- Pilih Kandang --</option>
            @foreach ($jenisPakan as $item)
                 <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
           
        </select>
    </div>
</div>


    {{-- pemberian pakan --}}
    <div class="mb-3">
    <label for="pemberian_pakan" class="form-label">Pemberian Pakan per Baris (Kg)</label>
    <div class="input-group">
        <!-- Prepend Icon -->
        <span class="input-group-text bg-white">
            <i class="fas fa-seedling text-muted"></i>
        </span>

        <!-- Input -->
        <input 
            type="number" 
            name="pemberian_pakan" 
            id="pemberian_pakan"
            class="form-control"
            step="0.01"
            min="0"
            value="{{ old('pemberian_pakan', @$data->pemberian_pakan) }}"
            placeholder="Masukkan Pemberian Pakan"
            readonly
        >

        <!-- Append Satuan -->
        <span class="input-group-text bg-white">
            <span class="text-muted font-semibold">Kg</span>
        </span>
    </div>
</div>

    {{-- sisa pakan --}}
   <div class="mb-3">
    <x-adminlte-input 
        name="sisa_pakan"
        label="Sisa Pakan per baris (Kg)"
        type="number"
        igroup-size="md"
        step="0.01"
        min="0"
        value="{{ old('sisa_pakan', @$data->sisa_pakan) }}">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-balance-scale text-muted"></i>
            </div>
        </x-slot>

        <x-slot name="appendSlot">
            <div class="input-group-text bg-white">
                <span class="text-muted font-semibold">Kg</span>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>



@push('js')
<script>
$(document).ready(function() {


$("#kandang_id").change(function() {
    let kandangId = $(this).val();

    if (!kandangId) {
        console.log('Kandang belum dipilih');
        return; 
    }

    $.ajax({
        url: "{{ route('ajax.getFlockByKandangId', ':kandangId') }}"
        .replace(':kandangId', kandangId),
        type: "GET",
        dataType: "json",
        success: function(response) {
            // generate Flock
            let flockInput = $('#flock_id');
            flockInput.empty();
            flockInput.append(`<option value="">-- Pilih Baris --</option>`);

            if(response.results && response.results.length > 0) {
                response.results.forEach(function(item) {
                    flockInput.append(`<option value="${item.id}">${item.nama}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error("AJAX Error:", xhr.responseText);
        }
    });
});

$("#flock_id").change(function() {
    let tanggal = $('#tanggal_pemberian_pakan').val();
    let flockId = $('#flock_id').val();

    if (!tanggal || !flockId) {
        console.log("Tanggal atau flock belum dipilih");
        // Kosongkan input dan select jika belum lengkap
        $('#pemberian_pakan').val('');
        $('#jenis_pakan_id').empty().append(`<option value="">-- Pilih Jenis Pakan --</option>`);
        return;
    }
     $.ajax({
        url: "{{ route('ajax.getPemberianPakanByFlockId', [':tanggal', ':flockId']) }}"
            .replace(':tanggal', tanggal)
            .replace(':flockId', flockId),
        type: "GET",
        dataType: "json",
        success: function(response) {
           if (!response.status) {
                Swal.fire({
                    icon: "warning",
                    title: "Data tidak ditemukan",
                    text: response.message || "Tidak ada data pakan untuk tanggal dan flock ini.",
                });
                $('#pemberian_pakan').val('');
                return; 
            }
              $('#pemberian_pakan').val(response.result ?? 0);
            },
            error: function(xhr, status, error) {
                console.error("Terjadi error AJAX:", error);
            }
    });
})
})

</script>
@endpush



