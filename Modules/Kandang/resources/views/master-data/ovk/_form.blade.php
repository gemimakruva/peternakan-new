<div
    x-data="{
        listSatuan: @js($listSatuan),
        dosis_pembilang: @js(old('dosis_pembilang', @$data->dosis_pembilang)),
        dosis_pembilang_satuan_id: @js(old('dosis_pembilang_satuan_id', @$data->dosis_pembilang_satuan_id)),
        dosis_penyebut: @js(old('dosis_penyebut', @$data->dosis_penyebut)),
        dosis_penyebut_satuan_id: @js(old('dosis_penyebut_satuan_id', @$data->dosis_penyebut_satuan_id)),
        penggunaan_per_hari: @js(old('penggunaan_per_hari', @$data->penggunaan_per_hari)),
        penggunaan_per_hari_satuan_id: @js(old('penggunaan_per_hari_satuan_id', @$data->penggunaan_per_hari_satuan_id)),
        {{-- durasi_per_bulan: @js(old('durasi_per_bulan', @$data->durasi_per_bulan)), --}}
        harga: @js(old('harga', @$data->harga)),
        harga_per_satuan: @js(old('harga_per_satuan', @$data->harga_per_satuan)),
        harga_per_satuan_id: @js(old('harga_per_satuan_id', @$data->harga_per_satuan_id)),
        get dosis() {
            if (
                !this.dosis_pembilang
                || !this.dosis_penyebut
                || !this.dosis_pembilang_satuan_id
                || !this.dosis_penyebut_satuan_id
            ) { return 0 }

            const dosis     = Number(this.dosis_pembilang)/Number(this.dosis_penyebut);
            const pembilang = this.listSatuan.find((item) => item.id == this.dosis_pembilang_satuan_id).nama;
            const penyebut  = this.listSatuan.find((item) => item.id == this.dosis_penyebut_satuan_id).nama;

            return `${dosis} ${pembilang}/${penyebut}`;
        },
        {{-- get total_penggunaan_per_bulan() {
            const penggunaan    = this.penggunaan_per_hari * this.durasi_per_bulan
            const satuan     = this.listSatuan.find((item) => item.id == this.dosis_pembilang_satuan_id).nama;
            return `${penggunaan} ${satuan}`
        } --}}
    }"
>
    <x-adminlte-select
        label="Jenis OVK"
        name="jenis_ovk_id"
    >
        <x-adminlte-options
            :options="$listJenisOvk"
            empty-option="Pilih Jenis OVK"
            :selected="old('jenis_ovk_id', @$data->jenis_ovk_id)"
        />
    </x-adminlte-select>

    <x-adminlte-input
        label="Nama"
        name="nama"
        placeholder="Nama"
        :value="old('nama', @$data->nama)"
    />

    <x-adminlte-input
        label="Dosis Pembilang"
        name="dosis_pembilang"
        x-model="dosis_pembilang"
        placeholder="Dosis Pembilang"
        type="numeric"
    />

    <x-adminlte-select
        label="Satuan Dosis Pembilang"
        name="dosis_pembilang_satuan_id"
        x-model="dosis_pembilang_satuan_id"
    >
        <x-adminlte-options
            :options="$listSatuan->pluck('nama', 'id')->toArray()"
            empty-option="Pilih Satuan Dosis Pembilang"
            :selected="old('dosis_pembilang_satuan_id', @$data->dosis_pembilang_satuan_id)"
        />
    </x-adminlte-select>

    <x-adminlte-input
        label="Dosis Penyebut"
        name="dosis_penyebut"
        x-model="dosis_penyebut"
        placeholder="Dosis Penyebut"
        type="numeric"
    />

    <x-adminlte-select
        label="Satuan Dosis Penyebut"
        name="dosis_penyebut_satuan_id"
        x-model="dosis_penyebut_satuan_id"
    >
        <x-adminlte-options
            :options="$listSatuan->pluck('nama', 'id')->toArray()"
            empty-option="Pilih Satuan Dosis Penyebut"
            :selected="old('dosis_penyebut_satuan_id', @$data->dosis_penyebut_satuan_id)"
        />
    </x-adminlte-select>

    <x-adminlte-input
        label="Dosis"
        name="dosis"
        placeholder="Dosis"
        x-bind:value="dosis"
        readonly
    />

    <x-adminlte-input
        label="Penggunaan per Hari"
        name="penggunaan_per_hari"
        x-model="penggunaan_per_hari"
        placeholder="Penggunaan per Hari"
        type="numeric"
    />

    <x-adminlte-select
        label="Satuan Penggunaan per Hari"
        name="penggunaan_per_hari_satuan_id"
        x-model="penggunaan_per_hari_satuan_id"
    >
        <x-adminlte-options
            :options="$listSatuan->pluck('nama', 'id')->toArray()"
            empty-option="Pilih Satuan Penggunaan per Hari"
            :selected="old('penggunaan_per_hari_satuan_id', @$data->penggunaan_per_hari_satuan_id)"
        />
    </x-adminlte-select>

    <x-adminlte-input
        label="Harga"
        name="harga"
        x-model="harga"
        placeholder="Harga"
        type="numeric"
    />

    <x-adminlte-input
        label="Harga per Satuan"
        name="harga_per_satuan"
        x-model="harga_per_satuan"
        placeholder="Harga per Satuan"
        type="numeric"
    />

    <x-adminlte-select
        label="Satuan Harga"
        name="harga_per_satuan_id"
        x-model="harga_per_satuan_id"
    >
        <x-adminlte-options
            :options="$listSatuan->pluck('nama', 'id')->toArray()"
            empty-option="Pilih Satuan Harga"
            :selected="old('harga_per_satuan_id', @$data->harga_per_satuan_id)"
        />
    </x-adminlte-select>

    {{-- <x-adminlte-input
        label="Durasi Perbulan"
        name="durasi_per_bulan"
        x-model="durasi_per_bulan"
        placeholder="Durasi Perbulan"
        type="numeric"
    /> --}}

    {{-- <x-adminlte-input
        label="Total Penggunaan Perbulan"
        name="total_penggunaan_per_bulan"
        placeholder="Total Penggunaan Perbulan"
        x-bind:value="total_penggunaan_per_bulan"
        readonly
    /> --}}

</div>