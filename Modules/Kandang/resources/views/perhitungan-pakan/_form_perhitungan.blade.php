@push('css')
    <style>
        .card-body.p-0 .table tbody>tr>td:first-of-type {
            padding-left: .8rem;
        }
        .card-body.p-0 .table tbody>tr>td:last-of-type {
            padding-right: .8rem;
        }
    </style>
@endpush

<div 
    class="card"
    x-data="{
        ...@js([
            'pipes' => old('items', $initialState['pipes']),
            'flocks' => old('flocks', $initialState['flocks']),
        ]),
        proporsi_pemberian_pagi: @js((float) $data->proporsi_pemberian_pagi),
        proporsi_pemberian_sore: @js((float) $data->proporsi_pemberian_sore),
        handlePemberianPakanChange (flock, pipe) {
            const flocks = Object.values(this.pipes).filter((p) => p.flock_id == pipe.flock_id)
            const gramasiFlock = flocks.reduce(function (total, item) {
                return total + (Number(item.pemberian_pakan_per_ekor) * Number(item.jumlah_ayam));
            }, 0)
            flock.pemberian_pakan_per_flock_kg = (gramasiFlock/1000)
            flock.pemberian_pakan_pagi_kg = (gramasiFlock/1000)*(this.proporsi_pemberian_pagi/100)
            flock.pemberian_pakan_sore_kg = (gramasiFlock/1000)*(this.proporsi_pemberian_sore/100)
        },
        get totalJumlahAyam () {
            return Object.values(this.pipes).reduce(function (total, item) {
                return total + Number(item.jumlah_ayam);
            }, 0)
        },
        get rata2PemberianGram() {
            return Object.values(this.pipes).reduce(function (total, item) {
                return total + (Number(item.pemberian_pakan_per_ekor) * Number(item.jumlah_ayam));
            }, 0) / this.totalJumlahAyam
        },
        get totalPemberianKg() {
            return Object.values(this.flocks).reduce(function (total, item) {
                return total + Number(item.pemberian_pakan_per_flock_kg);
            }, 0)
        },
        get totalPemberianPagiKg() {
            return Object.values(this.flocks).reduce(function (total, item) {
                return total + Number(item.pemberian_pakan_pagi_kg);
            }, 0)
        },
        get totalPemberianSoreKg() {
            return Object.values(this.flocks).reduce(function (total, item) {
                return total + Number(item.pemberian_pakan_sore_kg);
            }, 0)
        }
    }"
>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th class="align-middle" rowspan="2" style="width: 40px;">#</th>
                    <th class="align-middle" rowspan="2">Flock</th>
                    <th class="align-middle" rowspan="2">Pipa</th>
                    <th class="align-middle" rowspan="2">Jumlah Ayam</th>
                    <th class="align-middle" style="width: 100px;" rowspan="2">Pemberian per Ekor (gram)</th>
                    <th class="align-middle" style="width: 165px;" rowspan="2">Pemberian per Flock (kg)</th>
                    <th class="align-middle" style="width: 100px;">Pagi (%)</th>
                    <th class="align-middle" style="width: 100px;">Sore (%)</th>
                </tr>
                <tr>
                    <th>{{ format_angka(@$data->proporsi_pemberian_pagi, 0) }}</th>
                    <th>{{ format_angka(@$data->proporsi_pemberian_sore, 0) }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach (@$data->kandang->flocks as $flock)
                    @php
                        $no = $loop->iteration
                    @endphp
                    @foreach ($flock->pipes as $pipeIndex => $pipe)
                        <tr 
                            x-data="{ 
                                flock_id: @js((int) $flock->id),
                                pipe_id: @js((int) $pipe->id),
                            }">
                            @if ($pipeIndex === 0)
                                <td class="text-right" rowspan="{{ $flock->pipes->count() }}">{{ $no }}</td>
                                <td class="text-left" rowspan="{{ $flock->pipes->count() }}">{{ $flock->nama }}</td>
                            @endif
                            <td class="text-left">{{ $pipe->nama }}</td>
                            <td class="text-right">{{ format_angka($pipe->populasiAyam[0]?->ayam_sehat) }}</td>
                            <td>
                                <input type="hidden" x-bind:value="pipes[pipe_id].id" :name="`items[${pipe_id}][id]`">
                                <input type="hidden" x-bind:value="pipes[pipe_id].perhitungan_pakan_id" :name="`items[${pipe_id}][perhitungan_pakan_id]`">
                                <input type="hidden" x-bind:value="pipes[pipe_id].kandang_id" :name="`items[${pipe_id}][kandang_id]`">
                                <input type="hidden" x-bind:value="pipes[pipe_id].flock_id" :name="`items[${pipe_id}][flock_id]`">
                                <input type="hidden" x-bind:value="pipes[pipe_id].pipe_id" :name="`items[${pipe_id}][pipe_id]`">
                                <input type="hidden" x-bind:value="pipes[pipe_id].jumlah_ayam" :name="`items[${pipe_id}][jumlah_ayam]`">
                                <input 
                                    :name="`items[${pipe_id}][pemberian_pakan_per_ekor]`"
                                    type="text"
                                    class="form-control form-control-sm"
                                    x-model="pipes[pipe_id].pemberian_pakan_per_ekor"
                                    @@input="handlePemberianPakanChange(flocks[flock_id], pipes[pipe_id])"
                                />
                            </td>
                            @if ($pipeIndex === 0)
                                <td 
                                    class="text-right"
                                    rowspan="{{ $flock->pipes->count() }}"
                                >
                                    <span x-text="Math.floor(flocks[flock_id].pemberian_pakan_per_flock_kg).toLocaleString('id')"></span>
                                    <input
                                        type="hidden"
                                        x-bind:value="flocks[flock_id].pemberian_pakan_per_flock_kg"
                                        :name="`flocks[${flock_id}][pemberian_pakan_per_flock_kg]`"
                                    />
                                </td>
                                <td
                                    class="text-right"
                                    rowspan="{{ $flock->pipes->count() }}"
                                >
                                    <span x-text="Math.floor(flocks[flock_id].pemberian_pakan_pagi_kg).toLocaleString('id')"></span>
                                    <input
                                        type="hidden"
                                        x-bind:value="flocks[flock_id].pemberian_pakan_pagi_kg"
                                        :name="`flocks[${flock_id}][pemberian_pakan_pagi_kg]`"
                                    />
                                </td>
                                <td
                                    class="text-right"
                                    rowspan="{{ $flock->pipes->count() }}"
                                >
                                    <span x-text="Math.floor(flocks[flock_id].pemberian_pakan_sore_kg).toLocaleString('id')"></span>
                                    <input
                                        type="hidden"
                                        x-bind:value="flocks[flock_id].pemberian_pakan_sore_kg"
                                        :name="`flocks[${flock_id}][pemberian_pakan_sore_kg]`"
                                    />
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Jumlah</th>
                    <th class="text-right" x-text="totalJumlahAyam.toLocaleString('id')"></th>
                    <th class="text-right" x-text="rata2PemberianGram.toLocaleString('id')"></th>
                    <th class="text-right" x-text="totalPemberianKg.toLocaleString('id')"></th>
                    <th class="text-right" x-text="totalPemberianPagiKg.toLocaleString('id')"></th>
                    <th class="text-right" x-text="totalPemberianSoreKg.toLocaleString('id')"></th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th class="text-center">(Average)</th>
                    <th class="text-center" style="padding-right: .8rem;">(Total Pemberian)</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>