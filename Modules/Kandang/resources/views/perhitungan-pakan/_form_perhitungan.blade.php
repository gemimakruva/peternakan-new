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
        ...@js($initialState),
        proporsi_pemberian_pagi: @js((float) $data->proporsi_pemberian_pagi),
        proporsi_pemberian_sore: @js((float) $data->proporsi_pemberian_sore),
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
            return Object.values(this.pipes).reduce(function (total, item) {
                return total + (Number(item.pemberian_pakan_per_ekor) * Number(item.jumlah_ayam));
            }, 0) / 1000
        },
        get totalPemberianPagiKg() {
            return (Object.values(this.pipes).reduce(function (total, item) {
                return total + (Number(item.pemberian_pakan_per_ekor) * Number(item.jumlah_ayam));
            }, 0) / 1000) * (this.proporsi_pemberian_pagi/100)
        },
        get totalPemberianSoreKg() {
            return (Object.values(this.pipes).reduce(function (total, item) {
                return total + (Number(item.pemberian_pakan_per_ekor) * Number(item.jumlah_ayam));
            }, 0) / 1000) * (this.proporsi_pemberian_sore/100)
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
                    <th class="align-middle" style="width: 160px;" rowspan="2">Pemberian per Pipa (kg)</th>
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
                                pipe_id: @js((int) $pipe->id),
                                get pemberianPakanPipeKg() {
                                    return Number(pipes[this.pipe_id].pemberian_pakan_per_ekor) * Number(pipes[this.pipe_id].jumlah_ayam) / 1000
                                }
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
                                    type="number"
                                    class="form-control form-control-sm"
                                    x-model="pipes[pipe_id].pemberian_pakan_per_ekor"
                                />
                            </td>
                            <td class="text-right">
                                <span x-text="pemberianPakanPipeKg.toLocaleString('id')"></span>
                            </td>
                            <td class="text-right">
                                <span x-text="(pemberianPakanPipeKg*(proporsi_pemberian_pagi/100)).toLocaleString('id')"></span>
                            </td>
                            <td class="text-right">
                                <span x-text="(pemberianPakanPipeKg*(proporsi_pemberian_sore/100)).toLocaleString('id')"></span>
                            </td>
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