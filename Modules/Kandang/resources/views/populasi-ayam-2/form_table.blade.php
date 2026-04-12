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
                        return total + Number(item2[key] || 0);
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
                getPindahChange(pipeId) {
                    let total = 0;
                    items.forEach(item => {
                        if (item.pindah_ayam && item.pindah_ayam.length > 0) {
                            item.pindah_ayam.forEach(p => {
                                if (String(p.pipe_tujuan_id) === String(pipeId)) {
                                    total += Number(p.jumlah_perubahan || 0);
                                } else if (String(item.pipe.id) === String(pipeId)) {
                                    total -= Number(p.jumlah_perubahan || 0);
                                }
                            });
                        }
                    });
                    return total;
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
                    <th colspan="2" style="vertical-align: middle; text-align: center; min-width: 150px;">Pindah Ayam</th>
                </tr>
                <tr style="vertical-align: middle; text-align: center;">
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Sebelum</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Sesudah</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Masuk</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Keluar</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Pipe Tujuan</th>
                    <th style="vertical-align: middle; text-align: center; min-width: 100px;">Perpindahan</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, index) in items">
                    <tr
                        x-data="{
                            get current_ayam_sehat() {
                                return Number(item.ayam_sehat_before || 0)
                                    - Number(item.ayam_mati || 0)
                                    - Number(item.ayam_afkir || 0)
                                    - Number(item.ayam_masuk_karantina || 0)
                                    + Number(item.ayam_keluar_karantina || 0)
                                    + getPindahChange(item.pipe.id);
                            },
                            getOtherPipes() {
                                return items.filter(i => String(i.pipe.id) !== String(item.pipe.id));
                            },
                            updatePindah(targetPipeId, jumlah) {
                                if (!item.pindah_ayam) item.pindah_ayam = [];
                                const existingIndex = item.pindah_ayam.findIndex(p => String(p.pipe_tujuan_id) === String(targetPipeId));
                                if (Number(jumlah) === 0) {
                                    if (existingIndex >= 0) item.pindah_ayam.splice(existingIndex, 1);
                                } else {
                                    if (existingIndex >= 0) {
                                        item.pindah_ayam[existingIndex].jumlah_perubahan = jumlah;
                                    } else {
                                        item.pindah_ayam.push({ pipe_tujuan_id: targetPipeId, jumlah_perubahan: jumlah });
                                    }
                                }
                                items[index] = item;
                            }
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
                            <div class="d-flex flex-column align-items-end">
                                <span x-text="current_ayam_sehat"></span>
                                <template x-if="getPindahChange(item.pipe.id) !== 0">
                                    <small class="text-primary" :class="getPindahChange(item.pipe.id) > 0 ? 'text-success' : 'text-danger'">
                                        (<span x-text="getPindahChange(item.pipe.id) > 0 ? '+' : ''"></span><span x-text="getPindahChange(item.pipe.id)"></span>)
                                    </small>
                                </template>
                            </div>
                            <input
                                type="hidden"
                                x-bind:name="`items[${item.pipe.id}][ayam_sehat]`"
                                :value="current_ayam_sehat"
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
                        <td class="text-left">
                            <template x-if="getOtherPipes().length > 0">
                                <select 
                                    class="form-control form-control-sm"
                                    x-bind:readonly="is_editable"
                                    @change="updatePindah($event.target.value, $event.target.dataset.jumlah || 0)"
                                    :data-jumlah="item.pindah_ayam && item.pindah_ayam.length > 0 ? item.pindah_ayam[0].jumlah_perubahan : 0"
                                >
                                    <option value="">Pilih Pipe Tujuan</option>
                                    <template x-for="otherPipe in getOtherPipes()" :key="otherPipe.pipe.id">
                                        <option 
                                            :value="otherPipe.pipe.id"
                                            :selected="item.pindah_ayam && item.pindah_ayam.some(p => String(p.pipe_tujuan_id) === String(otherPipe.pipe.id))"
                                            x-text="otherPipe.pipe.nama"
                                        ></option>
                                    </template>
                                </select>
                            </template>
                            <template x-if="getOtherPipes().length === 0">
                                <span class="text-muted">-</span>
                            </template>
                        </td>
                        <td class="text-right">
                            <template x-if="getOtherPipes().length > 0">
                                <input 
                                    type="number"
                                    class="form-control form-control-sm"
                                    x-bind:name="`items[${item.pipe.id}][pindah_ayam][0][jumlah_perubahan]`"
                                    :value="item.pindah_ayam && item.pindah_ayam.length > 0 ? item.pindah_ayam[0].jumlah_perubahan : 0"
                                    x-bind:readonly="is_editable"
                                    @input="if ($event.target.value) { const selectedPipe = $event.target.closest('tr').querySelector('select').value; if (selectedPipe) updatePindah(selectedPipe, $event.target.value); }"
                                />
                            </template>
                            <input 
                                type="hidden"
                                x-bind:name="`items[${item.pipe.id}][pindah_ayam][0][pipe_tujuan_id]`"
                                :value="item.pindah_ayam && item.pindah_ayam.length > 0 ? item.pindah_ayam[0].pipe_tujuan_id : ''"
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
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>