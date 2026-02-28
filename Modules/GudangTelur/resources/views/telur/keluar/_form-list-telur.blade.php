<div
    class="card"
    x-data="telur"
>
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">List Telur Keluar</h2>
            <button type="button" class="btn btn-primary btn-sm" x-on:click="addItem">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
        
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered mb-0">
            <thead>
                <tr>
                    <th class="text-center align-middle" style="min-width: 150px;">Jenis Telur</th>
                    <th class="text-center align-middle" style="min-width: 150px;">Keluar</th>
                    <th class="text-center align-middle" style="min-width: 40px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, i) in items">
                    <tr>
                        <td>
                            <input 
                                type="hidden" 
                                :name="`items[${i}][id]`"
                                :value="item.id"
                            />
                            <select
                                class="w-100 mb-0 form-control"
                                :name="`items[${i}][telur_jenis_id]`"
                                x-model="item.telur_jenis_id"
                                x-select2
                            >
                                <template x-for="(jenisTelur, j) in listJenisTelur">
                                    <option
                                        :value="jenisTelur.id"
                                        :selected="jenisTelur.id == item.telur_jenis_id"
                                        x-text="jenisTelur.nama"
                                    ></option>
                                </template>
                            </select>
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                fgroup-class="mb-0"
                                igroup-size="sm"
                                name="jumlah"
                                x-bind:name="`items[${i}][jumlah]`"
                                x-bind:value="item.jumlah"
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-secondary">
                                        Butir
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </td>
                        <td class="text-center">
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
        Alpine.directive('select2', (el, binding, { cleanup }) => {
            $(el).select2({
                placeholder: "Pilih Jenis Telur",
                allowClear: true,
                theme: "bootstrap",
                width: '100%'
            });

            cleanup(() => {
                $(el).select2('destroy');
            })
        })

        Alpine.data('telur', () => ({
            items: @js(old('items', @$data->telurInventory ?? [])),
            listJenisTelur: @js($listTelurJenis),
            addItem() {
                this.items.push({
                    kemasan_id  : null,
                    jumlah      : null,
                });
            },
            deleteItem(i) {
                this.items = this.items.filter((_, i2) => i2 !== i);
            },
        }));
    })
</script>