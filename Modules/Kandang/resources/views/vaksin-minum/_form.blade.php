<x-adminlte-input
    id="tanggal_vaksin_minum"
    type="date"
    name="tanggal"
    label="Tanggal Vaksin Minum"
    value="{{ old('tanggal', @$data->tanggal) }}"
    igroup-size="lg"
    fgroup-class="col-12"
    class="form-control-lg py-3"
>
    <x-slot name="prependSlot">
        <div class="input-group-text bg-white">
            <i class="fas fa-calendar-alt text-muted"></i>
        </div>
    </x-slot>
</x-adminlte-input>

<div class="form-group col-12">
    <x-adminlte-select id="input-kandang-vaksin-minum" name="kandang_id" label="Pilih Kandang" class="select-nama-berkas"
    igroup-size="lg">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
        <option selected disabled>Pilih Kandang...</option>
        @foreach ($kandangList as $kandang_id => $nama)
            <option value="{{ $kandang_id }}"
                {{ (old('kandang_id', @$data->flock->kandang->id ?? @$data->kandang_id) == $kandang_id) ? 'selected' : '' }}>
                {{ $nama }}
            </option>
        @endforeach
    </x-adminlte-select>
</div>

<div class="form-group col-12">
    <x-adminlte-select id="input-flock-vaksin-minum" name="flock_id" label="Pilih Baris" class="select-nama-berkas"
    igroup-size="lg">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather-alt text-muted"></i>
            </div>
        </x-slot>
        <option selected disabled>Pilih Baris...</option>
    </x-adminlte-select>
</div>


@push('js')
    <script>
        $(document).ready(function() {
            let kandangId = $('#input-kandang-vaksin-minum').val();
            populateDataBarisVaksinMinum ('input-flock-vaksin-minum', kandangId);

            $('#input-kandang-vaksin-minum').on('change', function() {
                let kandangId = $(this).val();
                populateDataBarisVaksinMinum ('input-flock-vaksin-minum', kandangId);
                populateJumlahAyamByKandang(kandangId, $('#tanggal_vaksin_minum').val());
            });


            function populateDataBarisVaksinMinum(elementId, kandangId) {
                let url = '/master-data/ajax/flock/' + kandangId;
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        barisData = response.results;
                        $(`#${elementId}`).empty();
                        $(`#${elementId}`).append('<option selected disabled>Pilih Baris...</option>');
                        $.each(response.results, function(index, item) {
                            $(`#${elementId}`).append('<option value="' + item.id + '">' + item.text + '</option>');
                        });
                        $(`#${elementId}`).prop('disabled', false);

                        @if(old('flock_id', @$data->flock_id))
                            $(`#${elementId}`).val('{{ old('flock_id', @$data->flock_id) }}');
                        @endif
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            @if(old('flock_id', @$data->flock_id))
                $(`#input-flock-vaksin-minum`).val('{{ old('flock_id', @$data->flock_id) }}');
            @endif

            function populateJumlahAyamByKandang(kandangId, tanggal) {
                let url = '/master-data/ajax/jumlah-ayam-per-kandang?kandang_id=' + kandangId + '&tanggal=' + tanggal;
                let method = 'GET';

                $.ajax({
                    url: url,
                    type: method,
                    success: function(response) {
                        let totalAyamPerKandang = response.jumlah_ayam;
                        let jumlahAyamPerBaris = $('#jumlah-ayam-per-baris-vaksin-minum').val();
                        let result = 0;
                        if (totalAyamPerKandang > 0) {
                            result = jumlahAyamPerBaris / totalAyamPerKandang * 1000;
                        }
                        $('#jumlah-ml-vaksin-per-baris').val(result);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        $('#jumlah-ml-vaksin-per-baris').val(0);
                    }
                });
            }

        });
    </script>
@endpush