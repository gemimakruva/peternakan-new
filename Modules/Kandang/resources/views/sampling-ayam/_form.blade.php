<x-adminlte-input
    id="tanggal_sampling_ayam"
    type="date"
    name="tanggal"
    label="Tanggal Produksi"
    value="{{ old('tanggal', isset($samplingBobotAyam) ? $samplingBobotAyam->tanggal->format('Y-m-d') : now()->format('Y-m-d')) }}"
    :readonly="$readonly"
/>

<x-adminlte-select
    id="input-kandang-recording-telur"
    name="kandang_id"
    label="Pilih Kandang"
    :readonly="$readonly"
    :disabled="$readonly"
>
    <x-adminlte-options 
        :options="$listKandang"
        empty-option="Pilih Kandang"
        :selected="old('kandang_id', @$samplingBobotAyam->kandang_id)"
    />
</x-adminlte-select>

<x-adminlte-input
    name="usia_ayam_saat_ini"
    label="Umur Ayam (Minggu)"
    value="{{ old('usia_ayam_saat_ini', @$samplingBobotAyam->umur) }}"
    type="number"
    readonly
/>

<x-adminlte-input
    name="jumlah_ayam_saat_ini"
    label="Jumlah Ayam Saat Ini"
    value="{{ old('jumlah_ayam_saat_ini', @$samplingBobotAyam->jumlah_ayam_saat_ini) }}"
    type="number"
    readonly
/>

<x-adminlte-input
    name="jumlah_ayam_disampling"
    label="Jumlah Ayam yang Disampling"
    value="{{ old('jumlah_ayam_disampling', @$samplingBobotAyam->jumlah_ayam_yang_disampling) }}"
    type="number"
    readonly
/>

<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Bobot Badan Ayam (kg)</th>
            @if (!$readonly)
                <th width="1%">
                    <button class="btn btn-primary btn-sm" type="button" id="btn-add-row-bobot-sampling-ayam"><i class="fas fa-plus"></i></button>
                </th>
            @endif
        </tr>
    </thead>
    <tbody id="container-sampling-ayam-bobot-ayam">
        @php
            $bobotData = old('berat_badan_rata_rata');
            if (!$bobotData && isset($samplingBobotAyam)) {
                $bobotData = $samplingBobotAyam->samplingBobotAyamPerEkor->pluck('bobot_per_kg')->toArray();
            }
        @endphp
        
        @if($bobotData && count($bobotData) > 0)
            @foreach($bobotData as $index => $bobot)
            <tr>
                <td width="1%" class="text-center">{{ $index + 1 }}</td>
                <td>
                    <input 
                        type="number" 
                        name="berat_badan_rata_rata[]" 
                        value="{{ $bobot }}" 
                        class="form-control form-control-sm"
                        step="0.01"
                        @readonly($readonly)
                    />
                </td>
                @if(!$readonly)
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-delete-row-bobot-sampling-ayam"><i class="fas fa-trash"></i></button>
                    </td>
                @endif
            </tr>
            @endforeach
        @else
        <tr>
            <td width="1%" class="text-center">1</td>
            <td>
                <input 
                    type="number" 
                    name="berat_badan_rata_rata[]" 
                    value="" 
                    class="form-control form-control-sm"
                    step="0.01"
                    @readonly($readonly)
                />
            </td>
            @if (!$readonly)
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-delete-row-bobot-sampling-ayam"><i class="fas fa-trash"></i></button>
                </td>
            @endif
        </tr>
        @endif
    </tbody>
</table>


@push('js')
    <script>
        $(document).ready(function() {
            let container = $('#container-sampling-ayam-bobot-ayam');

            removeBobotAyamRow();
            updateJumlahSampling();

            $('#btn-add-row-bobot-sampling-ayam').click(function() {
                addBobotAyamRow();
                removeBobotAyamRow();
                updateJumlahSampling();
            });

            function removeBobotAyamRow() {
                $('.btn-delete-row-bobot-sampling-ayam').each(function() {
                    $(this).click(function() {
                        $(this).closest('tr').remove();
                        updateJumlahSampling();
                        updateRowNumbers();
                    });
                });
            }

            function updateJumlahSampling() {
                const rowCount = container.find('tr').length;
                $('input[name="jumlah_ayam_disampling"]').val(rowCount);
            }

            function updateRowNumbers() {
                container.find('tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }

            function addBobotAyamRow() {
                const rowCount = container.find('tr').length + 1;
                const newRow = `
                    <tr>
                        <td width="1%" class="text-center">${rowCount}</td>
                        <td>
                            <input 
                                type="number" 
                                name="berat_badan_rata_rata[]" 
                                class="form-control form-control-sm"
                                step="0.01"
                            />
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-delete-row-bobot-sampling-ayam"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                container.append(newRow);
            }

            function getUmurAyam(kandangId, tanggal) {
                
                let url = @js(route('ajax.umur_ayam_by_kandang', ['kandangId' => ':kandangId', 'tanggal' => ':tanggal']))
                    .replace(':kandangId', kandangId)
                    .replace(':tanggal', tanggal);
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        tanggal: tanggal
                    },
                    success: function(response) {
                        $('input[name="usia_ayam_saat_ini"]').val(response.umur_ayam);
                        
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('input[name="usia_ayam_saat_ini"]').val(0);
                    }
                });
            }

            function getPopulasiAyam(kandangId, tanggal = new Date().toISOString().split('T')[0]) {

                let url = @js(route('ajax.populasi-by-kandang', [':kandangId', ':tanggal']))
                    .replace(':kandangId', kandangId)
                    .replace(':tanggal', tanggal);
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        $('input[name="jumlah_ayam_saat_ini"]').val(response.total_ayam_sehat_terakhir);
                        
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('input[name="jumlah_ayam_saat_ini"]').val(0);
                    }
                });
            }

            var kandangId = @js(old('kandang_id', @$samplingBobotAyam->kandang_id));
            var tanggal = @js(old('tanggal', @$samplingBobotAyam?->tanggal?->format('Y-m-d') ?? now()->format('Y-m-d')));

            if  (kandangId) {
                getUmurAyam(kandangId, tanggal);
                getPopulasiAyam(kandangId, tanggal);
            }

            $('#input-kandang-recording-telur').change(function() {
                kandangId = $(this).val();
                if (!kandangId || !tanggal) return;
                getUmurAyam(kandangId, tanggal);
                getPopulasiAyam(kandangId, tanggal);
            });

            $('#tanggal_sampling_ayam').change(function() {
                tanggal = $(this).val();
                if (!kandangId || tanggal) return;
                getUmurAyam(kandangId, tanggal);
                getPopulasiAyam(kandangId, tanggal);
            });
        });
    </script>
@endpush