<div class="card">
    <div class="card-header">
        <h5 class="card-title">Upload Dokumentasi</h5>
    </div>
    <div class="card-body">
        <x-adminlte-input-file 
            name="dokumentasi_new[][file]"
            label="Upload Dokumentasi"
            placeholder="Pilih gambar..."
            accept="image/*"
            multiple
            id="multiImageInput"
        />
        <div id="previewContainer" class="row mt-3 g-2">
            @foreach ($pengadaanAyam->dokumentasi as $dokumentasi)
                <div class="col-3">
                    <input type="hidden" name="dokumentasi_persisted[][id]" value="{{ $dokumentasi->id }}">
                    <button class="btn btn-danger btn-sm btn-delete" type="button">
                        <i class="fas fa-trash"></i>
                    </button>
                    <img src="{{ $dokumentasi->file_url }}" alt="" class="preview-image">
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#multiImageInput').on('change', function() {
            const files = Array.from(this.files);
            const previewContainer = $('#previewContainer');

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    const img = $('<img>').addClass('preview-image').attr('src', ev.target.result);
                    const col = $('<div>').addClass('col-3').append(img);
                    previewContainer.append(col);
                };
                reader.readAsDataURL(file);
            });
        });

        $('#previewContainer .col-3 .btn-delete').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.col-3').remove();
        })
    </script>
@endpush

@push('css')
    <style>
        #previewContainer .col-3 {
            position: relative;
        }
        #previewContainer .col-3 .btn-delete {
            position: absolute;
            top: 8px;
            right: 16px;
        }
        #previewContainer .preview-image {
            height: 150px;
            width: 100%;
            object-fit: cover;
            margin-bottom: 16px;
            border: 1px solid #dddd;
        }
    </style>
@endpush