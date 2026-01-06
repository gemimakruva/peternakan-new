<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Uploud Berkas</h5>
            <button class="btn btn-primary btn-sm" type="button" id="btn-tambah-berkas-pengadaan-ayam">Tambah Berkas</button>
        </div>
    </div>
    <div class="card-body">
        
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

        <div id="container-berkas-pengadaan-ayam">
            <div class="border border-rounded p-3 w-100 mb-3">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-danger btn-sm btn-delete-container-berkas-pengadaan-ayam" type="button"><i class="fas fa-trash"></i></button>
                </div>
                
                <x-adminlte-select
                    name="nama_berkas[]"
                    label="Nama Berkas"
                    class="select-nama-berkas"
                >
                    <option selected disabled>Pilih Nama Berkas...</option>
                    @foreach ($listNamaBerkas as $namaBerkas)
                        <option value="{{ $namaBerkas->value }}">{{ $namaBerkas->title() }}</option>
                    @endforeach
                    <option value="lainnya">Lainnya</option>
                </x-adminlte-select>

                <div class="d-none input-nama-berkas-lainnya">
                    <x-adminlte-input 
                        name="nama_berkas_lainnya[]"
                        label="Nama Berkas Lainnya"
                        type="text"
                        placeholder="Input Nama berkas ..."
                    />
                </div>

                <x-adminlte-input-file 
                    name="file_path_berkas[]"
                    label="Berkas"
                    placeholder="Pilih beberapa berkas..."
                    accept="image/*"
                    multiple
                    class="input-file-berkas"
                />

                <div class="preview-berkas-container row mt-3 g-2"></div>
            </div>
        </div>
    </div>
</div>