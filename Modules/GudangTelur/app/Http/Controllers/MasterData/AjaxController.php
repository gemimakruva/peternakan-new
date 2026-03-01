<?php

namespace Modules\GudangTelur\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Modules\GudangTelur\Models\Kemasan;
use Modules\GudangTelur\Models\SupplierKemasan;

class AjaxController extends Controller
{
    public function __construct(
        private Kemasan $kemasan,
        private SupplierKemasan $supplierKemasan,
    ) { }

    public function supplierKemasan($supplierId)
    {
        $datas = $this->supplierKemasan
            ->query()
            ->with([
                'kemasan:id,satuan_id,nama',
                'kemasan.satuan:id,nama',
            ])
            ->where('supplier_id', '=', $supplierId)
            ->get()
            ->transform(function ($item) {
                return $item->kemasan;
            });
        
        return $datas;
    }
}