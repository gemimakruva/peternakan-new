<x-adminlte-input
    name="kandang_name" 
    label="Pilih Kandang" 
    :value="@$data->kandang->nama"
    readonly
/>

<x-adminlte-input
    name="tanggal"
    label="Tanggal"
    type="date"
    :value="@$data->tanggal?->format('Y-m-d')"
    readonly
/>

<x-adminlte-input 
    id="total_ayam_karantina"
    name="total_ayam_karantina" 
    label="Total Ayam Karantina" 
    type="number" 
    :value="old('total_ayam_karantina', @$data->total_ayam_karantina)"
    placeholder="Total Ayam Karantina" 
    disabled
/>

<x-adminlte-input 
    id="ayam_mati"
    name="ayam_mati" 
    label="Ayam Mati" 
    type="number" 
    :value="old('ayam_mati', @$data->ayam_mati)"
    placeholder="Masukkan jumlah ayam mati" 
    required
/>

<x-adminlte-input 
    id="ayam_afkir"
    name="ayam_afkir" 
    label="Ayam Afkir" 
    type="number" 
    :value="old('ayam_afkir', @$data->ayam_afkir)"
    placeholder="Masukkan jumlah ayam afkir" 
    required
/>

<x-adminlte-input 
    id="pemberian_pakan"
    name="pemberian_pakan" 
    label="Pemberian Pakan (kg)" 
    type="number"
    step="0.01"
    :value="old('pemberian_pakan', @$data->pemberian_pakan)"
    placeholder="Masukkan jumlah pakan"
    required
/>

<x-adminlte-input 
    id="sisa_pakan"
    name="sisa_pakan" 
    label="Sisa Pakan (kg)" 
    type="number"
    step="0.01"
    :value="old('sisa_pakan', @$data->sisa_pakan)"
    placeholder="Masukkan sisa pakan"
    required
/>

<x-adminlte-input 
    id="jumlah_telur_bagus"
    name="jumlah_telur_bagus" 
    label="Jumlah Telur Bagus" 
    type="number" 
    :value="old('jumlah_telur_bagus', @$data->jumlah_telur_bagus)"
    placeholder="Masukkan jumlah telur bagus"
    required
/>

<x-adminlte-input 
    id="jumlah_telur_retak"
    name="jumlah_telur_retak" 
    label="Jumlah Telur Retak" 
    type="number" 
    :value="old('jumlah_telur_retak', @$data->jumlah_telur_retak)"
    placeholder="Masukkan jumlah telur retak"
    required
/>

<x-adminlte-input 
    id="jumlah_telur_rusak"
    name="jumlah_telur_rusak" 
    label="Jumlah Telur Rusak" 
    type="number" 
    :value="old('jumlah_telur_rusak', @$data->jumlah_telur_rusak)"
    placeholder="Masukkan jumlah telur rusak"
    required
/>

<x-adminlte-input 
    id="berat_telur_bagus"
    name="berat_telur_bagus" 
    label="Berat Telur Bagus (gram)" 
    type="number"
    step="0.01"
    :value="old('berat_telur_bagus', @$data->berat_telur_bagus)"
    placeholder="Masukkan berat telur bagus"
    required
/>

<x-adminlte-input 
    id="berat_telur_retak"
    name="berat_telur_retak" 
    label="Berat Telur Retak (gram)" 
    type="number"
    step="0.01"
    :value="old('berat_telur_retak', @$data->berat_telur_retak)"
    placeholder="Masukkan berat telur retak"
    required
/>

<x-adminlte-input 
    id="berat_telur_rusak"
    name="berat_telur_rusak" 
    label="Berat Telur Rusak (gram)" 
    type="number" 
    step="0.01"
    :value="old('berat_telur_rusak', @$data->berat_telur_rusak)"
    placeholder="Masukkan berat telur rusak" required
/>

<x-adminlte-input 
    id="pengobatan_yang_dilakukan"
    name="pengobatan_yang_dilakukan" 
    label="Pengobatan yang Dilakukan" 
    type="text" 
    :value="old('pengobatan_yang_dilakukan', @$data->pengobatan_yang_dilakukan)"
    placeholder="Masukkan jenis pengobatan"
    required
/>

<x-adminlte-input 
    id="jumlah_ayam_diobati"
    name="jumlah_ayam_diobati" 
    label="Jumlah Ayam Diobati" 
    type="number" 
    :value="old('jumlah_ayam_diobati', @$data->jumlah_ayam_diobati)"
    placeholder="Masukkan jumlah ayam diobati"
    required
/>

<x-adminlte-input 
    id="penyemprotan"
    name="penyemprotan" 
    label="Penyemprotan" 
    type="text" 
    :value="old('penyemprotan', @$data->penyemprotan)"
    placeholder="Masukkan jenis penyemprotan"
    required
/>

<x-adminlte-input 
    id="vaksin"
    name="vaksin" 
    label="Vaksin" 
    type="text" 
    :value="old('vaksin', @$data->vaksin)"
    placeholder="Masukkan jenis vaksin" 
    required
/>

<x-adminlte-textarea 
    id="catatan"
    name="catatan" 
    label="Catatan" 
    placeholder="Tambahkan catatan jika perlu" 
    rows="4"
>{{ old('catatan', @$data->catatan) }}</x-adminlte-textarea>

@pushOnce('js')
    <script>
        var kandangId = $('select[name=kandang_id]').val();
        var tanggal = $('input[name=tanggal]').val();

        function getKarantinaPopulasiData() {            
            if (!kandangId || !tanggal) {
                return;
            }
            const url = @js(route('ajax.karantina_populasi', [':kandangId', ':tanggal']))
            $.getJSON(url)
                .then(function(res) {
                    if (!res) return;
                    $('#total_ayam_karantina').val(res.total_ayam_karantina);
                    $('#ayam_mati').val(res.ayam_mati);
                    $('#ayam_afkir').val(res.ayam_afkir);
                    $('#pemberian_pakan').val(res.pemberian_pakan);
                    $('#sisa_pakan').val(res.sisa_pakan);
                    $('#jumlah_telur_bagus').val(res.jumlah_telur_bagus);
                    $('#jumlah_telur_retak').val(res.jumlah_telur_retak);
                    $('#jumlah_telur_rusak').val(res.jumlah_telur_rusak);
                    $('#berat_telur_bagus').val(res.berat_telur_bagus);
                    $('#berat_telur_retak').val(res.berat_telur_retak);
                    $('#berat_telur_rusak').val(res.berat_telur_rusak);
                    $('#pengobatan_yang_dilakukan').val(res.pengobatan_yang_dilakukan);
                    $('#jumlah_ayam_diobati').val(res.jumlah_ayam_diobati);
                    $('#penyemprotan').val(res.penyemprotan);
                    $('#vaksin').val(res.vaksin);
                    $('#catatan').val(res.catatan);
                })
                .catch(function() {
                    console.log('Tidak ada karantina ayam di tanggal tersebut.');
                })
        }
        $('select[name=kandang_id]').on('change', function() {
            kandangId = this.value;
            getKarantinaPopulasiData();
        });
        $('input[name=tanggal]').on('change', function() {
            tanggal = this.value;
            getKarantinaPopulasiData();
        })
    </script>
@endPushOnce