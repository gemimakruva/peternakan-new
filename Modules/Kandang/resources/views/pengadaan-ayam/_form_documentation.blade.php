<div class="card shadow-sm border-0">
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title m-0 text-secondary fw-semibold">
        <i class="fas fa-camera text-muted mr-2"></i> Upload Dokumentasi
        </h5>
    </div>
    <div class="card-body">
          @if(isset($data) && $data->count() > 0)
              <div class="mb-4">
                  <h6 class="text-muted mb-3">
                      <i class="fas fa-images mr-1"></i> Dokumentasi yang Sudah Ada
                  </h6>
                  <div class="row g-2 mb-3">
                      @foreach($data as $doc)
                          <div class="col-md-3 col-4">
                              <div class="position-relative dokumentasi-item" data-doc-id="{{ $doc->id }}">
                                  <img src="{{ Storage::url($doc->file_path) }}" 
                                       class="img-thumbnail shadow-sm rounded" 
                                       style="height: 150px; width: 100%; object-fit: cover;" />
                                  <button type="button" 
                                          class="btn btn-danger btn-sm position-absolute btn-delete-existing-doc" 
                                          style="top: 5px; right: 5px;"
                                          data-doc-id="{{ $doc->id }}">
                                      <i class="fas fa-trash"></i>
                                  </button>
                                  <input type="hidden" name="delete_doc_ids[]" value="" class="delete-doc-input-{{ $doc->id }}">
                              </div>
                          </div>
                      @endforeach
                  </div>
                  <hr class="my-4">
              </div>
          @endif

          {{-- ===========================
                Input: Uploud Photo
                Digunakan untuk photo dokuemntasi 
            ============================ --}}
          <div class="mb-4">
            
            <x-adminlte-input-file 
                name="image_files_doc[]"
                label="Upload Dokumentasi"
                placeholder="Pilih gambar..."
                accept="image/*"
                multiple
                igroup-size="lg"
                fgroup-class="col-12"
                class="form-control form-control-lg py-3"
                id="multiImageInput">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-camera text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-file>
            <div id="previewContainer" class="row mt-3 g-2"></div>
         </div>
    </div>
</div>

{{-- Script Show Preview Uploud --}}
<script>
    const multiInput = document.getElementById('multiImageInput');
    const previewContainer = document.getElementById('previewContainer');

    multiInput.addEventListener('change', function(event) {
        previewContainer.innerHTML = ""; // reset preview
        const files = Array.from(event.target.files);

        files.forEach(file => {
            if (!file.type.startsWith("image/")) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement("div");
                col.classList.add("col-4");

                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-thumbnail shadow-sm 
                        rounded" style="height: 120px; width: 100%; object-fit: cover;" />
                    </div>
                `;

                previewContainer.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-existing-doc')) {
            const btn = e.target.closest('.btn-delete-existing-doc');
            const docId = btn.getAttribute('data-doc-id');
            const docItem = btn.closest('.dokumentasi-item');
            
            if (confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?')) {
                document.querySelector('.delete-doc-input-' + docId).value = docId;

                docItem.style.opacity = '0.3';
                docItem.style.pointerEvents = 'none';
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-secondary');
            }
        }
    });
</script>
