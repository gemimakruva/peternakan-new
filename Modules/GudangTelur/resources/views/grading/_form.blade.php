<div class="card">
    <div class="card-body">
        <x-adminlte-select
            label="Kandang"
            name="kandang_id"
        >
            <x-adminlte-options
                :options="$listKandang"
                empty-option="Pilih Kandang"
                :selected="@$data->kandang_id"
            />
        </x-adminlte-select>

        <x-adminlte-input
            type="date"
            label="Tanggal"
            name="tanggal"
            :value="@$data->tanggal?->format('Y-m-d')"
        />

        @foreach ($listGrading as $id => $label)
            @php
                $jumlah = @$data->telurGradingItems?->first(fn($item) => $item->telur_jenis_id == $id)?->jumlah;
            @endphp
            <x-adminlte-input
                type="hidden"
                :name='"grading[$loop->index][id]"'
                :value="$id"
                fgroup-class="mb-0"
            />
            <x-adminlte-input
                type="hidden"
                :name='"grading[$loop->index][telur_jenis_id]"'
                :value="$id"
                fgroup-class="mb-0"
            />
            <x-adminlte-input
                type="number"
                :label="$label"
                :name='"grading[$loop->index][jumlah]"'
                :value="$jumlah"
            />
        @endforeach
    </div>
</div>