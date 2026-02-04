<?php
namespace Modules\Kandang\Http\Controllers\SamplingAyam;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\SamplingBobotAyam;
use Modules\Kandang\Models\SamplingBobotAyamPerEkor;

class SamplingAyamController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private SamplingBobotAyam $samplingBobotAyam,
        private SamplingBobotAyamPerEkor $samplingBobotAyamPerEkor
    ) { }
    
    public function index(Request $request)
    {
        $listSamplingBobotAyam = DB::table('sampling_bobot_ayam as sba')
            ->select([
                'sba.id',
                'sba.tanggal',
                'sba.kandang_id',
                'sba.umur',
                'sba.jumlah_ayam_saat_ini',
                'sba.jumlah_ayam_yang_disampling',
                'k.nama as kandang_nama',
                'u.name as petugas_pencatat',
                DB::raw('COALESCE(ssm.berat_badan, 0) as standar_bobot_kg'),
                DB::raw("CONCAT(COALESCE(ssm.berat_badan_min, 0), ' - ', COALESCE(ssm.berat_badan_max, 0)) as range_standar_bobot"),
                DB::raw('ROUND(SUM(sbae.bobot_per_kg) / sba.jumlah_ayam_yang_disampling, 2) as rata_rata_sampling_kg'),
                DB::raw('ROUND((SUM(sbae.bobot_per_kg) / sba.jumlah_ayam_yang_disampling) * 1.1, 2) as batas_atas_kg'),
                DB::raw('ROUND((SUM(sbae.bobot_per_kg) / sba.jumlah_ayam_yang_disampling) * 0.9, 2) as batas_bawah_kg'),
                DB::raw('COUNT(sbae.id) as total_sampling')
            ])
            ->join('sampling_bobot_ayam_per_ekor as sbae', 'sbae.sampling_bobot_ayam_id', '=', 'sba.id')
            ->join('kandang as k', 'k.id', '=', 'sba.kandang_id')
            ->leftJoin('flock as f', 'f.kandang_id', '=', 'sba.kandang_id')
            ->leftJoin('pipe as p', 'p.flock_id', '=', 'f.id')
            ->leftJoin('pengadaan_ayam_distribusi as pad', 'pad.pipe_id', '=', 'p.id')
            ->leftJoin('pengadaan_ayam as pa', 'pa.id', '=', 'pad.pengadaan_ayam_id')
            ->leftJoin('users as u', 'u.id', '=', 'pa.pic_user_id')
            ->leftJoin('strain_standart_metric as ssm', function($join) {
                $join->on('ssm.strain_id', '=', 'k.strain_id')
                     ->on('ssm.umur', '=', 'sba.umur');
            })
            ->when($request->filled('kandang_id'), function($query) use ($request) {
                $query->where('sba.kandang_id', $request->kandang_id);
            })
            ->when($request->filled('tanggal_mulai'), function($query) use ($request) {
                $query->whereDate('sba.tanggal', '>=', $request->tanggal_mulai);
            })
            ->when($request->filled('tanggal_selesai'), function($query) use ($request) {
                $query->whereDate('sba.tanggal', '<=', $request->tanggal_selesai);
            })
            ->groupBy('sba.id', 'sba.tanggal', 'sba.kandang_id', 'sba.umur', 'sba.jumlah_ayam_saat_ini', 'sba.jumlah_ayam_yang_disampling', 'k.nama', 'u.name', 'ssm.berat_badan', 'ssm.berat_badan_min', 'ssm.berat_badan_max')
            ->orderBy('sba.tanggal', 'desc');

        $samplingData = $listSamplingBobotAyam->get();
        
        $listSamplingBobotAyam = $samplingData->map(function($item) {
            $bobotData = DB::table('sampling_bobot_ayam_per_ekor')
                ->where('sampling_bobot_ayam_id', $item->id)
                ->pluck('bobot_per_kg');
            
            $ayamMasukRange = $bobotData->filter(function($bobot) use ($item) {
                return $bobot >= $item->batas_bawah_kg && $bobot <= $item->batas_atas_kg;
            })->count();
            
            $uniformityPersen = $item->total_sampling > 0 
                ? round(($ayamMasukRange / $item->total_sampling) * 100, 2) 
                : 0;
            
            $item->ayam_masuk_range = $ayamMasukRange;
            $item->uniformity_persen = $uniformityPersen;
            
            return $item;
        });

        $page = $request->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $listSamplingBobotAyam->slice($offset, $perPage)->values(),
            $listSamplingBobotAyam->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        $listKandang = $this->kandang->orderBy('nama')->pluck('nama', 'id')->toArray();

        return view("kandang::sampling-ayam.index", [
            'listSamplingBobotAyam' => $paginatedData,
            'listKandang' => $listKandang
        ]);
    }
    
    public function create()
    {
        $listKandang = $this->kandang->orderBy('nama')->pluck('nama', 'id')->toArray();
        return view("kandang::sampling-ayam.create", compact('listKandang'));
    }

    public function store(Request $request)
    {
        $request['umur'] = $request->usia_ayam_saat_ini;

        $validated = $request->validate([
            'tanggal'   => [
                'required', 
                'date',
                'unique:sampling_bobot_ayam,tanggal,NULL,id,kandang_id,' . $request->kandang_id
            ],
            'kandang_id' => ['required', 'integer'],
            'umur' => ['required', 'integer'],
            'jumlah_ayam_saat_ini'   => ['required', 'numeric'],
            'jumlah_ayam_disampling'   => ['required', 'numeric'],
            'berat_badan_rata_rata'   => ['required', 'array'],
            'berat_badan_rata_rata.*'   => ['required', 'numeric'],

        ], [
            'tanggal.unique' => 'Data sampling bobot ayam untuk tanggal dan kandang ini sudah ada.'
        ]);

        try{
            DB::beginTransaction();

            $create = $this->samplingBobotAyam->create([
                'tanggal' => $validated['tanggal'],
                'kandang_id' => $validated['kandang_id'],
                'umur' => $validated['umur'],
                'jumlah_ayam_saat_ini' => $validated['jumlah_ayam_saat_ini'],
                'jumlah_ayam_yang_disampling' => $validated['jumlah_ayam_disampling'],
            ]);

            foreach($validated['berat_badan_rata_rata'] as $index => $bobot){                
                $this->samplingBobotAyamPerEkor->create([
                    'sampling_bobot_ayam_id' => $create->id,
                    'bobot_per_kg' => $bobot,
                ]);
            }

            DB::commit();
            return to_route('sampling-ayam.index')->with('success', 'Data Berhasil Ditambahkan.');
        }catch(\Exception $e){
            DB::rollBack();

            Log::error('Store method failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return to_route('sampling-ayam.index')->with('error', 'Data Gagal Ditambahkan. Error: '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $samplingBobotAyam = $this->samplingBobotAyam
            ->with(['kandang', 'beratBadanRataRataPerEkor'])
            ->findOrFail($id);
        
        $listKandang = $this->kandang->orderBy('nama')->pluck('nama', 'id')->toArray();
        
        return view('kandang::sampling-ayam.edit', compact('samplingBobotAyam', 'listKandang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request['umur'] = $request->usia_ayam_saat_ini;

        $validated = $request->validate([
            'tanggal'   => [
                'required', 
                'date',
                'unique:sampling_bobot_ayam,tanggal,' . $id . ',id,kandang_id,' . $request->kandang_id
            ],
            'kandang_id' => ['required', 'integer'],
            'umur' => ['required', 'integer'],
            'jumlah_ayam_saat_ini'   => ['required', 'numeric'],
            'jumlah_ayam_disampling'   => ['required', 'numeric'],
            'berat_badan_rata_rata'   => ['required', 'array'],
            'berat_badan_rata_rata.*'   => ['required', 'numeric'],
        ], [
            'tanggal.unique' => 'Data sampling bobot ayam untuk tanggal dan kandang ini sudah ada.'
        ]);

        try{
            DB::beginTransaction();

            $samplingBobotAyam = $this->samplingBobotAyam->findOrFail($id);
            
            $samplingBobotAyam->update([
                'tanggal' => $validated['tanggal'],
                'kandang_id' => $validated['kandang_id'],
                'umur' => $validated['umur'],
                'jumlah_ayam_saat_ini' => $validated['jumlah_ayam_saat_ini'],
                'jumlah_ayam_yang_disampling' => $validated['jumlah_ayam_disampling'],
            ]);
            $samplingBobotAyam->beratBadanRataRataPerEkor()->delete();
            
            foreach($validated['berat_badan_rata_rata'] as $index => $bobot){                
                $this->samplingBobotAyamPerEkor->create([
                    'sampling_bobot_ayam_id' => $samplingBobotAyam->id,
                    'bobot_per_kg' => $bobot,
                ]);
            }

            DB::commit();

            return to_route('sampling-ayam.index')->with('success', 'Data Berhasil Diupdate.');   
                
        }catch(\Exception $e){
            DB::rollBack();
            
            Log::error('Update method failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            
            return to_route('sampling-ayam.index')->with('error', 'Data Gagal Diupdate. Error: '.$e->getMessage());
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
