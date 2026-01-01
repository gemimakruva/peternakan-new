@extends('layouts.dashboard')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center pt-3">
    <h2 class="h4 fw-bold text-dark"> Form Edit Pengadaan Ayam</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Halaman ini digunakan untuk edit form pengadaan ayam
</div>
@stop

@section('content')
<div class="container-fluid px-2 px-md-4" style="max-width: 1200px">
    <div class="row justify-content-center">
        {{-- Form Content --}}
          <div class="col-md-8">
              <form enctype="multipart/form-data"
               action="{{ route('pengadaan-ayam.update', $pengadaan_ayam->id) }}"
               method="post" id="form_pengadaan">
                 @method('PUT')
                 @csrf
                 <input type="hidden" name="distribusi_json" id="distribusi_json"
                  >
                   <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @csrf
                            @include('kandang::pengadaan-ayam._form',
                            ['data' => $pengadaan_ayam])
                            {{-- ===========================
                             Status Ayam (3 sejajar)
                            =========================== --}}
                            <div class="row mb-4 p-2">
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <span style="width: 50px" class="info-box-icon
                                        bg-warning">
                                            <i class="fas fa-truck"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Ayam Datang</span>
                                            <span class="info-box-number"
                                             id="ayamDatangInfo">0</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Ayam Mati --}}
                               <div class="col-md-4">
                                    <div class="info-box">
                                            <span style="width: 50px" class="info-box-icon
                                            bg-warning">
                                                <i class="fas fa-skull"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span style="font-size:15px"
                                                class="info-box-text">Ayam Mati</span>
                                                <span class="info-box-number"
                                                id="ayamMatiInfo">0</span>
                                            </div>
                                        </div>
                                </div>

                                {{-- Ayam Sakit --}}
                               <div class="col-md-4">
                                    <div class="info-box">
                                            <span style="width: 50px" class="info-box-icon
                                            bg-warning">
                                                <i class="fas fa-thermometer-half"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span style="font-size:15px"
                                                class="info-box-text">Ayam Sakit</span>
                                                <span class="info-box-number"
                                                id="ayamSakitInfo">0</span>
                                            </div>
                                        </div>
                                </div>

                                {{-- Ayam Masuk Kandang --}}
                               <div class="col-md-4">
                                    <div class="info-box">
                                            <span style="width: 50px" class="info-box-icon
                                            bg-warning">
                                                <i class="fas fa-warehouse"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span style="font-size:15px"
                                                class="info-box-text">Masuk Kandang</span>
                                                <span class="info-box-number"
                                                id="ayamMasukKandangInfo">0</span>
                                            </div>
                                        </div>
                                </div>

                                {{-- Ayam Belum Masuk Kandang --}}
                               <div class="col-md-4">
                                    <div class="info-box">
                                            <span style="width: 50px" class="info-box-icon
                                            bg-warning">
                                            <i class="fas fa-balance-scale"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span style="font-size:15px"
                                                class="info-box-text">Sisa Ayam</span>
                                                <span class="info-box-number"
                                                id="AyamBelumMasukKandang">0</span>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            {{-- Tabel data distribusi  --}}
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="font-weight-bold mb-1">
                                            Data Distribusi Ayam
                                            @if(isset($pengadaan_ayam) && $pengadaan_ayam->distribusi->count() > 0)
                                                <span class="badge badge-info ml-2">{{ $pengadaan_ayam->distribusi->count() }} distribusi</span>
                                            @endif
                                        </h5>
                                    </div>
                                    <button type="button" data-toggle="modal" data-target=
                                    "#modalDistribusi"
                                    class="btn btn-primary btn-sm" id="btnAddDistribusi">
                                        <i class="fas fa-plus me-1"></i> Tambah Distribusi
                                    </button>
                                </div>

                                <table  id="tableDistribusi" class="table table-bordered table-striped
                                text-center align-middle">
                                    <thead class="bg-secondary text-white">
                                        <tr>
                                            <th style="width: 60px;">No</th>
                                            <th>Kandang</th>
                                            <th>Flock</th>
                                            <th>Pipe</th>
                                            <th>Jumlah Masuk</th>
                                            <th style="width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($pengadaan_ayam) && $pengadaan_ayam->distribusi->count() > 0)
                                            {{-- Data will be populated by JavaScript --}}
                                            <tr>
                                                <td colspan="6" class="text-muted">
                                                    <i class="fas fa-spinner fa-spin"></i> Loading data...
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-muted">
                                                    Belum ada data distribusi. Klik tombol "Tambah Distribusi" untuk menambah.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            @include('kandang::pengadaan-ayam._form_berkas', ['data' => $pengadaan_ayam->berkasSupplier])
                            @include('kandang::pengadaan-ayam._form_documentation', ['data' => $pengadaan_ayam->dokumentasi])
                              {{-- card submit --}}
                            <div class="mt-4 d-flex justify-content-between px-3">
                                <a href=""
                                class="btn btn-secondary px-4 py-2">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                </a>
                                <button type="submit"
                                        class="btn btn-success px-4 py-2 shadow-sm">
                                    <i class="fas fa-save me-2"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
              </form>
       </div>

       {{-- Petunjuk Form --}}
        <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="m-0 fw-semibold text-secondary">
                            <i class="fas fa-info-circle me-2"></i> Informasi Pengadaan Ayam
                        </h5>
                    </div>

                    <div class="card-body">
                            <p class="text-muted mb-3">
                                Pastikan mengisi data pengadaan ayam dengan benar sesuai petunjuk berikut:
                            </p>
                        <ul class="small text-muted ps-3">
                            <li>
                                <strong>Tanggal Pengadaan</strong><br>
                                Tanggal pengadaan diinput saat ayam dari supplier Datang
                                dari kandang
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam Datang</strong>
                                <br class="text-center"> - Masukan jumlah keseluruhan ayam yang datang
                                baik ayam sehat, ayam sakit maupun ayam mati
                            </li>

                            <li class="mt-2">
                                <strong>Umur Ayam</strong><br>
                                Masukan rata rata populasi umur ayam datang dalam format mingguan
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam Sakit</strong><br>
                                Masukan jumlah ayam sakit pada saat proses pengadaan ayam
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam Mati</strong>
                                <br class="text-center"> - Masukan jumlah ayam yang mati pada
                                saat proses pengadaan ayam
                            </li>

                             <li class="mt-2">
                                <strong>Kondisi Ayam</strong>
                                <br class="text-center"> - Masukan kondisi rata rata kesuluhan
                                ayam yang datang dalam proses pengadaan ayam
                            </li>

                             <li class="mt-2">
                                <strong>Catatan</strong>
                                <br class="text-center"> - Masukan catatan yang diperlukan
                                dalam proses pengadaan ayam
                            </li>

                            <li class="mt-2">
                                <strong>Input Form Distribusi Ayam</strong>
                                <br>
                                - Digunakan untuk melakukan plotting distribusi pengadaan
                                 ayam berdasarkan Kandang, Flock, dan Pipe.
                                Petugas diharapkan melakukan input dengan benar
                                 dan teliti sesuai data yang tersedia.
                                <br>
                                - Jumlah ayam yang diinput tidak boleh melebihi kapasitas
                                yang telah ditetapkan pada setiap Pipe.
                                <br>
                                - Setelah input distribusi dilakukan, sistem akan secara
                                otomatis menghitung jumlah ayam yang
                                belum masuk kandang
                            </li>

                             <li class="mt-2">
                                <strong>Input Form Berkas Supplier</strong>
                                <br>
                                - petugas diharapkan menginput nama (jenis) Berkas
                                dalam proses pengadaan Ayam
                                <br>
                                - setelah itu petugas diharapkan menguploud file
                                baik berupa file PNG , JPG atau PDF (disarankan JPG)
                            </li>

                              <li class="mt-2">
                                <strong>Upload Dokumentasi</strong>
                                <br>
                                - petugas diharapkan menguploud bukti proses
                                  dokumentasi saat pelaksanaan proses pengadaan ayam
                                  (bisa uploud lebih dari 1 foto)
                            </li>

                        </ul>
                        <hr>
                        <p class="text-muted small">
                            Jika pilihan dropdown tidak muncul atau pipe tidak tergenerate, pastikan Anda
                             sudah menambahkan:
                        </p>
                        <ul class="small text-muted ps-3">
                            <li>Data Peternakan</li>
                            <li>Data Kandang</li>
                            <li>Data Strain</li>
                        </ul>
                    </div>
                </div>
        </div>
    </div>
</div>

{{-- =================== MODAL FORM DISTRIBUSI ====================== --}}
<div class="modal fade" id="modalDistribusi" tabindex="-1" role="dialog"
    aria-labelledby="modalDistribusiLabel"
    aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="modalDistribusiLabel">Tambah Distribusi Ayam</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <form id="formDistribusi">
        <div class="modal-body">
          <div class="">
                {{-- Pilih Kandang --}}
                <div >
                    <x-adminlte-select name="kandang_id"  label="Kandang" igroup-size="lg" id="kandangSelect"
                        class="form-control form-control-lg py-1">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-warehouse text-muted"></i>
                                </div>
                            </x-slot>
                            <option selected disabled>Pilih Kandang...</option>
                            @foreach ($listKandang as $kandang)
                                <option value="{{ $kandang->id }}">{{ $kandang->nama }}</option>
                            @endforeach
                    </x-adminlte-select>
                </div>

                {{-- Pilih Flock --}}
                <div >
                    <x-adminlte-select id="flockSelect" name="flock_id" label="Flock"
                        igroup-size="lg">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-white">
                                <i class="fas fa-feather-alt text-muted"></i>
                            </div>
                        </x-slot>
                        <option selected disabled>Pilih Flock...</option>
                    </x-adminlte-select>
                </div>

                {{-- Pilih Pipe --}}
                <div >
                <x-adminlte-select id="pipeSelect" name="pipe_id"
                label="Pipe" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-tint text-muted"></i>
                        </div>
                    </x-slot>
                    <option selected disabled>Pilih Pipe...</option>
                </x-adminlte-select>
                </div>

                {{-- Jumlah Ayam --}}
                <div >
                <x-adminlte-input
                    id="jumlah_ayam"
                    name="jumlah_ayam"
                    label="Jumlah Ayam"
                    type="number"
                    min="0"
                    placeholder="Input jumlah ayam..."
                    class="form-control form-control-lg py-3"
                    igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-drumstick-bite text-muted"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@push('js')
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>

        // {{-- CASCADING SELECT FORM FUNCTION  --}}
        $(document).ready(function(){
        var kandangData = @json($listKandang);
        let editingId = null;
        let distribusiData = [];
        let count = 0;
        let selectedPipe = [];
        let TotalAyamDatang = 0;
        let TotalAyamSakit = 0;
        let TotalAyamMati = 0;
        let TotalMasukKandang = 0;
        let TotalBelumMasukKandang = 0;

        // LOAD EXISTING DISTRIBUTION DATA FIRST
        @if(isset($pengadaan_ayam) && $pengadaan_ayam->distribusi->count() > 0)
            @foreach($pengadaan_ayam->distribusi as $dist)
                distribusiData.push({
                    id: ++count,
                    kandang: "{{ $dist->pipe->flock->kandang->nama }}",
                    kandang_id: {{ $dist->pipe->flock->kandang->id }},
                    flock: "{{ $dist->pipe->flock->nama }}",
                    flock_id: {{ $dist->pipe->flock->id }},
                    pipe: "{{ $dist->pipe->nama }}",
                    pipe_id: {{ $dist->pipe_id }},
                    jumlah: {{ $dist->jumlah_ayam }},
                    isEditable: @js($dist->populasiAyam === null),
                    isExisting: true,
                });
                selectedPipe.push("{{ $dist->pipe_id }}");
            @endforeach
            console.log('Loaded ' + distribusiData.length + ' existing distribution records');
        @endif

        $('#kandangMainSelect').change(function(){
            var kandangId = $(this).val();
            $('#kandangSelect').val(kandangId).prop('disabled', true).trigger('change');
        });

        $('#btnAddDistribusi').click(function(){
            var mainKandangId = $('#kandangMainSelect').val();
            if(mainKandangId){
                $('#kandangSelect').val(mainKandangId).prop('disabled', true).trigger('change');
            } else {
                alert('Pilih kandang terlebih dahulu pada form utama');
                return false;
            }
        });

         $('#kandangSelect').change(function(){
            var kandangId = $(this).val();
            var flockSelect = $('#flockSelect');

            flockSelect.empty().append('<option selected disabled>Pilih Flock...</option>');

            if(kandangId){
                var kandang = kandangData.find(k => k.id == kandangId);
                if(kandang && kandang.flocks.length > 0){
                    $.each(kandang.flocks, function(i, flock){
                        flockSelect.append('<option value="'+flock.id+'">'+flock.nama+'</option>');
                    });
                }
            }
        });

         $('#flockSelect').change(function(){
            var flockId = $(this).val();
            var pipeSelect = $('#pipeSelect');
            pipeSelect.empty().append('<option selected disabled>Pilih Pipe...</option>');

            if(flockId){
                var kandangId = $('#kandangSelect').val();
                var kandang = kandangData.find(k => k.id == kandangId);
                if(kandang){
                    var flock = kandang.flocks.find(f => f.id == flockId);
                    if(flock && flock.pipes.length > 0){
                        pipeSelect.empty().append('<option selected disabled>Pilih Pipe...</option>');
                        $.each(flock.pipes, function(i, pipe){
                            var currentEditPipe = null;
                            if (editingId) {
                                var editItem = distribusiData.find(d => d.id == editingId);
                                if (editItem) {
                                    currentEditPipe = editItem.pipe_id;
                                }
                            }

                            if (!selectedPipe.includes(String(pipe.id)) || pipe.id == currentEditPipe) {
                                pipeSelect.append(
                                    `<option value="${pipe.id}" data-kapasitas="${pipe.kapasitas}">
                                        ${pipe.nama} (Kapasitas: ${pipe.kapasitas})
                                    </option>`
                                );
                            }

                        });
                    }
                }
            }
        });

       // {{-- SUBMITION TEMPORARY FUNCTION  --}}
        $('#formDistribusi').submit(function(e){
            e.preventDefault();

            if (confirm("Anda yakin akan dihapus. Tekan ya yakin?")) {
                console.log('Menghapus data distribusi yang dipilih');
            }

            const kandangText = $('#kandangSelect option:selected').text();
            const flockText = $('#flockSelect option:selected').text();
            const pipeText = $('#pipeSelect option:selected').text();
            const pipeId = $('#pipeSelect option:selected').val();
            const kandangId = $('#kandangSelect option:selected').val();
            const flockId = $('#flockSelect option:selected').val();
            const jumlah = $(this).find('input[name="jumlah_ayam"]').val();

            if (editingId) {
                const index = distribusiData.findIndex(item => item.id == editingId);

                if (index !== -1) {
                    if (distribusiData[index].pipe_id !== pipeId) {
                        selectedPipe = selectedPipe.filter(p => p !== distribusiData[index].pipe_id);
                        if (!selectedPipe.includes(pipeId)) {
                            selectedPipe.push(pipeId);
                        }
                    }

                    distribusiData[index] = {
                        id: editingId,
                        kandang: kandangText,
                        kandang_id: kandangId,
                        flock: flockText,
                        flock_id: flockId,
                        pipe: pipeText,
                        pipe_id: pipeId,
                        jumlah: jumlah
                    };
                }
                editingId = null;
            } else {
                if (!selectedPipe.includes(pipeId)) {
                    selectedPipe.push(pipeId);
                }

                distribusiData.push({
                    id: ++count,
                    kandang: kandangText,
                    kandang_id: kandangId,
                    flock: flockText,
                    flock_id: flockId,
                    pipe: pipeText,
                    pipe_id: pipeId,
                    jumlah: jumlah
                });
            }

            $(this)[0].reset();
            // $('#pipeSelect').empty().append('<option selected disabled>Pilih Pipe...</option>');
            // $('#flockSelect').empty().append('<option selected disabled>Pilih Flock...</option>');
            // $('#kandangSelect').empty().append('<option selected disabled>Pilih Kandang...</option>');

            $('#modalDistribusi').modal('hide');
            setModalMode('add');
            renderTableDistribusi();
            updateAyamStatus();
        });

         //  =============== FUNCTION RENDER TABEL ================
        function renderTableDistribusi() {
            var tbody = $('#tableDistribusi tbody');
            tbody.empty();

        if (distribusiData.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="6" class="text-muted">
                        Belum ada data distribusi. Klik tombol "Tambah Distribusi" untuk menambah.
                    </td>
                </tr>
            `);
        } else {
            $.each(distribusiData, function(index, item) {

                var tr = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.kandang}</td>
                        <td>${item.flock}</td>
                        <td>${item.pipe}</td>
                        <td>${item.jumlah}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn"
                                type="button"
                                data-id="${item.id}"
                                data-kandang="${item.kandang_id}"
                                data-flock="${item.flock_id}"
                                data-pipe="${item.pipe_id}"
                                data-jumlah="${item.jumlah}"
                                ${item.isEditable ? '' : 'disabled'}>
                                <i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger delete-btn"
                                data-id="${item.id}"
                                ${item.isEditable ? '' : 'disabled'}>
                                <i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                tbody.append(tr);
            });
        }
    }

    // ===== FUNCTION VALIDATION INPUT JUMLAH AYAM ===========
    $('#jumlah_ayam').on('input', function() {
        var inputJumlah = parseInt($(this).val());
        var kapasitasPipe = parseInt($('#pipeSelect option:selected').data('kapasitas')) || 0;

        if(inputJumlah > kapasitasPipe){
            $(this).addClass('is-invalid');
            $('#jumlah_ayam_feedback').remove();
            $(this).
            after('<div id="jumlah_ayam_feedback" class="invalid-feedback">Jumlah melebihi kapasitas pipe ('
                +kapasitasPipe+')</div>');
        } else {
            $(this).removeClass('is-invalid');
            $('#jumlah_ayam_feedback').remove();
        }
    });

    // ===== FUNCTION REFRESH PIPE SELECT ===========
    function refreshPipeSelect() {
        var kandangId = $('#kandangSelect').val();
        var flockId = $('#flockSelect').val();
        var pipeSelect = $('#pipeSelect');

        if (!flockId || !kandangId) return;

        var kandang = kandangData.find(k => k.id == kandangId);
        if (!kandang) return;

        var flock = kandang.flocks.find(f => f.id == flockId);
        if (!flock || !flock.pipes.length) return;

        // Simpan nilai yang sedang dipilih (jika ada)
        var currentValue = pipeSelect.val();

        pipeSelect.empty().append('<option selected disabled>Pilih Pipe...</option>');

        $.each(flock.pipes, function(i, pipe){
            var currentEditPipe = null;
            if (editingId) {
                var editItem = distribusiData.find(d => d.id == editingId);
                if (editItem) {
                    currentEditPipe = String(editItem.pipe_id);
                }
            }

            // Tampilkan pipe jika tidak ada di selectedPipe ATAU sedang di-edit
            if (!selectedPipe.includes(String(pipe.id)) || String(pipe.id) === currentEditPipe) {
                pipeSelect.append(
                    `<option value="${pipe.id}" data-kapasitas="${pipe.kapasitas}">
                        ${pipe.nama} (Kapasitas: ${pipe.kapasitas})
                    </option>`
                );
            }
        });

        // Restore nilai jika masih valid
        if (currentValue && pipeSelect.find(`option[value="${currentValue}"]`).length > 0) {
            pipeSelect.val(currentValue);
        }
    }

    //  ====== FUNCTION DELEGATIN FOR DELETE DATA ========
    $(document).on('click', '.delete-btn', function() {
         var id = $(this).data('id');
         var item = distribusiData.find(d => d.id == id);

         if (item) {
             selectedPipe = selectedPipe.filter(p => p !== item.pipe_id);
         }
         distribusiData = distribusiData.filter(item => item.id != id);
         renderTableDistribusi();
         updateAyamStatus();

         // REFRESH DROPDOWN PIPE jika modal sedang terbuka
        if ($('#modalDistribusi').hasClass('show')) {
        refreshPipeSelect();
        }
    })

    // ===== SUBMIT DISTRIBUTION DATA INTO REQUEST CONTROLLER ======
    $('#form_pengadaan').submit(function(e){
        e.preventDefault();
        $('#distribusi_json').val(JSON.stringify(distribusiData));
        this.submit();
    });

    // CALCULATE AYAM MASUK DAN AYAM BELUM MASUK KANDANG
    $('#inputAyamDatang').on('input', function () {
        TotalAyamDatang = parseInt($(this).val()) || 0;
        $('#ayamDatangInfo').text(TotalAyamDatang.toLocaleString('id-ID'));
        updateAyamStatus();
    });

    $('#inputAyamMati').on('input', function () {
        let TotalAyamMati = parseInt($(this).val()) || 0;
        $('#ayamMatiInfo').text(TotalAyamMati.toLocaleString('id-ID'));
        updateAyamStatus();
    });

    $('#inputAyamSakit').on('input', function () {
        let TotalAyamSakit = parseInt($(this).val()) || 0;
        $('#ayamSakitInfo').text(TotalAyamSakit.toLocaleString('id-ID'));
        updateAyamStatus();
    });

    function updateAyamStatus() {
        // Baca nilai terbaru dari input form
        TotalAyamDatang = parseInt($('#inputAyamDatang').val()) || 0;
        TotalAyamMati = parseInt($('#inputAyamMati').val()) || 0;
        TotalAyamSakit = parseInt($('#inputAyamSakit').val()) || 0;

        TotalMasukKandang = 0;

        $.each(distribusiData, function (index, item) {
            TotalMasukKandang += parseInt(item.jumlah) || 0;
        });

        TotalBelumMasukKandang = TotalAyamDatang - (TotalAyamMati + TotalAyamSakit + TotalMasukKandang);

        $('#ayamMasukKandangInfo').text(TotalMasukKandang.toLocaleString('id-ID'));
        $('#AyamBelumMasukKandang').text(TotalBelumMasukKandang.toLocaleString('id-ID'));
    }

    function setModalMode(mode) {
        if (mode === 'edit') {
            $('#modalDistribusiLabel').text('Edit Distribusi Ayam');
            $('#formDistribusi button[type="submit"]').html('<i class="fas fa-save me-1"></i> Update');
        } else {
            $('#modalDistribusiLabel').text('Tambah Distribusi Ayam');
            $('#formDistribusi button[type="submit"]').html('<i class="fas fa-save me-1"></i> Simpan');
            editingId = null;
        }
    }

    $(document).on('click', '.edit-btn', function() {
        editingId = $(this).data('id');
        const item = distribusiData.find(d => d.id == editingId);

        if (item) {
            setModalMode('edit');
            $('#kandangSelect').val(item.kandang_id).prop('disabled', true).trigger('change');

            setTimeout(() => {
                $('#flockSelect').val(item.flock_id).trigger('change');

                setTimeout(() => {
                    $('#pipeSelect').val(item.pipe_id);
                    $('#jumlah_ayam').val(item.jumlah);
                }, 100);
            }, 100);

            $('#modalDistribusi').modal('show');
        }
    });

    $('#modalDistribusi').on('hidden.bs.modal', function () {
        setModalMode('add');
        $('#formDistribusi')[0].reset();
        $('#kandangSelect').prop('disabled', false);
        $('#jumlah_ayam').removeClass('is-invalid');
        $('#jumlah_ayam_feedback').remove();
    });

    // RENDER TABLE IF DATA EXISTS
    @if(isset($pengadaan_ayam) && $pengadaan_ayam->distribusi->count() > 0)
        renderTableDistribusi();
    @endif

    // LOAD INITIAL AYAM DATANG VALUE
    @if(isset($pengadaan_ayam))
        TotalAyamDatang = {{ $pengadaan_ayam->jumlah_ayam_datang }};
        TotalAyamMati = {{ $pengadaan_ayam->jumlah_ayam_mati }};
        TotalAyamSakit = {{ $pengadaan_ayam->jumlah_ayam_sakit }};
        $('#ayamDatangInfo').text(TotalAyamDatang.toLocaleString('id-ID'));
        $('#ayamMatiInfo').text(TotalAyamMati.toLocaleString('id-ID'));
        $('#ayamSakitInfo').text(TotalAyamSakit.toLocaleString('id-ID'));
        updateAyamStatus();
    @endif

 })
</script>
@endpush


@endsection
