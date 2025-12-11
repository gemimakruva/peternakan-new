<?php

namespace Modules\Kandang\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Kandang\Repositories\Contracts\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Apply eager loads to a query builder.
     */
    protected function applyWith(Builder $query, array|string|null $with): Builder
    {
        if (empty($with)) {
            return $query;
        }

        return $query->with($with);
    }

    /**
     * Get all records, optionally eager loading relations.
     */
    public function all(array|string|null $with = null, array $columns = ['*']): Collection
    {
        $q = $this->model->newQuery();
        $q = $this->applyWith($q, $with);

        return $q->get($columns);
    }

    /**
     * Paginate records, optionally eager loading relations.
     */
    public function paginate(int $perPage = 15, array|string|null $with = null, array $columns = ['*']): LengthAwarePaginator
    {
        $q = $this->model->newQuery();
        $q = $this->applyWith($q, $with);

        return $q->paginate($perPage, $columns);
    }

    /**
     * Find by primary key, optionally eager loading relations.
     */
    public function find(int|string $id, array|string|null $with = null, array $columns = ['*']): ?Model
    {
        $q = $this->model->newQuery();
        $q = $this->applyWith($q, $with);

        return $q->find($id, $columns);
    }

    /**
     * Find first record matching criteria, optionally eager loading relations.
     */
    public function findBy(array $criteria, array|string|null $with = null, array $columns = ['*']): ?Model
    {
        $q = $this->model->newQuery();
        foreach ($criteria as $k => $v) {
            $q->where($k, $v);
        }
        $q = $this->applyWith($q, $with);

        return $q->first($columns);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * Update a record by id.
     */
    public function update(array $data, int|string $id): bool
    {
        $record = $this->find($id);
        if (! $record) {
            return false;
        }

        return $record->update($data);
    }

    /**
     * Delete a record by id.
     */
    public function delete(int|string $id): bool
    {
        $record = $this->find($id);
        if (! $record) {
            return false;
        }

        return (bool) $record->delete();
    }

    /**
     * Restore a soft-deleted record.
     */
    public function restore(int|string $id): bool
    {
        $record = $this->model->newQuery()->withTrashed()->find($id);
        if (! $record || ! method_exists($record, 'restore')) {
            return false;
        }

        return (bool) $record->restore();
    }

    /**
     * Force delete a model (permanent).
     */
    public function forceDelete(int|string $id): bool
    {
        $record = $this->model->newQuery()->withTrashed()->find($id);
        if (! $record) {
            return false;
        }

        return (bool) $record->forceDelete();
    }

    /**
     * Return a new query builder optionally preloaded with relations.
     */
    public function query(array|string|null $with = null): Builder
    {
        $q = $this->model->newQuery();

        return $this->applyWith($q, $with);
    }
}
