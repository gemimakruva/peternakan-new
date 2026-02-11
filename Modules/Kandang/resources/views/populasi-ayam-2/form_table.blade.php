<div class="card">
    <div class="card-header">
        <h2 class="card-title">Pencatatan Perubahan Populasi</h2>
    </div>
    <div class="card-body p-0">
        <table
            class="table table-sm table-bordered"
            x-data="{
                get total_ayam_sehat() {
                    return items.reduce((total, item2) => {
                        return total + Number(item2.ayam_sehat);
                    }, 0)
                }
            }"
        >
            <thead>
                <tr style="vertical-align: middle; text-align: center;">
                    <th rowspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Flock</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Pipa</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">Sehat</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Mati</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Afkir</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">Karantina</th>
                </tr>
                <tr style="vertical-align: middle; text-align: center;">
                    <th style="vertical-align: middle; text-align: center;">Sebelum</th>
                    <th style="vertical-align: middle; text-align: center;">Sesudah</th>
                    <th style="vertical-align: middle; text-align: center;">Masuk</th>
                    <th style="vertical-align: middle; text-align: center;">Keluar</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in items">
                    <tr
                        x-data="{
                            get current_ayam_sehat() {
                                return Number(item.ayam_sehat_before)
                                    - Number(item.ayam_mati)
                                    - Number(item.ayam_afkir)
                                    - Number(item.ayam_masuk_karantina)
                                    + Number(item.ayam_keluar_karantina)
                            },
                        }"
                    >
                        <td class="text-left">
                            <span x-text="item.flock.nama"></span>
                            <input
                                type="hidden" 
                                x-bind:name="`items[${item.pipe.id}][id]`"
                                :value="item.id"
                            />
                            <input
                                type="hidden" 
                                x-bind:name="`items[${item.pipe.id}][flock_id]`"
                                :value="item.flock.id"
                            />
                            <input
                                type="hidden" 
                                x-bind:name="`items[${item.pipe.id}][flock][id]`"
                                :value="item.flock.id"
                            />
                            <input
                                type="hidden" 
                                x-bind:name="`items[${item.pipe.id}][flock][nama]`"
                                :value="item.flock.nama"
                            />
                        </td>
                        <td class="text-left">
                            <span x-text="item.pipe.nama"></span>
                            <input
                                type="hidden" 
                                x-bind:name="`items[${item.pipe.id}][pipe_id]`"
                                :value="item.pipe.id"
                            />
                            <input
                                type="hidden" 
                                x-bind:name="`items[${item.pipe.id}][pipe][id]`"
                                :value="item.pipe.id"
                            />
                            <input
                                type="hidden" 
                                x-bind:name="`items[${item.pipe.id}][pipe][nama]`"
                                :value="item.pipe.nama"
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                name="ayam_sehat_before"
                                x-bind:name="`items[${item.pipe.id}][ayam_sehat_before]`"
                                x-bind:value="item.ayam_sehat_before"
                                fgroup-class="mb-0"
                                readonly
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                name="ayam_sehat"
                                x-bind:name="`items[${item.pipe.id}][ayam_sehat]`"
                                x-bind:value="current_ayam_sehat"
                                fgroup-class="mb-0"
                                readonly
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                name="ayam_mati"
                                x-bind:name="`items[${item.pipe.id}][ayam_mati]`"
                                x-model="item.ayam_mati"
                                fgroup-class="mb-0"
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                name="ayam_afkir"
                                x-bind:name="`items[${item.pipe.id}][ayam_afkir]`"
                                x-model="item.ayam_afkir"
                                fgroup-class="mb-0"
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                name="ayam_masuk_karantina"
                                x-bind:name="`items[${item.pipe.id}][ayam_masuk_karantina]`"
                                x-model="item.ayam_masuk_karantina"
                                fgroup-class="mb-0"
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                name="ayam_keluar_karantina"
                                x-bind:name="`items[${item.pipe.id}][ayam_keluar_karantina]`"
                                x-model="item.ayam_keluar_karantina"
                                fgroup-class="mb-0"
                            />
                        </td>
                    </tr>
                </template>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th x-text="total_ayam_sehat"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>