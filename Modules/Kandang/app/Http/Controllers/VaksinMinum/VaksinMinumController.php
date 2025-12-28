<?php
namespace Modules\Kandang\Http\Controllers\VaksinMinum;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\SamplingBobotAyam;
use Modules\Kandang\Models\SamplingBobotAyamPerEkor;
use Modules\Kandang\Models\VaksinMinum;

class VaksinMinumController extends Controller
{
    public function __construct(
        private VaksinMinum $vaksinMinum,
    ) { }
    
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);

        $listVaksinMinum = VaksinMinum::with(['flock.kandang'])
            ->when($request->filled('tanggal_mulai'), function($query) use ($request) {
                $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
            })
            ->when($request->filled('tanggal_selesai'), function($query) use ($request) {
                $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
            })
            ->when($request->filled('kandang_id'), function($query) use ($request) {
                $query->whereHas('flock.kandang', function($q) use ($request) {
                    $q->where('id', $request->kandang_id);
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage);

        $listKandang = Kandang::get(['id', 'nama']);
        return view("kandang::vaksin-minum.index", compact('listKandang', 'listVaksinMinum'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        $kandangList = Kandang::get(['id', 'nama'])->pluck('nama', 'id');
        return view("kandang::vaksin-minum.create", compact('kandangList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'tanggal'   => ['required', 'date'],
            'flock_id' => ['required', 'integer'],
            'nama_vaksin' => ['required', 'string', 'max:255'],
            'total_dosis'   => ['required', 'numeric'],
            'air_minum_per_ekor'   => ['required', 'numeric'],
            'jumlah_ayam_per_baris'   => ['required', 'integer'],
            'jumlah_ml_vaksin_per_baris'   => ['required', 'numeric'],
            'jumlah_air_di_tong_per_baris'   => ['required', 'numeric'],

        ]);

        try{

            $create = $this->vaksinMinum->create([
                'tanggal' => $validated['tanggal'],
                'flock_id' => $validated['flock_id'],
                'nama_vaksin' => $validated['nama_vaksin'],
                'total_dosis' => $validated['total_dosis'],
                'air_minum_per_ekor' => $validated['air_minum_per_ekor'],
                'jumlah_ayam_per_baris' => (int) $validated['jumlah_ayam_per_baris'],
                'jumlah_ml_vaksin_per_baris' =>  (float) $validated['jumlah_ml_vaksin_per_baris'],
                'jumlah_air_di_tong_per_baris' => (float) $validated['jumlah_air_di_tong_per_baris'],
            ]);
        
            return to_route('vaksin-minum.index')->with('success', 'Data Berhasil Ditambahkan.');   
                
        }catch(\Exception $e){
            DB::rollBack();
            return to_route('vaksin-minum.index')->with('error', 'Data Gagal Ditambahkan. Error: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PopulasiAyam $populasiAyam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        $data = $this->vaksinMinum->with(['flock.kandang'])->findOrFail($id);
        $kandangList = Kandang::get(['id', 'nama'])->pluck('nama', 'id');

        return view("kandang::vaksin-minum.edit", compact('data', 'kandangList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date'],
            'flock_id' => ['required', 'integer'],
            'nama_vaksin' => ['required', 'string', 'max:255'],
            'total_dosis'   => ['required', 'numeric'],
            'air_minum_per_ekor'   => ['required', 'numeric'],
            'jumlah_ayam_per_baris'   => ['required', 'integer'],
            'jumlah_ml_vaksin_per_baris'   => ['required', 'numeric'],
            'jumlah_air_di_tong_per_baris'   => ['required', 'numeric'],

        ]);

        try{

            $vaksinMinum = $this->vaksinMinum->findOrFail($id);

            $vaksinMinum->update([
                'tanggal' => $validated['tanggal'],
                'flock_id' => $validated['flock_id'],
                'nama_vaksin' => $validated['nama_vaksin'],
                'total_dosis' => $validated['total_dosis'],
                'air_minum_per_ekor' => $validated['air_minum_per_ekor'],
                'jumlah_ayam_per_baris' => (int) $validated['jumlah_ayam_per_baris'],
                'jumlah_ml_vaksin_per_baris' =>  (float) $validated['jumlah_ml_vaksin_per_baris'],
                'jumlah_air_di_tong_per_baris' => (float) $validated['jumlah_air_di_tong_per_baris'],
            ]);
        
            return to_route('vaksin-minum.index')->with('success', 'Data Berhasil Diubah.');   
                
        }catch(\Exception $e){
            DB::rollBack();
            return to_route('vaksin-minum.index')->with('error', 'Data Gagal Diubah. Error: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            
            $samplingBobotAyam = $this->samplingBobotAyam->findOrFail($id);
            
            // Delete related bobot per ekor (cascade should handle this, but being explicit)
            $samplingBobotAyam->beratBadanRataRataPerEkor()->delete();
            
            // Delete main record
            $samplingBobotAyam->delete();
            
            DB::commit();

            return to_route('sampling-ayam.index')
                ->with('success', 'Data Berhasil Dihapus.');   
                
        }catch(\Exception $e){
            DB::rollBack();
            
            return to_route('sampling-ayam.index')
            ->with('danger', 'Data Gagal Dihapus. Error: '.$e->getMessage());
        }
    }
}
