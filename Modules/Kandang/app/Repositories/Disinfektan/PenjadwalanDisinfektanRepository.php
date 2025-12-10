<?php

namespace Modules\Kandang\Repositories\Disinfektan;

use Illuminate\Support\Collection;
use Modules\Kandang\Models\PenjadwalanDisinfektan;

class PenjadwalanDisinfektanRepository
{
    public function index(): Collection
    {
        return PenjadwalanDisinfektan::with(['kandang', 'penjadwalanFlock'])
            ->get();
    }

    public function find(int $id): PenjadwalanDisinfektan
    {
        return PenjadwalanDisinfektan::with(['kandang', 'penjadwalanFlock'])
            ->findOrFail($id);
    }

    public function store(array $data): PenjadwalanDisinfektan
    {
        return PenjadwalanDisinfektan::create($data);
    }

    public function update(array $data, PenjadwalanDisinfektan $model): PenjadwalanDisinfektan
    {
        $model->update($data);

        return $model;
    }

    public function delete(PenjadwalanDisinfektan $model): bool
    {
        return $model->delete();
    }
}
