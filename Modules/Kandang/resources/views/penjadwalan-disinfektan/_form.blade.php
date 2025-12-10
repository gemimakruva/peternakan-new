@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

<div class="mb-3">
    <x-adminlte-input name="tanggal" label="Tanggal Penjadwalan Disinfektan Kandang" type="date"
        :disabled="isset($penjadwalanDisinfektan)" placeholder="Pilih tanggal penjadwalan..." :value="old('tanggal', isset($penjadwalanDisinfektan) && $penjadwalanDisinfektan->tanggal ? $penjadwalanDisinfektan->tanggal : '')"
        required>

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-calendar-alt text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

<div class="mb-3">
    <x-adminlte-select id="form-kandang" name="kandang_id" label="Pilih Kandang" class="select-nama-berkas"
        data-selected="{{ old('kandang_id', $penjadwalanDisinfektan->kandang_id ?? '') }}" required
        :disabled="isset($penjadwalanDisinfektan)">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
        <option selected disabled>Pilih Kandang...</option>
    </x-adminlte-select>
</div>

@php
    $timeValue = old('detail_waktu', $penjadwalanDisinfektan->detail_waktu ?? '');

    $periodLabel = function (int $hour): string {
        if ($hour >= 4 && $hour < 10)
            return 'Pagi';
        if ($hour >= 10 && $hour < 15)
            return 'Siang';
        if ($hour >= 15 && $hour < 18)
            return 'Sore';
        return 'Malam';
    };

    $detailWaktuDisplay = '';
    if (!empty($timeValue) && preg_match('/^([01]?\d|2[0-3]):([0-5]\d)$/', $timeValue, $m)) {
        $hh = str_pad($m[1], 2, '0', STR_PAD_LEFT);
        $mm = str_pad($m[2], 2, '0', STR_PAD_LEFT);
        $detailWaktuDisplay = $periodLabel((int) $hh) . ' jam ' . $hh . '.' . $mm;
    }
@endphp

<div class="mb-3">
    <label for="detail_waktu_display" class="form-label">Waktu Penjadwalan Disinfektan</label>

    <div class="input-group">
        <x-adminlte-input id="detail_waktu_display" name="detail_waktu_display" value="{{ $detailWaktuDisplay }}"
            placeholder="Klik untuk memilih waktu..." readonly>
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-clock text-muted"></i>
                </div>
            </x-slot>
            <x-slot name="appendSlot">
                <button type="button" id="clear_detail_waktu" class="btn btn-outline-secondary"
                    title="Hapus waktu">✕</button>
            </x-slot>
        </x-adminlte-input>

        <input id="detail_waktu" name="detail_waktu" type="hidden" value="{{ $timeValue }}">

        <input id="native_time_picker" type="time" class="form-control visually-hidden col-md-2"
            value="{{ $timeValue }}" aria-hidden="true" />
    </div>

    <small class="form-text text-muted">Contoh tampilan: <strong>Pagi jam 08.00</strong>. Klik field untuk memilih
        waktu.</small>

    @error('detail_waktu')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kebutuhan Disinfektan per Baris</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="dynamicTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 20%">Baris</th>
                        <th style="width: 20%">Area</th>
                        <th style="width: 20%">Jenis Disinfektan</th>
                        <th style="width: 15%">Merk Disinfektan</th>
                        <th style="width: 15%">Dosis Per Tangki(gram/ml)</th>
                        <th style="width: 50px;">
                            <button type="button" id="addRowBtn" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $oldFlocks = old('flocks');

                        if (empty($oldFlocks) && isset($penjadwalanDisinfektan) && $penjadwalanDisinfektan->relationLoaded('penjadwalanFlock') === false) {
                            $oldFlocks = $penjadwalanDisinfektan->penjadwalanFlocks->toArray();
                        }

                        // Finally ensure it's an array
                        $oldFlocks = is_array($oldFlocks) ? $oldFlocks : ($oldFlocks ? $oldFlocks->toArray() : []);
                    @endphp

                    @if(!empty($oldFlocks))
                        @foreach($oldFlocks as $i => $f)
                            <tr data-row-index="{{ $i }}">
                                <td>
                                    <select name="flocks[{{ $i }}][flock_id]" class="form-control select-baris"
                                        data-current="{{ $f['flock_id'] ?? '' }}"></select>
                                </td>
                                <td>
                                    <input type="text" name="flocks[{{ $i }}][area]" class="form-control" placeholder="Area"
                                        value="{{ $f['area'] ?? '' }}">
                                </td>
                                <td>
                                    <select name="flocks[{{ $i }}][jenis_disinfektan_id]" class="form-control select-jenis"
                                        data-current="{{ $f['jenis_disinfektan_id'] ?? '' }}"></select>
                                </td>
                                <td>
                                    <input type="text" name="flocks[{{ $i }}][merk_disinfektan]" class="form-control"
                                        placeholder="Merk Disinfektan" value="{{ $f['merk_disinfektan'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" name="flocks[{{ $i }}][dosis_per_tangki]" class="form-control"
                                        placeholder="Dosis Per Tangki (gram/ml)" value="{{ $f['dosis_per_tangki'] ?? '' }}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm deleteRowBtn"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {

            const jenisData = {!! json_encode($jenisDisinfektan ?? []) !!};

            let barisData = [];
            let rowCounter = 0; // incremental row index

            let table = $("#dynamicTable").DataTable({
                paging: false,
                searching: false,
                ordering: false,
                info: false,
                columnDefs: [{ orderable: false, targets: [0, 1, 2, 3, 4, 5] }]
            });

            function renderBarisOptions(currentSelected = '') {
                let html = '<option value="">-- Pilih Baris --</option>';
                if (!Array.isArray(barisData) || barisData.length === 0) {
                    return html;
                }

                const assigned = new Set();
                $('select.select-baris').each(function () {
                    const v = $(this).val();
                    if (v && v !== currentSelected) assigned.add(String(v));
                });

                barisData.forEach(function (item) {
                    if (assigned.has(String(item.id))) return;
                    let text = (item.text || '').replace(/Kandang\s*\d+/i, '').trim();
                    html += `<option value="${item.id}" ${String(item.id) === String(currentSelected) ? 'selected' : ''}>${text}</option>`;
                });

                return html;
            }

            function renderJenisOptions(currentSelected = '') {
                let html = '<option value="">-- Pilih Jenis --</option>';
                if (!Array.isArray(jenisData) || jenisData.length === 0) {
                    return html;
                }

                jenisData.forEach(function (item) {
                    const id = item.id ?? item.value ?? item.key;
                    const label = item.name ?? item.text ?? item.label ?? item.nama ?? '';
                    html += `<option value="${id}" ${String(id) === String(currentSelected) ? 'selected' : ''}>${label}</option>`;
                });

                return html;
            }

            function updateAllSelectOptions() {
                // flock selects
                $('select.select-baris').each(function () {
                    const $sel = $(this);
                    const current = $sel.data('current') ?? $sel.val() ?? '';
                    const newHtml = renderBarisOptions(current);
                    $sel.html(newHtml);

                    const stillExists = barisData.some(item => String(item.id) === String(current));
                    if (!current) {
                        $sel.val('');
                        $sel.data('current', '');
                    } else if (!stillExists) {
                        $sel.val('');
                        $sel.data('current', '');
                    } else {
                        $sel.val(current);
                        $sel.data('current', current);
                    }

                    $sel.prop('disabled', !(Array.isArray(barisData) && barisData.length > 0));
                });

                $('select.select-jenis').each(function () {
                    const $sel = $(this);
                    const current = $sel.data('current') ?? $sel.val() ?? '';
                    const newHtml = renderJenisOptions(current);
                    $sel.html(newHtml);

                    if (!current) {
                        $sel.val('');
                        $sel.data('current', '');
                    } else if ($sel.find(`option[value="${String(current)}"]`).length) {
                        $sel.val(current);
                        $sel.data('current', current);
                    } else {
                        $sel.val('');
                        $sel.data('current', '');
                    }

                    $sel.prop('disabled', !(Array.isArray(jenisData) && jenisData.length > 0));
                });
            }

            function restoreSelectsFromDataCurrent() {
                $('select.select-baris').each(function () {
                    const $sel = $(this);
                    const desired = String($sel.attr('data-current') ?? $sel.data('current') ?? '');
                    if (!desired) return;
                    if ($sel.find(`option[value="${desired}"]`).length) {
                        $sel.val(desired);
                        $sel.data('current', desired);
                    } else {
                        $sel.val('');
                        $sel.data('current', '');
                    }
                });

                $('select.select-jenis').each(function () {
                    const $sel = $(this);
                    const desired = String($sel.attr('data-current') ?? $sel.data('current') ?? '');
                    if (!desired) return;
                    if ($sel.find(`option[value="${desired}"]`).length) {
                        $sel.val(desired);
                        $sel.data('current', desired);
                    } else {
                        $sel.val('');
                        $sel.data('current', '');
                    }
                });
            }

            function refreshRowNames() {
                $('#dynamicTable tbody tr').each(function (i) {
                    $(this).attr('data-row-index', i);
                    $(this).find('select.select-baris').attr('name', `flocks[${i}][flock_id]`);
                    $(this).find('input[name*="[area]"]').attr('name', `flocks[${i}][area]`);
                    $(this).find('select.select-jenis').attr('name', `flocks[${i}][jenis_disinfektan_id]`);
                    $(this).find('input[name*="[merk_disinfektan]"]').attr('name', `flocks[${i}][merk_disinfektan]`);
                    $(this).find('input[name*="[dosis_per_tangki]"]').attr('name', `flocks[${i}][dosis_per_tangki]`);
                });
                rowCounter = $('#dynamicTable tbody tr').length;
            }

            function addRow(prevFlock = '', prevJenis = '') {
                // if prevFlock already assigned elsewhere, ignore
                const alreadyAssigned = Array.from($('select.select-baris')).some(s => $(s).val() && $(s).val() == prevFlock);
                if (prevFlock && alreadyAssigned) prevFlock = '';

                const index = rowCounter;

                let selectHtml = `<select name="flocks[${index}][flock_id]" class="form-control select-baris" required>${renderBarisOptions(prevFlock)}</select>`;
                let areaHtml = `<input type="text" name="flocks[${index}][area]" class="form-control" placeholder="Area" required>`;
                let jenisSelectHtml = `<select name="flocks[${index}][jenis_disinfektan_id]" class="form-control select-jenis" required>${renderJenisOptions(prevJenis)}</select>`;
                let merkHtml = `<input type="text" name="flocks[${index}][merk_disinfektan]" class="form-control" placeholder="Merk Disinfektan" required>`;
                let dosisHtml = `<input type="number" name="flocks[${index}][dosis_per_tangki]" class="form-control" placeholder="Dosis Per Tangki (gram/ml)" required>`;
                let delBtn = `<button type="button" class="btn btn-danger btn-sm deleteRowBtn"><i class="fa fa-trash"></i></button>`;

                const rowNode = table.row.add([selectHtml, areaHtml, jenisSelectHtml, merkHtml, dosisHtml, delBtn]).draw(false).node();

                $(rowNode).attr('data-row-index', index);
                rowCounter++;

                updateAllSelectOptions();

                const $sel = $(rowNode).find('select.select-baris');
                if (prevFlock && !$('select.select-baris').not($sel).filter(function () { return $(this).val() == prevFlock; }).length) {
                    $sel.val(prevFlock);
                    $sel.data('current', prevFlock);
                }

                const $jenisSel = $(rowNode).find('select.select-jenis');
                if (prevJenis) {
                    $jenisSel.val(prevJenis);
                    $jenisSel.data('current', prevJenis);
                }

                refreshRowNames();
            }

            // ---------- INIT ----------
            const existingRows = table.rows().count();

            if (existingRows > 1) {
                rowCounter = existingRows;
                refreshRowNames();
                // don't call updateAllSelectOptions yet; will be called after kandang/jenis loaded
            } else {
                addRow();
            }

            // add row btn
            $("#addRowBtn").on("click", function (e) {
                e.preventDefault();
                let lastFlock = '';
                const $lastSelect = $('#dynamicTable tbody tr:last').find('select.select-baris');
                if ($lastSelect.length && $lastSelect.val()) lastFlock = $lastSelect.val();
                addRow(lastFlock, ''); // no prevJenis
            });

            // change flock select -> update options uniq
            $("#dynamicTable tbody").on("change", "select.select-baris", function () {
                $(this).data('current', $(this).val());
                updateAllSelectOptions();
            });

            // change jenis select -> store data-current too
            $("#dynamicTable tbody").on("change", "select.select-jenis", function () {
                $(this).data('current', $(this).val());
            });

            // delete row
            $("#dynamicTable tbody").on("click", ".deleteRowBtn", function () {
                table.row($(this).closest("tr")).remove().draw(false);
                setTimeout(function () {
                    updateAllSelectOptions();
                    refreshRowNames();
                }, 10);
            });

            // populate kandang list
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

            // when kandang changes load baris data then update selects and restore old values
            $('#form-kandang').change(function () {
                const kandangId = $(this).val();
                if (!kandangId) {
                    barisData = [];
                    updateAllSelectOptions();
                    return;
                }

                let url = '/master-data/ajax/flock/' + kandangId;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        barisData = response.results || [];

                        // update both flock & jenis selects
                        updateAllSelectOptions();

                        // restore server-rendered values (data-current) if present
                        restoreSelectsFromDataCurrent();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // form submit validation
            $('form').on('submit', function (e) {
                let valid = true;

                $('select.select-baris').each(function () {
                    if ($(this).prop('disabled') || !$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                $('select.select-jenis').each(function () {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                $('input[name^="flocks"][name$="[dosis_per_tangki]"]').each(function () {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Harap isi semua Baris, Jenis dan Dosis sebelum menyimpan.');
                    return false;
                }
            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            const hiddenInput = document.getElementById('detail_waktu');           // hidden HH:MM (submitted)
            const displayInput = document.getElementById('detail_waktu_display');  // visible readonly
            const nativePicker = document.getElementById('native_time_picker');    // <input type="time">
            const clearBtn = document.getElementById('clear_detail_waktu');

            function periodLabel(hour) {
                hour = parseInt(hour, 10);
                if (hour >= 4 && hour < 10) return 'Pagi';
                if (hour >= 10 && hour < 15) return 'Siang';
                if (hour >= 15 && hour < 18) return 'Sore';
                return 'Malam';
            }

            function toDisplayText(hhmm) {
                if (!hhmm) return '';
                const parts = hhmm.split(':');
                if (parts.length < 2) return hhmm;
                const hh = String(parts[0]).padStart(2, '0');
                const mm = String(parts[1]).padStart(2, '0');
                return periodLabel(hh) + ' jam ' + hh + '.' + mm;
            }

            // init display from existing value
            if (hiddenInput.value) {
                displayInput.value = toDisplayText(hiddenInput.value);
                // also sync native picker value
                if (nativePicker) nativePicker.value = hiddenInput.value;
            }

            // when user clicks visible display, open native time picker
            displayInput.addEventListener('click', function () {
                // support focusing the hidden native picker to open browser time UI
                if (nativePicker) {
                    // Some browsers need focus then click to open UI
                    nativePicker.focus();
                    nativePicker.click();
                } else {
                    // fallback: prompt user to enter (not ideal)
                    const manual = prompt('Masukkan waktu (HH:MM)', hiddenInput.value || '');
                    if (manual) {
                        hiddenInput.value = manual;
                        displayInput.value = toDisplayText(manual);
                    }
                }
            });

            // when native picker value changes -> update hidden and display
            nativePicker.addEventListener('input', function (e) {
                const val = e.target.value; // "HH:MM"
                hiddenInput.value = toDisplayText(val);
                displayInput.value = toDisplayText(val);
                displayInput.classList.remove('is-invalid');
            });

            // clear button
            clearBtn.addEventListener('click', function (e) {
                e.preventDefault();
                hiddenInput.value = '';
                displayInput.value = '';
                if (nativePicker) nativePicker.value = '';
            });

            // optional client-side form validation (UX)
            const form = displayInput.closest('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    // if you require the field, uncomment below to block empty
                    // if (!hiddenInput.value) { e.preventDefault(); alert('Silakan pilih waktu.'); displayInput.classList.add('is-invalid'); }
                });
            }
        });
    </script>
@endpush