<div
    x-data="data"
>
    <div class="card">
        <div class="card-body">
            <x-adminlte-select2
                :config="[
                    'tags' => true,
                    'allowClear' => true,
                    'placeholder' => 'Pilih atau ketik baru', 
                ]"
                label="Asal Telur"
                name="telur_asal_id"
            >
                <x-adminlte-options
                    :options="$listAsalTelur"
                    :selected="old('telur_asal_id', @$data->telur_asal_id)"
                />
            </x-adminlte-select2>
            <x-adminlte-input
                type="date"
                label="Tanggal"
                name="tanggal"
                :value="old('tanggal', @$data->tanggal?->format('Y-m-d'))"
            />
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">List Telur Masuk</h2>
        </div>
            
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="min-width: 150px;">Jenis</th>
                        <th class="align-middle" style="min-width: 150px;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i => $item) 
                    <tr>
                        <td>
                            <input 
                                type="hidden" 
                                name="{{ "items[$i][id]" }}"
                                value="{{ @$item['id'] }}"
                            />
                            <input 
                                type="hidden" 
                                name="{{ "items[$i][telur_jenis_id]" }}"
                                value="{{ @$item['telur_jenis']['id'] }}"
                            />
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                name="tipe"
                                disabled="true"
                                value="{{ @$item['telur_jenis']['nama'] }}"
                            />
                        </td>
                        <td>
                            <x-adminlte-input
                                type="number"
                                class="form-control-sm"
                                fgroup-class="mb-0"
                                :name='"items[$i][jumlah]"'
                                :value='old("items.$i.jumlah", @$item["jumlah"])'
                                igroup-size="sm"
                            >
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-secondary">
                                        Butir
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>