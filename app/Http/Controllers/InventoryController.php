<?php

namespace App\Http\Controllers;

use App\Models\BusinessInventoryMetricsPrices;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function getRelatedInventoryForBusiness(Request $request)
    {
        $businessId = $request->input("businessId");
        $pricedInventoryIds = BusinessInventoryMetricsPrices::where('business_id', $businessId)
            ->pluck('inventory_id')
            ->toArray();

        $unpricedInventories = Inventory::when(count($pricedInventoryIds) > 0, function ($query) use ($pricedInventoryIds) {
            return $query->whereNotIn('id', $pricedInventoryIds);
        })->get();

        $response = [
            'error' => false,
            'message' => $unpricedInventories
        ];

        return response()->json($response);
    }
}
