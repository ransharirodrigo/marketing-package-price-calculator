<?php

namespace App\Http\Controllers;

use App\Helpers\SettingHelper;
use App\Helpers\StorageHelper;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;

class SettingsController extends Controller
{
  public function index()
  {

    $invoice_note = SettingHelper::getSetting("invoice_note");
    $company_name = SettingHelper::getSetting("company_name");
    $company_contact = SettingHelper::getSetting("company_contact");
    $company_address = SettingHelper::getSetting("company_address");
    $company_email = SettingHelper::getSetting("company_email");
    $company_logo = SettingHelper::getSetting("company_logo");

    if (!$invoice_note) {
      $invoice_note = '';
    }


    return view("settings", compact("invoice_note", 'company_name', 'company_contact', 'company_address', 'company_email', 'company_logo'));
  }


  public function notesStore(Request $request)
  {

    try {
      $request->validate([
        'content' => 'required',
      ], [
        'content.required' => 'The note content is required.',
      ]);

      $type = 'invoice_note';
      $response_message = "";

      $setting = Setting::where('type', $type)->first();

      if ($setting) {

        $setting->content = $request->input('content');
        $setting->save();

        $response_message = "Note updated successfully";
      } else {

        $setting = new Setting();
        $setting->type = $type;
        $setting->content = $request->input('content');
        $setting->save();
        $response_message = "Note saved successfully";
      }

      $response = [
        "error" => false,
        "message" => $response_message
      ];

      return response()->json($response);
    } catch (\Exception $e) {
      Log::error('Error saving note: ' . $e->getMessage());

      $response = [
        "error" => true,
        "message" => $e->getMessage()
      ];

      return response()->json($response);
    }
  }

  public function companySettingUpdate(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'companyName' => 'nullable',
      'contactNumber' => 'nullable',
      'address' => 'nullable',
      'email' => 'nullable',
      'logo' => 'nullable',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => true,
        'message' => $validator->errors()->first(),
      ], 422);
    }
    try {
      if ($request->has('companyName')) {
        SettingHelper::updateSetting('company_name', $request->companyName);
      }

      if ($request->has('contactNumber')) {
        SettingHelper::updateSetting('company_contact', $request->contactNumber);
      }

      if ($request->has('address')) {
        SettingHelper::updateSetting('company_address', $request->address);
      }

      if ($request->has('email')) {
        SettingHelper::updateSetting('company_email', $request->email);
      }
      $filename = "";
      if ($request->hasFile('logo')) {
        $old_logo_data_row = SettingHelper::getSetting("company_logo");

        $logo = $request->file('logo');
        $filename = 'logo.' . $logo->getClientOriginalExtension();
        $path = 'images/' . $filename;

        SettingHelper::updateSetting('company_logo', $path);
        StorageHelper::deleteLocalImage($old_logo_data_row->content);

        $moved = $logo->move("images/",  $filename);
      }

      $response = [
        'error' => false,
        'message' => 'Company Settings Updated Successfully',
        "updatedLogoName" => $filename ?  asset($filename) : ""
      ];
      return response()->json($response);
    } catch (Exception $e) {
      Log::info($e);
      $response = [
        'error' => true,
        'message' => 'Error updating company settings.',

      ];
      return response()->json($response, 500);
    }
  }
}
