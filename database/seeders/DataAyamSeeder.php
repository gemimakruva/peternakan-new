<?php

namespace Database\Seeders;

use App\Imports\DataAyamImport;
use App\Models\User;
use Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Models\JenisTreatment;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\MetodeTreatment;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\ProduksiTelur;
use Modules\Kandang\Models\SamplingBobotAyam;
use Modules\Kandang\Models\Treatment;
use Modules\Kandang\Services\PopulasiAyamService;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DataAyamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auth::login(User::first());

        $datas = Excel::import(new DataAyamImport(), base_path('/database/seeders/data_ayam.xlsx'));
        $datas = $datas->toCollection(new DataAyamImport(), base_path('/database/seeders/data_ayam.xlsx'));

        $this->savePopulasiAyam($datas['populasi_ayam']);
        $this->savePemberianPakan($datas['pakan']);
        $this->saveProduksiTelur($datas['telur']);
        $this->saveSamplingBobotAyam($datas['sampling_bobot_ayam']);
        $this->saveTreatment($datas['treatment']);
    }

    private function savePopulasiAyam(Collection $rows)
    {
        $items = $rows->map(function($row) {
            $kandangId = Kandang::where('nama', $row['nama_kandang'])->value('id');
            $flockId = Flock::where('nama', $row['nama_flock'])->value('id');
            $pipeId = Pipe::where('nama', $row['nama_pipe'])->value('id');
            $data = array_merge(
                $row->toArray(),
                [
                    'kandang_id' => $kandangId,
                    'flock_id' => $flockId,
                    'pipe_id' => $pipeId,
                    'ayam_mati' => $row['ayam_mati'] ?? 0,
                    'ayam_afkir' => $row['ayam_afkir'] ?? 0,
                    'ayam_masuk_karantina' => $row['ayam_masuk_karantina'] ?? 0,
                    'ayam_keluar_karantina' => $row['ayam_keluar_karantina'] ?? 0,
                    'tanggal' => Date::excelToDateTimeObject($row["tanggal"])->format('Y-m-d'),
                ],
            );
            return $data; 
        });

        try {
            app(PopulasiAyamService::class)->savePopulasiAyam2($items);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
        }
    }

    private function savePemberianPakan(Collection $rows)
    {
        $rows->each(function($row) {
            $kandangId = Kandang::where('nama', $row['nama_kandang'])->value('id');
            $flockId = Flock::where('nama', $row['nama_flock'])->value('id');
            $pipeId = Pipe::where('nama', $row['nama_pipe'])->value('id');
            $jenisPakanId = JenisPakan::where('nama', $row['nama_jenis_pakan'])->value('id');
            $row["tanggal_pemberian_pakan"] = Date::excelToDateTimeObject($row["tanggal_pemberian_pakan"])->format('Y-m-d');

            if (!$row['nama_kandang']) {
                return;
            }

            if (!$pipeId) {
                dd($row);
            }

            $perhitunganPakan = PerhitunganPakan::firstOrCreate([
                'tanggal_pemberian_pakan'   => $row["tanggal_pemberian_pakan"],
                'kandang_id'                => $kandangId,
            ], [
                'umur_ayam'                 => $row['umur_ayam'],
                'jenis_pakan_id'            => $jenisPakanId,
                'proporsi_pemberian_pagi'   => $row['proporsi_pemberian_pagi'],
                'proporsi_pemberian_sore'   => $row['proporsi_pemberian_sore'],
                'waktu_pemberian_pagi'      => $row['waktu_pemberian_pagi'],
                'waktu_pemberian_sore'      => $row['waktu_pemberian_sore'],
                'user_creator_id'           => auth()->id(),
                'user_executor_id'          => auth()->id(),
                'catatan'                   => $row['catatan']
            ]);

            $perhitunganPakan->perhitunganPakanItems()->firstOrCreate([
                'tanggal_pemberian_pakan' => $row['tanggal_pemberian_pakan'],
                'kandang_id' => $kandangId,
                'flock_id' => $flockId,
                'pipe_id' => $pipeId,
            ], [
                'jumlah_ayam' => $row['jumlah_ayam'],
                'pemberian_pakan_per_ekor' => $row['pemberian_pakan_per_ekor'],
            ]);

            $perhitunganPakan->pemberianPakanSisaPakan()->firstOrCreate([
                'flock_id' => $flockId,
            ], [
                'sisa_pakan_per_flock_kg' => $row['sisa_pakan_per_flock_kg'],
            ]);
        });
    }

    private function saveProduksiTelur(Collection $rows)
    {
        $rows->each(function($row) {
            $kandangId = Kandang::where('nama', $row['nama_kandang'])->value('id');
            $flockId = Flock::where('nama', $row['nama_flock'])->value('id');
            $tanggal = Date::excelToDateTimeObject($row['tanggal'])->format('Y-m-d');

            if (!$kandangId || !$flockId || !$tanggal) {
                return;
            }
        
            $produksiTelur = ProduksiTelur::firstOrCreate([
                'tanggal' => $tanggal,
                'kandang_id' => $kandangId,
            ], [
                'pic_user_id' => auth()->id(),
                'umur_ayam' => $row['umur_ayam'],
            ]);

            $produksiTelur->produksiTelurItems()->firstOrCreate([
                'kandang_id' => $kandangId,
                'flock_id' => $flockId,
                'tanggal' => $tanggal,
            ], [
                'jumlah_telur_bagus' => @$row['jumlah_telur_bagus'] ?? 0,
                'jumlah_telur_putih' => @$row['jumlah_telur_putih'] ?? 0,
                'jumlah_telur_reject' => @$row['jumlah_telur_reject'] ?? 0,
                'berat_telur_bagus' => @$row['berat_telur_bagus'] ?? 0,
                'berat_telur_putih' => @$row['berat_telur_putih'] ?? 0,
                'berat_telur_reject' => @$row['berat_telur_reject'] ?? 0,
            ]);
        });
    }

    private function saveSamplingBobotAyam(Collection $rows)
    {
        $rows->map(function($row) {
            if (!$row['kandang'] || !$row['tanggal']) return;
            $sampling = $this->getSamplingBobotAyam($row['kandang'], $row['tanggal']);
            $sampling->samplingBobotAyamPerEkor()->create([
                'bobot_per_kg' => $row['bobot_ayam'],
            ]);
        });
    }

    private $samplingAyam = [];
    private function getSamplingBobotAyam($kandangNama, $tanggal)
    {
        $kandangId = Kandang::where('nama', $kandangNama)->value('id');
        $tanggal = Date::excelToDateTimeObject($tanggal)->format('Y-m-d');

        if (isset($this->samplingAyam["$kandangId-$tanggal"])) {
            return $this->samplingAyam["$kandangId-$tanggal"];
        }

        $umurResult = app(PopulasiAyamService::class)->getUmurAyamByKandangId($kandangId, Carbon::createFromFormat('Y-m-d', $tanggal));
        $umurAyam = $umurResult['umur_ayam'];
        $populasi = app(PopulasiAyamService::class)->getCurrentAyamSehatByKandang($kandangId, Carbon::createFromFormat('Y-m-d', $tanggal));

        $sampling = SamplingBobotAyam::firstOrCreate([
            'pencatat_user_id' => auth()->id(),
            'tanggal' => $tanggal,
            'kandang_id' => $kandangId,
            'umur' => $umurAyam,
            'jumlah_ayam_saat_ini' => $populasi,
        ]);

        $this->samplingAyam["$kandangId-$tanggal"] = $sampling;

        return $sampling;
    }

    private function saveTreatment(Collection $rows)
    {
        $rows->map(function($row) {
            if (!$row['area'] || !$row['kandang'] || !$row['tanggal']) {
                return;
            }

            $kandangId = Kandang::where('nama', $row['kandang'])->value('id');
            $tanggal = Date::excelToDateTimeObject($row['tanggal'])->format('Y-m-d');
            $waktu = Date::excelToDateTimeObject($row['waktu'])->format('H:i');

            $treatment = Treatment::firstOrCreate([
                'kandang_id' => $kandangId,
                'tanggal' => $tanggal,
                'user_creator_id' => auth()->id(),
            ]);

            $jenisTreatmentId = JenisTreatment::where('nama', $row['jenis_treatment'])->value('id');
            $metodeTreatmentId = MetodeTreatment::where('nama', $row['metode_treatment'])->value('id');

            if (!$jenisTreatmentId || !$metodeTreatmentId) {
                dd($row['jenis_treatment'], $row['metode_treatment']);
            }
            
            $jadwal = $treatment->treatmentJadwal()->firstOrCreate([
                'jenis_treatment_id' => $jenisTreatmentId,
                'metode_treatment_id' => $metodeTreatmentId,
                'merk_ovk' => $row['merk_ovk'],
                'area' => $row['area'],
                'dosis' => $row['dosis'],
                'waktu' => $waktu,
            ]);
            
            if ($row['flock'] != 'Semua Flock') {
                collect(explode(',', $row['flock']))->map(function($flockNama) use($jadwal) {
                    $flockNama = trim($flockNama);
                    $flockId = Flock::where('nama', $flockNama)->value('id');
                    if (!$flockId) {
                        dd($flockNama);
                    }
                    $jadwal->treatmentJadwalFlocks()->firstOrCreate(['flock_id' => $flockId]);
                });
            }
        });
    }
}
