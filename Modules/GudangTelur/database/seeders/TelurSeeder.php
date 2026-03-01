<?php

namespace Modules\GudangTelur\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GudangTelur\Enums\TelurJenisTipe;
use Modules\GudangTelur\Models\TelurJenis;

class TelurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            // ====== MASUK
            [
                'tipe'  => TelurJenisTipe::MASUK->value,
                'nama'  => 'Bagus',
            ],
            [
                'tipe'  => TelurJenisTipe::MASUK->value,
                'nama'  => 'Reject',
            ],
            [
                'tipe'  => TelurJenisTipe::MASUK->value,
                'nama'  => 'Putih',
            ],
            [
                'tipe'  => TelurJenisTipe::MASUK->value,
                'nama'  => 'Retur',
            ],
            // ====== KELUAR
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Grade A',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Grade B',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Oversize',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Telur Reject',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Telur Putih',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'B dan OS',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Campur',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Ceplok Plastik',
            ],
            [
                'tipe'  => TelurJenisTipe::KELUAR->value,
                'nama'  => 'Returan',
            ],
            // ====== GRADING
            [
                'tipe'  => TelurJenisTipe::GRADING->value,
                'nama'  => 'Grade A',
            ],
            [
                'tipe'  => TelurJenisTipe::GRADING->value,
                'nama'  => 'Grade B',
            ],
            [
                'tipe'  => TelurJenisTipe::GRADING->value,
                'nama'  => 'Oversize',
            ],
            [
                'tipe'  => TelurJenisTipe::GRADING->value,
                'nama'  => 'Telur Putih',
            ],
            [
                'tipe'  => TelurJenisTipe::GRADING->value,
                'nama'  => 'Telur Reject',
            ],
            // ====== OPNAME
            [
                'tipe'  => TelurJenisTipe::OPNAME->value,
                'nama'  => 'Campur',
            ],
        ];
        TelurJenis::insert($datas);
    }
}
