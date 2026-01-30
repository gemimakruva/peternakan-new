<?php

namespace Modules\Kandang\Services\PerhitunganObat;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Models\VitaminObatMinum;
use Modules\Kandang\Repositories\PerhitunganObat\VitaminObatMinumRepository;
use Modules\Kandang\Repositories\Treatment\JenisTreatmentRepository;

class VitaminObatMinumService
{
    public function __construct(
        private VitaminObatMinumRepository $repository,
        private JenisTreatmentRepository $jenisTreatmentRepository
    ) {}

    public function index(array $filter): Collection
    {
        return $this->repository->index($filter, false);
    }

    public function getDatatable(array $filter): LengthAwarePaginator
    {
        $data = $this->repository->index($filter, true)
            ->paginate(10)
            ->withQueryString();

        return $data->through(function ($item) {
            $item->jumlah_ovk_per_flock = round($item->jumlah_air_di_tong_per_flock * ($item->dosis_pemberian / $item->satuan_per_dosis), 3);

            return $item;
        });
    }

    public function store(array $data): VitaminObatMinum
    {
        Log::info('Store Vitamin Obat Minum', [
            'user_id' => auth()->user()->id,
            'data'    => $data,
        ]);

        return $this->repository->create($data);
    }

    public function update(array $data, VitaminObatMinum $model): VitaminObatMinum
    {
        Log::info('Update Vitamin Obat minum', [
            'user_id' => auth()->user()->id,
            'data'    => $data,
        ]);

        $this->repository->update($data, $model->id);

        return $model->refresh();
    }

    public function getJenisTreatment(): Collection
    {
        return $this->jenisTreatmentRepository->all();
    }

    public function delete(VitaminObatMinum $model): void
    {
        Log::info('Delete Vitamin Obat Minum', [
            'user_id' => auth()->user()->id,
            'data'    => $model,
        ]);

        $this->repository->delete($model->id);
    }
}
