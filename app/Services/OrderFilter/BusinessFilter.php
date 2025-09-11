<?php

namespace App\Services\OrderFilter;

use App\Interfaces\OrderFilter;

class BusinessFilter implements OrderFilter
{

    function apply($query, $value)
    {
        return  $query->whereHas('invoiceItems', function ($q) use ($value) {
            $q->where('business_id', $value);
        });
    }
}
