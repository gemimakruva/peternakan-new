<div
    x-data="pengadaan"
    x-init="
        $('#modalDistribusi').on('hidden.bs.modal', function() {
            cleanModalForm()
        });
        $('#modalDistribusi').on('shown.bs.modal', function() {
            if (summaryMasukKandang >= summary_ayam_datang) {
                Swal.fire({
                    title: `Tidak dapat mendistribusikan ayam!`,
                    text: `Semua ayam telah didistribusikan pada pipa.`,
                })
                $('#modalDistribusi').modal('hide');
            }
        });
    "
>
    <input type="hidden" name="distribusi_json" :value="JSON.stringify(distribusi)">

    <div class="card">
        <div class="card-body">
            <div class="row mb-4 p-2">
                {{-- Ayam Datang --}}
                <div class="col-md-4">
                    <div class="info-box">
                        <span style="width: 65px" class="info-box-icon bg-warning">
                            <i class="fas fa-truck"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ayam Datang</span>
                            <span class="info-box-number" x-text="summary_ayam_datang"></span>
                        </div>
                    </div>
                </div>

                {{-- Ayam Mati --}}
                <div class="col-md-4">
                    <div class="info-box">
                        <span style="width: 65px" class="info-box-icon bg-warning">
                            <i class="fas fa-skull"></i>
                        </span>
                        <div class="info-box-content">
                            <span style="font-size:15px" class="info-box-text">Ayam Mati</span>
                            <span class="info-box-number" x-text="summary_ayam_mati"></span>
                        </div>
                    </div>
                </div>

                {{-- Ayam Sakit --}}
                <div class="col-md-4">
                    <div class="info-box">
                        <span style="width: 65px" class="info-box-icon bg-warning">
                            <i class="fas fa-thermometer-half"></i>
                        </span>
                        <div class="info-box-content">
                            <span style="font-size:15px" class="info-box-text">Ayam Sakit</span>
                            <span class="info-box-number" x-text="summary_ayam_sakit"></span>
                        </div>
                    </div>
                </div>

                {{-- Ayam Masuk Kandang --}}
                <div class="col-md-4">
                    <div class="info-box">
                        <span style="width: 65px" class="info-box-icon bg-warning">
                            <i class="fas fa-warehouse"></i>
                        </span>
                        <div class="info-box-content">
                            <span style="font-size:15px" class="info-box-text">Masuk Kandang</span>
                            <span class="info-box-number" x-text="summaryMasukKandang"></span>
                        </div>
                    </div>
                </div>

                {{-- Ayam Belum Masuk Kandang --}}
                <div class="col-md-4">
                    <div class="info-box">
                        <span style="width: 65px" class="info-box-icon bg-warning">
                            <i class="fas fa-balance-scale"></i>
                        </span>
                        <div class="info-box-content">
                            <span style="font-size:15px" class="info-box-text">Sisa Ayam</span>
                            <span class="info-box-number" x-text="summarySisaAyam"></span>
                        </div>
                    </div>
                </div>

                {{-- Progress Pengisian Pipa --}}
                <div class="col-md-4">
                    <div class="info-box">
                        <span style="width: 65px" class="info-box-icon bg-warning">
                            <i class="fas fa-truck-loading"></i>
                        </span>
                        <div class="info-box-content">
                            <span style="font-size:15px" class="info-box-text">Pipa Terisi</span>
                            <span class="info-box-number" x-text="summaryPipaTerisi"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel data distribusi  --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-weight-bold">Data Distribusi Ayam</h5>
                <button type="button" data-toggle="modal" data-target="#modalDistribusi" class="btn btn-primary btn-sm" id="btnAddDistribusi">
                    Tambah Distribusi
                </button>
            </div>

            <div class="table-responsive">
                <table id="tableDistribusi" class="table table-bordered table-striped text-center align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Flock</th>
                            <th>Pipe</th>
                            <th>Jumlah Masuk</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(d, i) in distribusi">
                            <tr>
                                <td x-text="i+1"></td>
                                <td class="text-left" x-text="d.nama_flock"></td>
                                <td class="text-left"  x-text="d.nama_pipa"></td>
                                <td class="text-right"  x-text="d.jumlah_ayam"></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDistribusi" tabindex="-1" role="dialog" aria-labelledby="modalDistribusiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div 
                class="modal-content"
            >

                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="modalDistribusiLabel">Tambah Distribusi Ayam</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form id="formDistribusi">
                    <div class="modal-body">
                        <x-adminlte-input 
                            name="kandang_name"
                            label="Kandang"
                            :value="$pengadaanAyam->kandang->nama"
                            disabled
                        />

                        <x-adminlte-select 
                            id="flockSelect"
                            name="flock_id"
                            label="Flock"
                            x-model="selected_flock_id"
                            x-on:change="onFlockChange($event)"
                        >
                            <option selected value="">Pilih Flock...</option>
                            <template x-for="flock in flocksOptions">
                                <option
                                    x-text="flock.nama"
                                    :value="flock.id"
                                ></option>
                            </template>
                        </x-adminlte-select>

                        <x-adminlte-select
                            id="pipeSelect"
                            name="pipe_id"
                            label="Pipe"
                            x-model="selected_pipe_id"
                            x-bind:disabled="!selected_flock_id"
                            x-on:change="onPipeChange($event)"
                        >
                            <option selected value="">Pilih Pipe...</option>
                            <template x-for="pipe in pipesOptions">
                                <option
                                    x-text="`${pipe.nama} (Kapasitas: ${pipe.kapasitas})`"
                                    :value="pipe.id"
                                ></option>
                            </template>
                        </x-adminlte-select>

                        <x-adminlte-input
                            id="jumlah_ayam"
                            name="jumlah_ayam"
                            label="Jumlah Ayam"
                            type="number"
                            min="0"
                            placeholder="Input jumlah ayam..."
                            x-model="jumlah_ayam"
                            x-bind:disabled="!selected_pipe_id"
                            class="mb-0"
                            x-bind:class="{'border-danger': jumlah_ayam_error}"
                            x-on:input="onJumlahAyamInput($event)"
                        />
                        <template x-if="jumlah_ayam_error">
                            <p class="text-danger mb-0" x-text="jumlah_ayam_error"></p>
                        </template>
                    </div>

                    <div class="modal-footer">
                        <button 
                            type="button"
                            class="btn btn-secondary"
                            x-on:click="onBatalClick"
                        >
                            Batal
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            x-on:click="onSimpanClick"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        // mapping data pengadaan dari db
        const mappedData = @js([
            'pengadaan_ayam_id' => $pengadaanAyam->id,
            'summary_ayam_datang' => $pengadaanAyam->jumlah_ayam_datang,
            'summary_ayam_mati' => $pengadaanAyam->jumlah_ayam_mati,
            'summary_ayam_sakit' => $pengadaanAyam->jumlah_ayam_sakit,
            'list_flocks' => $pengadaanAyam->kandang->flocks->values(),
            'list_pipes' => [],
            'selected_pengadaan_ayam_id' => null,
            'selected_flock_id' => null,
            'selected_pipe_id' => null,
            'jumlah_ayam' => null,
            'jumlah_ayam_error' => null,
            'distribusi' => json_decode(old('distribusi_json') ?? @$pengadaanAyam?->distribusi_json ?? '[]'),
        ]);

        var pengadaan = {
            ...mappedData,
            get summaryMasukKandang() {
                return this.distribusi.reduce(function(total, item) {
                    return total += Number(item.jumlah_ayam);
                }, 0);
            },
            get summarySisaAyam() {
                return this.distribusi.reduce((total, item) => {
                    return this.summary_ayam_datang - this.summaryMasukKandang
                }, 0);
            },
            get summaryPipaTerisi() {
                const emptyPipe = this.list_flocks.reduce(function(total, item) {
                    return total + item.pipes.length
                }, 0)
                const filledPipe = this.distribusi.length
                return `${filledPipe}/${emptyPipe}`;
            },
            get flocksOptions() {
                const distributedPipeIds = this.distribusi.map((item) => Number(item.pipe_id));
                return this.list_flocks.filter(function(item) {
                    return item.pipes.filter(item2 => !distributedPipeIds.includes(item2.id)).length;
                });
            },
            get pipesOptions() {
                const distributedPipeIds = this.distribusi.map((item) => Number(item.pipe_id));
                return this.list_pipes.filter((item) => !distributedPipeIds.includes(item.id));
            },
            onFlockChange(e) {
                let flockId = e.target.value;
                if (flockId) {
                    let pipes = this.list_flocks.find((item) => item.id == flockId)?.pipes;
                    this.list_pipes = pipes;
                } else {
                    this.list_pipes = [];
                }
            },
            onPipeChange(e) {
                if (e.target.value) {
                    const kapasitasPipa = this.list_pipes.find((item) => item.id == Number(e.target.value))?.kapasitas
                    this.jumlah_ayam = kapasitasPipa;
                } else {
                    this.jumlah_ayam = null;
                }
            },
            onJumlahAyamInput(e) {
                let pipeId = this.selected_pipe_id;
                if (pipeId) {
                    const kapasitasPipa = this.list_pipes.find((item) => item.id == pipeId)?.kapasitas
                    if (this.jumlah_ayam > kapasitasPipa) {
                        this.jumlah_ayam_error = `Jumlah Ayam melebihi Kapasitas Pipa (${kapasitasPipa})`
                    } else {
                        this.jumlah_ayam_error = null;
                    }
                }
            },
            onSimpanClick() {
                if (this.jumlah_ayam_error) return;
                const nama_flock = this.list_flocks.find((item) => item.id == this.selected_flock_id)?.nama;
                const pipe = this.list_pipes.find((item) => item.id == this.selected_pipe_id)                
                const nama_pipa = pipe?.nama;
                this.distribusi.push({
                    id: this.selected_pengadaan_ayam_id,
                    pengadaan_ayam_id: this.pengadaan_ayam_id,
                    flock_id: this.selected_flock_id,
                    pipe_id: this.selected_pipe_id,
                    jumlah_ayam: this.jumlah_ayam,
                    is_editable: !!pipe?.is_editable,
                    nama_flock,
                    nama_pipa, 
                })
                $('#modalDistribusi').modal('hide');
            },
            onBatalClick() {
                $('#modalDistribusi').modal('hide');
            },
            cleanModalForm() {
                this.selected_flock_id = null;
                this.selected_pipe_id = null;
                this.selected_pengadaan_ayam_id = null;
                this.pengadaan_ayam_id = null;
                this.jumlah_ayam = null;
                this.jumlah_ayam_error = null;
            }
        }
    </script>
@endpush