<x-adminlte-input
    id="tanggal_vaksin_minum"
    type="date"
    name="tanggal"
    label="Tanggal Vaksin Minum"
    value="{{ old('tanggal', @$data->tanggal) }}"
/>

<x-adminlte-select 
    id="kandang_id"
    name="kandang_id"
    label="Pilih Kandang"
>
    <x-adminlte-options
        :options="$listKandang"
        empty-option="Pilih Kandang"
        :selected="old('kandang_id', @$data->flock->kandang_id)"
    />
</x-adminlte-select>

<x-adminlte-select
    id="flock_id"
    name="flock_id"
    label="Pilih Flock"
>
    <option selected disabled>Pilih Flock...</option>
</x-adminlte-select>

@push('js')
    <script>
        $(document).ready(function() {
            let kandangId = $('#kandang_id').val();
            let flockId = @js(old('flock_id', @$data->flock_id) ?? '');
            let tanggal = $('#tanggal_vaksin_minum').val();

            function populateDataFlockVaksinMinum(elementId, kandangId) {
                let url = @js(route('ajax.flock', ':kandangId')).replace(':kandangId', kandangId);
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        flockData = response.results;
                        $(`#${elementId}`).empty();
                        $(`#${elementId}`).append('<option selected disabled>Pilih Flock...</option>');
                        $.each(response.results, function(index, item) {
                            $(`#${elementId}`).append('<option value="' + item.id + '">' + item.text + '</option>');
                        });
                        $(`#${elementId}`).prop('disabled', false);

                        if (flockId) {
                            $(`#${elementId}`).val(flockId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function populateJumlahAyamByKandang(kandangId, tanggal) {
                if (!kandangId || !tanggal) return;

                let url = @js(route('ajax.populasi-by-kandang', [':kandangId', ':tanggal']))
                    .replace(':kandangId', kandangId)
                    .replace(':tanggal', tanggal);
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        let totalAyamPerKandang = Number(response.total_ayam_sehat_terakhir);
                        let jumlahAyamPerFlock = Number($('#jumlah-ayam-per-flock-vaksin-minum').val());
                        let result = 0;
                        console.log({ totalAyamPerKandang, jumlahAyamPerFlock });
                        
                        if (totalAyamPerKandang > 0) {
                            result = jumlahAyamPerFlock / totalAyamPerKandang * 1000;
                        }
                        $('#jumlah-ml-vaksin-per-flock').val(result);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#jumlah-ml-vaksin-per-flock').val(0);
                    }
                });
            }

            function countingAyamSehatVaksinMinum(flockId, tanggal) {
                console.log({ a: 'countingAyamSehatVaksinMinum', flockId, flockId, tanggal });

                let url = @js(route('ajax.populasi-by-flock', [':flockId', ':tanggal']))
                    .replace(':flockId', flockId)
                    .replace(':tanggal', tanggal);

                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {              
                        $('#jumlah-ayam-per-flock-vaksin-minum').val(Number(response.total_ayam_sehat_terakhir));
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#jumlah-ayam-per-flock-vaksin-minum').val(0);
                    }
                });
            }

            if (kandangId) {
                populateDataFlockVaksinMinum ('flock_id', kandangId);
            }

            if (flockId && tanggal) {
                countingAyamSehatVaksinMinum(flockId, tanggal)
            }

            $('#tanggal_vaksin_minum').on('change', function() {
                tanggal = $(this).val();                
                if (!flockId || !tanggal) return;
                countingAyamSehatVaksinMinum(flockId, tanggal);
                if (!kandangId || !tanggal) return;
                populateJumlahAyamByKandang(kandangId, tanggal);
            }); 

            $('#kandang_id').on('change', function() {
                kandangId = $(this).val();
                if (!kandangId || !tanggal) return;
                populateDataFlockVaksinMinum ('flock_id', kandangId);
                populateJumlahAyamByKandang(kandangId, tanggal);
            });

            $('#flock_id').on('change', function() {
                flockId = $(this).val();
                if (!flockId || !tanggal) return;
                countingAyamSehatVaksinMinum(flockId, tanggal);
                if (!kandangId || !tanggal) return;
                populateJumlahAyamByKandang(kandangId, tanggal);
            });
        });
    </script>
@endpush