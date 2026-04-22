<?php

use App\Models\User;
use Modules\GudangPakan\Enums\BahanPakanTipe;
use Modules\GudangTelur\Models\Satuan;

function insertBahanPakan($that, $satuanId, $nama, $harga, $jumlahSatuan) {
    $response = $that->post(route('gudang-pakan.master-data.bahan-pakan.store'), [
        'tipe' => BahanPakanTipe::PAKAN_PREMIX->value,
        'nama' => $nama,
        'satuan_id' => $satuanId,
        'harga' => $harga,
        'jumlah_satuan' => $jumlahSatuan,
    ]);

    $response->assertSessionHas('success');
}

test('buat bahan pakan', function () {
    $superAdmin = User::first();
    $this->actingAs($superAdmin);

    $satuanGramId = Satuan::where('nama', '=', 'Gram')->value('id');
    insertBahanPakan($this, $satuanGramId, 'Vitamin A', 15_000, 10_000);
    insertBahanPakan($this, $satuanGramId, 'Vitamin B', 18_000, 10_000);

    $satuanKgId = Satuan::where('nama', '=', 'Kg')->value('id');
    insertBahanPakan($this, $satuanKgId, 'Bekatul', 5000, 1);
    insertBahanPakan($this, $satuanKgId, 'Jagung Kuning Kasar', 3500, 1);
    insertBahanPakan($this, $satuanKgId, 'Jagung Kuning Halus', 6500, 1);
});
