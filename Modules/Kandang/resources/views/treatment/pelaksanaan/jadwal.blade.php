@extends('layouts.dashboard')

@section('title', "Jadwal Treatment Kandang \"$data->nama_kandang\" Bulan $data->nama_bulan")

@section('content_header')
    <x-page-header :title="'Jadwal Treatment — ' . $data->nama_kandang . ' — ' . $data->nama_bulan" :breadcrumbs="[
        'Pelaksanaan Treatment' => route('treatment-pelaksanaan.index'),
        $data->nama_kandang . ' — ' . $data->nama_bulan => null,
    ]" />
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th class="align-middle" style="max-width: 40px;">#</th>
                            <th class="align-middle" style="max-width: 180px;">Tanggal</th>
                            <th class="align-middle" style="max-width: 180px;">Waktu</th>
                            <th class="align-middle" style="max-width: 140px;">Jenis Treatment</th>
                            <th class="align-middle" style="max-width: 180px;">Metode</th>
                            <th class="align-middle" style="max-width: 180px;">Merk OVK</th>
                            <th class="align-middle" style="max-width: 180px;">Area</th>
                            <th class="align-middle" style="max-width: 180px;">Flock</th>
                            <th class="align-middle" style="max-width: 180px;">Dosis</th>
                            <th class="align-middle" style="max-width: 180px;">Selesai Pada</th>
                            <th class="align-middle" style="max-width: 180px;">Selesai Oleh</th>
                            @can('kandang.treatment.edit-pelaksanaan-treatment')
                                <th class="align-middle" style="max-width: 40px;">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 1;
                        @endphp
                        @forelse($datas as $treatment)
                            @foreach ($treatment->treatmentJadwal as $index => $jadwal)
                                <tr>
                                    <td class="text-right">{{ $num++ }}</td>
                                    @if ($index === 0)
                                        <td rowspan="{{ $treatment->treatmentJadwal->count() }}" class="text-right">{{ $treatment->tanggal->format('d') }}</td>
                                    @endif
                                    <td class="text-right">{{ $jadwal->waktu->format('H:i') }}</td>
                                    <td>{{ $jadwal->jenisTreatment->nama }}</td>
                                    <td>{{ $jadwal->metodeTreatment->nama }}</td>
                                    <td>{{ $jadwal->merk_ovk }}</td>
                                    <td>{{ $jadwal->area }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @forelse ($jadwal->treatmentJadwalFlocks as $jf)
                                                <span 
                                                    @class([
                                                        'badge'             => true,
                                                        'badge-primary'     => !!$jf->executed_at, 
                                                        'badge-secondary'   => !!!$jf->executed_at,
                                                    ])
                                                >{{ $jf->flock->nama }}</span>
                                            @empty
                                                <span 
                                                    @class([
                                                        'badge'             => true,
                                                        'badge-primary'     => !!$jadwal->executed_at, 
                                                        'badge-secondary'   => !!!$jadwal->executed_at,
                                                    ])
                                                >Semua Flock</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>{{ $jadwal->dosis }}</td>
                                    <td>{{ $jadwal->executed_at?->translatedFormat('l, d F Y, H:i') }}</td>
                                    <td>{{ $jadwal->executedBy?->name }}</td>
                                    @can('kandang.treatment.edit-pelaksanaan-treatment')
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('treatment-pelaksanaan.jadwal.pelaksanaan', [$data->id_kandang, $data->bulan, $jadwal->id]) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted py-3">
                                    Tidak ada data treatment ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection