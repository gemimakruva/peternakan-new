@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Vitamin/Obat Minum</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <x-adminlte-input name="tanggal" label="Tanggal Vitamin Obat Minum" type="date"
                :disabled="isset($vitaminObatMinum)" placeholder="Pilih tanggal penjadwalan..." :value="old('tanggal', isset($vitaminObatMinum) && $vitaminObatMinum->tanggal ? $vitaminObatMinum->tanggal : '')" required>

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-calendar-alt text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-select id="form-kandang" name="kandang_id" label="Pilih Kandang"
                data-selected="{{ old('kandang_id', $vitaminObatMinum->flock->kandang_id ?? '') }}" required
                :disabled="isset($vitaminObatMinum)">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-feather-alt text-muted"></i>
                    </div>
                </x-slot>
                <option selected disabled>Pilih Kandang...</option>
            </x-adminlte-select>
        </div>

        <div class="mb-3">
            <x-adminlte-select id="form-flock" name="flock_id" label="Pilih Flock"
                data-selected="{{ old('flock_id', $vitaminObatMinum->flock_id ?? '') }}" required class="select-flock"
                :disabled="isset($vitaminObatMinum)">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-feather-alt text-muted"></i>
                    </div>
                </x-slot>
                <option selected disabled>Pilih Flock</option>
            </x-adminlte-select>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pemberian Vitamin/Obat Minum</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <x-adminlte-select name="jenis_treatment_id" label="Pilih Jenis Treatment" required>
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-feather-alt text-muted"></i>
                    </div>
                </x-slot>
                <option value="">Pilih Jenis Treatment</option>
                @foreach($jenisTreatment as $item)
                    <option value={{ $item->id }} {{ old('jenis_treatment_id', $vitaminObatMinum->jenis_treatment_id ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </x-adminlte-select>
        </div>

        <div class="mb-3">
            <x-adminlte-input name="merk_ovk" label="Merk OVK" type="text" placeholder="Merk OVK"
                :value="old('merk_ovk', $vitaminObatMinum->merk_ovk ?? '')">
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-input name="dosis_pemberian" label="Dosis Pemberian OVK" type="number"
                :value="old('dosis_pemberian', $vitaminObatMinum->dosis_pemberian ?? '')">
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-input name="satuan_per_dosis" label="Satuan Per Dosis(liter)" type="number"
                :value="old('satuan_per_dosis', $vitaminObatMinum->satuan_per_dosis ?? '')">
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-input name="air_minum_per_ekor" label="Kebutuhan Air Minum per Ekor(ml)" type="number"
                :value="old('air_minum_per_ekor', $vitaminObatMinum->air_minum_per_ekor ?? '')">
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-input name="jumlah_ayam_per_flock" label="Jumlah Ayam per Flock" type="text" readonly
                :value="old('jumlah_ayam_per_flock', $vitaminObatMinum->jumlah_ayam_per_flock ?? '')">
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-input name="jumlah_air_di_tong_per_flock" label="Jumlah Air di Tong(liter) per Flock" readonly
                type="text" :value="old('jumlah_air_di_tong_per_flock', $vitaminObatMinum->jumlah_air_di_tong_per_flock ?? '')">
            </x-adminlte-input>
        </div>

        <div class="mb-3">
            <x-adminlte-input name="jumlah_ovk_per_flock" label="Jumlah OVK per Flock" type="text" readonly
                :value="old('jumlah_ovk_per_flock', $vitaminObatMinum->jumlah_ovk_per_flock ?? '')">
            </x-adminlte-input>
        </div>
    </div>
</div>
@push('js')
    <script>
        const IS_EDIT = {{ isset($vitaminObatMinum) ? 'true' : 'false' }};

        $(document).ready(function () {
            populateDataKandang('form-kandang');

            function populateDataKandang(elementId) {
                let url = '/master-data/ajax/kandang';
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        const $el = $(`#${elementId}`);
                        $el.empty();
                        $el.append('<option value="" selected disabled>Pilih Kandang...</option>');
                        $.each(response.results, function (index, item) {
                            $el.append('<option value="' + item.id + '">' + item.text + '</option>');
                        });

                        // trigger change jika ada selected data (edit form)
                        const pre = $el.data('selected') || $el.val();
                        if (pre) {
                            $el.val(pre).trigger('change');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            let flockData = [];

            $('#form-kandang').on('change', function () {
                const kandangId = $(this).val();

                if (!kandangId) return;

                $.get(`/master-data/ajax/flock/${kandangId}`, function (response) {
                    const flockData = response.results || [];
                    const $jumlahAyam = $('input[name="jumlah_ayam_per_flock"]');

                    if (!IS_EDIT) {
                        $jumlahAyam.val('').trigger('input');
                    }

                    $('select.select-flock').each(function () {
                        const $sel = $(this);

                        const selected =
                            $sel.data('selected') ??
                            $sel.val() ??
                            '';

                        let html = '<option value="">-- Pilih Flock --</option>';
                        flockData.forEach(item => {
                            html += `<option value="${item.id}">${item.text}</option>`;
                        });

                        $sel.html(html)
                            .prop('disabled', flockData.length === 0);

                        if (selected && flockData.some(i => String(i.id) === String(selected))) {
                            $sel.val(selected);
                        } else {
                            $sel.val('');
                        }
                    });

                    if (IS_EDIT) {
                        $('#form-kandang').prop('disabled', true);
                        $('#form-flock').prop('disabled', true);
                    }
                });
            });

            const $tanggal = $('input[name="tanggal"]');
            const $flock = $('#form-flock');
            const $jumlahAyam = $('input[name="jumlah_ayam_per_flock"]');
            const $airPerEkor = $('input[name="air_minum_per_ekor"]');
            const $jumlahAir = $('input[name="jumlah_air_di_tong_per_flock"]');
            const $dosis = $('input[name="dosis_pemberian"]');
            const $satuan = $('input[name="satuan_per_dosis"]');
            const $jumlahOVK = $('input[name="jumlah_ovk_per_flock"]');

            function fetchJumlahAyam() {
                const tanggal = $tanggal.val();
                const flockId = $flock.val();

                if (!tanggal || !flockId) {
                    $jumlahAyam.val('');
                    return;
                }

                $.ajax({
                    url: '/populasi-ayam/summary',
                    method: 'GET',
                    data: {
                        date: tanggal,
                        flock_id: flockId
                    },
                    success: function (res) {
                        $jumlahAyam.val(res.total ?? 0).trigger('input');
                    },
                    error: function () {
                        $jumlahAyam.val('');
                    }
                });
            }

            // Trigger saat tanggal berubah
            $tanggal.on('change', fetchJumlahAyam);

            // Trigger saat flock berubah
            $flock.on('change', fetchJumlahAyam);

            // Jika EDIT & value sudah ada → fetch otomatis
            if (!IS_EDIT && $tanggal.val() && $flock.val()) {
                fetchJumlahAyam();
            }

            function hitungJumlahAir() {
                const jumlahAyam = parseFloat($jumlahAyam.val()) || 0;
                const airPerEkor = parseFloat($airPerEkor.val()) || 0;

                if (jumlahAyam <= 0 || airPerEkor <= 0) {
                    $jumlahAir.val('').trigger('input');
                    return;
                }

                const totalAir = (jumlahAyam * airPerEkor) / 1000; // ml → liter
                $jumlahAir.val(totalAir.toFixed(2)).trigger('input');
            }

            function hitungJumlahOVK() {
                const jumlahAir = parseFloat($jumlahAir.val()) || 0;
                const dosis = parseFloat($dosis.val()) || 0;
                const satuan = parseFloat($satuan.val()) || 0;

                if (jumlahAir <= 0 || dosis <= 0 || satuan <= 0) {
                    $jumlahOVK.val('');
                    return;
                }

                const totalOVK = (jumlahAir * dosis) / satuan;
                $jumlahOVK.val(totalOVK.toFixed(2));
            }

            $jumlahAyam.on('input change', hitungJumlahAir);
            $airPerEkor.on('input change', hitungJumlahAir);

            $jumlahAir.on('input change', hitungJumlahOVK);
            $dosis.on('input change', hitungJumlahOVK);
            $satuan.on('input change', hitungJumlahOVK);

            if (
                $jumlahAyam.val() &&
                $airPerEkor.val()
            ) {
                hitungJumlahAir();
            }

            if (
                $jumlahAir.val() &&
                $dosis.val() &&
                $satuan.val()
            ) {
                hitungJumlahOVK();
            }
        });
    </script>
@endpush