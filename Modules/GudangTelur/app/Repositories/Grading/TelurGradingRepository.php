<?php

namespace Modules\GudangTelur\Repositories\Grading;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\GudangTelur\Models\TelurGrading;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurGradingRepository extends EloquentRepository
{
    public function __construct(TelurGrading $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->from('telur_grading', 'tg')
            ->join('kandang as k', 'k.id', '=', 'tg.kandang_id')
            ->join('users as u', 'u.id', '=', 'tg.pic_user_id')
            ->leftJoin('telur_grading_item as tgi', 'tgi.telur_grading_id', '=', 'tg.id')
            ->selectRaw(<<<SQL
                tg.id
                , tg.tanggal
                , k.nama as nama_kandang
                , u.name as nama_pic_user
                , sum(tgi.jumlah) as jumlah
            SQL)
            ->groupBy('tg.id');

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('nama_pic_user', 'LIKE', "%$search%");
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('tg.tanggal');
        $q->orderByDesc('tg.id');
    }

    public function save(array $data)
    {
        DB::beginTransaction();
        try {
            $telurGrading = $this->model->updateOrCreate([
                'id'            => @$data['id'],
            ], [
                'pic_user_id'   => $data['pic_user_id'],
                'kandang_id'    => $data['kandang_id'],
                'tanggal'       => $data['tanggal'],
            ]);

            $savedTelurGradingItemIds = [];
            foreach ($data['grading'] as $item) {
                if (!@$item['jumlah'] || @$item['jumlah'] == 0) continue;
                $item = $telurGrading->telurGradingItems()->updateOrCreate([
                    'id'                => @$item['id']
                ], [
                    'telur_jenis_id'    => $item['telur_jenis_id'],
                    'jumlah'            => $item['jumlah'],
                ]);
                $savedTelurGradingItemIds[] = $item->id;
            }
            $telurGrading->telurGradingItems()->whereNotIn('id', $savedTelurGradingItemIds)->delete();

            DB::commit();
            return $telurGrading;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
    }
}