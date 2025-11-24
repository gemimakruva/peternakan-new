<div class="card shadow-sm border-0">
   <div class="card-header bg-light d-flex  justify-content-between align-items-center">
        {{-- Judul --}}
        <h5 class="card-title m-0 text-secondary fw-semibold flex-1">
            <i class="fas fa-clipboard-list text-muted me-2"></i> Input Distribusi
        </h5>

        {{-- Button Add --}}
        <button type="button" id="addRowBtn" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Input
        </button>

    </div>
    {{-- Dinamis ketika akan di klik tombol addRowBtn --}}
    <div class="card-body pt-4 shadow"
     id="dynamicPipeContainer">
         <div class="row">
            {{-- pilih Kandang dan Flock--}}
               <div class="col-md-6">
                    <x-adminlte-select
                        name="kandang_id"
                        label="Kandang"
                        igroup-size="lg"
                        class="form-control form-control-lg py-3">

                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-white">
                                <i class="fas fa-warehouse text-muted"></i>
                            </div>
                        </x-slot>

                        <option value="" disabled selected>Pilih Kandang...</option>
                        <option value="1">Kandang A</option>
                        <option value="2">Kandang B</option>
                        <option value="3">Kandang C</option>
                        <option value="4">Kandang D</option>

                    </x-adminlte-select>
               </div>

             {{-- pilih pipe dan jumlah --}}
              <div class="col-md-6">
                <x-adminlte-select
                    name="flock_id"
                    label="Flock"
                    igroup-size="lg"
                    class="form-control form-control-lg py-3">

                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-feather-alt text-muted"></i>
                        </div>
                    </x-slot>

                    <option value="" disabled selected>Pilih Flock...</option>
                    <option value="F001">Flock 001</option>
                    <option value="F002">Flock 002</option>
                    <option value="F003">Flock 003</option>
                    <option value="F004">Flock 004</option>

                </x-adminlte-select>
              </div>
         </div>
          {{-- pilih Pipe--}}
         <div class="mb-4 row"> 
            <div class="col-md-6">
                <x-adminlte-select
                    name="pipe_id"
                    label="Pipe"
                    igroup-size="lg"
                    class="form-control form-control-lg py-3">

                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-tint text-muted"></i>
                        </div>
                    </x-slot>

                    {{-- Dummy Data Pipe --}}
                    <option value="" disabled selected>Pilih Pipe...</option>
                    <option value="P001">Pipe 001</option>
                    <option value="P002">Pipe 002</option>
                    <option value="P003">Pipe 003</option>
                    <option value="P004">Pipe 004</option>

                </x-adminlte-select>
            </div>

                {{-- Jumlah Ayam --}}
                <div class="col-md-6">
                    <x-adminlte-input
                        name="jumlah_ayam"
                        label="Jumlah_ayam"
                        type="number"
                        placeholder="Input Jumlah Ayam ..."
                        igroup-size="lg"
                        class="form-control form-control-lg py-3">

                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-white">
                            <i class="fas fa-drumstick-bite text-muted"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
         </div>
    </div>
    <div id="dynamicCardContainer"></div>
</div>
@push('js')
<script>
    let index = 0;

    $("#addRowBtn").on("click", function () {
        index++;

        let card = `
        <div class="input-card border p-3 rounded mt-4" id="row-${index}">
            <!-- Nomor Distribusi Dinamis -->
            <h6 class="fw-bold text-primary mb-3">
                Distribusi ke – ${index}
            </h6>

            <div class="row">
                <div class="col-md-6">
                    <label>Kandang</label>
                    <select name="kandang_id[]" class="form-control form-control-lg py-3">
                        <option value="" disabled selected>Pilih Kandang...</option>
                        <option value="1">Kandang A</option>
                        <option value="2">Kandang B</option>
                        <option value="3">Kandang C</option>
                        <option value="4">Kandang D</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Flock</label>
                    <select name="flock_id[]" class="form-control form-control-lg py-3">
                        <option value="" disabled selected>Pilih Flock...</option>
                        <option value="F001">Flock 001</option>
                        <option value="F002">Flock 002</option>
                        <option value="F003">Flock 003</option>
                        <option value="F004">Flock 004</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3 align-items-end">
                <div class="col-md-6">
                    <label>Pipe</label>
                    <select name="pipe_id[]" class="form-control form-control-lg py-3">
                        <option value="" disabled selected>Pilih Pipe...</option>
                        <option value="P001">Pipe 001</option>
                        <option value="P002">Pipe 002</option>
                        <option value="P003">Pipe 003</option>
                        <option value="P004">Pipe 004</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <label>Jumlah Ayam</label>
                    <input type="number" name="jumlah_ayam[]" class="form-control form-control-lg py-3"
                        placeholder="Input Jumlah Ayam...">
                </div>

                <div class="col-md-1 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger btn-sm removeRowBtn"
                            data-id="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
`;

        $("#dynamicCardContainer").append(card);
    });

    // Delete card row
    $(document).on("click", ".removeRowBtn", function () {
        const id = $(this).data("id");
        $("#row-" + id).remove();
    });
</script>
@endpush


