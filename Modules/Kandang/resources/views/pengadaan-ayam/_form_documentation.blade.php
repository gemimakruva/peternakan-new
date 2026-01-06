<div class="card">
    <div class="card-header">
        <h5 class="card-title">Upload Dokumentasi</h5>
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
