<?php

namespace App\Services\OrderFilter;

use App\Interfaces\OrderFilter;

class MetricsFilter implements OrderFilter
{

    function apply($query, $value)
    {
        return  $query->whereHas('invoiceItems', function ($q) use ($value) {
            $q->where('metrics_id', $value);
        });
    }
}
