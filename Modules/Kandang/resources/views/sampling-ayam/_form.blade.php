<x-adminlte-input
    id="tanggal_sampling_ayam"
    type="date"
    name="tanggal"
    label="Tanggal Produksi"
    value="{{ old('tanggal', isset($samplingBobotAyam) ? $samplingBobotAyam->tanggal->format('Y-m-d') : now()->format('Y-m-d')) }}"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
/>

<div class="form-group col-12">
    <x-adminlte-select id="input-kandang-recording-telur" name="kandang_id" label="Pilih Kandang" class="select-nama-berkas"
    igroup-size="lg">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
        <option selected disabled>Pilih Kandang...</option>
        @foreach ($kandangList as $kandang_id => $nama)
            <option value="{{ $kandang_id }}" 
                {{ old('kandang_id', isset($samplingBobotAyam) ? $samplingBobotAyam->kandang_id : '') == $kandang_id ? 'selected' : '' }}>
                {{ $nama }}
            </option>
        @endforeach
    </x-adminlte-select>
</div>


<x-adminlte-input
    name="usia_ayam_saat_ini"
    label="Umur Ayam (Minggu)"
    value="{{ old('usia_ayam_saat_ini', isset($samplingBobotAyam) ? $samplingBobotAyam->umur : 0) }}"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
/>
<x-adminlte-input
    name="jumlah_ayam_saat_ini"
    label="Jumlah Ayam Saat Ini"
    value="{{ old('jumlah_ayam_saat_ini', isset($samplingBobotAyam) ? $samplingBobotAyam->jumlah_ayam_saat_ini : 0) }}"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
/>
<x-adminlte-input
    name="jumlah_ayam_disampling"
    label="Jumlah Ayam yang Disampling"
    value="{{ old('jumlah_ayam_disampling', isset($samplingBobotAyam) ? $samplingBobotAyam->jumlah_ayam_yang_disampling : 0) }}"
    type="number"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg mb-3"
    readonly
/>


<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Bobot Badan Ayam (kg)</th>
            <th width="1%">
                <button class="btn btn-primary btn-sm" type="button" id="btn-add-row-bobot-sampling-ayam"><i class="fas fa-plus"></i></button>
            </th>
        </tr>
    </thead>
    <tbody id="container-sampling-ayam-bobot-ayam">
        @php
            $bobotData = old('berat_badan_rata_rata');
            if (!$bobotData && isset($samplingBobotAyam)) {
                $bobotData = $samplingBobotAyam->beratBadanRataRataPerEkor->pluck('bobot_per_kg')->toArray();
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
                    />
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-delete-row-bobot-sampling-ayam"><i class="fas fa-trash"></i></button>
                </td>
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
                />
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-delete-row-bobot-sampling-ayam"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        @endif
    </tbody>
</table>


@push('js')
    <script>
        $(document).ready(function() {
            let kandangData = [];
            let container = $('#container-sampling-ayam-bobot-ayam');
            removeBobotAyamRow();
            updateJumlahSampling();
            
            @if(old('tanggal'))
            console.log('has old tanggal');
                countingAyamSehat('{{ old('tanggal') }}');
            @else
            console.log('no old tanggal');
                @if(isset($samplingBobotAyam))
                    countingAyamSehat('{{ $samplingBobotAyam->tanggal->format('Y-m-d') }}');
                @endif
                
            @endif

            @if(old('kandang_id'))
                countingDate('{{ old('kandang_id') }}');
            @endif


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

            function countingDate(kandangId, tanggal = null) {
                if (!tanggal) {
                    tanggal = $('#tanggal_sampling_ayam').val() || new Date().toISOString().split('T')[0];
                }
                
                let url = '/master-data/ajax/umur-ayam-by-kandang/' + kandangId;
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        tanggal: tanggal
                    },
                    success: function(response) {
                        $('input[name="usia_ayam_saat_ini"]').val(response.usia_ayam);
                        
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('input[name="usia_ayam_saat_ini"]').val(0);
                    }
                });
            }

            function countingAyamSehat(tanggal = new Date().toISOString().split('T')[0]) {

                let url = '/master-data/ajax/jumlah-ayam-sehat/' + tanggal;
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        $('input[name="jumlah_ayam_saat_ini"]').val(response.ayam_sehat);
                        
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('input[name="jumlah_ayam_saat_ini"]').val(0);
                    }
                });
            }


            $('#input-kandang-recording-telur').change(function() {
                const kandangId = $(this).val();
                const tanggal = $('#tanggal_sampling_ayam').val();
                countingDate(kandangId, tanggal);
            });

            $('#tanggal_sampling_ayam').change(function() {
                const startDate = $(this).val();
                countingAyamSehat(startDate);
                
                // Update jika kandang selected
                const kandangId = $('#input-kandang-recording-telur').val();
                if (kandangId && kandangId !== 'Pilih Kandang...') {
                    countingDate(kandangId, startDate);
                }
            });
        });
    </script>
@endpush