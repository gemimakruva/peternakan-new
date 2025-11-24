<div class="card shadow-sm border-0 mt-5">
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
                label="Nama Berkas"
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
                name="file_path_berkas[]"
                label="Nama Berkas"
                placeholder="Pilih beberapa berkas..."
                accept="image/*"
                multiple
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-image text-muted"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
                <div id="previewBerkasContainer" class="row mt-3 g-2"></div>
            </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputFile = document.querySelector('input[name="file_path_berkas[]"]');
        const previewContainer = document.getElementById("previewBerkasContainer");

        inputFile.addEventListener("change", function (event) {
            previewContainer.innerHTML = ""; 
            const files = Array.from(event.target.files);

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
        });
    });
</script>
