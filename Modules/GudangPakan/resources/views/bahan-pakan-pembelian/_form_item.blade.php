<div
    class="card"
    x-data="data"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">Form Bahan Baku</h2>
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
                    <th class="align-middle" style="min-width: 200px;">Bahan Baku</th>
                    <th class="align-middle" style="min-width: 40px;">Satuan</th>
                    <th class="align-middle" style="min-width: 150px;">Harga Satuan</th>
                    <th class="align-middle" style="min-width: 150px;">Jumlah</th>
                    <th class="align-middle" style="min-width: 150px;">Sub Total</th>
                    <th class="align-middle" style="min-width: 40px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, i) in items">
                    <tr
                        x-data="{
                            get bahanPakan() {
                                return listBahanPakan?.find((_item) => _item.id == item.bahan_pakan_id);
                            }
                        }"
                    >
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
                                name="bahan_pakan_id"
                                x-bind:name="`items[${i}][bahan_pakan_id]`"
                                x-model="item.bahan_pakan_id"
                                x-on:change="item.harga_satuan = bahanPakan.harga_satuan"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                            >
                                <option value="">Pilih Bahan Pakan</option>
                                <template x-for="bahanPakan in listBahanPakan">
                                    <option
                                        :selected="bahanPakan.id == item.bahan_pakan_id"
                                        :value="bahanPakan.id"
                                        x-text="bahanPakan.nama"
                                    ></option>
                                </template>
                            </x-adminlte-select>
                        </td>
                        <td>
                            <x-adminlte-input
                                name="satuan"
                                x-bind:name="`items[${i}][satuan]`"
                                x-bind:value="bahanPakan?.satuan"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                                disabled
                                readonly
                            />
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="harga_satuan"
                                x-bind:name="`items[${i}][harga_satuan]`"
                                x-model="item.harga_satuan"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                            />
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="jumlah"
                                x-bind:name="`items[${i}][jumlah]`"
                                x-model="item.jumlah"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                            />
                        </td>
                        <td>
                            <x-adminlte-input
                                name="sub_total"
                                x-bind:name="`items[${i}][sub_total]`"
                                x-bind:value="(Number(item.harga_satuan)*Number(item.jumlah)).toLocaleString('id-ID')"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                                disabled
                                readonly
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

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('data', () => ({
            supplier_id: @js($data->id),
            items: @js(old('items', $data->bahanPakanPembelianItem)),
            listBahanPakan: @js($listBahanPakan),
            addItem() {
                this.items.push({
                    supplier_id     : this.supplier_id,
                    bahan_pakan_id  : null,
                    harga_satuan    : null,
                    jumlah          : null,
                })
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>