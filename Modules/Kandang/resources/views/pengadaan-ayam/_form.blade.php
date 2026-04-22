<div class="card">
    <div class="card-body">
        <x-adminlte-input
            type="date"
            name="tanggal"
            label="Tanggal Pengadaan"
            :disabled="@$data->tanggal"
            placeholder="Pilih tanggal pengadaan..."
            :value="old('tanggal', @$data->tanggal?->format('Y-m-d'))"
        />

        @if (@$data->kandang_id)
            <x-adminlte-input 
                type="text"
                name="kandang_name"
                label="Kandang"
                :value="$data->kandang->nama"
                disabled
            />
        @else
            <x-adminlte-select
                name="kandang_id"
                label="Pilih Kandang"
            >
                <option selected disabled>Pilih Kandang...</option>
                @foreach (@$listKandang as $kandang)
                    <option value="{{ $kandang->id }}" @selected(old('kandang_id', @$data->kandang_id) == $kandang->id)>{{ $kandang->nama }}</option>
                @endforeach
            </x-adminlte-select>
        @endif

        <x-adminlte-input
            name="umur_ayam"
            label="Umur Ayam (satuan minggu)"
            type="number"
            min="0"
            placeholder="Masukkan umur ayam.."
            :value="old('umur_ayam', @$data->umur_ayam)"
            :disabled="@$data->umur_ayam"
        />

        <x-adminlte-input
            name="penyesuaian_hari_umur_ayam"
            label="Penyesuaian Hari Umur Ayam (satuan hari)"
            type="number"
            placeholder="Isi -3 untuk kurang 3 hari atau 4 untuk lebih 4 hari"
            :value="old('penyesuaian_hari_umur_ayam', @$data->penyesuaian_hari_umur_ayam)"
            :disabled="@$data->penyesuaian_hari_umur_ayam"
        />

        <x-adminlte-input
            name="jumlah_ayam_datang"
            label="Jumlah Ayam Datang"
            type="number"
            id="inputAyamDatang"
            min="0"
            placeholder="Masukkan jumlah ayam.."
            :value="old('jumlah_ayam_datang', @$data->jumlah_ayam_datang)"
            :disabled="@$data->jumlah_ayam_datang"
        />

        <x-adminlte-input
            name="jumlah_ayam_sakit"
            label="Jumlah Ayam Sakit"
            id="inputAyamSakit"
            type="number"
            min="0"
            placeholder="Masukkan jumlah ayam sakit..."
            :value="old('jumlah_ayam_sakit', @$data->jumlah_ayam_sakit)"
            :disabled="@$data->jumlah_ayam_sakit"
        />

        <x-adminlte-input
            name="jumlah_ayam_mati"
            label="Jumlah Ayam Mati"
            id="inputAyamMati"
            type="number"
            min="0"
            placeholder="Masukkan jumlah ayam mati..."
            :value="old('jumlah_ayam_mati', @$data->jumlah_ayam_mati)"
            :disabled="@$data->jumlah_ayam_mati"
        />

        <x-adminlte-input
            name="kondisi_ayam"
            label="Kondisi Ayam"
            type="text"
            placeholder="Masukkan kondisi ayam..."
            :value="old('kondisi_ayam', @$data->kondisi_ayam)"
        />

        <x-adminlte-textarea
            name="catatan"
            label="Catatan"
            placeholder="Tuliskan catatan tambahan seperti kondisi ayam, catatan distribusi, dsb..."
            rows="4"
        >{{ old('catatan', @$data->catatan) }}</x-adminlte-textarea>
    </div>
</div>
