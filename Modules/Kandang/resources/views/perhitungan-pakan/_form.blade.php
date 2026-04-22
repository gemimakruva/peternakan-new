<x-adminlte-input 
    name="tanggal_pemberian_pakan" 
    label="Tanggal Pemberian Pakan" 
    type="date"
    value="{{ old('tanggal_pemberian_pakan', @$data->tanggal_pemberian_pakan?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
    :readonly="$readonly"
/>

<x-adminlte-select 
    name="kandang_id"
    label="Pilih Kandang"
    :readonly="@$data->kandang_id"
    :disabled="@$data->kandang_id"
    :readonly="$readonly"
>
    <option value="" @selected(!old('kandang_id', @$data->kandang_id))>-- Pilih Kandang --</option>
    @foreach ($listKandang as $id => $name)
        <option value="{{ $id }}" @selected(old('kandang_id', @$data->kandang_id) == $id)>{{ $name }}</option>
    @endforeach
</x-adminlte-select>

<x-adminlte-select 
    name="jenis_pakan_id"
    label="Jenis Pakan"
    :readonly="$readonly"
>
    <option value="" @selected(!old('jenis_pakan_id', @$data->jenis_pakan_id))>-- Pilih Jenis Pakan --</option>
    @foreach($listJenisPakan as $id => $nama)
        <option value="{{ $id }}" @selected(old('jenis_pakan_id', @$data->jenis_pakan_id) == $id)>
            {{ $nama }}
        </option>
    @endforeach
</x-adminlte-select>

<div class="row">
    <div class="col-md-6">
        <x-adminlte-input 
            name="proporsi_pemberian_pagi" 
            label="Proporsi Pemberian Pagi (%)" 
            type="number" 
            step="1"
            value="{{ old('proporsi_pemberian_pagi', @$data->proporsi_pemberian_pagi) }}"
            :readonly="$readonly"
        />
    </div>
    <div class="col-md-6">
        <x-adminlte-input 
            name="waktu_pemberian_pagi" 
            label="Jam Pemberian Pagi (WIB)" 
            type="time" 
            value="{{ old('waktu_pemberian_pagi', @$data->waktu_pemberian_pagi) }}"
            :readonly="$readonly"
        >
            <x-slot name="appendSlot">
                <div class="input-group-text bg-white font-bold text-sm">
                    WIB
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="col-md-6">
        <x-adminlte-input 
            name="proporsi_pemberian_sore" 
            label="Proporsi Pemberian Sore (%)"
            type="number" 
            step="1"
            value="{{ old('proporsi_pemberian_sore', @$data->proporsi_pemberian_sore) }}"
            :readonly="$readonly"
        />
    </div>
    <div class="col-md-6">
        <x-adminlte-input 
            name="waktu_pemberian_sore" 
            label="Jam Pemberian Sore (WIB)" 
            type="time"
            value="{{ old('waktu_pemberian_sore', @$data->waktu_pemberian_sore) }}"
            :readonly="$readonly"
        >
            <x-slot name="appendSlot">
                <div class="input-group-text bg-white font-bold text-sm">
                    WIB
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
</div>

<x-adminlte-select 
    name="user_executor_id"
    label="Pelaksana"
    :disabled="$readonly"
    :readonly="$readonly"
>
    <option value="" @selected(!old('user_executor_id', @$data->user_executor_id))>-- Pilih Pelaksana --</option>
    @foreach($listUser as $id => $nama)
        <option value="{{ $id }}" @selected(old('user_executor_id', @$data->user_executor_id) == $id)>
            {{ $nama }}
        </option>
    @endforeach
</x-adminlte-select>

<x-adminlte-textarea 
    name="catatan" 
    label="Catatan"
    rows="5"
    placeholder="Tulis catatan di sini..."
    :readonly="$readonly"
>{{ old('catatan', @$data->catatan) }}</x-adminlte-textarea>
