<?php

namespace Modules\Kandang\Services;

use Modules\Kandang\Repositories\PopulasiAyamRepository;

class PopulasiAyamService
{
    public function __construct(private PopulasiAyamRepository $repository) {}

    public function getChickensPerRow(array $filter): array
    {
        $total = $this->repository->getChickensPerRow($filter['flock_id'], $filter['date']);

        return [
            'flock_id' => $filter['flock_id'],
            'date'     => $filter['date'],
            'total'    => $total,
        ];
    }
}
