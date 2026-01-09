<x-adminlte-input
    name="ayam_mati"
    label="Jumlah Ayam Mati"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    :value="old('ayam_mati', @$data->ayam_mati)"
/>

<x-adminlte-input
    name="ayam_afkir"
    label="Jumlah Ayam Afkir"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    :value="old('ayam_afkir', @$data->ayam_afkir)"
/>

<x-adminlte-input
    name="ayam_masuk_karantina"
    label="Ayam Masuk ke Karantina"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    :value="old('ayam_masuk_karantina', @$data->ayam_masuk_karantina)"
/>

<x-adminlte-input
    name="ayam_keluar_karantina"
    label="Ayam Keluar dari Karantina"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    :value="old('ayam_keluar_karantina', @$data->ayam_keluar_karantina)"
/>