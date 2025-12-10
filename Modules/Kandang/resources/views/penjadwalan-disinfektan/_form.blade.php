<div class="mb-3">
    <x-adminlte-input name="tanggal" label="Tanggal Penjadwalan Disinfektan Kandang" type="date"
        placeholder="Pilih tanggal penjadwalan..." :value="old('tanggal', isset($data) && $data->tanggal ? $data->tanggal->format('Y-m-d') : '')" required>

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-calendar-alt text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

<div class="mb-3">
    <x-adminlte-select id="form-kandang" name="kandang_id" label="Pilih Kandang" class="select-nama-berkas" required>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
        <option selected disabled>Pilih Kandang...</option>
    </x-adminlte-select>
</div>


<div class="mb-3">
    <x-adminlte-input name="jumlah_ayam_afkir" label="Jumlah Ayam Afkir" type="number" igroup-size="md"
        value="{{ old('jumlah_ayam_afkir', @$data->jumlah_ayam_afkir) }}" placeholder="Masukkan jumlah ayam afkir"
        required>

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-dove text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
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
                            <button id="addRowBtn" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Row dynamic akan masuk di sini -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function () {

    let barisData = [];

    let table = $("#dynamicTable").DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        columnDefs: [{ orderable: false, targets: [0,1,2,3,4,5] }]
    });

    // placeholder tidak disabled sehingga select bisa diklik
    function renderBarisOptions(currentSelected = '') {
        let html = '<option value="">-- Pilih Baris --</option>';
        if (!Array.isArray(barisData) || barisData.length === 0) {
            return html;
        }

        const assigned = new Set();
        $('select.select-baris').each(function() {
            const v = $(this).val();
            if (v && v !== currentSelected) assigned.add(String(v));
        });

        barisData.forEach(function (item) {
            if (assigned.has(String(item.id))) return;
            text = item.text.replace(/Kandang\s*\d+/i, '').trim();
            html += `<option value="${item.id}" ${item.id == currentSelected ? 'selected' : ''}>${text}</option>`;
        });

        return html;
    }

    function updateAllSelectOptions() {
        $('select.select-baris').each(function() {
            const $sel = $(this);
            const current = $sel.val();
            const newHtml = renderBarisOptions(current);
            $sel.html(newHtml);

            // jika current tidak ada lagi di barisData (mis. change kandang), kosongkan
            const stillExists = barisData.some(item => String(item.id) === String(current));
            if (!current) {
                $sel.val('');
            } else if (!stillExists) {
                $sel.val('');
            } else {
                $sel.val(current);
            }

            // enable select jika ada data, disable jika belum ada data
            $sel.prop('disabled', !(Array.isArray(barisData) && barisData.length > 0));
        });
    }

    function addRow(prevValue = '') {
        // jika prevValue sudah ter-assign di row lain, jangan pakai
        const alreadyAssigned = Array.from($('select.select-baris')).some(s => $(s).val() && $(s).val() == prevValue);
        if (prevValue && alreadyAssigned) prevValue = '';

        // HAPUS atribut disabled pada markup — kita control enable/disable via updateAllSelectOptions()
        let selectHtml = `<select name="baris[]" class="form-control select-baris">${renderBarisOptions(prevValue)}</select>`;
        let areaHtml = `<input type="text" name="area[]" class="form-control" placeholder="Area">`;
        let jenisHtml = `<input type="text" name="jenis[]" class="form-control" placeholder="Jenis Disinfektan">`;
        let merkHtml = `<input type="text" name="merk[]" class="form-control" placeholder="Merk Disinfektan">`;
        let dosisHtml = `<input type="text" name="dosis[]" class="form-control" placeholder="Dosis Per Tangki (gram/ml)">`;
        let delBtn = `<button type="button" class="btn btn-danger btn-sm deleteRowBtn"><i class="fa fa-trash"></i></button>`;

        const rowNode = table.row.add([selectHtml, areaHtml, jenisHtml, merkHtml, dosisHtml, delBtn]).draw(false).node();

        // setelah ditambahkan, rebuild options & set enabled sesuai barisData
        updateAllSelectOptions();

        // jika prevValue valid & belum terassign, restore value di select baru
        const $sel = $(rowNode).find('select.select-baris');
        if (prevValue && !$('select.select-baris').not($sel).filter(function(){ return $(this).val() == prevValue; }).length) {
            $sel.val(prevValue);
        }
    }

    // buat 1 row default
    addRow();

    // tombol tambah
    $("#addRowBtn").on("click", function () {
        let lastVal = '';
        const $lastSelect = $('#dynamicTable tbody tr:last').find('select.select-baris');
        if ($lastSelect.length && $lastSelect.val()) lastVal = $lastSelect.val();
        addRow(lastVal);
    });

    // perubahan di select -> update semua agar unik
    $("#dynamicTable tbody").on("change", "select.select-baris", function () {
        updateAllSelectOptions();
    });

    // hapus row -> update opsi kembali
    $("#dynamicTable tbody").on("click", ".deleteRowBtn", function () {
        table.row($(this).closest("tr")).remove().draw(false);
        setTimeout(updateAllSelectOptions, 10);
    });

    // isi kandang
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

                // jika ada nilai terpilih (mis. edit form / old value), trigger change agar barisData ter-load
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

    // saat kandang berubah -> load baris dan refresh select
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
                updateAllSelectOptions();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // validasi sebelum submit
    $('form').on('submit', function (e) {
        let valid = true;
        $('select[name="baris[]"]').each(function () {
            if ($(this).prop('disabled') || !$(this).val()) {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        $('input[name="dosis[]"]').each(function () {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!valid) {
            e.preventDefault();
            alert('Harap isi semua Baris dan Dosis sebelum menyimpan.');
            return false;
        }
    });

    // Jika form di-render dengan old values (edit), kamu bisa set data-selected pada select kandang:
    // <select id="form-kandang" data-selected="{{ old('kandang_id', $data->kandang_id ?? '') }}">
    // sehingga populateDataKandang akan otomatis trigger change dan load baris.

});
</script>
@endpush