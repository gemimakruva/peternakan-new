<div class="mb-3 px-3">

{{-- ==================== INFORMATION SUPPLIER AND PRODUCT ================ --}}
<div class="card p-3">
      <h4 class="fw-bold mb-3 text-secondary border-start border-3 ps-2" style="border-color: #0d6efd !important;">
        Informasi Ayam
    </h4>
    <div class="mb-3">
    <x-adminlte-select 
        name="jenis_pencatatan" 
        label="Jenis Pencatatan" 
        igroup-size="md"
        required>
        <option value="" readonly>-- Pilih Jenis Pencatatan --</option>
        <option value="karantina" 
            {{ old('jenis_pencatatan', @$flock->jenis_pencatatan) == 'karantina' ? 'selected' : '' }}>
            Ayam Karantina
        </option>
        <option value="masuk" 
            {{ old('jenis_pencatatan', @$flock->jenis_pencatatan) == 'masuk' ? 'selected' : '' }}>
            Ayam Masuk
        </option>
    </x-adminlte-select>
</div>


<div class="row">
    {{-- Tanggal Masuk --}}
    <div class="col-6 col-md-8 mb-3">
        <x-adminlte-input 
            name="date_in" 
            label="Tanggal Masuk" 
            type="date" 
            :value="old('date_in', @$flock->date_in)" 
            igroup-size="md">

            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-calendar-alt text-muted"></i>
                </div>
            </x-slot>

        </x-adminlte-input>
    </div>

    {{-- Umur Ayam --}}
    <div class="col-6 col-md-4 mb-3">
        <x-adminlte-input 
            name="umur" 
            label="Umur Ayam (Hari)" 
            type="number"
            min="0"
            placeholder="Masukkan umur ayam..."
            :value="old('umur', @$flock->umur)" 
            igroup-size="md">

            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-egg text-muted"></i>
                </div>
            </x-slot>

        </x-adminlte-input>
    </div> 
</div>

<div class="row">
    {{-- kondisi ayam --}}
    <div class="col-6 col-md-8 mb-3">
    <x-adminlte-select 
        name="kondisi_ayam" 
        label="Kondisi Ayam" 
        igroup-size="md">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-heartbeat text-muted"></i>
            </div>
        </x-slot>

        <option value="">-- Pilih Kondisi Ayam --</option>
        <option value="sehat" {{ old('kondisi_ayam', @$flock->kondisi_ayam) == 'sehat' ? 'selected' : '' }}>Sehat</option>
        <option value="kurang sehat" {{ old('kondisi_ayam', @$flock->kondisi_ayam) == 'kurang sehat' ? 'selected' : '' }}>Kurang Sehat</option>
        <option value="sakit" {{ old('kondisi_ayam', @$flock->kondisi_ayam) == 'sakit' ? 'selected' : '' }}>Sakit</option>
    </x-adminlte-select>

    
</div>
    <div class="col-6 col-md-4 mb-3">
    <x-adminlte-input 
        name="jumlah_ayam_datang" 
        label="Jumlah Ayam Datang" 
        type="number"
        min="0"
        placeholder="Masukkan jumlah ayam..."
        :value="old('jumlah_ayam_datang', @$flock->jumlah_ayam_datang)"
        igroup-size="md">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-drumstick-bite text-muted"></i>
            </div>
        </x-slot>

    </x-adminlte-input>
</div>
    </div>
<div class="row">
<div class="col-6 col-md-6 mb-3">
    <x-adminlte-input 
        name="jumlah_ayam_mati" 
        label="Jumlah Ayam Mati" 
        type="number"
        min="0"
        placeholder="Masukkan jumlah ayam mati..."
        :value="old('jumlah_ayam_mati', @$flock->jumlah_ayam_mati)" 
        igroup-size="md">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-skull-crossbones text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

    <div class="col-6 col-md-6 mb-3">
    {{-- Jumlah Ayam Sakit --}}
    <x-adminlte-input 
        name="jumlah_ayam_sakit" 
        label="Jumlah Ayam Sakit" 
        type="number"
        min="0"
        placeholder="Masukkan jumlah ayam sakit..."
        :value="old('jumlah_ayam_sakit', @$flock->jumlah_ayam_sakit)" 
        igroup-size="md">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-notes-medical text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>  
</div>
</div>

{{-- ==================== INPUT SUPPLIER BEDASARKAN KANDANG, PIPE, FLOCK  ================ --}}
<div class="card p-3">
    <h4 class="fw-bold mb-3 text-secondary border-start border-3 ps-2" style="border-color: #0d6efd !important;">
        Input Ayam
    </h4>
<div class="mb-3">
    <x-adminlte-select 
        name="kandang_id" 
        label="Nama Kandang" 
        igroup-size="md"
        required>

        <option value="" readonly>-- Pilih Nama Kandang --</option>

        {{-- Dummy Data Kandang --}}
        <option value="1" {{ old('kandang_id', @$flock->kandang_id) == 1 ? 'selected' : '' }}>
            Kandang A - Kapasitas 1.000 Ekor
        </option>
        <option value="2" {{ old('kandang_id', @$flock->kandang_id) == 2 ? 'selected' : '' }}>
            Kandang B - Kapasitas 1.500 Ekor
        </option>
        <option value="3" {{ old('kandang_id', @$flock->kandang_id) == 3 ? 'selected' : '' }}>
            Kandang C - Kapasitas 800 Ekor
        </option>
        <option value="4" {{ old('kandang_id', @$flock->kandang_id) == 4 ? 'selected' : '' }}>
            Kandang D - Kapasitas 2.000 Ekor
        </option>
        <option value="5" {{ old('kandang_id', @$flock->kandang_id) == 5 ? 'selected' : '' }}>
            Kandang E - Kapasitas 1.200 Ekor
        </option>
    </x-adminlte-select>
</div>

<div class="mb-3">
  <div id="pipe-wrapper">
   <div class="pipe-row row g-2 mb-2 align-items-center">

    {{-- Nama Flock --}}
    <div class="col-12 col-md-4">
        <x-adminlte-input 
            name="pipe_flock[]" 
            label="Nama Flock" 
            placeholder="Masukkan nama flock..."
        />
    </div>

    {{-- Nama Pipe --}}
    <div class="col-12 col-md-4">
        <x-adminlte-input 
            name="pipe_name[]" 
            label="Nama Pipe" 
            placeholder="Masukkan nama pipe..."
        />
    </div>

   {{-- Jumlah Ekor --}}
<div class="col-12 col-md-3">
    <x-adminlte-input 
        name="jumlah_ekor[]" 
        type="number"
        min="0"
        label="Jumlah Ekor"
        placeholder="Masukkan jumlah ekor..."
        required
    />
</div>


    {{-- Tombol Hapus --}}
    <div class="col-12 col-md-1 d-flex align-items-end">
        <button type="button" class="btn btn-danger remove-pipe w-100 d-flex align-items-center justify-content-center">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</div>
</div>
    <button type="button" id="add-pipe" class="btn btn-primary mt-2">
        + Tambah Pipe
    </button>
</div>

</div>

{{-- ==================== Supplier Registration  ================ --}}
<div class="card p-3">
    <h4 class="fw-bold mb-3 text-secondary border-start border-3 ps-2" style="border-color: #0d6efd !important;">
        Administrasi Supplier 
    </h4>
<div class="row mb-3">
    {{-- Nama Berkas --}}
    <div class="col-12 col-md-6">
        <label class="form-label fw-semibold">Nama Berkas</label>
        <input 
            type="text" 
            name="nama_berkas" 
            class="form-control" 
            placeholder="Masukkan nama berkas..."
        >
    </div>

    {{-- Upload Berkas --}}
    <div class="col-12 col-md-6">
        <label class="form-label fw-semibold">Upload Berkas</label>
        <input 
            type="file" 
            name="berkas" 
            class="form-control"
        >
    </div>
</div>
{{-- uploud Dokumentasi--}}
<div class="mb-3">
    <label class="form-label fw-semibold">Upload Dokumentasi</label>

    <div class="border border-dashed rounded p-4 text-center bg-light position-relative"
         style="cursor: pointer;" 
         onclick="document.getElementById('dropzoneFile').click();">

        <div class="text-muted">
            <i class="bi bi-cloud-arrow-up fs-1 mb-2"></i>
            <p class="mb-1 fw-semibold">Klik untuk upload</p>
            <p class="small">atau seret file ke sini</p>
            <p class="small text-secondary">PNG, JPG, JPEG, GIF (Max 800x400)</p>
        </div>

        <input 
            id="dropzoneFile" 
            type="file" 
            name="dokumentasi" 
            class="d-none" 
            accept="image/*"
        >
    </div>
</div>

{{-- catatan --}}
<div class="mb-3">
    <label for="catatan" class="form-label fw-semibold">Catatan</label>
    <textarea 
        name="catatan" 
        id="catatan" 
        class="form-control" 
        rows="4" 
        placeholder="Tuliskan catatan tambahan di sini..."></textarea>
</div>
</div>




@push('js')
<script>
$(document).ready(function () {

    // Tambah Pipe
    $('#add-pipe').on('click', function () {
        let clone = $('.pipe-row').first().clone();

        // Reset value input
        clone.find('input').val('');

        // Tambahkan baris baru
        $('#pipe-wrapper').append(clone);
    });

    // Hapus Pipe
    $(document).on('click', '.remove-pipe', function () {
        let rows = $('.pipe-row');
        
        if (rows.length > 1) {
            $(this).closest('.pipe-row').remove();
        }
    });

});
</script>
@endpush
