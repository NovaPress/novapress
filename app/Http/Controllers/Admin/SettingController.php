<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Settings\UpdateRequest;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends AdminController
{
    protected string $policyClass = Setting::class;

    /**
     * Get All Tags.
     */
    public function generalSettings(): Response
    {
        if ($this->isAble('view', Setting::class)) {
            $timeFormats = [
                '12Hour' => [
                    'label' => Carbon::now()->format('g:i A'),
                    'value' => 'g:i A',
                ],
                '24Hour' => [
                    'label' => Carbon::now()->format('H:i'),
                    'value' => 'H:i',
                ],
            ];

            $dateFormats = [
                'j F Y' => [
                    'label' => Carbon::now()->format('j F Y'),
                    'value' => 'j F Y',
                ],
                'Y-m-d' => [
                    'label' => Carbon::now()->format('Y-m-d'),
                    'value' => 'Y-m-d',
                ],
                'm/d/Y' => [
                    'label' => Carbon::now()->format('m/d/Y'),
                    'value' => 'm/d/Y',
                ],
                'd/m/Y' => [
                    'label' => Carbon::now()->format('d/m/Y'),
                    'value' => 'd/m/Y',
                ],
            ];

            return Inertia::render('Admin/Settings/General', [
                'settings' => Setting::where('type', 'general')->get(['key', 'value']),
                'dateFormats' => $dateFormats,
                'timeFormats' => $timeFormats,
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Update Settings.
     */
    public function updateGeneralSettings(UpdateRequest $request): RedirectResponse|Response
    {
        if ($this->isAble('update', Setting::class)) {
            $settings = Setting::where('type', 'general')->get();
            foreach ($settings as $setting) {
                $setting->value = $request->input($setting->key);
                $setting->save();
            }

            return redirect()->route('admin.settings.general');
        }

        return Inertia::render('Admin/Error/403');
    }
}
