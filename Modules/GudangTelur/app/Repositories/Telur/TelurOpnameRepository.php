<?php

namespace Modules\GudangTelur\Repositories\Telur;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Enums\TelurJenisTipe;
use Modules\GudangTelur\Enums\TipeTelurInventory;
use Modules\GudangTelur\Models\TelurJenis;
use Modules\GudangTelur\Models\TelurOpname;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurOpnameRepository extends EloquentRepository
{
    public function __construct(TelurOpname $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users', 'users.id', '=', 'telur_opname.pic_user_id')
            ->selectRaw(<<<SQL
                telur_opname.id
                , telur_opname.tanggal
                , users.name as nama_pic_user
            SQL);

        return $query;
    }

    public function save(array $data): TelurOpname
    {
        $telurOpname = $this->model->updateOrCreate([
            'id'            => @$data['id']
        ], [
            'pic_user_id'   => $data['pic_user_id'],
            'tanggal'       => $data['tanggal'],
        ]);

        $opnameTelurJenisId = app(TelurJenis::class)->where([
            'tipe'  => TelurJenisTipe::OPNAME->value,
            'nama'  => 'Campur',
        ])->value('id');

        $telurOpname->telurInventory()->updateOrCreate([
            'telur_opname_id'   => $telurOpname->id
        ], [
            'tipe'              => TipeTelurInventory::OPNAME->value,
            'tanggal'           => $data['tanggal'],
            'jumlah'            => $data['opname'],
            'telur_jenis_id'    => $opnameTelurJenisId,
        ]);

        return $telurOpname;
    }
}