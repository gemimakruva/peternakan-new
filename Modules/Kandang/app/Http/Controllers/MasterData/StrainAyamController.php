<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\Strain;
use Modules\Kandang\Models\StrainStandartMetric;

class StrainAyamController extends Controller
{
    public function index()
    {
        $strains = Strain::all();

        $filterStrainId = request()->query('strain_id', 1);

        $strainMetrics = StrainStandartMetric::when($filterStrainId, function ($query) use ($filterStrainId) {
                $query->where('strain_id', $filterStrainId);
            })
            ->orderBy('umur')
            ->get();

        return view(
            'kandang::master-data.strain-ayam.index',
            compact('strains', 'strainMetrics', 'filterStrainId')
        );
    }
}
