<div class="card">
    <div class="card-body">
        <x-adminlte-input
            type="date"
            label="Tanggal"
            name="tanggal"
            :value="old('tanggal', @$data->tanggal?->format('Y-m-d'))"
        />
    </div>
</div>