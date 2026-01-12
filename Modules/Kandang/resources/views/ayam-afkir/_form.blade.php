<x-adminlte-input
    name="populasi_ayam_id" 
    label="Populasi Ayam" 
    placeholder="Pilih Populasi Ayam..."
    type="text"
    :value="@$ayamAfkir->populasi->pipe->nama"
    readonly
/>

<x-adminlte-input 
    name="tanggal" 
    label="Tanggal Transaksi" 
    type="date" 
    :value="$ayamAfkir->tanggal->format('Y-m-d')"
    readonly
/>

<x-adminlte-input 
    name="umur_ayam" 
    label="Umur Ayam (mingguan)" 
    type="number" 
    :value="old('umur_ayam', @$ayamAfkir->umur_ayam)"
    placeholder="Masukkan umur ayam"
    readonly
/>

<x-adminlte-input 
    name="jumlah_ayam_afkir" 
    label="Jumlah Ayam Afkir" 
    type="number" 
    :value="old('jumlah_ayam_afkir', @$ayamAfkir->jumlah_ayam_afkir)"
    placeholder="Masukkan jumlah ayam afkir"
    readonly
/>

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
