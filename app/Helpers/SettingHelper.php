<?php

namespace App\Helpers;

use App\Models\Setting;
use Sabberworm\CSS\Settings;

class SettingHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public static function getSetting($type)
    {
        return Setting::where('type', $type)->first();
    }

    public static function updateSetting($type, $content)
    {
        $setting = Setting::where("type", $type)->first();
        $setting->content = $content;
        $setting->save();
    }
}
