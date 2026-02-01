<div class="card">
    <div class="card-header">
        <h2 class="card-title">Form Sisa Pakan</h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table 
            class="table table-hover table-striped table-bordered text-center"
            x-data="{
                items: @js(old('items', $tables)),
                get totalSisaPakanKg() {
                    return Object.values(this.items).reduce((total, item) => total + Number(item.sisa_pakan_per_flock_kg), 0);
                }
            }"
        >
            <thead>
                <tr>
                    <th class="align-middle" style="width: 40px;">#</th>
                    <th class="align-middle" style="width: 200px;">Flock</th>
                    <th class="align-middle" style="width: 200px;">Jumlah Ayam</th>
                    <th class="align-middle" style="width: 100px;">Pemberian Pakan (kg)</th>
                    <th class="align-middle" style="width: 100px;">Pemberian Pakan Pagi (kg)</th>
                    <th class="align-middle" style="width: 100px;">Pemberian Pakan Sore (kg)</th>
                    <th class="align-middle" style="width: 200px;">Sisa Pakan (kg)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tables as $id => $row)
                    <tr x-data="{ flock_id: @js($id) }">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row['nama_flock'] }}</td>
                        <td class="text-right">{{ format_angka($row['jumlah_ayam']) }}</td>
                        <td class="text-right">{{ format_angka($row['pemberian_pakan_kg']) }}</td>
                        <td class="text-right">{{ format_angka($row['pemberian_pakan_pagi_kg']) }}</td>
                        <td class="text-right">{{ format_angka($row['pemberian_pakan_sore_kg']) }}</td>
                        <td class="text-right">
                            <input type="hidden" name="items[{{ $id }}][flock_id]" value="{{ $row['flock_id'] }}">
                            <input type="hidden" name="items[{{ $id }}][nama_flock]" value="{{ $row['nama_flock'] }}">
                            <input type="hidden" name="items[{{ $id }}][jumlah_ayam]" value="{{ $row['jumlah_ayam'] }}">
                            <input type="hidden" name="items[{{ $id }}][pemberian_pakan_kg]" value="{{ $row['pemberian_pakan_kg'] }}">
                            <input type="hidden" name="items[{{ $id }}][pemberian_pakan_pagi_kg]" value="{{ $row['pemberian_pakan_pagi_kg'] }}">
                            <input type="hidden" name="items[{{ $id }}][pemberian_pakan_sore_kg]" value="{{ $row['pemberian_pakan_sore_kg'] }}">
                            <input 
                                type="number"
                                class="form-control form-control-sm"
                                name="items[{{ $id }}][sisa_pakan_per_flock_kg]"
                                step=".1"
                                x-model="items[flock_id].sisa_pakan_per_flock_kg"
                            >
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-right">Total</th>
                    <th class="text-right">{{ format_angka($tables->sum('jumlah_ayam')) }}</th>
                    <th class="text-right">{{ format_angka($tables->sum('pemberian_pakan_kg')) }}</th>
                    <th class="text-right">{{ format_angka($tables->sum('pemberian_pakan_pagi_kg')) }}</th>
                    <th class="text-right">{{ format_angka($tables->sum('pemberian_pakan_sore_kg')) }}</th>
                    <th class="text-right" x-text="totalSisaPakanKg"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>