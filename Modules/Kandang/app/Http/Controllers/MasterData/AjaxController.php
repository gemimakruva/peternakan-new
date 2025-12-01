<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\Pipe;

class AjaxController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private Flock $flock,
        private Pipe $pipe,
        private PengadaanAyamDistribusi $pengadaanAyamDistribusi,
    ) { }

    public function kandang()
    {
        $kandangs = $this->kandang
            ->getQuery()
            ->select('id', 'nama')
            ->when(request()->query('q'), function($query, $q) {
                $query->where('nama', 'like', "%$q%");
            })
            ->get();
        $results = $kandangs->map(function($k) {
            return ['id' => $k->id, 'text' => $k->nama];
        });
        return response()->json(['results' => $results]);
    }

    public function flock($kandangId)
    {
        $flocks = $this->flock
            ->when(request()->query('q'), function($query, $q) {
                $query->where('nama', 'like', "%$q%");
            })
            ->where('kandang_id', $kandangId)
            ->select('id', 'nama')
            ->get();

        $results = $flocks->map(function($f) {
            return ['id' => $f->id, 'text' => $f->nama];
        });

        return response()->json(['results' => $results]);
    }

    public function pipe($flockId)
    {
        $pipes = $this->pipe->where('flock_id', $flockId)->select('id', 'nama')->get();
        $results = $pipes->map(function($p) {
            return ['id' => $p->id, 'text' => $p->nama];
        });
        return response()->json(['results' => $results]);
    }

    public function umur_ayam($pipeId)
    {
        $pengadaanAyam = $this->pengadaanAyamDistribusi
            ->with('pengadaanAyam:id,tanggal,umur_ayam')
            ->where('pipe_id', '=', $pipeId)
            ->firstOrFail(['pengadaan_ayam_id', 'pipe_id'])->pengadaanAyam;

        $tanggalPerbandingan = request()->has('tanggal_perbandingan') 
            ? request()->date('tanggal_perbandingan')->diffInWeeks($pengadaanAyam->tanggal)
            : now()->diffInWeeks($pengadaanAyam->tanggal);

        $umurAyamSekarang = $pengadaanAyam->umur_ayam + floor(abs($tanggalPerbandingan));

        return [
            'tanggal_ayam_datang' => $pengadaanAyam->tanggal,
            'umur_ayam_datang' => $pengadaanAyam->umur_ayam,
            'umur_ayam_sekarang' => $umurAyamSekarang,
        ];
    }

    
    
}