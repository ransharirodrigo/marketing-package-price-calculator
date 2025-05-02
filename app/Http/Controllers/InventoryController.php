<?php

namespace App\Http\Controllers;

use App\Models\BusinessInventoryMetricsPrices;
use App\Models\Inventory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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

    public function show()
    {
        $inventories = Inventory::get();
        $data = [];

        $index = 1;

        foreach ($inventories as $inventory) {
            $data[] = [

                'no' => $index,
                'name' => $inventory->name,
                'action' => "<i class='fas fa-edit edit-inventory-btn' data-id='" . $inventory->id . "' data-url='inventories/" . $inventory->id . "/edit' style='cursor: pointer;'></i> <i class='fas fa-trash-alt delete-inventory-btn' data-id='" . $inventory->id . "' data-url='inventories/" . $inventory->id . "/delete' style='cursor: pointer; margin-left: 10px;'></i>"
            ];
            $index++;
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inventoryName' => 'required|string|max:50',
        ], [
            'inventoryName.required' => 'Please enter an inventory name.',
            'inventoryName.max' => 'The inventory name is too long (maximum 50 characters).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->get('inventoryName')[0]
            ], 422);
        }

        $inventoryName = $request->input('inventoryName');

        try {
            $inventory = new Inventory();
            $inventory->name = $inventoryName;
            $inventory->save();

            $response = [
                'error' => false,
                'message' => 'Inventory saved successfully'
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            Log::info($e);
            $response = [
                'error' => true,
                'message' => 'Error saving inventory: ' . $e->getMessage()
            ];

            return response()->json($response, 500);
        }
    }

    public function edit($id)
    {
        $business = Inventory::find($id);

        if (!$business) {
            return response()->json(['error' => 'Inventory not found'], 404);
        }

        return response()->json($business);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'updatedInventoryName' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $inventory = Inventory::find($id);

            if (!$inventory) {
                return response()->json(['error' => 'Inventory not found'], 404);
            }

            $inventory->name = $request->updatedInventoryName;
            $inventory->save();

            $response = [
                "error" => false,
                "message" => "Inventory name updated successfully",
                "id" => $id,
                "name" => $request->updatedInventoryName
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                "error" => true,
                "message" => "An error occurred while updating inventory: " . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);

        if ($inventory) {
            BusinessInventoryMetricsPrices::where('inventory_id', $id)->delete();

            $inventory->delete();

            return response()->json(['success' => true, 'message' => 'Inventory Deleted Successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Inventory not found.'], 404);
        }
    }
}
