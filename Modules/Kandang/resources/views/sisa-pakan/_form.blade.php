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
   <div class="col-md-6 mb-3">
        <x-adminlte-input
            name="jenis_pakan"
            id="jenis_pakan"
            label="Jenis Pakan"
            igroup-size="md"
            placeholder="Jenis Pakan"
            readonly
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-drumstick-bite text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
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

$('#tanggal_pemberian_pakan').on('change', function() {
    let tanggalId = $(this).val();
    if (!tanggalId) return;

    $.ajax({
        url: "{{ route('ajax.show-detail-by-pipe', ['tanggalId' => 'TANGGAL_ID']) }}"
        .replace('TANGGAL_ID', tanggalId),
        type: "GET",
        dataType: "json",
         success: function(response) {
            console.log(response.results.pakanPerFlock)
                let kandangSelect = $('#kandang_id');
                kandangSelect.empty();
                kandangSelect.append('<option value="">-- Pilih Kandang --</option>');
                 if(response.results && response.results.kandang && response.results.kandang.length > 0) {
                    // load select kandang
                        $.each(response.results.kandang, function(index, kandang) {
                            kandangSelect.append('<option value="' + kandang.id + '">' +
                                 kandang.nama + '</option>');
                        });
                        // load input Flock
                        let flockSelect = $('#flock_id');
                        flockSelect.empty();
                        flockSelect.append('<option value="">-- Pilih Flock --</option>');
                        if(response.results && response.results.flock) {
                            $.each(response.results.flock, function(index, flock) {
                                flockSelect.append('<option value="' + flock.id + '">' + flock.nama + '</option>');
                            });
                        }
                        // jenis  pakan autofill
                          if(response.results.jenis_pakan) {
                                    $('#jenis_pakan').val(response.results.jenis_pakan);
                                } else {
                                    $('#jenis_pakan').val('');
                                }
                        }
                         if (response.results.pakanPerFlock) {
                                $('#pemberian_pakan').val(response.results.pakanPerFlock);
                            } else {
                                $('#pemberian_pakan').val('');
                            }
            },

        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
});

</script>
@endpush



