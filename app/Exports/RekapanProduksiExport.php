<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Kandang\Repositories\Rekapan\RekapanProduksiRepository;

class RekapanProduksiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return app(RekapanProduksiRepository::class)->getQuery()->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Kandang',
            'Tanggal',
            'Umur',
            'Mati',
            'Akumulasi Kematian (ekor)',
            'Persentase Kematian (realisasi)',
            'Afkir',
            'Akumulasi Afkir (ekor)',
            'Persentase Afkir (realisasi)',
            'Akumulasi Kematian + Afkir (ekor)',
            'Persentase Kematian + Afkir (realisasi)',
            'Persentase Kematian + Afkir (standar)',
            'Masuk Karantina',
            'Keluar Karantina',
            'Sehat',
        ];
    }
}
