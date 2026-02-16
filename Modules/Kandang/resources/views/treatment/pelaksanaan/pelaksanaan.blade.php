@extends('layouts.dashboard')

@section('title', 'Pelaksanaan Treatment')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pelaksanaan Treatment</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('treatment-pelaksanaan.index') }}">
                            Pelaksanaan Treatment
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('treatment-pelaksanaan.jadwal', [$data->id_kandang, $data->bulan]) }}">
                            {{ $data->nama_kandang }} - {{ $data->nama_bulan }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Pelaksanaan</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-1200 page-pelaksanaan">
    <x-form-alert />

    <form 
        class="row"
        action="{{ route('treatment-pelaksanaan.jadwal.pelaksanaan.store', [$data->id_kandang, $data->bulan, $jadwal->id]) }}"
        method="post"
    >
        @csrf
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="wrapper">
                        <div class="item">
                            <div class="label">Kandang</div>
                            <div class="value">: {{ $jadwal->treatment->kandang->nama }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Tanggal</div>
                            <div class="value">: {{ $jadwal->treatment->tanggal->translatedFormat('l, d F Y') }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Waktu</div>
                            <div class="value">: {{ $jadwal->waktu->format('H:i') }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Jenis Treatment</div>
                            <div class="value">: {{ $jadwal->jenisTreatment->nama }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Metode Treatment</div>
                            <div class="value">: {{ $jadwal->metodeTreatment->nama }}</div>
                        </div>
                    </div>
                    <div class="wrapper">
                        <div class="item">
                            <div class="label">Merk OVK</div>
                            <div class="value">: {{ $jadwal->merk_ovk }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Area</div>
                            <div class="value">: {{ $jadwal->area }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Dosis</div>
                            <div class="value">: {{ $jadwal->dosis }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Dilaksanakan Pada</div>
                            <div class="value">: {{ $jadwal->executed_at?->translatedFormat('l, d F Y') }}</div>
                        </div>
                        <div class="item">
                            <div class="label">Dilaksanakan Oleh</div>
                            <div class="value">: {{ $jadwal->executedBy?->name }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($flocks) > 0)
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title mb-0">Flock</h2>
                            <p class="mb-0">(tandai flock yang sudah selesai)</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div 
                            x-data="{
                                flocks: @js($flocks),
                                toggle(flock) {
                                    flock.checked = !flock.checked;
                                }
                            }"
                            class="flocks"
                        >
                            {{-- <pre x-text="JSON.stringify(flocks, 2, 2)"></pre> --}}
                            <template x-for="flock in flocks">
                                <div class="flock" :class="{ active: flock.checked }" x-on:click="toggle(flock)">
                                    <input
                                        type="hidden"
                                        :name="`flocks[${flock.id}]`" 
                                        x-model="flock.checked"
                                    />
                                    <span x-text="flock.nama"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header sticy-form-action">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="d-flex w-100 gap-2 mb-2">
                            <button
                                class="btn btn-danger flex-1"
                                type="submit"
                                name="eksekusi"
                                value="belum_selesai"
                            >
                                Belum Selesai
                            </button>
                            <button
                                class="btn btn-primary flex-1"
                                type="submit"
                                name="eksekusi"
                                value="tandai_selesai"
                            >
                                Tandai Selesai
                            </button>
                        </div>
                        <a 
                            href="{{ route('treatment-pelaksanaan.jadwal', [$data->id_kandang, $data->bulan]) }}" 
                            class="btn btn-secondary w-100"
                        >
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .page-pelaksanaan .flocks {
        width: 100%;
        gap: 1rem;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }
    @media (max-width: 999px) {
        .page-pelaksanaan .flocks {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .page-pelaksanaan .flocks .flock {
        color: white;
        padding: .8rem;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
        background-color: var(--secondary);
    }
    .page-pelaksanaan .flocks .flock.active {
        background-color: var(--primary);
    }


    .page-pelaksanaan .card-body {
        display: flex;
    }
    .page-pelaksanaan .wrapper {
        width: 50%;
        display: flex;
        flex-direction: column;
        gap: .2rem;
    }
    .page-pelaksanaan .wrapper .item {
        display: flex;
        width: 100%;
    }
    .page-pelaksanaan .wrapper .item .label {
        width: 50%;
    }
    .page-pelaksanaan .wrapper .item .value {
        width: 50%;
    }
</style>
@endpush