{{-- ================= INFORMASI UMUM ================= --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <strong>Informasi Treatment</strong>
    </div>

    <div class="card-body">
        {{-- Tanggal --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Pemberian Treatment</label>
            <input type="date" name="tanggal" class="form-control"
                value="{{ old('tanggal', $ovkPakan->tanggal ?? now()->format('Y-m-d')) }}" required>
        </div>

        {{-- Kandang --}}
        <div class="mb-3">
            <label class="form-label">Kandang</label>
            <select id="kandang_id" name="kandang_id" class="form-control" required>
                <option value="" disabled selected>Pilih Kandang</option>
                @foreach ($kandang as $item)
                    <option value="{{ $item->id }}"
                        {{ old('kandang_id', $ovkPakan->kandang_id ?? '')
                         == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Flock / Flock --}}
        <div class="mb-3">
            <label class="form-label">Flock / Flock</label>
            <select id="flock_id"name="flock_id" class="form-control" required>
                <option value="" disabled selected>Pilih Flock</option>
            </select>
        </div>

      
    </div>
</div>

{{-- ================= KEBUTUHAN OVK & PAKAN ================= --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <strong>Kebutuhan OVK & Pakan</strong>
    </div>

    <div class="card-body">
          {{-- Merk OVK --}}
        <div class="mb-3">
            <label class="form-label">Merk OVK</label>
            <input type="text" name="merk_ovk" class="form-control"
                value="{{ old('merk_ovk', $ovkPakan->merk_ovk ?? '') }}">
        </div>
        
        {{-- Dosis OVK --}}
        <div class="mb-3">
            <label class="form-label">Dosis Pemberian OVK (ml / kg pakan)</label>
            <input type="number" step="0.01" id="dosis_ovk" name="dosis_ovk"
                class="form-control" value="{{ old('dosis_ovk', $ovkPakan->dosis_ovk ?? '') }}">
        </div>

        {{-- Total Pakan --}}
        <div class="mb-3">
            <label class="form-label">Total Kebutuhan Pakan per Hari (kg)</label>
            <input type="number" step="0.01" id="total_pakan" name="total_kebutuhan_pakan"
                class="form-control" value="{{ old('total_kebutuhan_pakan', $ovkPakan->total_kebutuhan_pakan ?? '') }}">
        </div>
    </div>
</div>

{{-- ================= WAKTU PEMBERIAN ================= --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <strong>Waktu Pemberian Pakan</strong>
    </div>

    <div class="card-body">
        <select name="waktu_pemberian_pakan" id="waktu_pemberian" class="form-control">
            <option value="">-- Pilih Waktu --</option>
            <option value="pagi">Pagi</option>
            <option value="sore">Sore</option>
            <option value="pagi_sore">Pagi & Sore</option>
        </select>
    </div>
</div>

{{-- ================= PROPORSI & PERHITUNGAN ================= --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <strong>Proporsi & Perhitungan</strong>
    </div>
<div class="card-body">
    {{-- PAGI --}}
    <div class="mb-3" id="section-pagi">
    <h6 class="fw-semibold text-muted">Pagi</h6>
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">Proporsi Pagi (%)</label>
            <input type="number"
                   id="proporsi_pagi"
                   name="proporsi_pemberian_pagi"
                   class="form-control"
                   value="{{ old('proporsi_pagi', 60) }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Perhitungan Pakan Pagi (kg)</label>
            <input type="number"
                   step="0.01"
                   id="pakan_pagi"
                   name=perhitungan_kebutuhan_pakan_pagi"
                   class="form-control"
                   readonly>
        </div>
    </div>
</div>

    {{-- SORE --}}
   <div class="mb-3" id="section-sore">
    <h6 class="fw-semibold text-muted">Sore</h6>
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">Proporsi Sore (%)</label>
            <input type="number"
                   id="proporsi_sore"
                   name="proporsi_pemberian_sore"
                   class="form-control"
                   value="{{ old('proporsi_sore', 40) }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Perhitungan Pakan Sore (kg)</label>
            <input type="number"
                   step="0.01"
                   id="perhitungan_kebutuhan_pakan_sore"
                   name="pakan_sore"
                   class="form-control"
                   readonly>
        </div>
    </div>
</div>

    <hr>

    {{-- TOTAL OVK --}}
    <div class="row">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Total Kebutuhan OVK</label>
            <input type="number"
                   step="0.01"
                   id="total_ovk"
                   name="perhitungan_kebutuhan_ovk"
                   class="form-control"
                   readonly>
        </div>
    </div>
</div>

</div>

{{-- ================= SCRIPT HITUNG ================= --}}
@push('js')
<script>
$(document).ready(function () {
    function toggleWaktu() {
        let waktu = $('#waktu_pemberian').val();

        $('#section-pagi').hide();
        $('#section-sore').hide();

        if (waktu === 'pagi') {
            $('#section-pagi').show();
        } else if (waktu === 'sore') {
            $('#section-sore').show();
        } else if (waktu === 'pagi_sore') {
            $('#section-pagi').show();
            $('#section-sore').show();
        }

        hitungSemua();
    }
    function hitungSemua() {
        let totalPakan   = parseFloat($('#total_pakan').val()) || 0;
        let dosisOVK     = parseFloat($('#dosis_ovk').val()) || 0;
        let propPagi     = parseFloat($('#proporsi_pagi').val()) || 0;
        let propSore     = parseFloat($('#proporsi_sore').val()) || 0;
        let waktu        = $('#waktu_pemberian').val();
        let pakanPagi = 0;
        let pakanSore = 0;
        if (waktu === 'pagi') {
            pakanPagi = totalPakan * propPagi / 100;
        } 
        else if (waktu === 'sore') {
            pakanSore = totalPakan * propSore / 100;
        } 
        else if (waktu === 'pagi_sore') {
            pakanPagi = totalPakan * propPagi / 100;
            pakanSore = totalPakan * propSore / 100;
        }
        $('#pakan_pagi').val(pakanPagi.toFixed(2));
        $('#pakan_sore').val(pakanSore.toFixed(2));
        let totalOVK = totalPakan * dosisOVK / 1000;
        $('#total_ovk').val(totalOVK.toFixed(2));
    }
    $('#waktu_pemberian').on('change', toggleWaktu);

    $('#total_pakan, #dosis_ovk, #proporsi_pagi, #proporsi_sore')
        .on('keyup change', hitungSemua);
    toggleWaktu();
});

// Generate Cascade Flock id
$('#kandang_id').change(function() {
    var kandangId = $(this).val();
    if (kandangId) {
        $.ajax({
            url: "{{ route('ajax.flock', ':id') }}".replace(':id', kandangId), 
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log($('#flock_id'))
                $('#flock_id').empty(); 
                $('#flock_id').append('<option value="">Pilih Flock</option>');
                $.each(data.results, function(key, value) {
                    $('#flock_id').append('<option value="'+value.id+'">'+value.text+'</option>');
                });
            },
            error: function() {
                alert('Gagal mengambil data flock');
            }
        });
    } else {
        $('#flock_id').empty();
        $('#flock_id').append('<option value="">Pilih Flock</option>');
    }
});

</script>
@endpush
