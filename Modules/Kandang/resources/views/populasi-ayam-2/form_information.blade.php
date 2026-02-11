<div class="card">
    <div class="card-header">
        <h2 class="card-title">Kandang</h2>
    </div>
    <div class="card-body row">
        <x-adminlte-input
            label="Kandang"
            name="nama_kandang"
            :value="$kandang->nama"
            fgroup-class="col-6"
            readonly
        />
        <x-adminlte-input
            type="date"
            label="Tanggal"
            name="tanggal"
            x-model="tanggal"
            fgroup-class="col-6"
        />
        <x-adminlte-input
            type="numeric"
            label="Total Ayam Sehat"
            name="total_ayam_sehat"
            x-model="total_ayam_sehat"
            fgroup-class="col-6"
            readonly
        />
        <x-adminlte-input
            type="numeric"
            label="Total Ayam Karantina"
            name="total_ayam_karantina"
            x-model="total_ayam_karantina"
            fgroup-class="col-6"
            readonly
        />
        <x-adminlte-input
            type="numeric"
            label="Umur Ayam"
            name="umur_ayam"
            x-model="umur_ayam"
            fgroup-class="col-6"
            readonly
        />
    </div>
</div>