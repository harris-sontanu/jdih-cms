<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends AdminController
{
    public function index()
    {
        $this->authorize('viewAny', Setting::class);

        $pageHeader = 'Pengaturan Aplikasi';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.setting.index') => 'Pengaturan',
            'Aplikasi' => TRUE
        ];

        $settings = Setting::pluck('value', 'key');
        $settings['appLogoUrl'] = Storage::disk('public')->exists($settings['appLogo']) 
            ? Storage::url($settings['appLogo']) 
            : '/assets/admin/images/logo_icon.svg';

        return view('admin.setting.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'settings',
        ));
    }

    public function update(Request $request)
    {
        $this->authorize('update', Setting::class);

        $rules = [];
        $settings = Setting::pluck('value', 'key');

        foreach ($settings as $key => $value) {
            $rules[$key] = 'nullable';
            if ($key == 'appLogo') {
                $rules[$key] = 'nullable|image|max:2048';
            } else if (in_array($key, ['appName', 'appDesc', 'appUrl', 'company', 'companyUrl', 'region_code'])) {
                $rules[$key] = 'required';
            }
        }

        $validated = $request->validate($rules);
        foreach ($validated as $key => $value) {
            Setting::where('key', $key)
                    ->update(['value' => $value]);
        }

        if ($request->hasFile('appLogo')) {
            $path = $request->file('appLogo')->store('images', 'public');

            Setting::where('key', 'appLogo')
                    ->update(['value' => $path]);
        }

        return redirect('/admin/setting')->with('message', '<strong>Berhasil!</strong> Data Pengaturan Aplikasi telah berhasil diperbarui');
    }

    public function questionner(Request $request)
    {
        $this->authorize('update', Setting::class);
        
        $validated = $request->validate([
            'title' => 'required',
            'desc'  => 'nullable'
        ]);

        $validated['active'] = ($request->active) ? 1 : 0;
        
        Setting::where('key', 'questionner')
            ->update(['value' => json_encode($validated)]);

        
        return redirect('/admin/questionner')->with('message', '<strong>Berhasil!</strong> Data Kuesioner telah berhasil diperbarui');
    }
}
