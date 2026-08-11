@extends('layouts.dashboard')

@section('title', 'Tambah Populasi Ayam')

@section('content_header')
    <x-page-header title="Tambah Populasi Ayam" :breadcrumbs="[
        'Populasi Ayam' => route('populasi-ayam-2.index'),
        $kandang->nama => null,
        'Tambah' => null,
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
                        <button id="btnSubmitPopulasi" type="submit" class="btn btn-primary flex-1" form="form-populasi-ayam">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('data', () => ({
            kandang_id: @js($kandang->id),
            tanggal: @js(old('tanggal', request()->route('tanggal'))),
            total_ayam_sehat: 0,
            total_ayam_karantina: 0,
            umur_ayam: 0,

            controller: null, // buat cancel request lama (anti balapan)
            items: @js(old('items', [])),

            init() {
                this.$watch('tanggal', () => this.load());
                this.load();
            },

            async load() {
                if (!this.kandang_id || !this.tanggal) return;

                // cancel request sebelumnya
                if (this.controller) this.controller.abort();
                this.controller = new AbortController();

                try {
                    const url = @js(route('ajax.kandang.record-populasi', ['_kandangId', '_tanggal']))
                        .replace('_kandangId', this.kandang_id)
                        .replace('_tanggal', this.tanggal);
                    const res   = await fetch(url, { signal: this.controller.signal });
                    const json  = await res.json();
                    this.items  = json.items.map(item => {
                        item.pindah_ayam = [];
                        item.pindahJumlah = '';
                        return item;
                    });
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
