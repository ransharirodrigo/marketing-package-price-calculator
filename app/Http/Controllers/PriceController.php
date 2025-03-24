<?php

namespace App\Http\Controllers;

use App\Models\BusinessInventoryMetricsPrices;
use App\Models\Metrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller
{
    public function saveMetricsPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id' => 'required|exists:business,id',
            'inventory_id' => 'required|exists:inventory,id',
            'Impressions' => 'required|numeric',
            'Views' => 'required|numeric',
            'Clicks' => 'required|numeric',
            'Video_views' => 'required|numeric',
            'Calls' => 'required|numeric',
        ], [
            'business_id.required' => 'Please select a business.',
            'business_id.exists' => 'The selected business does not exist.',
            'inventory_id.required' => 'Please select an inventory type.',
            'inventory_id.exists' => 'The selected inventory type does not exist.',
            'Impressions.required' => 'Impression price is required.',
            'Impressions.numeric' => 'Impression price must be a number.',
            'Views.required' => 'View price is required.',
            'Views.numeric' => 'View price must be a number.',
            'Clicks.required' => 'Click price is required.',
            'Clicks.numeric' => 'Click price must be a number.',
            'Video_views.required' => 'Video view price is required.',
            'Video_views.numeric' => 'Video view price must be a number.',
            'Calls.required' => 'Call price is required.',
            'Calls.numeric' => 'Call price must be a number.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $businessId = $request->input('business_id');
            $inventoryId = $request->input('inventory_id');

            $metricNames = ['Impressions', 'Views', 'Clicks', 'Video views', 'Calls'];

            foreach ($metricNames as $metricName) {
                $metric = Metrics::where('name', $metricName)->first();

                if ($metric) {
                    if ($metricName == "Video views") {
                        $metricName = "Video_views";
                    }

                    $price = $request->input($metricName);

                    if ($price !== null) {
                        $businessInventoryMetricPrice = new BusinessInventoryMetricsPrices();
                        $businessInventoryMetricPrice->business_id = $businessId;
                        $businessInventoryMetricPrice->inventory_id = $inventoryId;
                        $businessInventoryMetricPrice->metrics_id = $metric->id;
                        $businessInventoryMetricPrice->price = $price;
                        $businessInventoryMetricPrice->save();
                    }
                } else {
                    $response = [
                        'error' => true,
                        'message' => 'Metric not found' . " " . $metric
                    ];

                    return response()->json($response, 400);
                }
            }

            $response = [
                'error' => false,
                'message' => 'Price metrics saved successfully.'
            ];
            return response()->json($response);
            
        } catch (\Exception $e) {
            $response = [
                'error' => true,
                'message' => 'Error saving price metrics.'
            ];
            return response()->json($response, 500);
        }
    }
}
