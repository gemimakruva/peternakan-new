    <div class="mb-3">
        <x-adminlte-input 
            name="tanggal" 
            readonly
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
        <x-adminlte-select name="kandang_id" label="Pilih Kandang" igroup-size="md" id="kandang_id" 
            data-default="{{ @$data->pipe->flock->kandang->id }}">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-warehouse text-muted"></i>
                </div>
            </x-slot>

            <!-- Default value dari DB -->
            @if(@$data->pipe->flock->kandang)
                <option value="{{ @$data->pipe->flock->kandang->id }}" selected>
                    {{ @$data->pipe->flock->kandang->nama }}
                </option>
            @else
                <option value="">-- Pilih Kandang --</option>
            @endif
        </x-adminlte-select>
    </div>

    {{-- pilih flock  --}}
    <div class="mb-3">
    <x-adminlte-select name="flock_id" label="Pilih Flock" igroup-size="md" id="flock_id" 
        data-default="{{ @$data->pipe->flock->id }}">
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-feather text-muted"></i>
            </div>
        </x-slot>
        @if($data->pipe->flock)
            <option value="{{ $data->pipe->flock->id }}" selected>
                {{ $data->pipe->flock->nama }}
            </option>
        @else
            <option value="">-- Pilih Flock --</option>
        @endif
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
                <option value="">-- Pilih Flock --</option>
        </x-adminlte-select>
    </div>


        {{-- Jumlah Ayam per --}}
        {{-- @dd($data) --}}
        <div class="mb-3">
            <x-adminlte-input 
                name="jumlah_ayam" 
                label="Jumlah Ayam" 
                type="number" 
                igroup-size="md"
                value="{{ old('jumlah_ayam', @$data->jumlah_ayam_per_pipe) }}">
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
                 value="{{ old('jam_pemberian_pagi', isset($data->waktu_pemberian_pagi) 
            ? \Carbon\Carbon::parse($data->waktu_pemberian_pagi)->format('H:i') 
            : '07:00') }}"  
                min="05:00"
                max="09:30">
    
    <x-slot name="prependSlot">
        <div class="input-group-text bg-white">
            <i class="fas fa-clock text-muted"></i>
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
            value="{{ old('jam_pemberian_pagi', isset($data->waktu_pemberian_sore) 
                ? \Carbon\Carbon::parse($data->jam_pemberian_sore)->format('H:i') : '') }}"
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
$(document).ready(function () {
    // Ambil default value dari DB
    let defaultKandang = $('#kandang_id').data('default'); 
    let defaultFlock = '{{ @$data->pipe->flock->id }}';
    let defaultPipe = '{{ @$data->pipe->id }}';

    // Flag editMode: true = user belum ingin mengubah, false = user ingin memilih baru
    let editMode = true;

    // === Kandang ===
    $('#kandang_id').one('focus', function () {
        editMode = false; // User ingin mengubah
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
                            text: item.text,
                            selected: item.id == defaultKandang
                        })
                    );
                });
            }
        });
    });

    // === Flock cascade dari Kandang ===
    $('#kandang_id').on('change', function() {
        let kandangID = $(this).val();
        if (!kandangID) {
            $('#flock_id').html('<option value="">-- Pilih Kandang dulu --</option>');
            $('#pipe_id').html('<option value="">-- Pilih Baris dulu --</option>');
            return;
        }

        $('#flock_id').html('<option value="">Memuat data baris...</option>');

        $.ajax({
            url: '/master-data/ajax/flock/' + kandangID,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#flock_id').empty().append('<option value="">-- Pilih baris --</option>');
                $.each(response.results, function(index, flock) {
                    $('#flock_id').append(
                        $('<option>', { value: flock.id, text: flock.text })
                    );
                });
                defaultFlock = null; // hapus default karena user memilih baru
            },
            error: function(xhr) {
                $('#flock_id').html('<option value="">Gagal memuat data Flock</option>');
            }
        });
    });

    // === Pipe cascade dari Flock ===
    $('#flock_id').on('change', function() {
        let flockID = $(this).val();
        if (!flockID) {
            $('#pipe_id').html('<option value="">-- Pilih baris dulu --</option>');
            return;
        }

        $('#pipe_id').html('<option value="">Memuat data Pipe...</option>');

        $.ajax({
            url: '/master-data/ajax/pipe/' + flockID,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#pipe_id').empty().append('<option value="">-- Pilih Pipe --</option>');
                $.each(response.results, function(index, pipe) {
                    $('#pipe_id').append(
                        $('<option>', { value: pipe.id, text: pipe.text })
                    );
                });
                defaultPipe = null; // hapus default karena user memilih baru
            },
            error: function(xhr) {
                $('#pipe_id').html('<option value="">Gagal memuat data Pipe</option>');
            }
        });
    });

    // Set default value awal jika tidak ingin diubah
    if (defaultKandang) $('#kandang_id').append(`<option value="${defaultKandang}" selected>{{ @$data->pipe->flock->kandang->nama }}</option>`);
    if (defaultFlock) $('#flock_id').append(`<option value="${defaultFlock}" selected>{{ @$data->pipe->flock->nama }}</option>`);
    if (defaultPipe) $('#pipe_id').append(`<option value="${defaultPipe}" selected>{{ @$data->pipe->nama }}</option>`);
});
</script>


@endpush




