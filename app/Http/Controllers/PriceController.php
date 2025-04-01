<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessInventoryMetricsPrices;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Metrics;
use App\Rules\AtLeastOneRequired;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;

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

    public function show()
    {

        $prices = BusinessInventoryMetricsPrices::with(['business', 'inventory', 'metrics'])->get();
        $data = [];

        $index = 1;

        foreach ($prices as $price) {
            $data[] = [
                'no' => $index,
                'business' => $price->business->name,
                'inventory' => $price->inventory->name,
                'metric' => $price->metrics->name,
                'price' => $price->price,
                "action" => "<i class='fas fa-edit price-metrics-edit-btn' data-id='" . $price->id . "' data-url='business-inventory-metric-prices/" . $price->id . "/edit' style='cursor: pointer;'></i>"
            ];
            $index++;
        }
        return response()->json($data);
    }

    public function edit(int $id)
    {
        $price = BusinessInventoryMetricsPrices::with(['business', 'inventory', 'metrics'])->find($id);

        if (!$price) {
            return response()->json(['error' => 'Price data not found'], 404);
        }
        return response()->json([
            'id' => $price->id,
            'business_id' => $price->business_id,
            'inventory_id' => $price->inventory_id,
            'metrics_id' => $price->metrics_id,
            'price' => $price->price,
            'business' => [
                'name' => $price->business->name,
            ],
            'inventory' => [
                'name' => $price->inventory->name,
            ],
            'metrics' => [
                'name' => $price->metrics->name,
            ],
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:business_inventory_metric_prices,id',
            'price' => 'required|numeric',
        ], [
            'id.required' => 'ID is required.',
            'price.required' => 'Price is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $price_row = BusinessInventoryMetricsPrices::find($request->id);

            if (!$price_row) {
                return response()->json(['error' => true, 'message' => 'Price data not found'], 404);
            }

            $price_row->price = $request->price;
            $price_row->save();

            return response()->json(['error' => false, 'message' => 'Price updated successfully']);
        } catch (Exception $e) {
            Log::info($e);
        }
    }

    public function calculatePrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'businessType' => 'required|exists:business,id',
            '1' => 'nullable|numeric',
            '2' => 'nullable|numeric',
            '3' => 'nullable|numeric',
            '4' => 'nullable|numeric',
            '5' => 'nullable|numeric',
            // 'at_least_one' => ['required', new AtLeastOneRequired(['1', '2', '3', '4', '5'])],
            // 'at_least_one_inventory' => ['required', new AtLeastOneRequired(['Facebook', 'Youtube', 'Tiktok', 'Instagram', 'Twitter','Web_Pages-Tamil','Web_Pages-Sinhala'])],
        ]);

        if ($validator->fails()) {
            $response = [
                "error" => true,
                "message" => $validator->errors()
            ];

            return response()->json($response);
        }

        if (!$request->hasAny(["Facebook", "Youtube", "Tiktok", "Instagram", "Twitter", "Web_Pages-Tamil", "Web_Pages-Sinhala"])) {
            $response = [
                "error" => true,
                "message" => "Please select atleast one inventory platform"
            ];

            return response()->json($response);
        }

        if (!$request->anyFilled("1", "2", "3", "4", "5")) {
            $response = [
                "error" => true,
                "message" => "Please enter atleast one metric count"
            ];

            return response()->json($response);
        }

        $businessTypeId = $request->input('businessType');
        $inventoryKeysToCheck = [
            'Facebook',
            'Youtube',
            'Tiktok',
            'Instagram',
            'Twitter',
            'Web_Pages-Tamil',
            'Web_Pages-Sinhala',
        ];
        $metricValues = $request->only(['1', '2', '3', '4', '5']);

        $business = Business::find($businessTypeId);

        if (!$business) {
            $response = [
                "error" => true,
                "message" => "Business not found."
            ];
            return response()->json($response);
        }

        $checkedInventoryKeys = [];

        foreach ($inventoryKeysToCheck as $key) {
            if ($request->has($key)) {
                $checkedInventoryKeys[] = $key;
            }
        }

        $checkedInventoryIds = [];

        foreach ($checkedInventoryKeys as $key) {
            if ($key === 'Web_Pages-Tamil') {
                $key = 'Web Pages-Tamil';
            } elseif ($key === 'Web_Pages-Sinhala') {
                $key = 'Web Pages-Tamil';
            }

            $inventory = Inventory::where("name", $key)->first();
            if ($inventory) {
                $checkedInventoryIds[] = $inventory->id;
            }
        }

        $result = $this->calculateTotalPriceWithDetails($businessTypeId, $checkedInventoryIds, $metricValues);
        $response = [
            "error" => false,
            "data" => $result
        ];
        return response()->json($response);
    }

    private function calculateTotalPriceWithDetails(int $businessId, array $inventoryIds, array $metricValues): array
    {
        $totalPrice = 0;
        $missingPrices = [];
        $priceDetails = [];

        foreach ($inventoryIds as $inventoryId) {
            foreach ($metricValues as $metricId => $value) {
                if ($value !== null) {
                    $priceRow = BusinessInventoryMetricsPrices::where('business_id', $businessId)
                        ->where('inventory_id', $inventoryId)
                        ->where('metrics_id', $metricId)
                        ->with(['business', 'inventory', 'metrics'])
                        ->first();

                    if ($priceRow) {
                        $price = $priceRow->price;
                        $subtotal = $price * $value;
                        $totalPrice += $subtotal;

                        $priceDetails[] = [
                            'inventory_name' => $priceRow->inventory->name,
                            'metrics_name' => $priceRow->metrics->name,
                            'price' => $price,
                            'value' => $value,
                            'subtotal' => $subtotal,
                        ];
                    } else {

                        $inventoryName = Inventory::find($inventoryId)->name;
                        $metricsName = Metrics::find($metricId)->name;

                        $missingPrices[] = [
                            'inventory_name' => $inventoryName,
                            'metrics_name' => $metricsName,
                        ];
                    }
                }
            }
        }

        return [
            'total_price' => $totalPrice,
            'missing_prices' => $missingPrices,
            'price_details' => $priceDetails,
        ];
    }

    public function generatePdf(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'clientName' => 'required|string',
        //     'clientMobileNumber' => 'required',
        //     'clientEmail' => 'nullable|email',
        // ], [
        //     'clientMobileNumber.regex' => 'The mobile number is not a valid Sri Lankan mobile number.',
        // ]);


        // if ($validator->fails()) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => $validator->errors(),
        //     ], 422);
        // }

        try {
            $clientName = $request->input('clientName');
            $clientAddress = $request->input('clientAddress');
            $clientMobileNumber = $request->input('clientMobileNumber');
            $clientEmail = $request->input('clientEmail');
            $totalResultHtml = $request->input('totalResultHtml');

            $prefix = 'INV-';
            $date = now()->format('Ymd');
            $invoiceNumber = $prefix . $date;

            $invoice = Invoice::create([
                'name' => $clientName,
                'address' => $clientAddress,
                'mobile' => $clientMobileNumber,
                'email' => $clientEmail,
                'invoice_number' => $invoiceNumber,
                'status' => "0",
            ]);

            $data = [
                'clientName' => $clientName,
                'clientAddress' => $clientAddress,
                'clientMobile' => $clientMobileNumber,
                'invoiceNumber' => $invoiceNumber,
                'totalResultHtml' => $totalResultHtml,
            ];
            $pdf = PDF::loadView('pdf.price_calculation', $data);

            return $pdf->download('price_calculation.pdf');
        } catch (Exception $e) {
            Log::info($e);
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while generating the PDF.',
            ], 500);
        }
    }
}
