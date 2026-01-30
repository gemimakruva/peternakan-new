<x-adminlte-input 
    name="pembeli_afkir" 
    label="Nama Pembeli" 
    type="text" 
    :value="old('pembeli_afkir', @$ayamAfkir->pembeli_afkir)"
    placeholder="Masukkan nama pembeli (opsional)"
/>

<x-adminlte-input
    name="harga_jual" 
    label="Harga Jual (Rp)" 
    type="number" 
    :value="old('harga_jual', @$ayamAfkir->harga_jual)"
    placeholder="Masukkan harga jual (opsional)"
/>

<x-adminlte-textarea 
    name="penyebab_afkir" 
    label="Penyebab Afkir"
    rows="5" 
    placeholder="Masukkan penyebab ayam afkir"
>{{ @$ayamAfkir->penyebab_afkir }}</x-adminlte-textarea>
