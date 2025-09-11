<?php

namespace App\Services\OrderFilter;

use App\Services\OrderFilter\BusinessFilter;
use App\Services\OrderFilter\InventoryFilter;
use App\Services\OrderFilter\MetricsFilter;

class OrderFilterContext
{
    private array $filter;

    public function __construct()
    {

        $this->filter = [
            'business' => new BusinessFilter(),
            'inventory' => new InventoryFilter(),
            'metrics'   => new MetricsFilter(),
        ];
    }


    public function applyFilter($query, $type, $value)
    {

        if (isset($this->filter[$type])) {
            return $this->filter[$type]->apply($query, $value);
        }

        return $query;
    }
}
