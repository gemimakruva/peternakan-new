<div
    class="card"
    x-data="data"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">List Bahan Pakan</h2>
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
                    <th class="align-middle" style="min-width: 150px;">Bahan Pakan</th>
                    <th class="align-middle" style="min-width: 150px;">Sistem</th>
                    <th class="align-middle" style="min-width: 150px;">Selisih</th>
                    <th class="align-middle" style="min-width: 150px;">Real</th>
                    <th class="align-middle" style="min-width: 40px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, i) in items">
                    <tr
                        x-data="{
                            get bahanPakan() {
                                return listBahanPakan.find((_item) => _item.id == item.bahan_pakan_id)
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
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                            >
                                <option value="">Pilih Bahan Pakan</option>
                                <template x-for="bahanPakan in listBahanPakan">
                                    <option
                                        :selected="bahanPakan.id == item.bahan_pakan_id"
                                        :value="bahanPakan.id"
                                        x-text="bahanPakan.nama_bahan_pakan"
                                    ></option>
                                </template>
                            </x-adminlte-select>
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="stok"
                                x-bind:name="`items[${i}][stok]`"
                                x-bind:value="bahanPakan?.jumlah || 0"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                                :readonly="true"
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-secondary" x-text="bahanPakan?.nama_satuan"></div>
                                </x-slot>
                            </x-adminlte-input>
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="jumlah"
                                x-bind:name="`items[${i}][jumlah]`"
                                x-bind:value="item.real-Number(bahanPakan?.jumlah || 0)"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                                :readonly="true"
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-secondary" x-text="bahanPakan?.nama_satuan"></div>
                                </x-slot>
                            </x-adminlte-input>
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="real"
                                x-bind:name="`items[${i}][real]`"
                                x-model="item.real"
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
            items: @js(old('items', @$data->bahanPakanInventory ?? [])),
            listBahanPakan: @js($listBahanPakan),
            addItem() {
                this.items.push({
                    id: null,
                    bahan_pakan_id: null,
                    jumlah: null,
                    real: 0,
                    satuan: null,
                })
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>