<div
    x-data="{
        saldo: @js($latestInventory->saldo),
        realisasi: @js(old('opname', (@$data->telurInventory?->jumlah ?? 0) + $latestInventory->saldo)),
        get opname() {
            return Number(this.realisasi || 0) - Number(this.saldo || 0)
        },
    }"
>
    <div class="card">
        <div class="card-body">
            <x-adminlte-input
                type="number"
                label="Saldo Telur Sistem"
                name="saldo_telur_sistem"
                x-model="saldo"
                :readonly="true"
                :disabled="true"
            />

            <x-adminlte-input
                type="number"
                label="Realisasi"
                name="realisasi"
                x-model="realisasi"
            />

            <x-adminlte-input
                type="number"
                label="Opname"
                name="opname"
                x-model="opname"
                :readonly="true"
            />

            <x-adminlte-input
                type="date"
                label="Tanggal"
                name="tanggal"
                :value="old('tanggal', @$data->tanggal?->format('Y-m-d'))"
            />
        </div>
    </div>
</div>