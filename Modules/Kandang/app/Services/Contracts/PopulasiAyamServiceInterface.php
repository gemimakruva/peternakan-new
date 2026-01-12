<?php

namespace Modules\Kandang\Services\Contracts;

interface PopulasiAyamServiceInterface {
    public function getChickensPerRow(array $filter): array;
    // public function savePopulasiAyam();
    // public function saveAyamAfkir();
    // public function saveAyamKarantina();
}