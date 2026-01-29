<x-adminlte-input
    id="tanggal_produksi"
    type="date"
    name="tanggal"
    label="Tanggal Produksi"
    value="{{ old('tanggal', $produksiTelur->tanggal ?? now()->format('Y-m-d')) }}"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
/>

<div class="form-group col-12">
    <x-adminlte-select id="input-kandang-recording-telur" name="kandang_id" label="Pilih Kandang" class="select-nama-berkas"
    igroup-size="lg">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
        <option selected disabled>Pilih Kandang...</option>
    </x-adminlte-select>
</div>

<div class="form-group col-12">
    <x-adminlte-select id="input-flock-recording-telur" name="flock_id" label="Pilih Flock" class="select-nama-berkas"
    igroup-size="lg" disabled>
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
        <option selected disabled>Pilih Flock...</option>
    </x-adminlte-select>
</div>

<x-adminlte-input
    id="usia_ayam"
    name="usia_ayam"
    label="Umur Ayam (Minggu Ini)"
    value="{{ old('usia_ayam', $data->usia_ayam ?? 0) }}"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
/>
<div class="row">
    <h4 class="col-12 mb-0">Telur Bagus</h4>
    <div class="col-md-6">
        <x-adminlte-input
            name="jumlah_telur_bagus"
            label="Jumlah"
            type="number"
            step="0.01"
            value="{{ old('jumlah_telur_bagus', $data->jumlah_telur_bagus ?? '') }}"
            placeholder="Masukkan angka..."
            igroup-size="lg"
            class="form-control-lg"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-sort-numeric-up text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="col-md-6">
        <x-adminlte-input
            name="berat_telur_bagus"
            label="Berat (kg)"
            type="number"
            step="0.01"
            value="{{ old('berat_telur_bagus', $data->berat_telur_bagus ?? '') }}"
            placeholder="Masukkan angka..."
            igroup-size="lg"
            class="form-control-lg"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-sort-numeric-up text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
</div>

<div class="row">
    <h4 class="col-12 mb-0">Telur Putih</h4>
    <div class="col-md-6">
        <x-adminlte-input
            name="jumlah_telur_putih"
            label="Jumlah"
            type="number"
            step="0.01"
            value="{{ old('jumlah_telur_putih', $data->jumlah_telur_putih ?? '') }}"
            placeholder="Masukkan angka..."
            igroup-size="lg"
            class="form-control-lg"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-sort-numeric-up text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="col-md-6">
        <x-adminlte-input
            name="berat_telur_putih"
            label="Berat (kg)"
            type="number"
            step="0.01"
            value="{{ old('berat_telur_putih', $data->berat_telur_putih ?? '') }}"
            placeholder="Masukkan angka..."
            igroup-size="lg"
            class="form-control-lg"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-sort-numeric-up text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
</div>
<div class="row">
    <h4 class="col-12 mb-0">Telur Reject</h4>
    <div class="col-md-6">
        <x-adminlte-input
            name="jumlah_telur_reject"
            label="Jumlah"
            type="number"
            step="0.01"
            value="{{ old('jumlah_telur_reject', $data->jumlah_telur_reject ?? '') }}"
            placeholder="Masukkan angka..."
            igroup-size="lg"
            class="form-control-lg"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-sort-numeric-up text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="col-md-6">
        <x-adminlte-input
            name="berat_telur_reject"
            label="Berat (kg)"
            type="number"
            step="0.01"
            value="{{ old('berat_telur_reject', $data->berat_telur_reject ?? '') }}"
            placeholder="Masukkan angka..."
            igroup-size="lg"
            class="form-control-lg"
        >
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-sort-numeric-up text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            let kandangData = [];
            
            populateDataKandang('input-kandang-recording-telur');
            
            function populateDataKandang(elementId) {
                let url = '/master-data/ajax/kandang';
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        console.log(response.results);
                        kandangData = response.results;
                        $(`#${elementId}`).empty();
                        $(`#${elementId}`).append('<option selected disabled>Pilih Kandang...</option>');
                        $.each(response.results, function(index, item) {
                            $(`#${elementId}`).append('<option value="' + item.id + '">' + item.text + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            function populateDataFlock(elementId, kandangId) {
                let url = '/master-data/ajax/flock/' + kandangId;
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        console.log(response.results);
                        flockData = response.results;
                        $(`#${elementId}`).empty();
                        $(`#${elementId}`).append('<option selected disabled>Pilih Flock...</option>');
                        $.each(response.results, function(index, item) {
                            $(`#${elementId}`).append('<option value="' + item.id + '">' + item.text + '</option>');
                        });
                        $(`#${elementId}`).prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function getUsiaAyamByKandangId(kandangid, tanggal = null) {
                if (!tanggal) {
                    tanggal = $('#tanggal_produksi').val() || new Date().toISOString().split('T')[0];
                }
                
                let url = '/master-data/ajax/umur-ayam-by-kandang/' + kandangid;
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        tanggal: tanggal
                    },
                    success: function(response) {
                        console.log(response);
                        data = response;
                        $('input[name="usia_ayam"]').val(data.usia_ayam_saat_ini);
                    },
                    error: function(xhr, status, error) {
                        $('input[name="usia_ayam"]').val(0);
                        console.error(error);
                    }
                });
            }

            $('#input-kandang-recording-telur').change(function() {
                const kandangId = $(this).val();
                const tanggal = $('#tanggal_produksi').val();
                
                populateDataFlock('input-flock-recording-telur', kandangId);
                getUsiaAyamByKandangId(kandangId, tanggal);
            });
            

            $('#tanggal_produksi').change(function() {
                const tanggal = $(this).val();
                const kandangId = $('#input-kandang-recording-telur').val();
                
                if (kandangId && kandangId !== 'Pilih Kandang...') {
                    getUsiaAyamByKandangId(kandangId, tanggal);
                }
            });

            // Auto select data dengan interval
            @if(isset($data) && $data->flock_id)
                @php
                    $editKandangId = $data->flock->kandang_id ?? null;
                    $editFlockId = $data->flock_id;
                @endphp
                
                const editKandangId = {{ $editKandangId ?? 'null' }};
                const editFlockId = {{ $editFlockId }};
                
                const checkKandangLoaded = setInterval(function() {
                    if (kandangData.length > 0) {
                        clearInterval(checkKandangLoaded);
                        
                        if (editKandangId) {
                            console.log('kandang:', editKandangId);
                            $('#input-kandang-recording-telur').val(editKandangId).trigger('change');
                            
                            setTimeout(function() {
                                console.log('flock:', editFlockId);
                                $('#input-flock-recording-telur').val(editFlockId);
                            }, 100);
                        }
                    }
                }, 100);
            @endif
        });
    </script>
@endpush