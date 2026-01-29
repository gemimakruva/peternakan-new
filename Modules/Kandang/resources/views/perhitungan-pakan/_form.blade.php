    <div class="mb-3">
        <x-adminlte-input 
            name="tanggal" 
            label="Tanggal Pemberian Pakan" 
            type="date" 
            igroup-size="md"
            value="{{ old('tanggal', @$data->tanggal ?? 
            \Carbon\Carbon::now()->format('Y-m-d')) }}">
            
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-calendar-alt text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    {{-- pilih kandang --}}
    <div class="mb-3">
    <x-adminlte-select name="kandang_id" label="Pilih Kandang" igroup-size="md" id="kandang_id">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-warehouse text-muted"></i>
            </div>
        </x-slot>

        <option value="">-- Pilih Kandang --</option>
        {{-- opsi nanti akan diappend lewat ajax --}}
    </x-adminlte-select>
</div>

    {{-- pilih flock  --}}
    <div class="mb-3">
        <x-adminlte-select name="flock_id" label="Pilih Flock" igroup-size="md" id="flock_id">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-feather text-muted"></i>
                </div>
            </x-slot>

            <option value="">-- Pilih flock --</option>
            {{-- Opsi akan diisi lewat AJAX --}}
        </x-adminlte-select>
    </div>


     {{-- Pilih Pipe --}}
    <div class="mb-3">
        <x-adminlte-select name="pipe_id" id="pipe_id" label="Pilih Pipa" igroup-size="md">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-cogs text-muted"></i>
                </div>
            </x-slot>
                <option value="">-- Pilih Pipa --</option>
        </x-adminlte-select>
    </div>


        {{-- Jumlah Ayam per --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="jumlah_ayam" 
                label="Jumlah Ayam" 
                type="number" 
                igroup-size="md"
                value="{{ old('jumlah_ayam', @$data->jumlah_ayam) }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-drumstick-bite text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{-- Jumlah Pakan per Ekor (gram) --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="jumlah_pakan_per_ekor_gram" 
                label="Jumlah Pakan per Ekor (gram)" 
                type="number" 
                step="0.01"
                igroup-size="md"
                value="{{ old('jumlah_pakan_per_ekor_gram', @$data->jumlah_pakan_per_ekor_gram) }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-bread-slice text-muted"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>

        {{--  Proposi pemberian pakan + jenis pakan pagi --}}

        <div class="row mb-3">
            <div class="col-md-6">
                <x-adminlte-input 
                    name="proporsi_pemberian_pagi" 
                    label="Proporsi Pemberian Pagi (%)" 
                    type="number" 
                    step="0.01"
                    igroup-size="md"
                    value="{{ old('proporsi_pemberian_pagi',
                     @$data->proporsi_pemberian_pagi) }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-sun text-muted"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>

    {{-- Jenis Pakan --}}
        <div class="col-md-6">
            <x-adminlte-input 
                name="jam_pemberian_pagi" 
                label="Jam Pemberian Pagi (WIB)" 
                type="time" 
                igroup-size="md"
                value="{{ old('jam_pemberian_pagi',
                 @$data->jam_pemberian_pagi) }}"
                min="05:00"
                max="09:30">
                
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-clock text-muted"></i>
                    </div>
                </x-slot>

                <x-slot name="appendSlot">
                    <div class="input-group-text
                     bg-white font-bold text-sm">
                        WIB
                    </div>
                </x-slot>

            </x-adminlte-input>
        </div>

    </div>

     {{--  Proposi pemberian pakan + jenis pakan sore --}}

<div class="row mb-3">
    <div class="col-md-6">
        <x-adminlte-input 
            name="proporsi_pemberian_sore" 
            label="Proporsi Pemberian Sore" 
            type="number" 
            step="0.01"
            igroup-size="md"
            value="{{ old('proporsi_pemberian_sore', 
            @$data->proporsi_pemberian_sore) }}">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-cloud-moon text-secondary"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="col-md-6">
        <x-adminlte-input 
            name="jam_pemberian_sore" 
            label="Jam Pemberian Sore (WIB)" 
            type="time" 
            igroup-size="md"
            value="{{ old('jam_pemberian_sore',
             @$data->jam_pemberian_sore) }}"
            min="15:00"
            max="18:30">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-clock text-secondary"></i>
                </div>
            </x-slot>
            <x-slot name="appendSlot">
                <div class="input-group-text bg-white font-bold text-sm">
                    WIB
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>

</div>

{{-- jenis pakan --}}
<div class="mb-3">
    <x-adminlte-select name="jenis_pakan_id" label="Jenis Pakan" igroup-size="md">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-seedling text-muted"></i>
            </div>
        </x-slot>

        <option value="">-- Pilih Jenis Pakan --</option>
        @foreach($listJenisPakan as $pakan)
            <option value="{{ $pakan->id }}" 
                {{ old('jenis_pakan_id',
                 @$data->jenis_pakan_id) 
                == $pakan->id ? 'selected' : '' }}>
                {{ $pakan->nama }}
            </option>
        @endforeach
    </x-adminlte-select>
</div>

{{-- catatan --}}
<div class="mb-3">
    <x-adminlte-textarea 
        name="catatan" 
        label="Catatan" 
        igroup-size="md"
        rows="5"
        placeholder="Tulis catatan di sini...">
        
        {{ old('catatan', @$data->catatan) }}

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-sticky-note text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-textarea>
</div>

@push('js')
<script>
    $.ajax({
        url: '/master-data/ajax/kandang',
        type: 'GET',
        dataType: 'json',
        success: function(response){
            let select = $('#kandang_id');
            select.empty();
            select.append('<option value="">-- Pilih Kandang --</option>');

            $.each(response.results, function(index, item){
                select.append(
                    $('<option>', {
                        value: item.id,
                        text: item.text
                    })
                );
            });
            
            @if(old('kandang_id'))
                select.val('{{ old("kandang_id") }}').change();
            @endif
        },
        error: function(xhr){
            console.log("Error fetch kandang / ajax:", xhr);
        }
    });

    //  === Cascade functional flock ====
    $('#kandang_id').on('change', function() {
        let kandangID = $(this).val();
        if (!kandangID) {
            $('#flock_id').empty().append('<option value="">-- Pilih Kandang dulu --</option>');
        return;
        }
        $('#flock_id').empty().append('<option value="">Memuat data Flock...</option>');
    
        $.ajax({
        url: '/master-data/ajax/flock/' + kandangID, 
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#flock_id').empty().append('<option value="">-- Pilih BARIS --</option>');

            $.each(response.results, function(index, flock) {
                $('#flock_id').append(
                    $('<option>', {
                        value: flock.id,
                        text: flock.text
                    })
                );
            });

            @if(old('flock_id'))
                $('#flock_id').val('{{ old("flock_id") }}');
            @endif
        },
            error: function(xhr, status, error) {
                console.log("Gagal memuat data flock: " + error);
                $('#flock_id').empty().append('<option value="">Gagal memuat data flock</option>');
            }
        });
    });

       //  === Cascade functional pipe ====
    $('#flock_id').on('change', function() {
    let flockID = $(this).val();
    console.log(flockID);
    if (!flockID) {
            $('#pipe_id').empty().append('<option value="">-- Pilih Flock dulu --</option>');
        return;
        }
     $('#pipe_id').empty().append('<option value="">Memuat data pipa...</option>');  
     
       $.ajax({
        url: '/master-data/ajax/pipe/' + flockID,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#pipe_id').empty().append('<option value="">-- Pilih Pipa --</option>');
            $.each(response.results, function(index, pipe) {
                $('#pipe_id').append(
                    $('<option>', {
                        value: pipe.id,
                        text: pipe.text
                    })
                );
            });
            @if(old('pipe_id'))
                $('#pipe_id').val('{{ old("pipe_id") }}');
            @endif
        },
        error: function(xhr, status, error) {
            console.log("Gagal memuat data pipe: " + error);
            $('#pipe_id').empty().append('<option value="">Gagal memuat data pipa</option>');
        }
         });
    })

</script>

@endpush




