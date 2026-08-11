<div class="card">
    <div class="card-header">
        <h2 class="card-title">Informasi Kandang</h2>
    </div>
    <div class="card-body">
        <table class="w-100 desktop-table d-none d-md-table">
            <tbody>
                <tr>
                    <td class="w-25">Nama Strain</td>
                    <td class="w-25">: {{ $kandang->strain->nama }}</td>
                    <td class="w-25">Nama Kandang</td>
                    <td class="w-25">: {{ $kandang->nama }}</td>
                </tr>
                <tr>
                    <td class="w-25">Nama Peternakan</td>
                    <td class="w-25">: {{ $kandang->peternakan->nama }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mobile-card-list d-md-none">
            <div class="data-row">
                <span class="data-label">Nama Strain</span>
                <span class="data-value">{{ $kandang->strain->nama }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Nama Kandang</span>
                <span class="data-value">{{ $kandang->nama }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Nama Peternakan</span>
                <span class="data-value">{{ $kandang->peternakan->nama }}</span>
            </div>
        </div>
    </div>
</div>
