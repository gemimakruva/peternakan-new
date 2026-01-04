<div class="card">
    <div class="card-header">
        <h2 class="card-title">Informasi Kandang</h2>
    </div>
    <div class="card-body">
        <table class="w-100">
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
    </div>
</div>