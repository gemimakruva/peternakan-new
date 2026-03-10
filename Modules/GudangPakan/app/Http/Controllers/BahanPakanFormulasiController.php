<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangPakan\Enums\BahanPakanFormulasiItemTipe;
use Modules\GudangPakan\Enums\BahanPakanFormulasiTipe;
use Modules\GudangPakan\Models\BahanPakanFormulasi;
use Modules\GudangPakan\Repositories\BahanPakanFormulasiRepository;
use Modules\GudangPakan\Repositories\MasterData\BahanPakanRepository;
use Modules\Kandang\Repositories\Pakan\JenisPakanRepository;

class BahanPakanFormulasiController extends Controller
{    
    public function __construct(
        private BahanPakanFormulasiRepository $repository,
        private JenisPakanRepository $jenisPakanRepository,
        private BahanPakanRepository $bahanPakanRepository,
    ) {
        $this->middleware('can:gudang-pakan.bahan-pakan-formulasi.menu-bahan-pakan-formulasi');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['jenis_pakan_id', 'tipe']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        $listTipe = BahanPakanFormulasiTipe::getSelectItems();
        $listJenisPakan = $this->jenisPakanRepository->getSelectItems();
        return view('gudang-pakan::bahan-pakan-formulasi.index', compact([
            'datas',
            'listTipe',
            'listJenisPakan',
        ]));
    }

    public function create()
    {
        $listTipe = BahanPakanFormulasiTipe::getSelectItems();
        $listJenisPakan = $this->jenisPakanRepository->getSelectItems();
        $listBahanPakan = $this->bahanPakanRepository->getSelectItems();
        $listBahanPakanSatuan = $this->bahanPakanRepository->getSelectItemsWithSatuan();
        return view('gudang-pakan::bahan-pakan-formulasi.create', compact([
            'listTipe',
            'listJenisPakan',
            'listBahanPakan',
            'listBahanPakanSatuan',
        ]));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'jenis_pakan_id'            => ['required', 'exists:jenis_pakan,id'],
            'tipe'                      => ['required', Rule::in(BahanPakanFormulasiTipe::getArrayValues())],
            'nama'                      => ['required', 'string', 'unique:bahan_pakan_formulasi,nama'],
            // 'items.*'                   => ['required', 'array'],
            // 'items.*.id'                => ['nullable', 'exists:bahan_pakan_formulasi_item,id'],
            // 'items.*.bahan_pakan_id'    => ['required', 'exists:bahan_pakan,id'],
            // 'items.*.persentase'        => ['required', 'numeric'],
            // 'berat_pakan.*'             => ['required', 'array'],
            // 'berat_pakan.*.id'          => ['nullable', 'exists:bahan_pakan_formulasi_berat,id'],
            // 'berat_pakan.*.berat'       => ['required', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $bahanPakanFormulasi = $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-formulasi.edit', $bahanPakanFormulasi)
            ->with('success', 'Data Formulasi Bahan Pakan Berhasil Disimpan.');
    }

    public function edit(BahanPakanFormulasi $bahanPakanFormulasi)
    {
        $bahanPakanFormulasi->load([
            'bahanPakanFormulasiItem',
            'bahanPakanFormulasiBerat',
        ]);
        $data = $bahanPakanFormulasi;
        $listTipe = BahanPakanFormulasiTipe::getSelectItems();
        $listItemTipe = BahanPakanFormulasiItemTipe::getSelectItems();
        $listJenisPakan = $this->jenisPakanRepository->getSelectItems();
        $listBahanPakan = $this->bahanPakanRepository->getSelectItems();
        $listFormulasiPremix = $this->repository->getSelectItems2($bahanPakanFormulasi->id);
        $listBahanPakanSatuan = $this->bahanPakanRepository->getSelectItemsWithSatuan();
        return view('gudang-pakan::bahan-pakan-formulasi.edit', compact([
            'data',
            'listTipe',
            'listItemTipe',
            'listJenisPakan',
            'listBahanPakan',
            'listFormulasiPremix',
            'listBahanPakanSatuan',
        ]));
    }

    public function update(Request $request, BahanPakanFormulasi $bahanPakanFormulasi)
    {
        $validated = $request->validate([
            'jenis_pakan_id'            => ['required', 'exists:jenis_pakan,id'],
            'tipe'                      => ['required', Rule::in(BahanPakanFormulasiTipe::getArrayValues())],
            'nama'                      => ['required', 'string', Rule::unique('bahan_pakan_formulasi', 'nama')->ignoreModel($bahanPakanFormulasi)],
            'items.*'                   => ['required', 'array'],
            'items.*.id'                => ['nullable', 'exists:bahan_pakan_formulasi_item,id'],
            'items.*.tipe'              => ['required', Rule::in(BahanPakanFormulasiItemTipe::getArrayValues())],
            'items.*.formulasi_premix_id'   => ['required_without:items.*.bahan_pakan_id', 'exists:bahan_pakan,id'],
            'items.*.bahan_pakan_id'        => ['required_without:items.*.formulasi_premix_id', 'exists:bahan_pakan,id'],
            'items.*.persentase'        => ['required', 'numeric'],
            'berat_pakan.*'             => ['required', 'array'],
            'berat_pakan.*.id'          => ['nullable', 'exists:bahan_pakan_formulasi_berat,id'],
            'berat_pakan.*.berat'       => ['required', 'numeric'],
        ]);

        $validated['id'] = $bahanPakanFormulasi->id;
        $validated['pic_user_id'] = $bahanPakanFormulasi->pic_user_id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-formulasi.index')
            ->with('success', 'Data Formulasi Bahan Pakan Berhasil Diupdate.');
    }

    public function destroy(BahanPakanFormulasi $bahanPakanFormulasi)
    {
        $bahanPakanFormulasi->bahanPakanFormulasiItem()->delete();
        $bahanPakanFormulasi->bahanPakanFormulasiBerat()->delete();
        $bahanPakanFormulasi->delete();

        return to_route('gudang-pakan.bahan-pakan-formulasi.index')
            ->with('success', 'Data Formulasi Bahan Pakan Berhasil Dihapus.');
    }
}
