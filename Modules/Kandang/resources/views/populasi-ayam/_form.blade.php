<x-adminlte-input
    id="tanggal_transaksi"
    type="date"
    name="tanggal_transaksi"
    label="Tanggal Transaksi"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
/>

<input type="hidden" name="kandang_id" value="{{ request()->route('kandangId') }}">

<div class="form-group col-12">
    <label for="flock_id">Baris</label>
    <div class="input-group input-group-lg">
        <select name="flock_id" id="flock_id" class="form-control form-control-lg">
        </select>
    </div>
</div>

<div class="form-group col-12">
    <label for="pipe_id">Pipa</label>
    <div class="input-group input-group-lg">
        <select name="pipe_id" id="pipe_id" class="form-control form-control-lg">
        </select>
    </div>
</div>

<x-adminlte-input
    id="umur_ayam"
    name="umur_ayam"
    label="Umur Ayam"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
/>

<x-adminlte-input
    name="ayam_sehat"
    label="Jumlah Ayam Sehat pada Pipa saat ini"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
/>

<x-adminlte-textarea 
    name="catatan"
    label="Catatan"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
/>

@push('js')
    <script>
        $(function() {
            $('#flock_id').select2({
                ajax: {
                    url: @js(route('master-data.ajax.flock', request()->route('kandangId'))),
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

            async function getUmurAyam() {
                if (!pipeId || !tanggalTransaksi) return;
                let umurAyamSekarang = await $.ajax(`/master-data/ajax/umur-ayam/${pipeId}?tanggal_perbandingan=${tanggalTransaksi}`)
                    .then(res => res.umur_ayam_sekarang); // satuan minggu
                $('#umur_ayam').val(umurAyamSekarang);
            }

            async function getRecordPopulasi() {
                if (!tanggalTransaksi) return;
                const list_populasi = await $.ajax(`/master-data/ajax/kandang/{{ request()->route('kandangId') }}/${tanggalTransaksi}/record-populasi`);
                $('#record-harian').html('');
                list_populasi.map((populasi) => {
                    $('#record-harian').append(`
                        <tr>
                            <td>${populasi.pipe.nama}</td>
                            <td>${populasi.ayam_sehat}</td>
                            <td>${populasi.ayam_mati}</td>
                            <td>${populasi.ayam_afkir}</td>
                        </tr>
                    `);
                })
            }

            $('#pipe_id').on('change', function() {
                pipeId = this.value;
                getUmurAyam();
            });

            $('#tanggal_transaksi').on('change', function() {
                tanggalTransaksi = this.value;
                getUmurAyam();
                getRecordPopulasi()
            });
        })
    </script>
@endpush