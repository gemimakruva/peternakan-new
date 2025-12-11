<?php

namespace Modules\Kandang\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int|string $id, array $columns = ['*']): ?Model;

    public function findBy(array $criteria, array $columns = ['*']): ?Model;

    public function create(array $data): Model;

    public function update(array $data, int|string $id): bool;

    public function delete(int|string $id): bool;

    public function restore(int|string $id): bool;

    public function forceDelete(int|string $id): bool;

    public function query(): \Illuminate\Database\Eloquent\Builder;
}
