<?php

namespace App\Http\Controllers;

use App\Models\Business;
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
                "action" => "<i class='fas fa-edit edit-btn' data-id='" . $business->id . "' style='cursor: pointer;'></i> <i class='fas fa-trash-alt delete-btn' data-id='" . $business->id . "' style='cursor: pointer; margin-left: 10px;'></i>"
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
}
