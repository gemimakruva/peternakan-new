<?php

namespace Modules\Kandang\Repositories\Disinfektan;

use Illuminate\Support\Collection;
use Modules\Kandang\Models\JenisDisinfektan;

class JenisDisinfektanRepository
{
    public function index(): Collection
    {
        return JenisDisinfektan::all();
    }
}
