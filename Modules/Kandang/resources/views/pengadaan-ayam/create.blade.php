@extends('layouts.dashboard')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center pt-3">
    <h2 class="h4 fw-bold text-dark"> Form Pengadaan Ayam</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Halaman ini digunakan untuk input form pengadaan ayam
</div>
@stop

@section('content')
<div class="container-fluid px-2 px-md-4" style="max-width: 1200px">
    <div class="row justify-content-center">
        {{-- Form Content --}}
          <div class="col-md-8">
              <form action="{{ route('pengadaan-ayam.store') }}" method="post" id="form_pengadaan">
                 <input type="hidden" name="distribusi_json" id="distribusi_json">
                   <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @csrf
                            @include('kandang::pengadaan-ayam._form')
                            {{-- ===========================
                             Status Ayam (3 sejajar)
                            =========================== --}}
                            <div class="row mb-4 p-2">
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <span style="width: 50px" class="info-box-icon 
                                        bg-warning">
                                            <i class="fas fa-drumstick-bite"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Ayam Datang</span>
                                            <span class="info-box-number"
                                             id="ayamDatangInfo">0</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Ayam Masuk Kandang --}}
                               <div class="col-md-4">
                                    <div class="info-box">
                                            <span style="width: 50px" class="info-box-icon 
                                            bg-warning">
                                                <i class="fas fa-home"></i>
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
                                    <h5 class="font-weight-bold">Data Distribusi Ayam</h5>
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
                                        {{-- row content --}}
                                    </tbody>
                                </table>
                            </div>

                            @include('kandang::pengadaan-ayam._form_berkas')
                            @include('kandang::pengadaan-ayam._form_documentation')
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
                                Pastikan mengisi data Flock dengan benar sesuai petunjuk berikut:
                            </p>
                        <ul class="small text-muted ps-3">
                            <li>
                                <strong>Tanggal Pengadaan</strong><br>
                                Tanggal pengadaan input saat ayam dari supplier Datang
                                dari kandang
                            </li>

                            <li class="mt-2"> 
                                <strong>Kata Kunci Nama Pipe</strong>
                                <br class="text-center"> - Kata kunci ini digunakan untuk mengelompokkan
                                atau mengidentifikasi pipe yang terhubung dengan flock.
                                <br class="text-center"> - Pastikan kata kunci dibuat tanpa sepasi
                                atau dihubungkan antar kata dengan strip (-). Contoh: <em>flock1-pipe-1, 
                                    flock2-pipe-1</em>.
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Pipe per-Flock</strong><br>
                                isi dengan jumlah pipe yang akan digunakan dalam flock ini.
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
                    class="form-control form-control-lg py-3">
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
    
<script>

    // {{-- CASCADING SELECT FORM FUNCTION  --}}

$(document).ready(function(){
        var kandangData = @json($listKandang);
         $('#kandangSelect').change(function(){
        var kandangId = $(this).val();
        var flockSelect = $('#flockSelect');
        var pipeSelect = $('#pipeSelect');

        flockSelect.empty().append('<option selected disabled>Pilih Flock...</option>');
        pipeSelect.empty().append('<option selected disabled>Pilih Pipe...</option>');

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
                            // filter pipe 
                             if (!selectedPipe.includes(String(pipe.id))) {
                                 pipeSelect.append( '<option value="'+pipe.id+'" data-kapasitas="'+pipe.kapasitas+'">'
                                    +pipe.nama+'</option>'
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
            $(document).ready(function () {})
            e.preventDefault();
            var kandangText = $('#kandangSelect option:selected').text();
            var flockText = $('#flockSelect option:selected').text();
            var pipeText = $('#pipeSelect option:selected').text();
            var pipeId = $('#pipeSelect option:selected').val();
            var jumlah = $(this).find('input[name="jumlah_ayam"]').val();

              if (!selectedPipe.includes(pipeId)) {
                    selectedPipe.push(pipeId);
                }
            
                console.log(selectedPipe)

            distribusiData.push({
            id: ++count,
            kandang: kandangText,
            flock: flockText,
            pipe: pipeText,
            pipe_id: pipeId,
            jumlah: jumlah
            });

            $(this)[0].reset();
            $('#pipeSelect').empty().append('<option selected disabled>Pilih Pipe...</option>');
            $('#flockSelect').empty().append('<option selected disabled>Pilih Flock...</option>');

            $('#modalDistribusi').modal('hide');
            renderTableDistribusi();
            updateAyamStatus();
        })

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
                        <button class="btn btn-sm btn-danger delete-btn" 
                            data-id="${item.id}">
                            <i class="fas fa-trash"></i></button>
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
    $('#form_pengadaan').submit(function(e){
    e.preventDefault(); 
    $('#distribusi_json').val(JSON.stringify(distribusiData));
    this.submit();
    });

    // CALCULATE AYAM MASUK DAN AYAM BELUM MASUK KANDANG
    let TotalAyamDatang = 0;
    let TotalMasukKandang = 0;
    let TotalBelumMasukKandang = 0;
    
    $('#inputAyamDatang').on('input', function () {
    TotalAyamDatang = parseInt($(this).val()) || 0;
    $('#ayamDatangInfo').text(TotalAyamDatang.toLocaleString('id-ID'));
    updateAyamStatus();
    }); 

    function updateAyamStatus() {
    TotalMasukKandang = 0;

    $.each(distribusiData, function (index, item) {
        TotalMasukKandang += parseInt(item.jumlah) || 0;
    });

    TotalBelumMasukKandang = TotalAyamDatang - TotalMasukKandang;

    $('#ayamMasukKandangInfo').text(TotalMasukKandang.toLocaleString('id-ID'));
    $('#AyamBelumMasukKandang').text(TotalBelumMasukKandang.toLocaleString('id-ID'));
    }

 })
</script>
@endpush


@endsection