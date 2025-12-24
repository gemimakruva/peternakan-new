@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-steps@1.1.0/demo/css/jquery.steps.css">
@endpush

<form id="wizard-form" method="POST" action="{{ isset($monitoringKesehatan) ? route('monitoring-kesehatan.update', $monitoringKesehatan->id) : route('monitoring-kesehatan.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($monitoringKesehatan))
        @method('PUT')
    @endif
    <div class="row">

        <!-- ================= LEFT STEP NAV ================= -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column" id="wizardSteps" data-mode="{{ isset($monitoringKesehatan) ? 'edit' : 'create' }}">
                        <li class="nav-item">
                            <a class="nav-link active" data-step="0" href="#">
                                Form Monitoring
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-step="1" href="#">
                                I. Data Populasi Ternak
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-step="2" href="#">
                                II. Pemeriksaan Umum
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-step="3" href="#">
                                III. Nekropsi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-step="4" href="#">
                                IV. Tindakan & Rekomendasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-step="5" href="#">
                                V. Evaluasi & Catatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-step="6" href="#">
                                VI. Dokumentasi & Submit
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ================= RIGHT CONTENT ================= -->
        <div class="col-md-9">

            <div class="wizard-step" data-step="0">
                <div class="card">
                    <div class="card-header">
                        <strong>Form Monitoring Kesehatan</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <x-adminlte-input name="tanggal" label="Tanggal Pelaksanaan Monitoring" type="date"
                                    :disabled="isset($monitoringKesehatan)" :value="old('tanggal', $monitoringKesehatan->tanggal ?? '')"
                                    required>

                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-white">
                                            <i class="fas fa-calendar-alt text-muted"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                        </div>

                        <div class="form-group">
                        <label>Pilih Kandang</label>
                        <select
                            name="kandang_id"
                            id="kandang_id"
                            class="form-control"
                            required
                            @isset($monitoringKesehatan) disabled @endisset
                            data-selected="{{ old('kandang_id', $monitoringKesehatan->kandang_id ?? '') }}"
                        >
                            <option value="">Memuat data kandang...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <x-adminlte-input name="tim_pelaksana" label="Tim Pelaksana" type="text" placeholder="Tim Pelaksana"
                            :value="old('tim_pelaksana', $monitoringKesehatan->tim_pelaksana ?? '')"
                            required>
                        </x-adminlte-input>
                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 0 -->
            <div class="wizard-step" data-step="1">
                <div class="card">
                    <div class="card-header">
                        <strong>I. Data Populasi Ternak</strong>
                    </div>
                    <div class="card-body">
                        <h5>1. Total Populasi Ayam</h5>
                        <div class="form-group">
                            <x-adminlte-input name="total_populasi_ayam" label="Total Populasi Ayam" type="number" placeholder="Total Populasi Ayam"
                                :value="old('total_populasi_ayam', $monitoringKesehatan->total_populasi_ayam ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>

                        <h5>2. Distribusi Populasi Ayam</h5>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <x-adminlte-input name="ayam_sehat" label="Ayam Sehat" type="number" placeholder="Ayam Sehat"
                                    :value="old('ayam_sehat', $monitoringKesehatan->ayam_sehat ?? '')"
                                    required>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-6 form-group">
                                <x-adminlte-input name="ayam_sakit" label="Ayam Sakit" type="number" placeholder="Ayam Sakit"
                                    :value="old('ayam_sakit', $monitoringKesehatan->ayam_sakit ?? '')"
                                    required>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-6 form-group">
                                <x-adminlte-input name="ayam_afkir" label="Ayam Afkir" type="number" placeholder="Ayam Afkir"
                                    :value="old('ayam_afkir', $monitoringKesehatan->ayam_afkir ?? '')"
                                    required>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-6 form-group">
                                <x-adminlte-input name="ayam_mati" label="Ayam Mati" type="number" placeholder="Ayam Mati"
                                    :value="old('ayam_mati', $monitoringKesehatan->ayam_mati ?? '')"
                                    required>
                                </x-adminlte-input>
                            </div>
                        </div>

                        <h5>3. Jenis Penyakit yang Ditemukan</h5>
                        <div class="form-group">
                            <x-adminlte-textarea
                                name="detail_penyakit_ditemukan"
                                placeholder="Jenis Penyakit yang Ditemukan"
                                required
                            >
                                {{ old('detail_penyakit_ditemukan', $monitoringKesehatan->detail_penyakit_ditemukan ?? '') }}
                            </x-adminlte-textarea>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 1 -->
            <div class="wizard-step d-none" data-step="2">
                <div class="card">
                    <div class="card-header">
                        <strong>II. Pemeriksaan Umum</strong>
                    </div>
                    <div class="card-body">

                        <h5>1. Kondisi Umum Ternak</h5>
                        <div class="form-group">
                            <x-adminlte-input name="umum_perilaku" label="Perilaku" type="text" placeholder="Perilaku"
                                :value="old('umum_perilaku', $monitoringKesehatan->umum_perilaku ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>
                        <div class="form-group">
                            <x-adminlte-input name="umum_kondisi_bulu" label="Kondisi Bulu" type="text" placeholder="Kondisi Bulu"
                                :value="old('umum_kondisi_bulu', $monitoringKesehatan->umum_kondisi_bulu ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>
                        <div class="form-group">
                            <x-adminlte-input name="umum_proporsi_tubuh" label="Proporsi Tubuh" type="text" placeholder="Proporsi Tubuh"
                                :value="old('umum_proporsi_tubuh', $monitoringKesehatan->umum_proporsi_tubuh ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>
                        <div class="form-group">
                            <x-adminlte-input name="umum_nafsu_makan" label="Nafsu Makan" type="text" placeholder="Nafsu Makan"
                                :value="old('umum_nafsu_makan', $monitoringKesehatan->umum_nafsu_makan ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>
                        <div class="form-group">
                            <x-adminlte-input name="umum_produktivitas_telur" label="Produktivitas Telur" type="text" placeholder="Produktivitas Telur"
                                :value="old('umum_produktivitas_telur', $monitoringKesehatan->umum_produktivitas_telur ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>

                        <h5>2. Kondisi Lingkungan Kandang</h5>
                        <div class="form-group">
                            <x-adminlte-input name="lingkungan_suhu" label="Suhu" type="text" placeholder="Suhu"
                                :value="old('lingkungan_suhu', $monitoringKesehatan->lingkungan_suhu ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>
                        <div class="form-group">
                            <x-adminlte-input name="lingkungan_kelembapan" label="Kelembapan" type="text" placeholder="Kelembapan"
                                :value="old('lingkungan_kelembapan', $monitoringKesehatan->lingkungan_kelembapan ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>
                        <div class="form-group">
                            <x-adminlte-input name="lingkungan_kebersihan" label="Kebersihan" type="text" placeholder="Kebersihan"
                                :value="old('lingkungan_kebersihan', $monitoringKesehatan->lingkungan_kebersihan ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>

                        <h5>3. Kondisi Umum Ayam</h5>
                        <div class="form-group">
                            <x-adminlte-input name="detail_kondisi_umum" type="text" placeholder="Kondisi Umum Ayam"
                                :value="old('detail_kondisi_umum', $monitoringKesehatan->detail_kondisi_umum ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-prev">
                            Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="wizard-step d-none" data-step="3">
                <div class="card">
                    <div class="card-header">
                        <strong>III. Nekropsi</strong>
                    </div>
                    <div class="card-body">
                        <h5>1. Jumlah ternak yang dinekropsi(bedah)</h5>
                        <div class="form-group">
                            <x-adminlte-input name="nekropsi_jumlah_ayam" type="number" placeholder="Jumlah ternak yang dinekropsi"
                                :value="old('nekropsi_jumlah_ayam', $monitoringKesehatan->nekropsi_jumlah_ayam ?? '')"
                                required>
                            </x-adminlte-input>
                        </div>

                        <h5>2. Temuan Nekropsi</h5>
                        <div class="table-responsive">
                            <table id="dynamicTable" class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width:120px;">File Upload</th>
                                        <th style="width:160px;">Preview</th>
                                        <th>Keterangan</th>
                                        <th style="width:50px;" class="text-center">
                                            <button type="button" id="addRowBtn" class="btn btn-success btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Untuk EDIT MODE (jika ada data) --}}
                                    @if(!empty($monitoringKesehatan?->nekropsi))
                                        @foreach($monitoringKesehatan->nekropsi as $i => $item)
                                        
                                            <tr data-index="{{ $i }}">
                                                {{-- simpan ID nekropsi lama --}}
                                                <input type="hidden" name="nekropsi[{{ $i }}][id]" value="{{ $item->id }}">

                                                <td class="text-center align-middle">
                                                    <label class="btn btn-outline-secondary btn-sm mb-0">
                                                        <i class="fas fa-upload"></i><br>Upload
                                                        <input type="file"
                                                            name="nekropsi[{{ $i }}][image]"
                                                            accept="image/*"
                                                            class="d-none file-input">
                                                    </label>
                                                </td>

                                                <td class="text-center align-middle">
                                                    <img src="{{ Storage::url($item->path) }}"
                                                        class="img-thumbnail preview-img"
                                                        style="width:120px;height:120px;object-fit:cover;">
                                                </td>

                                                <td>
                                                    <textarea
                                                        name="nekropsi[{{ $i }}][keterangan]"
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="Input keterangan sesuai gambar">{{ $item->keterangan }}</textarea>
                                                </td>

                                                <td class="text-center align-middle">
                                                    <button type="button" class="btn btn-danger btn-sm removeRowBtn">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-prev">
                            Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="wizard-step d-none" data-step="4">
                <div class="card">
                    <div class="card-header">
                        <strong>IV. Tindakan & Rekomendasi</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <x-adminlte-textarea name="tindakan_pengobatan" label="1. Pengobatan yang dilakukan" type="text" placeholder="Pengobatan yang dilakukan"
                                required>
                                {{ old('tindakan_pengobatan', $monitoringKesehatan->tindakan_pengobatan ?? '') }}
                            </x-adminlte-textarea>
                        </div>
                        <div class="form-group">
                            <x-adminlte-textarea name="tindakan_rekomendasi_jangka_pendek" label="2. Rekomendasi Jangka Pendek" type="text" placeholder="Rekomendasi Jangka Pendek"
                                required>
                                {{ old('tindakan_rekomendasi_jangka_pendek', $monitoringKesehatan->tindakan_rekomendasi_jangka_pendek ?? '') }}
                            </x-adminlte-textarea>
                        </div>
                        <div class="form-group">
                            <x-adminlte-textarea name="tindakan_rekomendasi_jangka_panjang" label="2. Rekomendasi Jangka Panjang" type="text" placeholder="Rekomendasi Jangka Panjang"
                                required>
                                {{ old('tindakan_rekomendasi_jangka_panjang', $monitoringKesehatan->tindakan_rekomendasi_jangka_panjang ?? '') }}
                            </x-adminlte-textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-prev">
                            Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="wizard-step d-none" data-step="5">
                <div class="card">
                    <div class="card-header">
                        <strong>V. Evaluasi & Catatan</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <x-adminlte-textarea name="evaluasi_efektivitas_pengobatan" label="1. Efektivitas Pengobatan" type="text" placeholder="Efektivitas Pengobatan"
                                required>
                                {{ old('evaluasi_efektivitas_pengobatan', $monitoringKesehatan->evaluasi_efektivitas_pengobatan ?? '') }}
                            </x-adminlte-textarea>
                        </div>
                        <div class="form-group">
                            <x-adminlte-textarea name="evaluasi_catatan" label="2. Catatan Khusus" type="text" placeholder="Catatan Khusus"
                                required>
                                {{ old('evaluasi_catatan', $monitoringKesehatan->evaluasi_catatan ?? '') }}
                            </x-adminlte-textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-prev">
                            Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary btn-next">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 5 -->
            <div class="wizard-step d-none" data-step="6">
                <div class="card">
                    <div class="card-header">
                        <strong>VI. Dokumentasi & Submit</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <x-adminlte-input-file 
                                name="dokumentasi[]"
                                label="Upload Dokumentasi"
                                placeholder="Pilih gambar..."
                                accept="image/*"
                                multiple
                                igroup-size="md"
                                fgroup-class="col-12"
                                class="form-control form-control-lg py-3"
                                id="multiImageInput">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-white">
                                        <i class="fas fa-camera text-muted"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-file>
                            <div id="previewContainer" class="row mt-3 g-2">
                                @isset($monitoringKesehatan->dokumentasi)
                                    @foreach ($monitoringKesehatan->dokumentasi as $doc)
                                        <div class="col-4 existing-image" data-path="{{ $doc }}">
                                            <input type="hidden" name="existing_dokumentasi[]" value="{{ $doc }}">
                                            <div class="position-relative">
                                                <img src="{{ Storage::url($doc) }}" class="img-thumbnail shadow-sm rounded" style="height: 120px; width: 100%; object-fit: cover;" />
                                                <button type="button"
                                                        class="btn btn-danger btn-xs position-absolute remove-existing"
                                                        style="top:5px;right:5px;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-prev">
                            Sebelumnya
                        </button>
                        <button type="submit" class="btn btn-success">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>

<script type="text/template" id="rowTemplate">
<tr data-index="{index}">
    <td class="text-center align-middle">
        <label class="btn btn-outline-secondary btn-sm mb-0">
            <i class="fas fa-upload"></i><br>Upload
            <input type="file"
                   name="nekropsi[{index}][image]"
                   accept="image/*"
                   class="d-none file-input">
        </label>
    </td>

    <td class="text-center align-middle">
        <img src=""
             class="img-thumbnail preview-img d-none"
             style="width:120px;height:120px;object-fit:cover;">
    </td>

    <td>
        <textarea name="nekropsi[{index}][keterangan]"
                  class="form-control"
                  rows="3"
                  placeholder="Input keterangan sesuai gambar"></textarea>
    </td>

    <td class="text-center align-middle">
        <button type="button" class="btn btn-danger btn-sm removeRowBtn">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
</script>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-steps@1.1.0/build/jquery.steps.min.js"></script>
    <script>
        $(function () {
            const $tableBody = $('#dynamicTable tbody');
            const template = $('#rowTemplate').html();
            let index = $tableBody.children().length;

            function addRow() {
                let html = template.replace(/{index}/g, index);
                $tableBody.append(html);
                index++;
            }

            if (index === 0) addRow();

            $('#addRowBtn').on('click', function () {
                addRow();
            });

            $tableBody.on('click', '.removeRowBtn', function () {
                $(this).closest('tr').remove();
            });

            $tableBody.on('change', '.file-input', function () {
                const file = this.files[0];
                if (!file || !file.type.startsWith('image/')) return;

                const reader = new FileReader();
                const $img = $(this).closest('tr').find('.preview-img');

                reader.onload = e => {
                    $img.attr('src', e.target.result).removeClass('d-none');
                };
                reader.readAsDataURL(file);
            });

            populateDataKandang('kandang_id');

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
            
            let currentStep = 0;
            const totalSteps = $('.wizard-step').length;
            const mode = $('#wizardSteps').data('mode'); // create | edit

            function showStep(step) {
                $('.wizard-step').addClass('d-none');
                $(`.wizard-step[data-step="${step}"]`).removeClass('d-none');

                $('#wizardSteps .nav-link').removeClass('active');
                $(`#wizardSteps .nav-link[data-step="${step}"]`).addClass('active');

                currentStep = step;
            }

            function validateStep(step) {
                let valid = true;

                $(`.wizard-step[data-step="${step}"]`)
                    .find(':input[required]:enabled')
                    .each(function () {
                        if (!this.value) {
                            $(this).addClass('is-invalid');
                            valid = false;
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                return valid;
            }

            // =====================
            // NEXT (VALIDASI)
            // =====================
            $(document).on('click', '.btn-next', function () {
                if (!validateStep(currentStep)) return;
                if (currentStep < totalSteps - 1) {
                    showStep(currentStep + 1);
                }
            });

            // =====================
            // PREV (BEBAS)
            // =====================
            $(document).on('click', '.btn-prev', function () {
                if (currentStep > 0) {
                    showStep(currentStep - 1);
                }
            });

            // =====================
            // TAB CLICK
            // =====================
            $('#wizardSteps').on('click', '.nav-link', function (e) {
                e.preventDefault();
                const target = $(this).data('step');

                // CREATE → hanya boleh maju jika valid
                if (mode === 'create' && target > currentStep) {
                    if (!validateStep(currentStep)) return;
                }

                // EDIT → bebas
                showStep(target);
            });

            // =====================
            // START STEP
            // =====================
            showStep(0);
        });

        const previewContainer = $('#previewContainer');
        const fileInput = $('#multiImageInput');

        // ==========================
        // PREVIEW GAMBAR BARU
        // ==========================
        fileInput.on('change', function (e) {
            const files = Array.from(e.target.files);

            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function (ev) {
                    previewContainer.append(`
                        <div class="col-4 new-image">
                            <div class="position-relative">
                                <img src="${ev.target.result}"
                                    class="img-thumbnail shadow-sm rounded"
                                    style="height:120px;width:100%;object-fit:cover;">
                            </div>
                        </div>
                    `);
                };
                reader.readAsDataURL(file);
            });
        });

        // ==========================
        // HAPUS GAMBAR LAMA
        // ==========================
        previewContainer.on('click', '.remove-existing', function () {
            $(this).closest('.existing-image').remove();
        });
    </script>
@endpush