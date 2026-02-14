<?php

namespace Modules\Kandang\Http\Controllers\Treatment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Http\Requests\Treatment\UpdateRequest;
use Modules\Kandang\Models\Treatment;
use Modules\Kandang\Repositories\Kandang\FlockRepository;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\Treatment\JenisTreatmentRepository;
use Modules\Kandang\Repositories\Treatment\MetodeTreatmentRepository;
use Modules\Kandang\Repositories\Treatment\TreatmentRepository;
use Modules\Kandang\Repositories\User\UserRepository;

class TreatmentController extends Controller
{
    public function __construct(
        private TreatmentRepository $repository,
        private KandangRepository $kandangRepository,
        private UserRepository $userRepository,
        private JenisTreatmentRepository $jenisTreatmentRepository,
        private MetodeTreatmentRepository $metodeTreatmentRepository,
        private FlockRepository $flockRepository,
    ) {
        $this->middleware('can:kandang.treatment.menu-penjadwalan-treatment');
    }

    public function index(Request $request)
    {
        $listKandang = $this->kandangRepository->getSelectItems();
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('kandang::treatment.index', compact(['listKandang', 'datas']));
    }

    public function create()
    {
        $listKandang = $this->kandangRepository->getSelectItems();
        $listUser = $this->userRepository->getSelectItems('name');
        return view('kandang::treatment.create', compact(['listKandang', 'listUser']));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'kandang_id'    => ['required', 'numeric', 'exists:kandang,id'],
            'tanggal'       => ['required', 'date', function ($attr, $value, $fail) use($request) {
                $isExist = app(Treatment::class)
                    ->where('tanggal', '=', $value)
                    ->where('kandang_id', '=', $request->input('kandang_id'))
                    ->exists();
                if ($isExist) {
                    $fail("Penjadwalan Treatment pada tanggal $value");
                }
            }],
        ]);

        $validated['user_creator_id'] = auth()->id();

        $treatment = $this->repository->getModel()->create($validated);

        return to_route('treatment.edit', $treatment)->with('success', 'Data Treatment Berhasil Ditambahkan, Tambahkan Data Jadwal Treatment.');
    }

    public function edit(Treatment $treatment)
    {
        $data                   = $treatment;
        $listKandang            = $this->kandangRepository->getSelectItems();
        $listJenisTreatment     = $this->jenisTreatmentRepository->getSelectItems();
        $listMetodeTreatment    = $this->metodeTreatmentRepository->getSelectItems();
        $listFlock              = $this->flockRepository->getModel()
            ->query()
            ->where('kandang_id', '=', $treatment->kandang_id)
            ->orderBy('nama')
            ->pluck('nama', 'id');

        $data->treatmentJadwal->transform(function ($item) {
            $item->flocks = $item->treatmentJadwalFlocks->map(function ($item2) {
                return $item2->flock_id;
            });
            return $item;
        });

        return view('kandang::treatment.edit', compact([
            'data',
            'listKandang',
            'listJenisTreatment',
            'listMetodeTreatment',
            'listFlock',
        ]));
    }

    public function update(UpdateRequest $request, Treatment $treatment) {
        $validated = $request->all();

        $savedJadwal = [];
        foreach ($validated['items'] as $item) {
            $item['waktu'] = Carbon::createFromFormat('H:i', $item['waktu']);
            $jadwal = $treatment->treatmentJadwal()->updateOrCreate([
                'id'                    => @$item['id'],
                'treatment_id'          => $treatment->id
            ], [
                'jenis_treatment_id'    => $item['jenis_treatment_id'],
                'metode_treatment_id'   => $item['metode_treatment_id'],
                'merk_ovk'              => $item['merk_ovk'],
                'area'                  => $item['area'],
                'dosis'                 => $item['dosis'],
                'waktu'                 => $item['waktu'],
            ]);
            $savedJadwal[] = $jadwal->id;

            $savedFlock = []; // flock terpilih, jika flock kosong dianggap memilih semua flock
            foreach ((@$item['flocks'] ?? []) as $flockId) {
                $flock = $jadwal->treatmentJadwalFlocks()->firstOrCreate([
                    'treatment_jadwal_id'   => $jadwal->id,
                    'flock_id'              => $flockId,
                ]);
                $savedFlock[] = $flock->id;
            }
            $jadwal->treatmentJadwalFlocks()->whereNotIn('id', $savedFlock)->delete();
        }
        $treatment->treatmentJadwal()->whereNotIn('id', $savedJadwal)->delete();

        return to_route('treatment.index')->with('success', 'Data Penjadwalan Treatment Berhasil Diupdate.');
    }

    public function destroy(Treatment $treatment)
    {
        DB::beginTransaction();
        try {
            $treatment->treatmentJadwal()->delete();
            $treatment->delete();
            DB::commit();
            return to_route('treatment.index')->with('success', 'Data Penjadwalan Treatment Berhasil Dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return to_route('treatment.index')->with('error', 'Data Penjadwalan Treatment Gagal Dihapus.');
        }
    }
}
