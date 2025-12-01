<?php

namespace Modules\Kandang\Enums;

enum BerkasName: string
{
    case SURAT_JALAN = 'surat_jalan';
    case DATA_RERATA_BERAT_BADAN = 'data_rerata_berat_badan';
    case UNIFORMITY = 'uniformity';
    case RECORDING_KESEHATAN = 'recording_kesehatan';
    case RECORDING_PENGOBATAN_DAN_VAKSIN = 'recording_pengobatan_dan_vaksin';
    case JADWAL_VAKSIN_LANJUT = 'jadwal_vaksin_lanjut';

    public function title(): string
    {
        return match($this) {
            BerkasName::SURAT_JALAN => 'Surat Jalan',
            BerkasName::DATA_RERATA_BERAT_BADAN => 'Data Rerata Berat Badan',
            BerkasName::UNIFORMITY => 'Uniformity',
            BerkasName::RECORDING_KESEHATAN => 'Recording Kesehatan',
            BerkasName::RECORDING_PENGOBATAN_DAN_VAKSIN => 'Recording Pengobatan dan Vaksin',
            BerkasName::JADWAL_VAKSIN_LANJUT => 'Jadwal Vaksin Lanjut',
        };
    }
}