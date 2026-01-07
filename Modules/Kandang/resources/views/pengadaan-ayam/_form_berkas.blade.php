<div 
    class="card"
    x-data="upload_berkas"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Uploud Berkas</h5>
            <button class="btn btn-primary btn-sm" type="button" x-on:click="onTambahBerkasClick">Tambah Berkas</button>
        </div>
    </div>
    <div class="card-body">

        <template x-for="(berkas, i) in list_berkas_supplier" :key="i">
            <div class="border border-rounded p-3 w-100 mb-3">
                <div class="d-flex justify-content-end">
                    <button
                        class="btn btn-danger btn-sm"
                        type="button"
                        x-on:click="onDeleteClick(i)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

                <input type="hidden" :name="`berkas_supplier[${i}][id]`" :value="berkas.id">
                
                <x-adminlte-select
                    name="berkas_supplier[][nama_berkas]"
                    x-bind:name="`berkas_supplier[${i}][nama_berkas]`"
                    label="Nama Berkas"
                    class="select-nama-berkas"
                    x-model="berkas.nama_berkas"
                >
                    <option selected value="">Pilih Nama Berkas...</option>
                    @foreach ($listNamaBerkas as $namaBerkas)
                        <option value="{{ $namaBerkas->value }}">{{ $namaBerkas->title() }}</option>
                    @endforeach
                    <option value="lainnya">Lainnya</option>
                </x-adminlte-select>
    
                <template x-if="berkas.nama_berkas == 'lainnya'">
                    <x-adminlte-input 
                        name="berkas_supplier[][nama_berkas_lainnya]"
                        x-bind:name="`berkas_supplier[${i}][nama_berkas_lainnya]`"
                        label="Nama Berkas Lainnya"
                        type="text"
                        placeholder="Input Nama berkas ..."
                        x-model="berkas.nama_berkas_lainnya"
                    />
                </template>
    
                <x-adminlte-input-file 
                    name="berkas_supplier[][file]"
                    x-bind:name="`berkas_supplier[${i}][file]`"
                    label="Berkas"
                    placeholder="Pilih berkas..."
                    x-on:change="onFileChange($event)"
                />

                <template x-if="berkas.file_url">
                    <div class="form-group">
                        <p class="mb-0"><strong>Berkas terupload: </strong><a 
                            :href="berkas.file_url"
                            x-text="berkas.file_name"
                            target="_blank"
                            rel="noopener noreferrer"
                        ></a></p>
                        
                    </div>
                </template>
            </div>
        </template>

    </div>
</div>

@push('js')
    <script>
        const mappedBerkasSupplier = @json([
            'list_berkas_supplier' => 
                old('berkas_supplier') 
                ?? $pengadaanAyam->berkasSupplier->map(function($item) use($listNamaBerkas) {
                    if (!collect($listNamaBerkas)->map(fn($item) => $item->value)->contains($item->nama_berkas)) {
                        $item->nama_berkas_lainnya = $item->nama_berkas;
                        $item->nama_berkas = 'lainnya';
                    }
                    return $item;
                })
                ?? [],
        ]);

        var upload_berkas = {
            ...mappedBerkasSupplier,
            onTambahBerkasClick() {
                this.list_berkas_supplier.push({
                    id: null,
                    nama_berkas: null,
                    nama_berkas_lainnya: null,
                    file: null,
                    file_url: null,
                });
            },
            onDeleteClick(index) {
                this.list_berkas_supplier = this.list_berkas_supplier.filter((_, idx) => idx != index);
            },
            onFileChange(e) {
                let filename = e.target?.files[0]?.name;
                $(e.target).next().text(filename);
            },
        };
    </script>
@endpush