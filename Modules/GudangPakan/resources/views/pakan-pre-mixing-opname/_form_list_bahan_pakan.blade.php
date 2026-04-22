<div
    class="card"
    x-data="data"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">List Pre-Mixing</h2>
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
                    <th class="align-middle" style="min-width: 150px;">Pre-Mixing</th>
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
                            get preMixing() {
                                return listPreMixing.find((_item) => _item.id == item.formulasi_premix_id)
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
                                name="formulasi_premix_id"
                                x-bind:name="`items[${i}][formulasi_premix_id]`"
                                x-model="item.formulasi_premix_id"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                            >
                                <option value="">Pilih Pre-Mixing</option>
                                <template x-for="_preMixing in listPreMixing">
                                    <option
                                        :selected="_preMixing.id == item.formulasi_premix_id"
                                        :value="_preMixing.id"
                                        x-text="_preMixing.nama_formulasi"
                                    ></option>
                                </template>
                            </x-adminlte-select>
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="stok"
                                x-bind:name="`items[${i}][stok]`"
                                x-bind:value="preMixing?.jumlah || 0"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                                :readonly="true"
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-secondary">Kg</div>
                                </x-slot>
                            </x-adminlte-input>
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="jumlah"
                                x-bind:name="`items[${i}][jumlah]`"
                                x-bind:value="item.real-Number(preMixing?.jumlah || 0)"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                                :readonly="true"
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-secondary">Kg</div>
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
            items: @js(old('items', @$data->pakanPreMixingInventory ?? [])),
            listPreMixing: @js($listPreMixing),
            addItem() {
                this.items.push({
                    id: null,
                    formulasi_premix_id: null,
                    jumlah: null,
                    real: 0,
                })
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>