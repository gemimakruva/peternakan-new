<h2 class="h4">Filter</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route($routeName) }}" class="row">
            <x-adminlte-input
                name="tanggal"
                label="Tanggal"
                type="date"
                :value="$tanggal->format('Y-m-d')"
                fgroup-class="mb-0 col-12 col-lg-3"
            />

            <x-adminlte-select
                name="kandang_id"
                label="Kandang"
                fgroup-class="mb-0 col-12 col-lg-3"
            >
                <x-adminlte-options
                    :options="$listKandang"
                    empty-option="Semua Kandang"
                    :selected="@$kandang?->id"
                />
            </x-adminlte-select>

            @if (@$umurAyam)
                <x-adminlte-input
                    name="umur_ayam"
                    label="Umur Ayam"
                    :value="$umurAyam"
                    fgroup-class="mb-0 col-12 col-lg-3"
                    readonly
                />  
            @endif

            <div class="col-12 col-lg-3 d-flex gap-2 justify-content-end justify-content-lg-start align-items-end">
                <button class="btn btn-primary mt-2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>