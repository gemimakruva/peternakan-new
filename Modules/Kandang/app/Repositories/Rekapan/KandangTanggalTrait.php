<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Support\Carbon;

trait KandangTanggalTrait
{
    private int $kandangId;
    private ?Carbon $tanggal;

    public function setContext(int $kandangId, ?Carbon $tanggal = null)
    {
        $this->kandangId    = $kandangId;
        $this->tanggal      = $tanggal;

        return $this;
    }
}