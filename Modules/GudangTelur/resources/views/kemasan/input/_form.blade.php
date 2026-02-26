<div
    x-data="data"
>
    <div class="card">
        <div class="card-body">
            <x-adminlte-select
                label="Supplier"
                name="supplier_id"
                x-model="supplier_id"
            >
                <x-adminlte-options
                    :options="$listSupplier"
                    empty-option="Semua Supplier"
                />
            </x-adminlte-select>

            <x-adminlte-input
                type="datetime-local"
                label="Tanggal"
                name="tanggal"
                :value="old('tanggal', @$data->tanggal?->format('Y-m-d\TH:i'))"
            />
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="card-title">List Kemasan</h2>
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
                        <th class="align-middle" style="min-width: 150px;">Kemasan</th>
                        <th class="align-middle" style="min-width: 150px;">Jumlah</th>
                        <th class="align-middle" style="min-width: 80px;">Satuan</th>
                        <th class="align-middle" style="min-width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, i) in items">
                        <tr
                            x-data="{
                                get get_kemasan() {
                                    if (!item.kemasan_id) return null;
                                    const res = Array.from(list_kemasan).find((item2) => item2.id == item.kemasan_id);
                                    return res;
                                }
                            }"
                        >
                            <td>
                                <span x-text="i+1"></span>
                                <input
                                    type="hidden"
                                    :name="`items[${i}][id]`"
                                    :value="item.id"
                                />
                            </td>
                            <td>
                                <x-adminlte-select
                                    name="kemasan_id"
                                    x-bind:name="`items[${i}][kemasan_id]`"
                                    x-model="item.kemasan_id"
                                    class="form-control-sm"
                                    fgroup-class="w-100 mb-0"
                                >
                                    <option value="">Pilih Kemasan</option>
                                    <template x-for="kemasan in list_kemasan">
                                        <option
                                            :value="kemasan.id"
                                            :selected="item.kemasan_id == kemasan.id"
                                            x-text="kemasan.nama"
                                        ></option>
                                    </template>
                                </x-adminlte-select>
                            </td>
                            <td>
                                <x-adminlte-input
                                    name="jumlah"
                                    x-bind:name="`items[${i}][jumlah]`"
                                    x-bind:value="item.jumlah"
                                    class="form-control-sm"
                                    fgroup-class="w-100 mb-0"
                                />
                            </td>
                            <td>
                                <x-adminlte-input
                                    name="satuan"
                                    x-bind:name="`items[${i}][satuan]`"
                                    x-bind:value="get_kemasan?.satuan?.nama"
                                    x-bind:disabled="get_kemasan"
                                    class="form-control-sm"
                                    fgroup-class="w-100 mb-0"
                                />
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
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('data', () => ({
            supplier_id: @js(old('supplier_id', @$data->supplier_id)),
            items: @js(old('items', @$data->kemasanInventory ?? [])),
            list_kemasan: [],
            addItem() {
                this.items.push({
                    supplier_id : this.supplier_id,
                    jumlah      : null,
                    satuan      : null,
                });
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
            init() {
                if (this.supplier_id) {
                    this.fetchListKemasan()
                }

                this.$watch('supplier_id', (value) => {
                    this.fetchListKemasan()
                })
            },
            async fetchListKemasan() {
                if (!this.supplier_id) {
                    this.list_kemasan = [];
                    return;
                }

                const url = @js(route('gudang-telur.ajax.supplier.kemasan', [':supplierId']))
                    .replace(':supplierId', this.supplier_id)

                try {
                    const res = await $.getJSON(url)          
                    this.list_kemasan = res ?? []
                } catch (e) {
                    this.list_kemasan = []
                }
            },
        }));
    })
</script>