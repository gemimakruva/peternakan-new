<?php

namespace Modules\Kandang\Http\Controllers\PerhitunganPakan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Models\PerhitunganPakan;
use Illuminate\Http\Request;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PerhitunganPakanItem;
use Modules\Kandang\Notifications\Pakan\PemberianPakanAssigned;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\Pakan\PerhitunganPakanRepository;
use Modules\Kandang\Services\PerhitunganPakanService;
use Modules\Kandang\Services\PopulasiAyamService;

class PerhitunganPakanController extends Controller
{
    public function __construct(
        private PerhitunganPakanRepository $repository,
        private PerhitunganPakanService $service,
        private PerhitunganPakanItem $perhitunganPakanItem,
        private PopulasiAyamService $populasiAyamService,
        private KandangRepository $kandangRepository,
        private JenisPakan $jenisPakan,
        private Kandang $kandang,
        private User $user,
    ) {
        $this->middleware('can:kandang.pakan.menu-perhitungan-pemberian-pakan');
    }

    public function index(Request $request)
    {
        Gate::authorize('kandang.pakan.list-perhitungan-pemberian-pakan');

        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id', 'jenis_pakan_id']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        $listKandang = $this->kandang->pluck('nama', 'id');
        $listJenisPakan = $this->jenisPakan->pluck('nama', 'id');

        return view('kandang::perhitungan-pakan.index', compact(['datas', 'listKandang', 'listJenisPakan']));
    }

    public function create()
    {
        Gate::authorize('kandang.pakan.create-perhitungan-pemberian-pakan');

        $listKandang = $this->kandang
            ->orderBy('nama')
            ->pluck('nama', 'id');
        $listUser = $this->user
            ->where('id', '<>', auth()->id())
            ->orderBy('name')
            ->pluck('name', 'id');
        $listJenisPakan = $this->jenisPakan
            ->orderBy('nama')
            ->pluck('nama', 'id');

        return view("kandang::perhitungan-pakan.create", compact(['listKandang', 'listUser', 'listJenisPakan']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('kandang.pakan.create-perhitungan-pemberian-pakan');

        $validated = $request->validate([
            'tanggal_pemberian_pakan'   => ['required', 'date', function ($attr, $value, $fail) use($request) {
                $isExists = $this->repository->getModel()
                    ->where('kandang_id', '=', $request->input('kandang_id'))
                    ->where('tanggal_pemberian_pakan', '=', $value)
                    ->exists();
                if ($isExists) {
                    $fail('Perhitungan Pakan telah dibuat dengan Tanggal dan Kandang yang sama.');
                }
            }],
            'kandang_id'                => ['required', 'exists:kandang,id'],
            'jenis_pakan_id'            => ['required', 'exists:jenis_pakan,id'],
            'proporsi_pemberian_pagi'   => ['required', 'numeric', function ($attr, $value, $fail) {
                if ((request()->integer('proporsi_pemberian_pagi') + request()->integer('proporsi_pemberian_sore')) !== 100) {
                    $fail('Proposi Pemberian Pakan Tidak Valid.');
                }
            }],
            'proporsi_pemberian_sore'   => ['required', 'numeric', function ($attr, $value, $fail) {
                if ((request()->integer('proporsi_pemberian_pagi') + request()->integer('proporsi_pemberian_sore')) !== 100) {
                    $fail('Proposi Pemberian Pakan Tidak Valid.');
                }
            }],
            'waktu_pemberian_pagi'      => ['required', 'date_format:H:i'],
            'waktu_pemberian_sore'      => ['required', 'date_format:H:i'],
            'user_executor_id'          => ['required', 'exists:users,id'],
            'catatan'                   => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $umurAyam = $this->populasiAyamService->getUmurAyamByKandangId($validated['kandang_id'], $request->date('tanggal_pemberian_pakan'))['umur_ayam'];
            $validated = [
                'tanggal_pemberian_pakan'   => $validated["tanggal_pemberian_pakan"],
                'umur_ayam'                 => $umurAyam,
                'kandang_id'                => $validated['kandang_id'],
                'jenis_pakan_id'            => $validated['jenis_pakan_id'],
                'proporsi_pemberian_pagi'   => $validated['proporsi_pemberian_pagi'],
                'proporsi_pemberian_sore'   => $validated['proporsi_pemberian_sore'],
                'waktu_pemberian_pagi'      => $validated['waktu_pemberian_pagi'],
                'waktu_pemberian_sore'      => $validated['waktu_pemberian_sore'],
                'user_creator_id'           => auth()->id(),
                'user_executor_id'          => $validated['user_executor_id'],
                'catatan'                   => $validated['catatan']
            ];

            $perhitunganPakan = $this->repository->create($validated);

            $perhitunganPakan->userExecutor->notify(new PemberianPakanAssigned($perhitunganPakan));

            return redirect()->route('perhitungan-pakan.edit', $perhitunganPakan)
                ->with('success', 'Data Perhitungan Pakan berhasil disimpan!');
        } catch (\Throwable $th) {
            Log::error('Store method failed', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerhitunganPakan $perhitunganPakan)
    {
        Gate::authorize('kandang.pakan.edit-perhitungan-pemberian-pakan');

        [$data, $initialState] = $this->service->getTableInitialState($perhitunganPakan);

        $listKandang = $this->kandang
            ->orderBy('nama')
            ->pluck('nama', 'id');
        $listUser = $this->user
            ->where('id', '<>', auth()->id())
            ->orderBy('name')
            ->pluck('name', 'id');
        $listJenisPakan = $this->jenisPakan
            ->orderBy('nama')
            ->pluck('nama', 'id');

        return view("kandang::perhitungan-pakan.edit", compact([
            'data',
            'initialState',
            'listKandang',
            'listUser',
            'listJenisPakan',
        ]));
    }
    
    public function show(PerhitunganPakan $perhitunganPakan)
    {
        Gate::authorize('kandang.pakan.detail-perhitungan-pemberian-pakan');

        [$data, $initialState] = $this->service->getTableInitialState($perhitunganPakan);

        $listKandang = $this->kandang
            ->orderBy('nama')
            ->pluck('nama', 'id');
        $listUser = $this->user
            ->where('id', '<>', auth()->id())
            ->orderBy('name')
            ->pluck('name', 'id');
        $listJenisPakan = $this->jenisPakan
            ->orderBy('nama')
            ->pluck('nama', 'id');

        return view("kandang::perhitungan-pakan.show", compact([
            'data',
            'initialState',
            'listKandang',
            'listUser',
            'listJenisPakan',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerhitunganPakan $perhitunganPakan)
    {
        Gate::authorize('kandang.pakan.edit-perhitungan-pemberian-pakan');

        $validated = $request->validate([
            'tanggal_pemberian_pakan'   => ['required', 'date', function ($attr, $value, $fail) use($perhitunganPakan) {
                $isExists = $this->repository->getModel()
                    ->where('kandang_id', '=', $perhitunganPakan->kandang_id)
                    ->where('tanggal_pemberian_pakan', '=', $value)
                    ->where('id', '<>', $perhitunganPakan->id)
                    ->exists();
                if ($isExists) {
                    $fail('Perhitungan Pakan telah dibuat dengan Tanggal dan Kandang yang sama.');
                }
            }],
            'jenis_pakan_id'            => ['required', 'exists:jenis_pakan,id'],
            'proporsi_pemberian_pagi'   => ['required', 'numeric', function ($attr, $value, $fail) {
                if ((request()->integer('proporsi_pemberian_pagi') + request()->integer('proporsi_pemberian_sore')) !== 100) {
                    $fail('Proposi Pemberian Pakan Tidak Valid.');
                }
            }],
            'proporsi_pemberian_sore'   => ['required', 'numeric', function ($attr, $value, $fail) {
                if ((request()->integer('proporsi_pemberian_pagi') + request()->integer('proporsi_pemberian_sore')) !== 100) {
                    $fail('Proposi Pemberian Pakan Tidak Valid.');
                }
            }],
            'waktu_pemberian_pagi'      => ['required', 'date_format:H:i:s'],
            'waktu_pemberian_sore'      => ['required', 'date_format:H:i:s'],
            'user_executor_id'          => ['required', 'exists:users,id'],
            'catatan'                   => ['nullable', 'string', 'max:500'],
            'items'                             => ['required', 'array'],
            'items.*.id'                        => ['nullable', 'integer'],
            'items.*.perhitungan_pakan_id'      => ['required', 'integer', 'exists:perhitungan_pakan,id'],
            'items.*.kandang_id'                => ['required', 'integer', 'exists:kandang,id'],
            'items.*.flock_id'                  => ['required', 'integer', 'exists:flock,id'],
            'items.*.pipe_id'                   => ['required', 'integer', 'exists:pipe,id'],
            'items.*.jumlah_ayam'               => ['required', 'integer', 'min:0'],
            'items.*.pemberian_pakan_per_ekor'  => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            $umurAyam = $this->populasiAyamService->getUmurAyamByKandangId($perhitunganPakan->kandang->id, $request->date('tanggal_pemberian_pakan'))['umur_ayam'];
            $perhitunganPakan->fill([
                'tanggal_pemberian_pakan'   => $validated["tanggal_pemberian_pakan"],
                'umur_ayam'                 => $umurAyam,
                'jenis_pakan_id'            => $validated['jenis_pakan_id'],
                'proporsi_pemberian_pagi'   => $validated['proporsi_pemberian_pagi'],
                'proporsi_pemberian_sore'   => $validated['proporsi_pemberian_sore'],
                'waktu_pemberian_pagi'      => $validated['waktu_pemberian_pagi'],
                'waktu_pemberian_sore'      => $validated['waktu_pemberian_sore'],
                'user_creator_id'           => auth()->id(),
                'user_executor_id'          => $validated['user_executor_id'],
                'catatan'                   => $validated['catatan']
            ]);
            $perhitunganPakan->save();

            foreach ($validated['items'] as $item) {
                $this->perhitunganPakanItem->updateOrCreate([
                    'id'                        => $item['id'],
                    'perhitungan_pakan_id'      => $item['perhitungan_pakan_id'],
                    'kandang_id'                => $item['kandang_id'],
                    'flock_id'                  => $item['flock_id'],
                    'pipe_id'                   => $item['pipe_id'],
                ], [
                    'tanggal_pemberian_pakan'   => $validated['tanggal_pemberian_pakan'],
                    'jumlah_ayam'               => $item['jumlah_ayam'],
                    'pemberian_pakan_per_ekor'  => $item['pemberian_pakan_per_ekor'],
                ]);
            }
           
            DB::commit();
            return back()->with('success', 'Data Perhitungan Pakan berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Store method failed', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage())
                ->withInput();
        }
    }
}
