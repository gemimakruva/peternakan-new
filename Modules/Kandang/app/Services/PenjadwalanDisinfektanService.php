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

            $jadwal = $this->repository->store($data);
            $jadwal->penjadwalanFlock()->insert($data['flocks']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Store Penjadwalan Disinfektan Error', [
                'user_id' => auth()->user()->id,
                'data'    => $data,
                'error'   => $th->getMessage(),
            ]);
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

            $jadwal = $this->repository->update($data, $jadwal);
            $jadwal->penjadwalanFlock()->delete();
            $jadwal->penjadwalanFlock()->insert($data['flocks']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update Penjadwalan Disinfektan Error', [
                'user_id' => auth()->user()->id,
                'data'    => $data,
                'error'   => $th->getMessage(),
            ]);
            throw new \Exception($th->getMessage());
        }

        return $jadwal;
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

            $jadwal->penjadwalanFlock()->delete();
            $jadwal->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Delete Penjadwalan Disinfektan Error', [
                'user_id' => auth()->user()->id,
                'data'    => $jadwal,
                'error'   => $th->getMessage(),
            ]);
            throw new \Exception($th->getMessage());
        }
    }
}
