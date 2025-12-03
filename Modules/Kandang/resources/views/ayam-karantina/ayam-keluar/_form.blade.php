{{-- Tanggal --}}
    <div class="mb-3">
        <x-adminlte-input 
            name="tanggal" 
            label="Tanggal Pencatatan" 
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

{{-- Pilih Kandang --}}
<div class="mb-3">
    <x-adminlte-select name="kandang_id" label="Pilih Asal Kandang " igroup-size="md" id="kandang">
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-home text-muted"></i>
            </div>
        </x-slot>
        

        <option value="">-- Pilih Kandang --</option>
    </x-adminlte-select>
</div>


{{-- Pilih Flock --}}
<div class="mb-3">
    <x-adminlte-select name="flock_id" label="Pilih Asal Baris" igroup-size="md" id="flock">
         <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-home text-muted"></i>
            </div>
        </x-slot>
        <option value="">-- Pilih Baris --</option>
    </x-adminlte-select>
</div>


{{-- Pilih Pipe --}}
<div class="mb-3">
    <x-adminlte-select name="pipe_id" label="Pilih Asal Pipa" igroup-size="md" id="pipe">
         <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-home text-muted"></i>
            </div>
        </x-slot>
        <option value="">-- Pilih Pipa --</option>
    </x-adminlte-select>
</div>

{{-- Input Jumlah Ayam --}}
<div class="mb-3">
    <x-adminlte-input 
        name="jumlah" 
        label="Jumlah Ayam" 
        type="number" 
        igroup-size="md"
        min="0"
        value="{{ old('jumlah', @$data->jumlah ?? 0) }}">
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-hashtag text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

{{-- Keterangan --}}
<div class="mb-3">
    <x-adminlte-textarea 
        name="keterangan" 
        label="Keterangan" 
        igroup-size="md" 
        placeholder="Masukkan keterangan..." 
        rows=5>
        {{ old('keterangan', @$data->keterangan ?? '') }}
        
        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-align-left text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-textarea>
</div>



@push('js')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
$(document).ready(function(){
    // Load Kandang saat page load
    $.ajax({
        url: '/master-data/ajax/kandang',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            $.each(data.results, function(index, kandang){
                $('#kandang').append(
                    $('<option>', { 
                        value: kandang.id, 
                        text: kandang.text 
                    })
                );
            });
        },
        error: function(xhr, status, error){
            console.log("Terjadi kesalahan: " + error);
        }
    });

    // Ketika pilih Kandang → load Flock
    $('#kandang').on('change', function(){
        var kandangId = $(this).val();
        $('#flock').html('<option value="">-- Pilih Flock --</option>');
        $('#pipe').html('<option value="">-- Pilih Pipe --</option>');

        if(kandangId){
            $.ajax({
                url: '/master-data/ajax/flock/' + kandangId,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $.each(data.results, function(i, flock){
                        $('#flock').append(
                            $('<option>', { 
                                value: flock.id, 
                                text: flock.text 
                            })
                        );
                    });
                },
                error: function(xhr, status, error){
                    console.log("Terjadi kesalahan: " + error);
                }
            });
        }
    });

    // Ketika pilih Flock → load Pipe
    $('#flock').on('change', function(){
        var flockId = $(this).val();
        $('#pipe').html('<option value="">-- Pilih Pipe --</option>');

        if(flockId){
            $.ajax({
                url: '/master-data/ajax/pipe/' + flockId,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $.each(data.results, function(i, pipe){
                        $('#pipe').append(
                            $('<option>', { 
                                value: pipe.id, 
                                text: pipe.text 
                            })
                        );
                    });
                },
                error: function(xhr, status, error){
                    console.log("Terjadi kesalahan: " + error);
                }
            });
        }
    });

});

</script>

@endpush