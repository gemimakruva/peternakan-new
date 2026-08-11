@extends('layouts.dashboard')

@section('title', 'Edit Populasi Ayam')

@section('content_header')
    <x-page-header title="Edit Populasi Ayam" :breadcrumbs="[
        'Populasi Ayam' => route('populasi-ayam-2.index'),
        'Edit' => null,
    ]" />
@endsection

@section('content')
<div
    class="mx-1200 page-create-populasi"
    x-data="data"
>
    @include('components.form-alert')

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <form
                action="{{ route('populasi-ayam-2.update', [request()->route('kandangId'), request()->route('tanggal')]) }}" 
                method="POST" 
                id="form-populasi-ayam"
            >
                @csrf
                @include('kandang::populasi-ayam-2.form_information')
                @include('kandang::populasi-ayam-2.form_table')
            </form>
        </div>

        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('populasi-ayam-2.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        @if ($isEditable)
                            <button id="btnSubmitPopulasi" type="submit" class="btn btn-primary flex-1" form="form-populasi-ayam">
                                Simpan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var items = @js(array_values(old('items', [])));
    var ayamPindah = @js($ayamPindah ?? []);

    document.addEventListener('alpine:init', () => {
        Alpine.data('data', () => ({
            kandang_id: @js($kandang->id),
            tanggal: @js(old('tanggal', request()->route('tanggal'))),
            total_ayam_sehat: 0,
            total_ayam_karantina: 0,
            umur_ayam: 0,

            controller: null,
            items,

            init() {
                this.$watch('tanggal', () => this.load());
                this.load();
            },

            async load() {
                if (!this.kandang_id || !this.tanggal) return;

                if (this.controller) this.controller.abort();
                this.controller = new AbortController();

                try {
                    const url = @js(route('ajax.kandang.record-populasi', ['_kandangId', '_tanggal']))
                        .replace('_kandangId', this.kandang_id)
                        .replace('_tanggal', this.tanggal);
                    const res   = await fetch(url, { signal: this.controller.signal });
                    const json  = await res.json();
                    if (!this.items.length) {
                        this.items = json.items.map(item => {
                            const pindahData = ayamPindah.filter(p => String(p.asal_pipe_id) === String(item.pipe.id));
                            if (pindahData.length > 0) {
                                item.pindah_ayam = [{
                                    pipe_tujuan_id: pindahData[0].tujuan_pipe_id,
                                    jumlah_perubahan: pindahData[0].jumlah_perubahan
                                }];
                                item.pindahJumlah = String(pindahData[0].jumlah_perubahan);
                            } else {
                                item.pindah_ayam = [];
                                item.pindahJumlah = '';
                            }
                            return item;
                        });
                    }
                    this.total_ayam_sehat       = json.info.total_ayam_sehat_terakhir;
                    this.total_ayam_karantina   = json.info.total_ayam_sakit_terakhir;
                    this.umur_ayam              = json.info.umur_ayam;
                } catch (e) {
                    if (e.name !== 'AbortError')
                        console.error('fetch gagal', e)
                }
            }
        }));
    })
</script>
@endsection
