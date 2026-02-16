<?php

namespace Modules\Kandang\Http\Controllers\Treatment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Repositories\Treatment\TreatmentPelaksanaanRepository;
use Modules\Kandang\Repositories\Treatment\TreatmentRepository;

class TreatmentPelaksanaanController extends Controller
{
    public function __construct(
        private TreatmentRepository $treatmentRepository,
        private TreatmentPelaksanaanRepository $repository,
    ) {
        $this->middleware('can:kandang.treatment.menu-pelaksanaan-treatment');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id', 'month']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        $datas->transform(function ($item) {
            $item->nama_bulan = Carbon::createFromFormat('m', $item->bulan)->translatedFormat('F');
            return $item;
        });

        return view('kandang::treatment.pelaksanaan.index', compact('datas'));
    }

    public function jadwal(Request $request, $kandangId, $bulan)
    {
        $data = $this->repository
            ->getQuery()
            ->having('id_kandang', '=', $kandangId)
            ->having('bulan', '=', $bulan)
            ->first();
        $data->nama_bulan = Carbon::createFromFormat('m', $data->bulan)->translatedFormat('F');

        $datas = $this->treatmentRepository
            ->getModel()
            ->with([
                'treatmentJadwal' => function ($r) {
                    if (auth()->user()->hasPermissionTo('kandang.treatment.list-unexecuted-only-pelaksanaan-treatment')) {
                        $r->where('executed_at', '=', null);
                    }
                    $r->orderBy('waktu');
                },
                'treatmentJadwal.jenisTreatment:id,nama',
                'treatmentJadwal.metodeTreatment:id,nama',
                'treatmentJadwal.treatmentJadwalFlocks.flock:id,nama',
            ])
            ->where('kandang_id', '=', $kandangId)
            ->where(DB::raw('month(tanggal)'), '=', $bulan)
            ->when(
                auth()->user()->hasPermissionTo('kandang.treatment.list-unexecuted-only-pelaksanaan-treatment'),
                function ($q, $isListUnexecutedOnly) {
                    if ($isListUnexecutedOnly) {
                        $q->whereRelation('treatmentJadwal', 'executed_at', '=', null);
                    }
                }
            )
            ->orderBy('tanggal')
            ->get();

        return view('kandang::treatment.pelaksanaan.jadwal', compact(['data', 'datas']));
    }

    public function pelaksanaan(Request $request, $kandangId, $bulan, $treatmentJadwalId)
    {
        $data = $this->repository
            ->getQuery()
            ->having('id_kandang', '=', $kandangId)
            ->having('bulan', '=', $bulan)
            ->first();
        $data->nama_bulan = Carbon::createFromFormat('m', $data->bulan)->translatedFormat('F');

        $jadwal = $this->repository->find($treatmentJadwalId, [
            'treatment:id,tanggal,kandang_id',
            'treatment.kandang:id,nama',
            'jenisTreatment:id,nama',
            'metodeTreatment:id,nama',
            'treatmentJadwalFlocks.flock:id,nama',
        ]);

        $flocks = $jadwal->treatmentJadwalFlocks->map(function ($item) {
            return [
                'checked'   => !!$item->executed_at,
                'nama'      => $item->flock->nama,
                'id'        => $item->id,
            ];
        });

        return view('kandang::treatment.pelaksanaan.pelaksanaan', compact([
            'data', 
            'jadwal', 
            'flocks',
        ]));
    }

    public function pelaksanaanStore(Request $request, $kandangId, $bulan, $treatmentJadwalId)
    {
        $flocks = $request->input('flocks', []);
        $eksekusi = $request->input('eksekusi');

        $request->validate([
            'eksekusi' => function ($attr, $value, $fail) use($flocks, $eksekusi) {
                if (
                    $eksekusi === 'tandai_selesai'
                    && count($flocks) > 0
                    && in_array("false", array_values($flocks))
                ) {
                    $fail('Semua Flock Belum Terpilih.');
                }
            }
        ]);
        
        $jadwal = $this->repository->getModel()->findOrFail($treatmentJadwalId);
        if ($eksekusi === 'tandai_selesai') {
            $jadwal->fill([
                'executed_at'   => now(),
                'executed_by'   => auth()->id(),
            ]);
        } else if ($eksekusi === 'belum_selesai') {
            $jadwal->fill([
                'executed_at'   => null,
                'executed_by'   => null,
            ]);
        }
        $jadwal->save();

        foreach ($flocks as $id => $value) {
            $jadwal->treatmentJadwalFlocks()->where('id', '=', $id)->update([
                'executed_at'   => $value === "true" ? now() : null,
                'executed_by'   => $value === "false" ? auth()->id() : null,
            ]);
        }

        return to_route('treatment-pelaksanaan.jadwal', [$kandangId, $bulan])
            ->with('success', 'Jadwal Berhasil Diupdate.');
    }
}