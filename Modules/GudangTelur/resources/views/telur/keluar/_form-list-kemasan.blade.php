<div
    class="card"
    x-data="kemasan"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">List Kemasan</h2>
            <button type="button" class="btn btn-primary btn-sm" x-on:click="addItem">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
        
    <div class="card-body table-responsive p-0">
        <input type="hidden" name="kemasan_output_id" value="{{ @$data->kemasan_output_id }}">
        <table class="table table-hover table-striped table-bordered text-center mb-0">
            <thead>
                <tr>
                    <th class="align-middle" style="min-width: 40px;">#</th>
                    <th class="align-middle" style="min-width: 150px;">Kemasan</th>
                    <th class="align-middle" style="min-width: 150px;">Stok</th>
                    <th class="align-middle" style="min-width: 150px;">Sisa</th>
                    <th class="align-middle" style="min-width: 150px;">Keluar</th>
                    <th class="align-middle" style="min-width: 40px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, i) in items">
                    <tr
                        x-data="{
                            get get_kemasan() {
                                if (!item.kemasan_id) return null;
                                const res = Array.from(list_kemasan).find((item2) => item2.kemasan_id == item.kemasan_id);
                                return res;
                            }
                        }"
                    >
                        <td>
                            <span x-text="i+1"></span>
                            <input
                                type="hidden"
                                :name="`kemasan_items[${i}][id]`"
                                :value="item.id"
                            />
                        </td>
                        <td>
                            <x-adminlte-select
                                name="kemasan_id"
                                x-bind:name="`kemasan_items[${i}][kemasan_id]`"
                                x-model="item.kemasan_id"
                                class="form-control-sm"
                                fgroup-class="w-100 mb-0"
                            >
                                <option value="">Pilih Kemasan</option>
                                <template x-for="kemasan in list_kemasan">
                                    <option
                                        :value="kemasan.kemasan_id"
                                        :selected="item.kemasan_id == kemasan.kemasan_id"
                                        x-text="kemasan.nama_kemasan"
                                    ></option>
                                </template>
                            </x-adminlte-select>
                        </td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="stok"
                                    x-bind:name="`kemasan_items[${i}][stok]`"
                                    x-bind:value="get_kemasan?.stok || 0"
                                    :disabled="true"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text" x-text="get_kemasan?.nama_satuan || '-'"></span>
                                </div>
                            </div>
                        </td>
                        <td
                            x-data="{
                                get get_sisa() {
                                    return Number(get_kemasan?.stok || 0)-Number(item.jumlah || 0);
                                }
                            }"
                        >
                            <div class="input-group input-group-sm">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="stok"
                                    x-bind:name="`kemasan_items[${i}][stok]`"
                                    x-bind:value="get_sisa"
                                    :disabled="true"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text" x-text="get_kemasan?.nama_satuan || '-'"></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="jumlah"
                                    x-bind:name="`kemasan_items[${i}][jumlah]`"
                                    x-model="item.jumlah"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text" x-text="get_kemasan?.nama_satuan || '-'"></span>
                                </div>
                            </div>
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
        Alpine.data('kemasan', () => ({
            items: @js(old('items', default: @$data->kemasanOutput->kemasanInventory ?? [])),
            list_kemasan: @js($listKemasanInventory),
            addItem() {
                this.items.push({
                    kemasan_id  : null,
                    kemasan     : null,
                    jumlah      : null,
                    satuan      : null,
                });
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>