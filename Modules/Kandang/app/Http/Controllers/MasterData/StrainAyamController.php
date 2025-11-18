<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\Strain;
use Modules\Kandang\Models\StrainStandartMetric;

class StrainAyamController extends Controller
{
    /**
     * Display a listing of strain ayam and their metrics.
     * Menampilkan daftar strain ayam dengan tombol filter dan metrik terkait.
     */
    public function index()
    {
        // Ambil semua strain untuk tombol filter
        $strains = Strain::all();

        // Ambil parameter filter strain_id dari query string
        $filterStrainId = request()->query('strain_id');

        // Ambil metric strain sesuai filter jika ada
        $strainMetrics = StrainStandartMetric::when($filterStrainId, function ($query) use ($filterStrainId) {
                $query->where('strain_id', $filterStrainId);
            })
            ->orderBy('umur')
            ->get();

        // Return view dengan data strains, metrics, dan filterId
        return view(
            'kandang::master-data.strain-ayam.index',
            compact('strains', 'strainMetrics', 'filterStrainId')
        );
    }
}
