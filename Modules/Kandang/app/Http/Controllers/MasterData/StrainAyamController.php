<?php
namespace Modules\Kandang\Http\Controllers\MasterData;
use App\Http\Controllers\Controller;
use Modules\Kandang\Models\StrainAyam;
class StrainAyamController extends Controller
{
    public function index() {
    $strain = StrainAyam::orderBy('umur_minggu')->get();
    return view('kandang::master-data.strain-ayam.index',compact('strain'));
    }
}
