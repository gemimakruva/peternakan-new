<?php

namespace Modules\Kandang\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Kandang\Models\MonitoringKesehatan;
use Modules\Kandang\Repositories\MonitoringKesehatanRepository;

class MonitoringKesehatanService
{
    public function __construct(
        private MonitoringKesehatanRepository $repository
    ) {}

    public function index(array $filter): Collection
    {
        return $this->repository->index($filter, false);
    }

    public function getDatatable(array $filter): LengthAwarePaginator
    {
        return $this->repository->index($filter, true)
            ->paginate(10)
            ->withQueryString();
    }

    public function store(array $data): MonitoringKesehatan
    {
        Log::info('Store Monitoring Kesehatan', [
            'user_id' => auth()->user()->id,
            'data'    => $data,
        ]);

        try {
            $model =DB::transaction(function () use ($data) {
                $model = $this->repository->create($data);
                $this->updateOrCreateNekropsi($model, $data);

                $dokumentasi        = $this->uploadDocumentation($model, $data);
                $model->dokumentasi = $dokumentasi;
                $model->save();

                return $model;
            });
        } catch (\Throwable $th) {
            Log::error('Error storing Monitoring Kesehatan: ' . $th->getMessage(), [
                'user_id' => auth()->user()->id,
                'data'    => $data,
            ]);
            throw $th;
        }

        return $model->refresh();
    }

    public function uploadDocumentation(MonitoringKesehatan $model, array $data): array
    {
        $dokumentasi = [];

        if (isset($data['dokumentasi'])) {
            foreach ($data['dokumentasi'] as $dok) {
                $kandangSlug = Str::slug($model->kandang->nama ?? 'kandang');
                $basePath    = "monitoring-kesehatan/dokumentasi/{$kandangSlug}";

                $originalName = pathinfo(
                    $dok->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                $filename = Str::slug($originalName)
                    . '-' . now()->format('Ymd-His')
                    . '.' . $dok->getClientOriginalExtension();

                $dokumentasi[] = $dok->storeAs(
                    $basePath,
                    $filename,
                    'public'
                );
            }
        }

        return array_merge($data['existing_dokumentasi'] ?? [], $dokumentasi);
    }

    public function update(array $data, MonitoringKesehatan $model): MonitoringKesehatan
    {
        Log::info('Update Monitoring Kesehatan', [
            'user_id' => auth()->user()->id,
            'data'    => $data,
        ]);

        try {
            $data['dokumentasi'] = $this->uploadDocumentation($model, $data);

            DB::transaction(function () use ($model, $data) {
                $this->repository->update($data, $model->id);
                $this->updateOrCreateNekropsi($model, $data);
            });
        } catch (\Throwable $th) {
            Log::error('Error updating Monitoring Kesehatan: ' . $th->getMessage(), [
                'user_id' => auth()->user()->id,
                'data'    => $data,
            ]);
            throw $th;
        }

        return $model->refresh();
    }

    private function updateOrCreateNekropsi(MonitoringKesehatan $model, array $data): void
    {
        $ids = collect($data['nekropsi'] ?? [])
            ->pluck('id')
            ->filter()
            ->toArray();

        $model->nekropsi()
            ->whereNotIn('id', $ids)
            ->get()
            ->each(function ($item) {
                if ($item->path && Storage::disk('public')->exists($item->path)) {
                    Storage::disk('public')->delete($item->path);
                }
                $item->delete();
            });

        $kandangSlug = Str::slug($model->kandang->nama ?? 'kandang');
        $basePath    = "monitoring-kesehatan/nekropsi/{$kandangSlug}";

        foreach ($data['nekropsi'] ?? [] as $item) {
            $payload = Arr::only($item, ['keterangan']);

            if (! empty($item['image']) && $item['image']->isValid()) {

                $originalName = pathinfo(
                    $item['image']->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                $filename = Str::slug($originalName)
                    . '-' . now()->format('Ymd-His')
                    . '.' . $item['image']->getClientOriginalExtension();

                $payload['path'] = $item['image']->storeAs(
                    $basePath,
                    $filename,
                    'public'
                );
            } else {
                continue;
            }

            if (! empty($item['id'])) {
                $model->nekropsi()
                    ->where('id', $item['id'])
                    ->update($payload);
            } else {
                $model->nekropsi()->create($payload);
            }
        }
    }

    public function delete(MonitoringKesehatan $model): void
    {
        Log::info('Delete Monitoring Kesehatan', [
            'user_id' => auth()->user()->id,
            'data'    => $model,
        ]);

        $this->repository->delete($model->id);
    }
}
