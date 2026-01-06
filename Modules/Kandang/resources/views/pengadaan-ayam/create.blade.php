@extends('layouts.dashboard')

@section('title', 'Pengadaan Ayam')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pengadaan Ayam</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pengadaan-ayam.index') }}">Pengadaan Ayam</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="mx-1200">
        <x-form-alert />
        <div class="row">
            <div class="col-md-9 col-12">
                <form
                    enctype="multipart/form-data"
                    action="{{ route('pengadaan-ayam.store') }}"
                    method="post"
                    id="form-pengadaan"
                >
                    @csrf
                    <input type="hidden" name="distribusi_json" id="distribusi_json">
                    @include('kandang::pengadaan-ayam._form')
                    {{-- @include('kandang::pengadaan-ayam._form_berkas',['listNamaBerkas' => $listNamaBerkas]) --}}
                    {{-- @include('kandang::pengadaan-ayam._form_documentation') --}}
                </form>
            </div>
            <div class="col-md-3 col-12">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('pengadaan-ayam.index') }}" class="btn btn-outline-secondary flex-1">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary flex-1" form="form-pengadaan">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('jsx')
<script>
    $(document).ready(function(){
        var kandangData = @json($listKandang);
        let editingId = null;

        // Auto-populate kandang in modal based on main form selection
        $('#kandangMainSelect').change(function(){
            var kandangId = $(this).val();
            $('#kandangSelect').val(kandangId).prop('disabled', true).trigger('change');
        });

        // When opening modal, set kandang from main form
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
                        pipeSelect.empty().append('<option selected disabled>Pilih Pipe...</option>'); // reset dulu
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
        let distribusiData = [];
        let  count = 0;
        let selectedPipe = [];
        $('#formDistribusi').submit(function(e){
            e.preventDefault();

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
            $('#pipeSelect').empty().append('<option selected disabled>Pilih Pipe...</option>');
            $('#flockSelect').empty().append('<option selected disabled>Pilih Flock...</option>');
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
            $.each(distribusiData, function(index, item) {
                var tr = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.kandang}</td>
                        <td>${item.flock}</td>
                        <td>${item.pipe}</td>
                        <td>${item.jumlah}</td>
                        <td>
                            <button 
                                class="btn btn-sm btn-warning edit-btn"
                                type="button"
                                data-id="${item.id}"
                                data-kandang="${item.kandang_id}"
                                data-flock="${item.flock_id}"
                                data-pipe="${item.pipe_id}"
                                data-jumlah="${item.jumlah}"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(tr);
        });
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

    //  ====== FUNCTION DELEGATIN FOR DELETE DATA ========
    $(document).on('click', '.delete-btn', function() {
         var id = $(this).data('id');
         distribusiData = distribusiData.filter(item => item.id != id);
         renderTableDistribusi();
         updateAyamStatus();
    })

    // ===== SUBMIT DISTRIBUTION DATA INTO REQUEST CONTROLLER ======
    $('#form-pengadaan').submit(function(e){
        e.preventDefault();
        $('#distribusi_json').val(JSON.stringify(distribusiData));
        this.submit();
    });

    // CALCULATE AYAM MASUK DAN AYAM BELUM MASUK KANDANG
    let TotalAyamDatang = 0;
    let TotalMasukKandang = 0;
    let TotalBelumMasukKandang = 0;
    let TotalAyamMati = 0;
    let TotalAyamSakit = 0;

    $('#inputAyamDatang').on('input', function () {
        TotalAyamDatang = parseInt($(this).val()) || 0;
        $('#ayamDatangInfo').text(TotalAyamDatang.toLocaleString('id-ID'));
        updateAyamStatus();
    });

    $('#inputAyamMati').on('input', function () {
        TotalAyamMati = parseInt($(this).val()) || 0;
        $('#ayamMatiInfo').text(TotalAyamMati.toLocaleString('id-ID'));
        updateAyamStatus();
    });

    $('#inputAyamSakit').on('input', function () {
        TotalAyamSakit = parseInt($(this).val()) || 0;
        $('#ayamSakitInfo').text(TotalAyamSakit.toLocaleString('id-ID'));
        updateAyamStatus();
    });

    function updateAyamStatus() {
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

 })
</script>
@endpush

