@extends('layouts.dashboard')

@section('title', 'Transaksi Ayam Karantina')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Form Ayam karantina</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan Mencatat Populasi dan detail ayam karantina
    </span>
</div>
@endsection


@section('content')
<div>
        <div style="max-width: 1200px" class="row justify-content-center px-3">
            {{-- Form Content --}}
            <div class="col-md-8">
            <form action="{{ route('ayam-karantina.masuk.store') }}" method="POST">
                @csrf
                    <div class="card">
                        <div class="card-body">
                            @include('kandang::ayam-karantina.ayam-masuk._form')
                        </div>
                    </div>
                    {{-- Button Submit --}}
                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button id="btnSubmitPopulasi" type="submit"
                            class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>

        {{-- Petunjuk Form --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="m-0 fw-semibold text-secondary">
                            <i class="fas fa-info-circle me-2"></i> Panduan Pencatatan Ayam Masuk Karantina
                        </h5>
                    </div>

                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Pastikan mengisi data karantina ayam dengan benar sesuai petunjuk berikut:
                        </p>

                        <ul class="small text-muted ps-3">
                            <li>
                                <strong>Pilih Kandang</strong><br>
                                Pilih kandang asal ayam yang akan dicatat.
                            </li>

                            <li class="mt-2">
                                <strong>Pilih Baris</strong><br>
                                Pilih baris sesuai kandang yang dipilih.
                            </li>

                            <li class="mt-2">
                                <strong>Pilih Pipa</strong><br>
                                Pilih pipe sesuai baris yang dipilih.
                            </li>

                            <li class="mt-2">
                                <strong>Tanggal Pencatatan</strong><br>
                                Masukkan tanggal catatan ayam masuk karantina.
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam</strong><br>
                                Masukkan jumlah ayam yang masuk karantina pada hari tersebut.
                            </li>

                            <li class="mt-2">
                                <strong>Catatan</strong><br>
                                Tambahkan keterangan tambahan yang relevan, misal kondisi
                                 ayam atau kendala.
                            </li>
                        </ul>

                        <hr>

                        <p class="text-muted small">
                            Pastikan dropdown Kandang, Baris, dan Pipa muncul dengan benar.
                             Jika tidak, periksa bahwa data berikut sudah ada:
                        </p>
                        <ul class="small text-muted ps-3">
                            <li>Data Kandang</li>
                            <li>Data Baris</li>
                            <li>Data Pipa</li>
                        </ul>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
    // Load Kandang saat page load
    $.ajax({
        url: '/master-data/ajax/kandang',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            $.each(data.results, function(index, kandang){
                $('#kandang').append(
                    $('<option>', { 
                        value: kandang.id, 
                        text: kandang.text 
                    })
                );
            });
        },
        error: function(xhr, status, error){
            console.log("Terjadi kesalahan: " + error);
        }
    });

    // Ketika pilih Kandang → load Flock
    $('#kandang').on('change', function(){
        var kandangId = $(this).val();
        $('#flock').html('<option value="">-- Pilih Flock --</option>');
        $('#pipe').html('<option value="">-- Pilih Pipe --</option>');

        if(kandangId){
            $.ajax({
                url: '/master-data/ajax/flock/' + kandangId,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $.each(data.results, function(i, flock){
                        $('#flock').append(
                            $('<option>', { 
                                value: flock.id, 
                                text: flock.text 
                            })
                        );
                    });
                },
                error: function(xhr, status, error){
                    console.log("Terjadi kesalahan: " + error);
                }
            });
        }
    });

    // Ketika pilih Flock → load Pipe
    $('#flock').on('change', function(){
        var flockId = $(this).val();
        $('#pipe').html('<option value="">-- Pilih Pipe --</option>');

        if(flockId){
            $.ajax({
                url: '/master-data/ajax/pipe/' + flockId,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $.each(data.results, function(i, pipe){
                        $('#pipe').append(
                            $('<option>', { 
                                value: pipe.id, 
                                text: pipe.text 
                            })
                        );
                    });
                },
                error: function(xhr, status, error){
                    console.log("Terjadi kesalahan: " + error);
                }
            });
        }
    });
});

</script>
@endpush
