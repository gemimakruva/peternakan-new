<x-adminlte-input 
    name="nama_vaksin"
    label="Nama Vaksin Minum"
    type="text"
    id="nama-vaksin-minum"
    placeholder="Masukkan nama vaksin minum..."
    :value="old('nama_vaksin', @$data->nama_vaksin)"
/>

<x-adminlte-input
    name="total_dosis"
    label="Total Dosis Vaksin Minum"
    type="number"
    min="0"
    id="total-dosis-vaksin-minum"
    placeholder="Masukkan total dosis vaksin minum..."
    :value="old('total_dosis', @$data->total_dosis)"
/>

<x-adminlte-input
    name="air_minum_per_ekor"
    label="Kebutuhan Air Minum per Ekor"
    type="number"
    min="0"
    id="air_minum_per_ekor"
    placeholder="Masukkan kebutuhan air minum per ekor..."
    :value="old('air_minum_per_ekor', @$data->air_minum_per_ekor)"
/>

<x-adminlte-input
    name="jumlah_ayam_per_flock"
    label="Jumlah Ayam per Flock"
    type="number"
    id="jumlah-ayam-per-flock-vaksin-minum"
    :value="old('jumlah_ayam_per_flock', @$data->jumlah_ayam_per_flock)"
    readonly
/>

<x-adminlte-input
    name="jumlah_ml_vaksin_per_flock"
    label="Jumlah ML Vaksin per Flock"
    type="number"
    id="jumlah-ml-vaksin-per-flock"
    :value="old('jumlah_ml_vaksin_per_flock', @$data->jumlah_ml_vaksin_per_flock)"
    readonly
/>

<x-adminlte-input
    name="jumlah_air_di_tong_per_flock"
    label="Jumlah Air di Tong per Flock"
    type="number"
    id="jumlah-air-di-tong-per-flock"
    :value="old('jumlah_air_di_tong_per_flock', @$data->jumlah_air_di_tong_per_flock)"
    readonly
/>

@push('js')
    <script>
        $('document').ready(function() {
            $('#air_minum_per_ekor').on('keyup', function() {
                let airMinumPerEkor = parseFloat($(this).val()) || 0;
                let jmlAyamPerFlock = parseFloat($('#jumlah-ayam-per-flock-vaksin-minum').val()) || 0;
                $('#jumlah-air-di-tong-per-flock').val(jmlAyamPerFlock * airMinumPerEkor / 1000);
            });
        });
    </script>
@endpush