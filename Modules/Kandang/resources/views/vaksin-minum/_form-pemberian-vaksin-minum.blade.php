<div class="mb-4">
    <x-adminlte-input 
        name="nama_vaksin"
        label="Nama Vaksin Minum"
        type="text"
        id="nama-vaksin-minum"
        min="0"
        placeholder="Masukkan nama vaksin minum..."
        :value="old('nama_vaksin', @$data->nama_vaksin)"
        igroup-size="lg"
        fgroup-class="col-12"
        class="form-control form-control-lg py-3">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-drumstick-bite text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>
<div class="mb-4">
    <x-adminlte-input
        name="total_dosis"
        label="Total Dosis Vaksin Minum"
        type="number"
        id="total-dosis-vaksin-minum"
        placeholder="Masukkan total dosis vaksin minum..."
        :value="old('total_dosis', @$data->total_dosis)"
        igroup-size="lg"
        fgroup-class="col-12"
        class="form-control form-control-lg py-3">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-drumstick-bite text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>
<div class="mb-4">
    <x-adminlte-input
        id="air_minum_per_ekor"
        type="number"
        name="air_minum_per_ekor"
        label="Kebutuhan Air Minum per Ekor"
        value="{{ old('air_minum_per_ekor', @$data->air_minum_per_ekor) }}"
        igroup-size="lg"
        fgroup-class="col-12"
        class="form-control form-control-lg py-3"
        placeholder="Masukkan kebutuhan air minum per ekor..."
    >
    <x-slot name="prependSlot">
        <div class="input-group-text bg-white">
            <i class="fas fa-drumstick-bite text-muted"></i>
        </div>
    </x-slot>
    </x-adminlte-input>
</div>
<div class="mb-4">
    <x-adminlte-input
        id="jumlah-ayam-per-baris-vaksin-minum"
        type="number"
        name="jumlah_ayam_per_baris"
        label="Jumlah Ayam per Baris"
        value="{{ old('jumlah_ayam_per_baris', @$data->jumlah_ayam_per_baris) }}"
        igroup-size="lg"
        fgroup-class="col-12"
        readonly
        class="form-control-lg py-3">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-drumstick-bite text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>
<div class="mb-4">
    <x-adminlte-input
        id="jumlah-ml-vaksin-per-baris"
        type="number"
        name="jumlah_ml_vaksin_per_baris"
        label="Jumlah ML Vaksin per Baris"
        value="{{ old('jumlah_ml_vaksin_per_baris', @$data->jumlah_ml_vaksin_per_baris) }}"
        igroup-size="lg"
        fgroup-class="col-12"
        readonly
        class="form-control-lg py-3">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-drumstick-bite text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>
<div class="mb-4">
    <x-adminlte-input
        id="jumlah-air-di-tong-per-baris"
        type="number"
        name="jumlah_air_di_tong_per_baris"
        label="Jumlah Air di Tong per Baris"
        value="{{ old('jumlah_air_di_tong_per_baris', @$data->jumlah_air_di_tong_per_baris) }}"
        igroup-size="lg"
        fgroup-class="col-12"
        readonly
        class="form-control-lg py-3">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-drumstick-bite text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>



@push('js')
    <script>
        $('document').ready(function() {
            $('#air_minum_per_ekor').on('keyup', function() {
                let airMinumPerEkor = parseFloat($(this).val()) || 0;
                let jmlAyamPerBaris = parseFloat($('#jumlah-ayam-per-baris-vaksin-minum').val()) || 0;
                $('#jumlah-air-di-tong-per-baris').val(jmlAyamPerBaris * airMinumPerEkor / 1000);
            });
        });
    </script>
@endpush