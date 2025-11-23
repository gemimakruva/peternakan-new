<div class="card shadow-sm border-0">
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
            <i class="fas fa-file text-muted mr-2"></i> Uploud Berkas
        </h5>
    </div>
            {{-- ===========================
                Input: Nama Berkas
                Digunakan untuk input nama berkas
            ============================ --}}
    <div class="card-body pt-4">
        <div class="mb-4">
            <x-adminlte-input 
                name="nama_berkas"
                label="Tanggal Pengadaan"
                type="text"
                placeholder="input Nama berkas ..."
                :value="old('pipe_date', @$data->nama_berkas)"
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
                Input: Uploud Berkas
                Digunakan untuk uploud nama berkas
            ============================ --}}
           <div class="mb-4">
                <x-adminlte-input-file 
                    name="image_file"
                    label="Nama Berkas"
                    placeholder="Nama Berkas..."
                    :value="old('image_file', @$data->nama_berkas)"
                    igroup-size="lg"
                    fgroup-class="col-12"
                    class="form-control form-control-lg py-3">

                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-image text-muted"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>
    </div>
</div>
