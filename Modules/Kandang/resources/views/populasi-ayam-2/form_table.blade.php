<div class="card">
    <div class="card-header">
        <h2 class="card-title">Pencatatan Perubahan Populasi</h2>
    </div>
    <div class="card-body p-0 table-responsive">
        <table
            class="table table-sm table-bordered"
            x-data="{
                is_editable: @js(!@$isEditable),
                getTotalAyam(key) {
                    return items.reduce((total, item2) => {
                        return total + Number(item2[key]);
                    }, 0); 
                },
                get total_ayam_sehat_sebelumnya() {
                    return this.getTotalAyam('ayam_sehat_before').toLocaleString('id');
                },
                get total_ayam_sehat() {
                    return this.getTotalAyam('ayam_sehat').toLocaleString('id');
                },
                get total_ayam_mati() {
                    return this.getTotalAyam('ayam_mati').toLocaleString('id');
                },
                get total_ayam_afkir() {
                    return this.getTotalAyam('ayam_afkir').toLocaleString('id');
                },
                get total_ayam_masuk_karantina() {
                    return this.getTotalAyam('ayam_masuk_karantina').toLocaleString('id');
                },
                get total_ayam_keluar_karantina() {
                    return this.getTotalAyam('ayam_keluar_karantina').toLocaleString('id');
                },
            }"
        >
            <thead>
                <tr style="vertical-align: middle; text-align: center;">
                    <th rowspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Flock</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Pipa</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Sehat</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Mati</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Afkir</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center; min-width: 100px;">Karantina</th>
                </tr>
                <tr style="vertical-align: middle; text-align: center;">
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Sebelum</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Sesudah</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Masuk</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Keluar</th>
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
                                type="number"
                                name="ayam_mati"
                                x-bind:name="`items[${item.pipe.id}][ayam_mati]`"
                                x-model="item.ayam_mati"
                                fgroup-class="mb-0"
                                x-bind:readonly="is_editable"
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                type="number"
                                name="ayam_afkir"
                                x-bind:name="`items[${item.pipe.id}][ayam_afkir]`"
                                x-model="item.ayam_afkir"
                                fgroup-class="mb-0"
                                x-bind:readonly="is_editable"
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                type="number"
                                name="ayam_masuk_karantina"
                                x-bind:name="`items[${item.pipe.id}][ayam_masuk_karantina]`"
                                x-model="item.ayam_masuk_karantina"
                                fgroup-class="mb-0"
                                x-bind:readonly="is_editable"
                            />
                        </td>
                        <td class="text-right">
                            <x-adminlte-input 
                                type="number"
                                name="ayam_keluar_karantina"
                                x-bind:name="`items[${item.pipe.id}][ayam_keluar_karantina]`"
                                x-model="item.ayam_keluar_karantina"
                                fgroup-class="mb-0"
                                x-bind:readonly="is_editable"
                            />
                        </td>
                    </tr>
                </template>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right" x-text="total_ayam_sehat_sebelumnya"></th>
                    <th class="text-right" x-text="total_ayam_sehat"></th>
                    <th class="text-right" x-text="total_ayam_mati"></th>
                    <th class="text-right" x-text="total_ayam_afkir"></th>
                    <th class="text-right" x-text="total_ayam_masuk_karantina"></th>
                    <th class="text-right" x-text="total_ayam_keluar_karantina"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>