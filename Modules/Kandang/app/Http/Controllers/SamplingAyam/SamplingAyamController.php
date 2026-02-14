<?php
namespace Modules\Kandang\Http\Controllers\SamplingAyam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Models\SamplingBobotAyam;
use Modules\Kandang\Models\SamplingBobotAyamPerEkor;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\SamplingAyam\SamplingAyamRepository;

class SamplingAyamController extends Controller
{
    public function __construct(
        private SamplingAyamRepository $repository,
        private KandangRepository $kandangRepository,
        private SamplingBobotAyam $samplingBobotAyam,
        private SamplingBobotAyamPerEkor $samplingBobotAyamPerEkor
    ) { 
        $this->middleware('can:kandang.sampling.menu-sampling-bobot-ayam');
    }
    
    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id', 'tanggal']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        $listKandang = $this->kandangRepository->getSelectItems();

        return view("kandang::sampling-ayam.index", compact(['datas', 'listKandang']));
    }
    
    public function create()
    {
        $listKandang = $this->kandangRepository->getSelectItems();
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
                'pencatat_user_id'              => auth()->id(),
                'tanggal'                       => $validated['tanggal'],
                'kandang_id'                    => $validated['kandang_id'],
                'umur'                          => $validated['umur'],
                'jumlah_ayam_saat_ini'          => $validated['jumlah_ayam_saat_ini'],
                'jumlah_ayam_yang_disampling'   => $validated['jumlah_ayam_disampling'],
            ]);

            foreach($validated['berat_badan_rata_rata'] as $index => $bobot){                
                $this->samplingBobotAyamPerEkor->create([
                    'sampling_bobot_ayam_id'    => $create->id,
                    'bobot_per_kg'              => $bobot,
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
            ->with(['kandang', 'samplingBobotAyamPerEkor'])
            ->findOrFail($id);
        
        $listKandang = $this->kandangRepository->getSelectItems();
        
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
                'tanggal'                       => $validated['tanggal'],
                'kandang_id'                    => $validated['kandang_id'],
                'umur'                          => $validated['umur'],
                'jumlah_ayam_saat_ini'          => $validated['jumlah_ayam_saat_ini'],
                'jumlah_ayam_yang_disampling'   => $validated['jumlah_ayam_disampling'],
            ]);
            $samplingBobotAyam->samplingBobotAyamPerEkor()->delete();
            
            foreach($validated['berat_badan_rata_rata'] as $index => $bobot){                
                $this->samplingBobotAyamPerEkor->create([
                    'sampling_bobot_ayam_id'    => $samplingBobotAyam->id,
                    'bobot_per_kg'              => $bobot,
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
            $samplingBobotAyam->samplingBobotAyamPerEkor()->delete();
            
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
