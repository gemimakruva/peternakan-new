<?php

namespace Modules\Kandang\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Models\PenjadwalanDisinfektan;
use Modules\Kandang\Repositories\Disinfektan\JenisDisinfektanRepository;
use Modules\Kandang\Repositories\Disinfektan\PenjadwalanDisinfektanRepository;

class PenjadwalanDisinfektanService
{
    public function __construct(
        private PenjadwalanDisinfektanRepository $repository,
        private JenisDisinfektanRepository $jenisDisinfektanRepository
    ) {}

    public function index(): Collection
    {
        return $this->repository->index();
    }

    public function store(array $data): PenjadwalanDisinfektan
    {
        Log::info('Store Penjadwalan Disinfektan', [
            'user_id' => auth()->user()->id,
            'data'    => $data,
        ]);

        try {
            DB::beginTransaction();

            $data['pic_user_id'] = auth()->id();
            $jadwal              = $this->repository->store($data);
            $jadwal->penjadwalanFlocks()->createMany($data['flocks']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }

        return $jadwal;
    }

    public function update(array $data, PenjadwalanDisinfektan $jadwal): PenjadwalanDisinfektan
    {
        Log::info('Update Penjadwalan Disinfektan', [
            'user_id' => auth()->user()->id,
            'data'    => $data,
        ]);

        try {
            DB::beginTransaction();

            $jadwal->penjadwalanFlocks()->delete();
            $jadwal->penjadwalanFlocks()->createMany($data['flocks']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }

        return $jadwal->refresh()->load('penjadwalanFlocks');
    }

    public function getJenisDisinfektan(): Collection
    {
        return $this->jenisDisinfektanRepository->index();
    }

    public function delete(PenjadwalanDisinfektan $jadwal): void
    {
        Log::info('Delete Penjadwalan Disinfektan', [
            'user_id' => auth()->user()->id,
            'data'    => $jadwal,
        ]);

        try {
            DB::beginTransaction();

            $jadwal->penjadwalanFlocks()->delete();
            $jadwal->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
