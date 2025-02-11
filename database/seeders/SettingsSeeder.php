<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'key' => 'site_title',
            'value' => 'NovaPress',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'site_icon',
            'value' => '',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'site_url',
            'value' => 'http://localhost:8000',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'admin_email',
            'value' => 'administrator@example.com',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'registration',
            'value' => 'false',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'default_role',
            'value' => 'subscriber',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'language',
            'value' => 'english',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'timezone',
            'value' => 'UTC',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'date_format',
            'value' => 'F j, Y',
            'type' => 'general',
        ]);

        Setting::create([
            'key' => 'time_format',
            'value' => 'g:i a',
            'type' => 'general',
        ]);
    }
}
