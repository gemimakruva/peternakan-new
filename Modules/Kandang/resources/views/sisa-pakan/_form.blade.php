  {{-- tanggal pemberian pakan --}}
    
<div class="form-group col-12">
    <label for="tanggal_pemberian_pakan">Tanggal Pemberian Pakan</label>
    <div class="input-group input-group-lg">
        <select name="tanggal" id="tanggal_pemberian_pakan" class="form-control form-control-lg">
            <option value="">-- Pilih Tanggal --</option>
        </select>
    </div>
</div>

    {{-- pilih kadang --}}
    <div class="form-group col-12">
    <label for="kandang_id">Pilih Kandang</label>
        <div class="input-group input-group-lg">
            <select name="kandang_id" id="kandang_id" class="form-control form-control-lg">
                <option value="">-- Pilih Kandang --</option>
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
            <option value="">-- Pilih Jenis Pakan --</option>
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
    function loadTanggalPakan(query = '') {
        $.ajax({
            url: "{{ route('ajax.tanggal-perhitungan') }}",
            type: "GET",
            data: { q: query },
            dataType: "json",
            success: function(response) {
                let select = $('#tanggal_pemberian_pakan');
                select.empty();
                select.append('<option value="">-- Pilih Tanggal --</option>');

                $.each(response.results, function(index, item) {

                    let parts = item.text.split('-');
                    let dateObj = new Date(parts[2], parts[1]-1, parts[0]);
                    let formattedDate = dateObj.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });

                    select.append('<option value="' + item.id + '">' + formattedDate + '</option>');
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }    
    loadTanggalPakan();
});

$("#tanggal_pemberian_pakan").change(function() {
    let tanggalId = $(this).val();

    if (!tanggalId) {
        console.log('Tanggal belum dipilih');
        return; 
    }

    $.ajax({
        url: "{{ route('ajax.getKandangByTanggalId', ':tanggalId') }}".
        replace(':tanggalId', tanggalId),
        type: "GET",
        dataType: "json",
        success: function(response) {
            let kandangInput = $('#kandang_id');
            kandangInput.empty();
            kandangInput.append(`<option value="">-- Pilih Kandang --</option>`);

            if(response.results && response.results.length > 0) {
                response.results.forEach(function(item) {
                    kandangInput.append(`<option value="${item.id}">${item.nama}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error("AJAX Error:", xhr.responseText);
        }
    });
});
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
// GENERATE SISA PAKAN 
function fetchPemberianPakan() {
    let tanggalId = $('#tanggal_pemberian_pakan').val();
    let flockId = $('#flock_id').val();

    if (!tanggalId || !flockId) {
        console.log("Tanggal atau flock belum dipilih");
        // Kosongkan input dan select jika belum lengkap
        $('#pemberian_pakan').val('');
        $('#jenis_pakan_id').empty().append(`<option value="">-- Pilih Jenis Pakan --</option>`);
        return;
    }

    // GET Sisa Pakan per baris (Kg) 
    $.ajax({
        url: "{{ route('ajax.getPemberianPakanByFlockId', [':tanggalId', ':flockId']) }}"
            .replace(':tanggalId', tanggalId)
            .replace(':flockId', flockId),
        type: "GET",
        dataType: "json",
        success: function(response) {
            $('#pemberian_pakan').val(response.result ?? 0);
            let jenisPakanInput = $('#jenis_pakan_id');
            jenisPakanInput.empty(); 
            jenisPakanInput.append(`<option value="">-- Pilih Jenis Pakan --</option>`);

            if (response.jenisPakan && response.jenisPakan.length > 0) {
                response.jenisPakan.forEach(function(item) {
                    jenisPakanInput.append(`<option value="${item.id}">${item.nama}</option>`);
                });
            }
            },
            error: function(xhr, status, error) {
                console.error("Terjadi error AJAX:", error);
            }
    });
}

$('#tanggal_pemberian_pakan').change(fetchPemberianPakan);
$('#flock_id').change(fetchPemberianPakan);
</script>
@endpush



