<div
    class="card"
    x-data="data"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">Form Kemasan</h2>
            <button type="button" class="btn btn-primary btn-sm" x-on:click="addItem">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
        
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered text-center mb-0">
            <thead>
                <tr>
                    <th class="align-middle" style="min-width: 40px;">#</th>
                    <th class="align-middle" style="min-width: 150px;">Supplier</th>
                    <th class="align-middle" style="min-width: 150px;">Kode Barang</th>
                    <th class="align-middle" style="min-width: 150px;">Harga</th>
                    <th class="align-middle" style="min-width: 150px;">Jenis Pengiriman</th>
                    <th class="align-middle" style="min-width: 40px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, i) in items">
                    <tr>
                        <td>
                            <span x-text="i+1"></span>
                        </td>
                        <td>
                            <template x-if="item?.id">
                                <input
                                    type="hidden"
                                    :name="`items[${i}][id]`"
                                    :value="item.id"
                                />
                            </template>
                            
                            <x-adminlte-select
                                name="kemasan_id"
                                x-bind:name="`items[${i}][kemasan_id]`"
                                x-model="item.kemasan_id"
                                class="form-control-sm"
                                fgroup-class="w-100 mb-0"
                            >
                                <x-adminlte-options
                                    :options="$listKemasan"
                                    empty-option="Pilih Kemasan"
                                />
                            </x-adminlte-select>
                        </td>
            
                        <td>
                            <x-adminlte-input
                                name="kode_barang"
                                x-bind:name="`items[${i}][kode_barang]`"
                                x-bind:value="item.kode_barang"
                                placeholder="Kode Barang"
                                class="form-control-sm"
                                fgroup-class="w-100 mb-0"
                            />
                        </td>
            
                        <td>
                            <x-adminlte-input
                                name="harga"
                                x-bind:name="`items[${i}][harga]`"
                                x-bind:value="item.harga"
                                placeholder="Harga"
                                class="form-control-sm"
                                fgroup-class="w-100 mb-0"
                            />
                        </td>

                        <td>
                            <x-adminlte-select
                                name="jenis_pengiriman"
                                x-bind:name="`items[${i}][jenis_pengiriman]`"
                                x-model="item.jenis_pengiriman"
                                class="form-control-sm"
                                fgroup-class="w-100 mb-0"
                            >
                                <x-adminlte-options
                                    :options="$listJenisPengiriman"
                                    empty-option="Pilih Jenis Pengiriman"
                                />
                            </x-adminlte-select>
                        </td>
            
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" x-on:click="deleteItem(i)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('data', () => ({
            supplier_id: @js($data->id),
            items: @js(old('items', $data->supplierKemasan)),
            addItem() {
                this.items.push({
                    supplier_id         : this.supplier_id,
                    kemasan_id          : null,
                    kode_barang         : null,
                    harga               : 0,
                    jenis_pengiriman    : null,
                })
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>