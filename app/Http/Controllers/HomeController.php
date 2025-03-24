<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessInventoryMetricsPrices;
use App\Models\Inventory;
use App\Models\Metrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $inventory_count = Inventory::count();
        $metrics_count = Metrics::count();

        $business_inventory_metrics_price_row_count_for_business = $inventory_count * $metrics_count;

        $all_businesses = Business::all();

        $businesses_for_price_updates = [];

        foreach ($all_businesses as $business) {
            $count = BusinessInventoryMetricsPrices::where('business_id', $business->id)->count();

            if ($count != $business_inventory_metrics_price_row_count_for_business) {
                $businesses_for_price_updates[] = $business;
            }
        }

        $metrics = Metrics::get();

        return view("home", compact('businesses_for_price_updates', 'metrics'));
    }
}
