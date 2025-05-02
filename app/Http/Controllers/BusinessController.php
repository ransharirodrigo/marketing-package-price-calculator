<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessInventoryMetricsPrices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function show()
    {

        $businesses = Business::get();
        $data = [];

        $index = 1;

        foreach ($businesses as $business) {
            $data[] = [
                'no' => $index,
                'business' => $business->name,
                "action" => "<i class='fas fa-edit edit-business-btn' data-id='" . $business->id . "' data-url='businesses/" . $business->id . "/edit' style='cursor: pointer;'></i> <i class='fas fa-trash-alt delete-btn' data-id='" . $business->id . "' data-url='businesses/" . $business->id . "/delete' style='cursor: pointer; margin-left: 10px;'></i>"
            ];
            $index++;
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'businessName' => 'required|string|max:50',
        ], [
            'businessName.required' => 'Please enter a business name.',
            'businessName.max' => 'The business name is too long (maximum 50 characters).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->get('businessName')[0]
            ], 422);
        }

        $businessName = $request->input('businessName');

        try {
            $business = new Business();
            $business->name = $businessName;
            $business->save();

            $response = [
                'error' => false,
                'message' => 'Business saved successfully'
            ];

            return response()->json($response);
        } catch (\Exception $e) {

            Log::info($e);
            $response = [
                'error' => true,
                'message' => 'Error saving business: ' . $e->getMessage()
            ];

            return response()->json($response, 500);
        }
    }

    public function edit($id)
    {
        $business = Business::find($id);

        if (!$business) {
            return response()->json(['error' => 'Business not found'], 404);
        }

        return response()->json($business);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $business = Business::find($id);

            if (!$business) {
                return response()->json(['error' => 'Business not found'], 404);
            }

            $business->name = $request->name;
            $business->save();

            $response=[
                "error"=>false,
                "message"=>"Business name updated successfully",
                "id"=>$id,
                "name"=>$request->name
            ];

            return response()->json( $response);
        } catch (Exception $e) {
        }
    }

 

    public function destroy($id)
{
    $business = Business::find($id);
    
    if ($business) {
        BusinessInventoryMetricsPrices::where('business_id', $id)->delete();
        
        $business->delete();
        
        return response()->json(['success' => true, 'message' => 'Business Deleted Successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Business not found.']);
    }
}

}
