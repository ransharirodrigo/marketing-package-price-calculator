<?php
namespace App\Services\OrderFilter;

use App\Interfaces\OrderFilter;

class InventoryFilter implements OrderFilter
{

    function apply($query, $value)
    {
        return  $query->whereHas('invoiceItems', function ($q) use ($value) {
            $q->where('inventory_id', $value);
        });
    }
}
