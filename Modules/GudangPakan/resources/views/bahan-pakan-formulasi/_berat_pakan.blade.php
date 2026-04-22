<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title">Berat Pakan (Kg)</h2>
            <button
                class="btn btn-primary btn-sm"
                type="button"
                x-on:click="addBeratPakan"
            >
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped table-bordered text-center mb-0">
            <tbody>
                <template x-for="(item, i) in list_berat_pakan">
                    <tr>
                        <td>
                            <input
                                type="hidden"
                                :name="`berat_pakan[${i}][id]`"
                                :value="item.id"
                            />
                            
                            <x-adminlte-input
                                type="number"
                                igroup-size="sm"
                                fgroup-class="mb-0"
                                name="berat_pakan"
                                x-bind:name="`berat_pakan[${i}][berat]`"
                                x-model="item.berat"
                            />
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" x-on:click="removeBeratPakan(i)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>