<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Settings\UpdateSettingsRequest;
use App\Models\Setting;
use App\Navigation\SuperAdminPath;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SettingsController extends BaseController
{

    public function __construct()
    {
        $this->middleware('permission:access-super-admin-settings')->only('index', 'update');
    }

    /**
     * Display the settings management page.
     */
    public function index()
    {
        $settings = Setting::getAllGrouped();

        return Inertia::render(SuperAdminPath::view('settings/index'), [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the application settings.
     */
    public function update(UpdateSettingsRequest $request)
    {
        try {
            DB::beginTransaction();

            $settingsData = $request->validated()['settings'];

            foreach ($settingsData as $key => $value) {
                $setting = Setting::where('key', $key)->first();

                if ($setting) {
                    $setting->update(['value' => $value]);
                }
            }

            DB::commit();

            Setting::clearCache();

            return $this->successWithToast(
                'Settings updated successfully',
                'Success',
                'super-admin.settings.index'
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorWithToast(
                'Failed to update settings. Please try again.',
                'Error'
            );
        }
    }
}
