<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
  public function index()
  {

    $invoice_note = Setting::where("type", "invoice_note")->first();

    if (!$invoice_note) {
      $invoice_note = '';
    }


    return view("settings", compact("invoice_note"));
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
      $response_message="";

      $setting = Setting::where('type', $type)->first();

      if ($setting) {

        $setting->content = $request->input('content');
        $setting->save();

        $response_message="Note updated successfully";
      } else {

        $setting = new Setting();
        $setting->type = $type;
        $setting->content = $request->input('content');
        $setting->save();
        $response_message="Note saved successfully";
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
}
