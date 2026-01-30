<?php

namespace Modules\Kandang\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function getQuery(): Builder;

    public function searchQuery(Builder $q, string $search): void;

    public function customWhereQuery(): array;

    public function wheresQuery(Builder $q, ?Collection $wheres = null): void;

    public function paginate(
        ?string $search = null,
        ?Collection $wheres = null,
        ?Collection $orders = null,
        int $perPage = 15,
        array $columns = ['*'],
    ): LengthAwarePaginator;

    public function all(array $columns = ['*']): Collection;

    public function find(int|string $id, array $columns = ['*']): ?Model;

    public function findBy(array $criteria, array $columns = ['*']): ?Model;

    public function create(array $data): Model;

    public function update(array $data, int|string $id): bool;

    public function delete(int|string $id): bool;

    public function restore(int|string $id): bool;

    public function forceDelete(int|string $id): bool;
}
