<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiteSettingController extends Controller
{
    public function index()
    {
        $sitesettings = SiteSetting::first();

        return view('dashboard.setting.site', compact('sitesettings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => ['required', 'string', 'min:2', 'max:255'],
            'tagline' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['required', 'string', 'min:2', 'max:300'],
            'copyright_text' => ['required', 'string', 'min:2', 'max:300'],
            'enable_registration' => ['nullable', 'integer'],
            'logo_dark' => ['nullable', 'image'],
            'logo_light' => ['nullable', 'image'],
            'banner_image' => ['nullable', 'image'],
            'banner_title' => ['nullable', 'string', 'max:255'],
            'banner_subtitle' => ['nullable', 'string', 'max:255'],
        ]);
        $sitesettings = SiteSetting::first();
        $sitesettings->site_title = $validated['site_title'];
        $sitesettings->tagline = $validated['tagline'];
        $sitesettings->description = $validated['description'];
        $sitesettings->copyright_text = $validated['copyright_text'];
        $sitesettings->enable_registration = Arr::has($validated, 'enable_registration') ? '1' : '0';
        $sitesettings->banner_title = $validated['banner_title'] ?? $sitesettings->banner_title;
        $sitesettings->banner_subtitle = $validated['banner_subtitle'] ?? $sitesettings->banner_subtitle;
        if (Arr::has($validated, 'logo_dark')) {
            $image = $request->file('logo_dark');
            $imageName = 'logo_dark_'.Str::random(5).'.'.$image->extension();
            $image->move(public_path('uploads/logo'), $imageName);
            if (File::exists(public_path('uploads/logo/'.$sitesettings->logo_dark))) {
                File::delete(public_path('uploads/logo/'.$sitesettings->logo_dark));
            }
            $sitesettings->logo_dark = $imageName;
        }
        if (Arr::has($validated, 'logo_light')) {
            $image = $request->file('logo_light');
            $imageName = 'logo_light_'.Str::random(5).'.'.$image->extension();
            $image->move(public_path('uploads/logo'), $imageName);
            if (File::exists(public_path('uploads/logo/'.$sitesettings->logo_light))) {
                File::delete(public_path('uploads/logo/'.$sitesettings->logo_light));
            }
            $sitesettings->logo_light = $imageName;
        }
        if (Arr::has($validated, 'banner_image')) {
            $image = $request->file('banner_image');
            $imageName = 'banner_'.Str::random(5).'.'.$image->extension();
            $image->move(public_path('uploads/banner'), $imageName);
            if ($sitesettings->banner_image && File::exists(public_path('uploads/banner/'.$sitesettings->banner_image))) {
                File::delete(public_path('uploads/banner/'.$sitesettings->banner_image));
            }
            $sitesettings->banner_image = $imageName;
        }
        $sitesettings->save();

        return back()->with('success', 'Site Settings updated!');
    }
}
