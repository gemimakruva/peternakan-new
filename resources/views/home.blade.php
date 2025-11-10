@extends('adminlte::page')

@section('content')
<div class="pt-3">

    {{-- Card Filter --}}
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">Monitoring Overview</h5>
        </div>

    <div class="card-body">
    <div class="row align-items-end mb-3">
        {{-- Dropdown Nama Kandang --}}
        <div class="col-md-3">
            <label class="form-label">Select House / Flock</label>
            <select class="form-control form-control-sm">
                <option value="">-- Select House --</option>
                <option value="A1">Flock A1</option>
                <option value="A2">Flock A2</option>
                <option value="B1">Flock B1</option>
            </select>
        </div>

        {{-- Filter Harian / Mingguan --}}
        <div class="col-md-3">
            <label class="form-label">View Period</label>
            <select class="form-control form-control-sm">
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
            </select>
        </div>

        {{-- Tanggal Update di sebelah kanan --}}
        <div class="col-md-6 text-end">
            <label class="form-label d-block">Last Updated</label>
            <input type="text"
                class="form-control form-control-sm d-inline-block"
                value="11 Nov 2025, 14:35"
                style="max-width: 200px;"
                disabled>
        </div>
    </div>
    {{-- Card --}}
</div>
</div>

</div>
@endsection
