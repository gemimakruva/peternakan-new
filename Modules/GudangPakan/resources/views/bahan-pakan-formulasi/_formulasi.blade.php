<div
    class="card"
    x-data="data"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">Form Formulasi</h2>
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
                    <th class="align-middle" style="min-width: 50px;">Persentase (<span x-text="items.reduce((total, item) => total+Number(item.persentase), 0)"></span>%) </th>
                    <template x-for="item in list_berat_pakan">
                        <th class="align-middle" style="min-width: 40px;" x-text="item.berat"></th>
                    </template>
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
                        }"
                    >
                        <td>
                            <span x-text="i+1"></span>
                        </td>
                        <td>
                            
                            <input
                                type="hidden"
                                :name="`items[${i}][id]`"
                                :value="item.id"
                            />
                            
                            <x-adminlte-select
                                name="bahan_pakan_id"
                                x-bind:name="`items[${i}][bahan_pakan_id]`"
                                x-model="item.bahan_pakan_id"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                            >
                                <x-adminlte-options
                                    :options="$listBahanPakan"
                                    empty-option="Pilih Bahan Pakan"
                                />
                            </x-adminlte-select>
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                name="persentase"
                                x-bind:name="`items[${i}][persentase]`"
                                x-model="item.persentase"
                                fgroup-class="w-100 mb-0"
                                igroup-size="sm"
                                min="0"
                                max="100"
                                step="0.01"
                            />
                        </td>
                        <template x-for="item2 in list_berat_pakan">
                            <td class="align-middle" style="min-width: 40px;">
                                <x-adminlte-input
                                    type="number"
                                    name="berat"
                                    x-bind:name="`items[${i}][${item2.berat}][berat]`"
                                    x-bind:value="(Number(item2.berat) * Number(item.persentase))/100"
                                    class="text-right"
                                    fgroup-class="w-100 mb-0"
                                    igroup-size="sm"
                                    disabled
                                    readonly
                                />
                            </th>
                        </template>
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
            items: @js(old('items', @$data->bahanPakanFormulasiItem ?? [])),
            listBahanPakan: @js($listBahanPakan),
            addItem() {
                this.items.push({
                    id              : null,
                    bahan_pakan_id  : null,
                    persentase      : null,
                })
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>