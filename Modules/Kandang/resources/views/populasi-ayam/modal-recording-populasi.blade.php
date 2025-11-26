<div class="modal fade" id="modalEditDistribusi" tabindex="-1" 
     aria-labelledby="modalEditDistribusiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formEditDistribusi" method="POST" action="">
            @csrf
            <input type="hidden" name="distribusi_id" id="distribusi_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDistribusiLabel">Edit Populasi Ayam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <x-adminlte-input type="number" name="ayam_sehat" id="ayam_sehat" label="Ayam Sehat" 
                            igroup-size="lg" class="form-control" placeholder="Masukkan jumlah ayam sehat" value="0">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-smile text-success"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input type="number" name="ayam_sakit" id="ayam_sakit" label="Ayam Sakit" 
                            igroup-size="lg" class="form-control" placeholder="Masukkan jumlah ayam sakit" value="0">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-frown text-warning"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input type="number" name="ayam_afkir" id="ayam_afkir" label="Ayam Afkir" 
                            igroup-size="lg" class="form-control" placeholder="Masukkan jumlah ayam afkir" value="0">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-times text-danger"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input type="number" name="ayam_masuk_karantina" id="ayam_masuk_karantina" 
                            label="Masuk Karantina" igroup-size="lg" class="form-control" 
                            placeholder="Jumlah ayam masuk karantina" value="0">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-arrow-down text-primary"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input type="number" name="ayam_keluar_karantina" id="ayam_keluar_karantina" 
                            label="Keluar Karantina" igroup-size="lg" class="form-control" 
                            placeholder="Jumlah ayam keluar karantina" value="0">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-white">
                                    <i class="fas fa-arrow-up text-primary"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
