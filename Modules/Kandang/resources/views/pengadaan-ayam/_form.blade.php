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
                :value="old('pipe_date', @$data->tanggal)"
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
            Input: Umur Ayam
            Umur ayam saat datang
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name=""
                label="Umur Ayam Datang"
                type="number"
                min="0"
                placeholder="Masukkan jumlah pipa untuk flock ini..."
                :value="old('pipe_count', @$data->pipe_count)"
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
            Input: Jumlah Ayam Datang
            Jumlah Ayam Datang dari supplier
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-input 
                name=""
                label="Jumlah Ayam Datang"
                type="number"
                min="0"
                placeholder="Jumlah Ayam Datang dari Supplier..."
                :value="old('pipe_count', @$data->pipe_count)"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

               <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-database text-muted"></i>
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
                name="chicken_condition"
                label="Kondisi Ayam"
                type="text"
                placeholder="Masukkan kondisi ayam..."
                :value="old('kondisi', @$data->chicken_condition)"
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
            Input: Staus Pengadaan
            Status Pengadan ayam (Done atau Archivea)
        ============================ --}}
        <div class="mb-4">
            <x-adminlte-select
                name="procurement_status"
                label="Status Pengadaan"
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-tasks text-muted"></i>
                    </div>
                </x-slot>

                <option value="" disabled selected>Pilih status pengadaan...</option>
                <option value="archive" {{ old('procurement_status', @$data->procurement_status)
                 == 'archive' ? 'selected' : '' }}>Archive</option>
                <option value="complete" {{ old('procurement_status', @$data->procurement_status) 
                == 'complete' ? 'selected' : '' }}>Complete</option>
            </x-adminlte-select>
        </div>
    </div>
</div>
<div>
</div>