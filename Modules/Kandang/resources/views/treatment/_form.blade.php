<div class="card">
    <div class="card-header">
        <h2 class="card-title">Form Treatment</h2>
    </div>
    <div class="card-body">
        <x-adminlte-select
            label="Kandang"
            name="kandang_id"
            :readonly="@$data->kandang_id"
            :disabled="@$data->kandang_id"
        >
            <x-adminlte-options
                :options="$listKandang"
                empty-option="Pilih Kandang"
                :selected="old('kandang_id', @$data->kandang_id)"
            />
        </x-adminlte-select>

        <x-adminlte-input
            label="Tanggal"
            name="tanggal"
            type="date"
            :value="old('tanggal', @$data->tanggal?->format('Y-m-d'))"
            :readonly="@$data->tanggal"
            :disabled="@$data->tanggal"
        />
    </div>
</div>

@if (@$data)
<div
    class="card"
    x-data="{
        items: @js(old('items', @$data->treatmentJadwal) ?? []),
        errors: @js($errors->messages()) || {},
        listFlock: @js(@$listFlock),
        addItem () {
            this.items.push({
                waktu               : '',
                jenis_treatment_id  : '',
                metode_treatment_id : '',
                merk_ovk            : '',
                area                : '',
                flocks              : [],
                dosis               : '',
            })
        },
        deleteItem(i) {
            this.items = this.items.filter((_, idx) => idx !== i);
        }
    }"
>
    {{-- <pre x-text="JSON.stringify(errors, 2, 3)"></pre> --}}
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">Jadwal Treatment</h2>
            <button
                class="btn btn-primary btn-sm"
                x-on:click="addItem"
                type="button"
            >
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered text-center mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="align-middle" style="min-width: 100px;">Waktu</th>
                    <th class="align-middle" style="min-width: 200px;">Jenis</th>
                    <th class="align-middle" style="min-width: 200px;">Metode</th>
                    <th class="align-middle" style="min-width: 100px;">Merk OVK</th>
                    <th class="align-middle" style="min-width: 100px;">Area</th>
                    <th class="align-middle" style="min-width: 300px;">Flock</th>
                    <th class="align-middle" style="min-width: 140px;">Dosis</th>
                    <th class="align-middle" style="min-width: 40px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, i) in items" :key="i">
                    <tr>
                        <td>
                            <x-adminlte-input
                                type="time"
                                name="waktu"
                                x-bind:name="`items[${i}][waktu]`"
                                fgroup-class="w-100 mb-0"
                                x-bind:class="{'is-invalid': errors[`items.${i}.waktu`][0]}"
                                x-model="item.waktu"
                            />
                            <div 
                                x-if="errors[`items.${i}.waktu`][0]"
                                x-text="errors[`items.${i}.waktu`][0]"
                                class="text-danger"
                            ></div>
                        </td>
                        <td>
                            <x-adminlte-select 
                                name="jenis_treatment_id"
                                x-bind:name="`items[${i}][jenis_treatment_id]`"
                                fgroup-class="w-100 mb-0"
                                x-model="item.jenis_treatment_id"
                                x-bind:class="{'is-invalid': errors[`items.${i}.jenis_treatment_id`][0]}"
                            >
                                <x-adminlte-options
                                    :options="$listJenisTreatment"
                                    empty-option="Pilih Jenis Treatment"
                                />
                            </x-adminlte-select>
                            <div 
                                x-if="errors[`items.${i}.jenis_treatment_id`][0]"
                                x-text="errors[`items.${i}.jenis_treatment_id`][0]"
                                class="text-danger"
                            ></div>
                        </td>
                        <td>
                            <x-adminlte-select 
                                name="metode_treatment_id"
                                x-bind:name="`items[${i}][metode_treatment_id]`"
                                fgroup-class="w-100 mb-0"
                                x-model="item.metode_treatment_id"
                                x-bind:class="{'is-invalid': errors[`items.${i}.metode_treatment_id`][0]}"
                            >
                                <x-adminlte-options
                                    :options="$listMetodeTreatment"
                                    empty-option="Pilih Metode Treatment"
                                />
                            </x-adminlte-select>
                            <div
                                x-if="errors[`items.${i}.metode_treatment_id`][0]"
                                x-text="errors[`items.${i}.metode_treatment_id`][0]"
                                class="text-danger"
                            ></div>
                        </td>
                        <td>
                            <x-adminlte-input
                                name="merk_ovk"
                                x-bind:name="`items[${i}][merk_ovk]`"
                                fgroup-class="w-100 mb-0"
                                x-model="item.merk_ovk"
                                x-bind:class="{'is-invalid': errors[`items.${i}.merk_ovk`][0]}"
                            />
                            <div
                                x-if="errors[`items.${i}.merk_ovk`][0]"
                                x-text="errors[`items.${i}.merk_ovk`][0]"
                                class="text-danger"
                            ></div>
                        </td>
                        <td>
                            <x-adminlte-input
                                name="area"
                                x-bind:name="`items[${i}][area]`"
                                fgroup-class="w-100 mb-0"
                                x-model="item.area"
                                x-bind:class="{'is-invalid': errors[`items.${i}.area`][0]}"
                            />
                            <div
                                x-if="errors[`items.${i}.area`][0]"
                                x-text="errors[`items.${i}.area`][0]"
                                class="text-danger"
                            ></div>
                        </td>
                        <td>
                            <select 
                                :name="`items[${i}][flocks][]`"
                                class="w-100 mb-0 form-control"
                                x-model="item.flocks"
                                x-select2
                            >
                                <template x-for="key in Object.keys(listFlock)">
                                    <option :value="Number(key)" x-text="listFlock[key]" :selected="item.flocks.includes(Number(key))"></option>
                                </template>
                            </select>
                        </td>
                        <td>
                            <x-adminlte-input
                                name="dosis"
                                x-bind:name="`items[${i}][dosis]`"
                                fgroup-class="w-100 mb-0"
                                x-model="item.dosis"
                                x-bind:class="{'is-invalid': errors[`items.${i}.dosis`][0]}"
                            />
                            <div
                                x-if="errors[`items.${i}.dosis`][0]"
                                x-text="errors[`items.${i}.dosis`][0]"
                                class="text-danger"
                            ></div>
                        </td>
                        <td>
                            <input type="hidden" :name="`items[${i}][id]`" :value="item.id">
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
@endif

@once
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.directive('select2', (el, binding, { cleanup }) => {
            $(el).select2({
                placeholder: "Semua Flock",
                allowClear: true,
                theme: "bootstrap",
                multiple: true,
            });

            cleanup(() => {
                $(el).select2('destroy');
            })
        })
    })
</script>
@endonce