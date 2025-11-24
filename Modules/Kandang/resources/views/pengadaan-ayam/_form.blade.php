<div class="card shadow-sm border-0">
    {{-- ===========================
        Header Card
        Menampilkan judul Form Pengadaan Ayam
    ============================ --}}
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
            <i class="fas fa-dove me-2 text-muted"></i> Form Pengadaan Ayam
        </h5>
    </div>

    <div class="card-body pt-4">
        {{-- ===========================
            Input: Tanggal Pengadaan
            Digunakan untuk input tanggal Pengadaan 
            Dilaksanakan
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="pipe_date"
                label="Tanggal Pengadaan"
                type="date"
                placeholder="Pilih tanggal pengadaan..."
                :value="old('tanggal', @$data->tanggal)"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-calendar-alt text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- ===========================
            Input: Jumlah Ayam
            Jumlah ayam saat datang
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name=""
                label="Jumlah Ayam Datang"
                type="number"
                id="inputAyamDatang"
                min="0"
                placeholder="Masukkan jumlah ayam.."
                :value="old('jumlah_ayam', @$data->jumlah_ayam)"
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

         {{-- ===========================
            Input: Umur Ayam
            Umur ayam saat datang
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="umur_ayam"
                label="Umur Ayam Datang"
                type="number"
                min="0"
                placeholder="Masukkan umur ayam.."
                :value="old('jumlah_ayam', @$data->umur_ayam)"
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

        {{-- ===========================
            Input: Jumlah Ayam Sakit
            Jumlah Ayam sakit dari supplier
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="jumlah_ayam_sakit"
                label="Jumlah Ayam Sakit"
                type="number"
                min="0"
                placeholder="Masukkan jumlah ayam sakit..."
                :value="old('jumlah_ayam_sakit', @$data->jumlah_ayam_sakit)"
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

        {{-- ===========================
            Input: Jumlah Ayam Mati
            Jumlah Ayam mati dari supplier
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="jumlah_ayam_mati"
                label="Jumlah Ayam Mati"
                type="number"
                min="0"
                placeholder="Masukkan jumlah ayam mati..."
                :value="old('jumlah_ayam_mati', @$data->jumlah_ayam_mati)"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-skull text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

          {{-- ===========================
            Input: Kondisi Ayam
            Kondisi Ayam datang dari supplier
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name="kondisi"
                label="Kondisi Ayam"
                type="text"
                placeholder="Masukkan kondisi ayam..."
                :value="old('kondisi_ayam', @$data->jumlah_ayam)"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-notes-medical text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>
        {{-- ===========================
        Input: Keterangan Tambahan
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-textarea
                name="catatan"
                label="catatan"
                placeholder="Tuliskan catatan tambahan seperti kondisi ayam, catatan distribusi, dsb..."
                rows="4"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-sticky-note text-muted"></i>
                    </div>
                </x-slot>

                {{ old('catatan', @$data->catatan) }}

            </x-adminlte-textarea>
        </div>

    </div>
</div>
<div>
</div>