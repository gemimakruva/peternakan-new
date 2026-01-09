<x-adminlte-input
    id="tanggal_transaksi"
    type="date"
    name="tanggal_transaksi"
    label="Tanggal Transaksi"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    max="{{ today()->format('Y-m-d') }}"
    :value="old('tanggal_transaksi', @$data->tanggal?->format('Y-m-d'))"
/>

<x-adminlte-input
    id="kandang"
    name="kandang"
    label="Kandang"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
    :value="$kandang->nama"
/>

<input type="hidden" name="kandang_id" value="{{ $kandangId }}">

<div class="form-group col-12">
    <label for="flock_id">Baris</label>
    <div class="input-group input-group-lg @error('flock_id') adminlte-invalid-igroup @enderror">
        <select name="flock_id" id="flock_id" class="form-control form-control-lg @error('flock_id') is-invalid @enderror">
        </select>
    </div>
    @error('flock_id')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group col-12">
    <label for="pipe_id">Pipa</label>
    <div class="input-group input-group-lg @error('pipe_id') adminlte-invalid-igroup @enderror">
        <select name="pipe_id" id="pipe_id" class="form-control form-control-lg @error('pipe_id') is-invalid @enderror">
        </select>
    </div>
    @error('pipe_id')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<x-adminlte-input
    id="umur_ayam_record"
    name="umur_ayam_record"
    label="Umur Ayam"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
    :value="old('umur_ayam_record', @$data->umur_ayam_record)"
/>

<x-adminlte-input
    id="jumlah_ayam_sehat_pada_pipa_saat_ini"
    name="jumlah_ayam_sehat_pada_pipa_saat_ini"
    label="Jumlah Ayam Sehat pada Pipa saat ini"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
/>

@push('css')
    <style>
        .adminlte-invalid-igroup .select2-selection {
            border: 1px solid red !important;
        }
    </style>
@endpush

@push('js')
    @if ($tanggal = old('tanggal_transaksi', @$data->tanggal?->format('Y-m-d')))
        <script>
            tanggalTransaksi = @js($tanggal);
        </script>
    @endif
    @if ($flockId = old('flock_id', @$flock->id))
        @php
            $flockName = Modules\Kandang\Models\Flock::whereId($flockId)->value('nama');
        @endphp
        <script>
            // $(() => { 
                $('#flock_id').val(@js($flockId));
                $('#flock_id').append(`<option value="{{ $flockId }}">{{ $flockName }}</option>`)
                $('#flock_id').trigger('change'); 
            // });
        </script>
    @endif
    @if ($pipeId = old('pipe_id', @$pipe->id))
        @php
            $pipeName = Modules\Kandang\Models\Pipe::whereId($pipeId)->value('nama');
        @endphp
        <script>
            // $(() => {
                $('#pipe_id').val(@js($pipeId));
                $('#pipe_id').append(`<option value="{{ $pipeId }}">{{ $pipeName }}</option>`)
                $('#pipe_id').trigger('change'); 

                pipeId = @js($pipeId);
            // });
        </script>
    @endif
    <script>
        $(function() {
            $('#flock_id').select2({
                ajax: {
                    url: @js(route('master-data.ajax.flock', $kandangId)),
                    datType: 'json'
                },
                placeholder: "Pilih Flock",
                allowClear: true,
                theme: "bootstrap",
            })

            $('#flock_id').on('change', function() {
                $('#pipe_id').val('')
                $('#pipe_id').select2({
                    ajax: {
                        url: `/master-data/ajax/pipe/${this.value}`
                    },
                    placeholder: "Pilih Flock",
                    allowClear: true,
                    theme: "bootstrap",
                })
            });

            var pipeId, tanggalTransaksi;

            @if ($pipeId && $tanggal)
                pipeId = @js($pipeId);
                tanggalTransaksi = @js($tanggal);
            @endif

            async function getUmurAyam() {
                if (!pipeId || !tanggalTransaksi) return;
                let umurAyamSekarang = await $.ajax(`/master-data/ajax/umur-ayam/${pipeId}?tanggal_perbandingan=${tanggalTransaksi}`)
                    .then(res => res.umur_ayam_sekarang); // satuan minggu
                $('#umur_ayam_record').val(umurAyamSekarang);
            }

            async function getKesehatanAyam() {
                if (!pipeId || !tanggalTransaksi) return;
                let kesehatanAyamSekarang = await $.ajax(`/master-data/ajax/kesehatan-ayam/${pipeId}?tanggal_perbandingan=${tanggalTransaksi}`)
                    .then(res => res.total_ayam_sehat_terakhir); // satuan ekor
                $('#jumlah_ayam_sehat_pada_pipa_saat_ini').val(kesehatanAyamSekarang);
            }

            async function getRecordPopulasi() {
                if (!pipeId || !tanggalTransaksi) return;
                const list_populasi = await $.ajax(`/master-data/ajax/kandang/{{ $kandangId }}/${tanggalTransaksi}/record-populasi`);
                $('#record-harian').html('');
                list_populasi.map((populasi) => {
                    const editUri = `/populasi-ayam/${populasi.id}/edit`;
                    $('#record-harian').append(`
                        <tr>
                            <td class='text-left'>${populasi.pipe.nama}</td>
                            <td class='text-right'>${populasi.ayam_sehat}</td>
                            <td class='text-right'>${populasi.ayam_mati}</td>
                            <td class='text-right'>${populasi.ayam_afkir}</td>
                            <td class='text-right'>${populasi.ayam_masuk_karantina}</td>
                            <td class='text-right'>${populasi.ayam_keluar_karantina}</td>
                            <td class='text-center'>
                                <a href='${editUri}' class='btn btn-sm btn-primary'>
                                    <i class='fas fa-eye'></i>
                                </a>
                            </td>
                        </tr>
                    `);
                })
            }

            $('#pipe_id').on('change', function() {
                pipeId = this.value;
                getUmurAyam();
                getKesehatanAyam();
                getRecordPopulasi();
            });

            $('#tanggal_transaksi').on('change', function() {
                tanggalTransaksi = this.value;
                getUmurAyam();
                getKesehatanAyam();
                getRecordPopulasi();
            });

            if (pipeId && tanggalTransaksi) {
                getKesehatanAyam();
                getRecordPopulasi();
            }
        })
    </script>
    
@endpush