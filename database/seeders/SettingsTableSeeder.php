<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $settings = [
            [
                'type' => 'company_name',
                'content' => 'THE BUSINESS SOLUTIONS',
            ],
            [
                'type' => 'company_contact',
                'content' => '077 760 7644',
            ],
            [
                'type' => 'company_address',
                'content' => '4A, Kuda Edanda Road, Wattala 11300',
            ],
            [
                'type' => 'company_email',
                'content' => '',
            ],
            [
                'type' => 'company_logo',
                'content' => 'images/web-app-logo.png', 
            ],
        ];

         foreach ($settings as $setting) {
            $exists = Setting::where('type', $setting['type'])->exists();

            if (!$exists) {
                Setting::insert($setting);
            }
        }
    }
}
