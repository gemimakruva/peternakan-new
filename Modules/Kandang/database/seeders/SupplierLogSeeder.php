<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Modules\Kandang\Models\SupplierLog;

class SupplierLogSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        $data = [
            [
                'pipe_id' => 1,
                'flock_id' => 1,
                'house_id' => 1,
                'log_date' => $today,
                'bird_age' => 13,
                'bird_condition' => 'Sehat',
                'total_chicken' => 1000,
                'chicken_in' => 50,
                'died_chicken' => 2,
                'culled_chicken' => 1,
                'sick_chicken' => 3,
                'document_name' => 'Laporan Mingguan.pdf',
                'supplier_document' => 'PT Sumber Unggas Jaya',
                'documentation_photo' => 'photo_1.jpg',
                'notes' => 'Populasi stabil, nafsu makan baik.',
                'recorded_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pipe_id' => 2,
                'flock_id' => 2,
                'house_id' => 1,
                'log_date' => $today->copy()->subDay(),
                'bird_age' => 14,
                'bird_condition' => 'Sehat',
                'total_chicken' => 980,
                'chicken_in' => 40,
                'died_chicken' => 1,
                'culled_chicken' => 0,
                'sick_chicken' => 2,
                'document_name' => 'Cek Harian.xlsx',
                'supplier_document' => 'CV Ayam Maju Bersama',
                'documentation_photo' => 'photo_2.jpg',
                'notes' => 'Kondisi kandang lembab, perlu ventilasi tambahan.',
                'recorded_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pipe_id' => 3,
                'flock_id' => 3,
                'house_id' => 2,
                'log_date' => $today->copy()->subDays(2),
                'bird_age' => 12,
                'bird_condition' => 'Sehat',
                'total_chicken' => 995,
                'chicken_in' => 60,
                'died_chicken' => 0,
                'culled_chicken' => 1,
                'sick_chicken' => 1,
                'document_name' => 'Form Pemeriksaan.pdf',
                'supplier_document' => 'PT Peternak Mandiri',
                'documentation_photo' => 'photo_3.jpg',
                'notes' => 'Performa stabil, FCR dalam batas aman.',
                'recorded_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pipe_id' => 4,
                'flock_id' => 4,
                'house_id' => 2,
                'log_date' => $today->copy()->subDays(3),
                'bird_age' => 11,
                'bird_condition' => 'Sedikit stres',
                'total_chicken' => 960,
                'chicken_in' => 55,
                'died_chicken' => 3,
                'culled_chicken' => 1,
                'sick_chicken' => 4,
                'document_name' => 'Laporan Kesehatan.docx',
                'supplier_document' => 'CV Unggas Sejahtera',
                'documentation_photo' => 'photo_4.jpg',
                'notes' => 'Tingkat stres meningkat karena cuaca panas.',
                'recorded_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pipe_id' => 5,
                'flock_id' => 5,
                'house_id' => 3,
                'log_date' => $today->copy()->subDays(4),
                'bird_age' => 15,
                'bird_condition' => 'Sehat',
                'total_chicken' => 985,
                'chicken_in' => 70,
                'died_chicken' => 1,
                'culled_chicken' => 2,
                'sick_chicken' => 1,
                'document_name' => 'Monitoring Produksi.pdf',
                'supplier_document' => 'PT Pakan Prima',
                'documentation_photo' => 'photo_5.jpg',
                'notes' => 'Ayam afkir mulai meningkat, kondisi wajar.',
                'recorded_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        SupplierLog::insert($data);
    }
}
