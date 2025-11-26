<input type="hidden" name="populasi_record" id="populasi_record">
<div>
    <div class="mb-4">
    <x-adminlte-select 
        name="pengadaan_ayam_id_disabled"
        label="Pengadaan Ayam"
        igroup-size="lg"
        fgroup-class="col-12"
        class="form-control form-control-lg py-3"
        disabled>

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-clipboard-list text-muted"></i>
            </div>
        </x-slot>

        <option value="{{ $DataPengadaanAyam->id }}">
            {{ \Carbon\Carbon::parse($DataPengadaanAyam->tanggal)
                ->translatedFormat('l, d F Y') }}
        </option>
    </x-adminlte-select>

    <input type="hidden" name="pengadaan_ayam_id" value="{{ $DataPengadaanAyam->id }}">
</div>



    <div class="mb-4">
            <x-adminlte-select 
                name="jenis_pemeriksaan" 
                label="Jenis Pemeriksaan" 
                igroup-size="lg" 
                fgroup-class="col-12"
                class="form-control form-control-lg py-3">

                <x-slot name="prependSlot">
                    <div class="input-group-text bg-white">
                        <i class="fas fa-stethoscope text-muted"></i>
                    </div>
                </x-slot>

                <option value="">-- Pilih Jenis Pemeriksaan --</option>
                <option value="Sehat">Recording Harian</option>
                <option value="Sakit Ringan">Pemeriksaan Kesehatan</option>
            </x-adminlte-select>
    </div>

{{-- Input Tanggal Pencatatan --}}
    <div class="mb-4">
        <x-adminlte-input 
            name="tanggal_pencatatan" 
            label="Tanggal Pencatatan" 
            type="date" 
            igroup-size="lg" 
            fgroup-class="col-12" 
            class="form-control form-control-lg py-3"
            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            
            <x-slot name="prependSlot">
                <div class="input-group-text bg-white">
                    <i class="fas fa-calendar-alt text-muted"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>

    {{-- Catatan --}}
    <div class="mb-4">
    <x-adminlte-textarea 
        name="catatan"
        label="Catatan"
        placeholder="Masukkan catatan tambahan (opsional)"
        igroup-size="lg"
        fgroup-class="col-12"
        class="form-control form-control-lg py-3"
        rows="3">

        <x-slot name="prependSlot">
            <div class="input-group-text bg-white">
                <i class="fas fa-sticky-note text-muted"></i>
            </div>
        </x-slot>
    </x-adminlte-textarea>
</div>

</div>

{{--  ===================== TABEL KANDANG || FLOCK || PIPE  ==========================--}}
    <div class="mb-4">
        <div class="text-center py-3">
            <h5 class="font-weight-bold text-center">Data Distribusi Ayam</h5>
        </div>

        <table id="tableDistribusi" class="table table-bordered table-striped text-center align-middle">
            <thead class="bg-secondary text-white">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Kandang</th>
                    <th>Flock</th>
                    <th>Pipe</th>
                    <th>Jumlah</th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($DataPengadaanAyam->distribusi as $index => $distribusi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $distribusi->kandang->nama ?? '-' }}</td>
                        <td>{{ $distribusi->flock->nama ?? '-' }}</td>
                        <td>{{ $distribusi->pipe->nama ?? '-' }}</td>
                        <td>{{ $distribusi->jumlah_ayam ?? 0 }}</td>
                        <td>
                            <button 
                                    type="button"
                                    class="btn btn-warning btnEditDistribusi"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    data-id="{{ $distribusi->id }}"
                                    data-kandang_id="{{ $distribusi->kandang->id }}"
                                    data-flock_id="{{ $distribusi->flock->id }}"
                                    data-pipe_id="{{ $distribusi->pipe->id }}"
                                    data-ayam_sehat="{{ $distribusi->jumlah_ayam }}"
                                >
                                    <i class="fas fa-edit"></i> Record
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

{{-- ==============================  MODAL RECORDING HARIAN ================================== --}}

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <input type="hidden"  id="kandang_id">
        <input type="hidden"  id="flock_id">
        <input type="hidden"  id="pipe_id">
        
        {{-- Kandang --}}
        <div class="modal-header">
            <h3 class="modal-title fs-5 text-center" id="exampleModalLabel">Input Data Populasi Ayam</h3>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="modal-body">
                    <div class="modal-body">
                        {{-- ayam sehat --}}
                        <div class="mb-3">
                            <x-adminlte-input type="number" name="ayam_sehat" id="ayam_sehat" 
                                label="Ayam Sehat" igroup-size="lg" placeholder="Masukkan jumlah ayam sehat" value="0">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-white">
                                        <i class="fas fa-drumstick-bite text-muted"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        {{-- ayam sakit  --}}
                         <div class="mb-3">
                            <x-adminlte-input type="number" name="ayam_sakit" id="ayam_sakit" 
                                label="Ayam Sakit" igroup-size="lg" placeholder="Masukkan jumlah ayam sakit" value="0">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-white">
                                        <i class="fas fa-thermometer-half text-muted"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        {{-- ayam mati --}}
                         <div class="mb-3">
                            <x-adminlte-input type="number" name="ayam_sakit" id="ayam_mati" 
                                label="Ayam Mati" igroup-size="lg" placeholder="Masukkan jumlah ayam mati" value="0">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-white">
                                       <i class="fas fa-skull-crossbones text-muted"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        {{-- ayam afkir --}}
                        <div class="mb-3">
                            <x-adminlte-input type="number" name="ayam_afkir" id="ayam_afkir" 
                                label="Ayam Afkir" igroup-size="lg" placeholder="Masukkan jumlah ayam afkir" value="0">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-white">
                                        <i class="fas fa-times-circle text-muted"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        {{-- ayam masuk karantina --}}

                        <div class="mb-3">
                            <x-adminlte-input type="number" name="ayam_masuk_karantina" id="ayam_masuk_karantina" 
                                label="Masuk Karantina" igroup-size="lg" placeholder="Jumlah ayam masuk karantina" 
                                value="0">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-white">
                                        <i class="fas fa-door-closed text-muted"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        {{-- ayam keluar karantina --}}

                        <div class="mb-3">
                            <x-adminlte-input type="number" name="ayam_keluar_karantina" id="ayam_keluar_karantina" 
                                label="Keluar Karantina" igroup-size="lg" placeholder="Jumlah ayam keluar karantina" 
                                value="0">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-white">
                                        <i class="fas fa-door-open text-muted"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    </div>
        </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnSavePopulasi" class="btn btn-success">Save Population </button>
      </div>
    </div>
  </div>
</div>


@push('js')
<script>

    // Set Default value modal
$(document).on('click', '.btnEditDistribusi', function () {
    $('#distribusi_id').val($(this).data('id'));
    $('#kandang_id').val($(this).data('kandang_id'));
    $('#flock_id').val($(this).data('flock_id'));
    $('#pipe_id').val($(this).data('pipe_id'));
    $('#ayam_sehat').val($(this).data('ayam_sehat'));
});

// Ubah Input form modal menjadi Request
let recordPopulasi = [];

$('#btnSavePopulasi').click(function () {
    const data = {
        distribusi_id: $('#distribusi_id').val(),
        ayam_sehat: $('#ayam_sehat').val(),
        ayam_sakit: $('#ayam_sakit').val(),
        ayam_mati: $('#ayam_mati').val(),
        ayam_afkir: $('#ayam_afkir').val(),
        ayam_masuk_karantina: $('#ayam_masuk_karantina').val(),
        ayam_keluar_karantina: $('#ayam_keluar_karantina').val(),
        kandang_id: $('#kandang_id').val(),
        flock_id: $('#flock_id').val(),
        pipe_id: $('#pipe_id').val(),
    };

    recordPopulasi.push(data);
 
    $('#populasi_record').val(JSON.stringify(recordPopulasi));
    $('#exampleModal').modal('hide');
    // refresh
        $('#distribusi_id').val('');
        $('#kandang_id').val('');
        $('#flock_id').val('');
        $('#pipe_id').val('');

        $('#ayam_sehat').val(0);
        $('#ayam_sakit').val(0);
        $('#ayam_afkir').val(0);
        $('#ayam_masuk_karantina').val(0);
        $('#ayam_keluar_karantina').val(0);
});

$('#btnSubmitPopulasi').on('click', function () {
    $(this).closest('form').trigger('submit');
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush