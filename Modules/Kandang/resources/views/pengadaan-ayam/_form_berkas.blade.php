<div class="card shadow-sm border-0 mt-5">
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
            <i class="fas fa-file text-muted mr-2"></i> Uploud Berkas
        </h5>
    </div>
    <div class="card-body pt-4">
         {{-- ===========================
                Existing Berkas
                Menampilkan berkas yang sudah diupload sebelumnya
            ============================ --}}
        @if(isset($data) && $data->count() > 0)
            <div class="mb-4">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-folder-open mr-1"></i> Berkas yang Sudah Ada
                </h6>
                @foreach($data as $berkas)
                    <div class="card mb-2 border">
                        <div class="card-body d-flex justify-content-between align-items-center py-2">
                            <div class="d-flex align-items-center w-100">
                                <i class="fas fa-file-alt text-secondary mr-2" style="font-size: 20px;"></i>
                                <div>
                                    <strong>{{ $berkas->nama_berkas_display }}</strong>
                                    <br>
                                    <small class="text-muted">{{ basename($berkas->file_path) }}</small>
                                </div>
                            </div>
                            <div style="width:100px">
                                <a href="{{ Storage::url($berkas->file_path) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-danger btn-delete-existing-berkas" 
                                        data-berkas-id="{{ $berkas->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <input type="hidden" name="delete_berkas_ids[]" value="" class="delete-berkas-input-{{ $berkas->id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
                <hr class="my-4">
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-muted mb-0">
                <i class="fas fa-plus-circle mr-1"></i> Tambah Berkas Baru
            </h6>
            <button class="btn btn-primary btn-sm" type="button" id="btn-tambah-berkas-pengadaan-ayam">Tambah Berkas</button>
        </div>
        <div id="container-berkas-pengadaan-ayam">
            <div class="berkas-item bg-light border border-rounded p-2 w-100 mb-3">
                <div class="bg-light border border-rounded p-2 w-100 mb-3">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger btn-sm btn-delete-container-berkas-pengadaan-ayam" type="button"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="mb-4">
                        <x-adminlte-select name="nama_berkas[]" label="Nama Berkas" class="select-nama-berkas"
                        igroup-size="lg">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-feather-alt text-muted"></i>
                                </div>
                            </x-slot>
                            <option selected disabled>Pilih Nama Berkas...</option>
                            @foreach ($listNamaBerkas as $namaBerkas)
                                <option value="{{ $namaBerkas->value }}">{{ $namaBerkas->title() }}</option>
                            @endforeach
                            <option value="lainnya">Lainnya</option>
                        </x-adminlte-select>
                    </div>

                    <div class="mb-4 d-none input-nama-berkas-lainnya">
                        <x-adminlte-input 
                            name="nama_berkas_lainnya[]"
                            label="Nama Berkas Lainnya"
                            type="text"
                            placeholder="Input Nama berkas ..."
                            igroup-size="lg"
                            fgroup-class="col-12"
                            class="form-control form-control-lg py-3">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-feather-alt text-muted"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>

                    <div class="mb-4">
                        <x-adminlte-input-file 
                        name="file_path_berkas[]"
                        label="Berkas"
                        placeholder="Pilih beberapa berkas..."
                        accept="image/*"
                        multiple
                        igroup-size="lg"
                        fgroup-class="col-12"
                        class="form-control form-control-lg py-3 input-file-berkas">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                        <div class="preview-berkas-container row mt-3 g-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnTambahBerkas = document.getElementById("btn-tambah-berkas-pengadaan-ayam");
        const containerBerkas = document.getElementById("container-berkas-pengadaan-ayam");

        function getBerkasItemTemplate() {
            return `
            <div class="berkas-item bg-light border border-rounded p-2 w-100 mb-3">
                <div class="bg-light border border-rounded p-2 w-100 mb-3">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger btn-sm btn-delete-container-berkas-pengadaan-ayam" type="button"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Nama Berkas</label>
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-feather-alt text-muted"></i>
                                </div>
                            </div>
                            <select name="nama_berkas[]" class="form-control select-nama-berkas">
                                <option selected disabled>Pilih Nama Berkas...</option>
                                @foreach ($listNamaBerkas as $namaBerkas)
                                    <option value="{{ $namaBerkas->value }}">{{ $namaBerkas->title() }}</option>
                                @endforeach
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4 d-none input-nama-berkas-lainnya">
                        <label class="form-label">Nama Berkas Lainnya</label>
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-feather-alt text-muted"></i>
                                </div>
                            </div>
                            <input type="text" name="nama_berkas_lainnya[]" class="form-control form-control-lg py-3" placeholder="Input Nama berkas ...">
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-adminlte-input-file 
                        name="file_path_berkas[]"
                        label="Berkas"
                        placeholder="Pilih beberapa berkas..."
                        accept="image/*"
                        multiple
                        igroup-size="lg"
                        fgroup-class="col-12"
                        class="form-control form-control-lg py-3 input-file-berkas">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                        <div class="preview-berkas-container row mt-3 g-2"></div>
                    </div>
                </div>
            </div>`;
        }

        function handleSelectChange(selectElement) {
            const berkasItem = selectElement.closest('.berkas-item');
            const inputLainnya = berkasItem.querySelector('.input-nama-berkas-lainnya');
            
            if (selectElement.value === 'lainnya') {
                inputLainnya.classList.remove('d-none');
            } else {
                inputLainnya.classList.add('d-none');
            }
        }

        function handleFilePreview(inputFile) {
            const berkasItem = inputFile.closest('.berkas-item');
            const previewContainer = berkasItem.querySelector('.preview-berkas-container');
            previewContainer.innerHTML = "";
            
            const files = Array.from(inputFile.files);

            files.forEach((file) => {
                if (!file.type.startsWith("image/")) return;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const col = document.createElement("div");
                    col.classList.add("col-4");
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" 
                                class="img-thumbnail shadow-sm rounded" 
                                style="height: 120px; width: 100%; object-fit: cover;" />
                        </div>
                    `;
                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        }

        containerBerkas.addEventListener('change', function(e) {
            if (e.target.classList.contains('select-nama-berkas')) {
                handleSelectChange(e.target);
            }
            if (e.target.classList.contains('input-file-berkas')) {
                handleFilePreview(e.target);
            }
        });

        btnTambahBerkas.addEventListener("click", function () {
            containerBerkas.insertAdjacentHTML('beforeend', getBerkasItemTemplate());
        });

        containerBerkas.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete-container-berkas-pengadaan-ayam')) {
                e.target.closest('.berkas-item').remove();
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete-existing-berkas')) {
                const btn = e.target.closest('.btn-delete-existing-berkas');
                const berkasId = btn.getAttribute('data-berkas-id');
                const card = btn.closest('.card');
                
                if (confirm('Apakah Anda yakin ingin menghapus berkas ini?')) {
                    // Tandai untuk dihapus
                    document.querySelector('.delete-berkas-input-' + berkasId).value = berkasId;
                    // sembunyikan card
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                    btn.innerHTML = '<i class="fas fa-check"></i>';
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-secondary');
                }
            }
        });
    });
</script>