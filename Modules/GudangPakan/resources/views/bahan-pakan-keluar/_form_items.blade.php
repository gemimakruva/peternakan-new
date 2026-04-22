<div
    class="card"
    x-data="data"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">Form Bahan Baku Keluar</h2>
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
                    <th class="align-middle" style="min-width: 150px;">Bahan Baku</th>
                    <th class="align-middle" style="min-width: 40px;">Satuan</th>
                    <th class="align-middle" style="min-width: 150px;">Saldo</th>
                    <th class="align-middle" style="min-width: 150px;">Jumlah</th>
                    <th class="align-middle" style="min-width: 40px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, i) in items">
                    <tr
                        x-data="{
                            get bahanPakan() {
                                return listBahanPakan?.find((_item) => _item.id == item.bahan_pakan_id);
                            },
                            get satuan() {
                                return this.bahanPakan?.satuan;
                            },
                            get saldo() {
                                return this.bahanPakan?.saldo?.toLocaleString('id-ID');
                            }
                        }"
                    >
                        <td>
                            <span x-text="i+1"></span>
                        </td>
                        <td>
                            <input
                                type="hidden"
                                :name="`items[${i}][id]`"
                                :value="item?.id"
                            />

                            <input
                                type="hidden"
                                :name="`items[${i}][saldo]`"
                                :value="bahanPakan.saldo"
                            />
                            
                            <x-adminlte-select
                                name="bahan_pakan_id"
                                x-bind:name="`items[${i}][bahan_pakan_id]`"
                                x-model="item.bahan_pakan_id"
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
                        <td x-text="satuan" class="text-left"></td>
                        <td x-text="saldo" class="text-right"></td>
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
            items: @js(old('items', $data->bahanPakanInventory)),
            listBahanPakan: @js($listBahanPakan),
            addItem() {
                this.items.push({
                    id              : null,
                    bahan_pakan_id  : null,
                    jumlah          : null,
                });
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>