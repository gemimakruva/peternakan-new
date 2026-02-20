<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Support\Carbon;

trait KandangUmurTrait
{
    private int $kandangId;
    private int $umur;

    public function setContext(?int $kandangId = null, int $umur)
    {
        if ($kandangId !== null) {
            $this->kandangId    = $kandangId;
        }
        $this->umur         = $umur;
        return $this;
    }
}